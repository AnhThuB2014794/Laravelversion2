<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\ProductOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    protected $product;
    public function __construct(Product $product)
    {
        $this->product = $product;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$category_id)
    {
        $products =  $this->product->getBy($request->all(), $category_id);
        return view('client.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function search(Request $request){
        $keyword = $request->input('keyword');
        $products = Product::where('name', 'like', "%$keyword%")->paginate(10);
        return view('client.products.index', compact('products'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = $this->product->with('details')->findOrFail($id);
        $productDetails = ProductDetail::where('product_id', $id)
        ->select('size', DB::raw('SUM(quantity) as remaining_quantity'))
        ->groupBy('size')
        ->get();
        $productOrders = ProductOrder::join('orders', 'product_orders.order_id', '=', 'orders.id')
        ->where('orders.status', 'Xác nhận')
        ->where('product_orders.product_id', $id)
        ->select('product_orders.product_size', DB::raw('SUM(product_orders.product_quantity) as quantity_sold'))
        ->groupBy('product_orders.product_size')
        ->get();
        
        return view('client.products.detail', compact('product','productDetails', 'productOrders'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}