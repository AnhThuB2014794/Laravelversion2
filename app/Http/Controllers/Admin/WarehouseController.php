<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ProductDetail;
use App\Models\ProductOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = ProductDetail::with('product')->get();
        $products = ProductDetail::with('product')
        ->leftJoin('product_orders', function ($join) {
            $join->on('product_details.product_id', '=', 'product_orders.product_id')
            ->whereColumn('product_details.product_id', '=', 'product_orders.product_id')
                    ->whereColumn('product_details.size', '=', 'product_orders.product_size');
        })
        ->select(
            'product_details.id', // Include the non-aggregated columns in the SELECT
            'product_details.product_id',
            'product_details.size',
            'product_details.quantity', // Assuming this is a column in product_details table
            DB::raw('COALESCE(SUM(product_orders.product_quantity), 0) as total_quantity_sold')
        )
        ->groupBy('product_details.id', 'product_details.product_id', 'product_details.size', 'product_details.quantity')
        ->get();
        return view('admin.warehouse.index', compact('products'));
        // return view('admin.warehouse.index');
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
        //
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
