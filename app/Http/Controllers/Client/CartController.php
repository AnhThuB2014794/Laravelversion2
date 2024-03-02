<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;


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
}