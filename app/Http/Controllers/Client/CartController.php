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

        return view('client.carts.index', compact('cart'));

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
        $dataCreate['status'] = 'pending';
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
        Session::forget(['coupon_id', 'discount_amount_price', 'coupon_code']);
        return redirect()->route('client.carts.index');
    }






}