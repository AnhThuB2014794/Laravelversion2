<?php

namespace App\Http\Controllers\Client;

use App\Http\Resources\Cart\CartResource;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

use App\Http\Requests\Orders\CreateOrderRequest;
use App\Models\ProductDetail;
use App\Models\ProductOrder;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    protected $cart;
    protected $product;
    protected $cartProduct;
    protected $coupon;
    protected $order;
    public function __construct(Product $product, Cart $cart, CartProduct $cartProduct, Coupon $coupon, Order $order)
    {
        $this->product = $product;
        $this->cart = $cart;
        $this->cartProduct = $cartProduct;
        $this->coupon = $coupon;
        $this->order = $order;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cart = $this->cart->firtOrCreateBy(auth()->user()->id)->load('products');
        $coupons = Coupon::all();
        return view('client.carts.index', compact('cart', 'coupons'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->product_size){
            $product = $this->product->findOrFail($request->product_id);
            // $selectedSize = $request->product_size;
            // //lấy sl sp trong csdl dựa trên size đã chọn 
            // $remainingQuantity = ProductDetail::where('product_id', $request->product_id)
            //     ->where('size', $selectedSize)
            //     ->sum('quantity');
            // //lấy sl sp đã bán ra trên size đã chọn 
            // $quantitySold = ProductOrder::join('orders', 'product_orders.order_id', '=', 'orders.id')
            //     ->where('orders.status', 'Xác nhận')
            //     ->where('product_orders.product_id', $request->product_id)
            //     ->where('product_orders.product_size', $selectedSize)
            //     ->sum('product_orders.product_quantity');
            // //kiem tra dieu kien tồn kho 
            // $availableQuantity = $remainingQuantity - $quantitySold ;
            // dd($request->product_quantity);
            // if ($request->product_quantity > $availableQuantity || $request->product_quantity <= 0) {
            //     return back()->with(['message' => 'Số lượng nhập vào không hợp lệ']);   
            // }
            $cart = $this->cart->firtOrCreateBy(auth()->user()->id);
            $cartProduct = $this->cartProduct->getBy($cart->id, $product->id, $request->product_size);
            if($cartProduct){
                $quantity = $cartProduct->product_quantity;
                $cartProduct->update(['product_quantity' => ($quantity + $request->product_quantity)]);
            } else{
                $dateCreate['cart_id'] = $cart->id;
                $dateCreate['product_size'] = $request->product_size;
                $dateCreate['product_quantity'] = $request->product_quantity ?? 1;
                $dateCreate['product_price'] = $product->price;
                $dateCreate['product_id'] = $request->product_id;
                $this->cartProduct->create($dateCreate);
            }
        
            return back()->with(['message' => 'Thêm thành công']);
            
        } else {
            return back()->with(['message' => 'Bạn chưa chọn size']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function removeProductInCart($id)
    {
         $cartProduct =  $this->cartProduct->find($id);
         $cartProduct->delete();
         $cart =  $cartProduct->cart;
         return response()->json([
             'product_cart_id' => $id,
             'cart' => new CartResource($cart)
         ], Response::HTTP_OK);
    }

    public function updateQuantityProduct(Request $request, $id)
    {
         $cartProduct =  $this->cartProduct->find($id);
         $dataUpdate = $request->all();
         if($dataUpdate['product_quantity'] < 1 ) {
            $cartProduct->delete();
        } else {
            $cartProduct->update($dataUpdate);
        }

        $cart =  $cartProduct->cart;

        return response()->json([
            'product_cart_id' => $id,
            'cart' => new CartResource($cart),
            'remove_product' => $dataUpdate['product_quantity'] < 1,
            'cart_product_price' => $cartProduct->total_price
        ], Response::HTTP_OK);
    }

    public function applyCoupon(Request $request)
    {

        $name = $request->input('coupon_code');

        $coupon =  $this->coupon->firstWithExperyDate($name, auth()->user()->id);

        if($coupon)
        {
            $message = 'Áp Mã giảm giá thành công !';
            Session::put('coupon_id', $coupon->id);
            Session::put('discount_amount_price', $coupon->value);
            Session::put('coupon_code' , $coupon->name);

        }else{

            Session::forget(['coupon_id', 'discount_amount_price', 'coupon_code']);
            $message = 'Mã giảm giá không tồn tại hoặc hết hạn!';
        }

        return redirect()->route('client.carts.index')->with([
            'message' => $message,
        ]);
    }
    public function checkout()
    {
        $cart = $this->cart->firtOrCreateBy(auth()->user()->id)->load('products');

        return view('client.carts.checkout', compact('cart'));
    }
    public function processCheckout(CreateOrderRequest $request)
    {

        $dataCreate = $request->all();
        $dataCreate['user_id'] = auth()->user()->id;
        $dataCreate['status'] = 'Chờ xác nhận';
        $order = $this->order->create($dataCreate);
        $couponID = Session::get('coupon_id');
        if($couponID)
        {
            $coupon =  $this->coupon->find(Session::get('coupon_id'));
            if($coupon)
            {
                $coupon->users()->attach(auth()->user()->id, ['value' => $coupon->value]);
            }
        }
        $cart = $this->cart->firtOrCreateBy(auth()->user()->id);
        $cartItems = $cart->products;

        // Thêm từng sản phẩm vào đơn hàng và bảng product_order
        foreach ($cartItems as $item) {
            
            // Thêm chi tiết giỏ hàng vào bảng product_order
            DB::table('product_orders')->insert([
                
            'product_size' => $item->product_size,
            'product_quantity' => $item->product_quantity,
            'product_price' => $item->product_price,
            'order_id' => $order->id,
            'user_id' => $order->user->id,
            'product_id' => $item->product->id,
                // Thêm các thông tin khác nếu cần
            ]);
        }
    
        $cart->products()->delete();
        if ($dataCreate['payment'] == 'VNPay') {
            // Chuyển hướng đến trang thanh toán trực tuyến, ví dụ: /payment/vnpay
            // return redirect()->url('vnpay_payment');
            Session::forget(['coupon_id', 'discount_amount_price', 'coupon_code']);
            Session::save();
            return $this->payment($order->id);
        }
        Session::forget(['coupon_id', 'discount_amount_price', 'coupon_code']);
        Session::save();
        return redirect()->route('client.carts.index');
        
    }

    public function payment($id){
       
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://127.0.0.1:8000/carts";
        $vnp_TmnCode = "D3F2BAS3";//Mã website tại VNPAY 
        $vnp_HashSecret = "QKESBEHPQEZTUEEMFTOODWUIVCBGIZPX"; //Chuỗi bí mật
        $order = Order::findOrFail($id);
        // dd($order);
        $vnp_TxnRef = $order->id; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = "Thanh toán hóa đơn";
        $vnp_OrderType = "My clothing shop";
        $vnp_Amount = $order->total * 100;
        $vnp_Locale = "VN";
        $vnp_BankCode ="NCB";
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];


        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array('code' => '00'
            , 'message' => 'success'
            , 'data' => $vnp_Url);
            if (isset($_POST['redirect'])) {
                header('Location: ' . $vnp_Url);
                die();
            } else {
                echo json_encode($returnData);
            }
	// vui lòng tham khảo thêm tại code demo
    
    }






}