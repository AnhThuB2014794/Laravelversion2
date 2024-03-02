<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{


    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function index()
    {
        $orders =  $this->order->getWithPaginateBy(auth()->user()->id);
        return view('client.orders.index', compact('orders'));
    }

    public function cancel($id)
    {
        $order =  $this->order->findOrFail($id);
        $order->update(['status' => 'cancel']);
        return redirect()->route('client.orders.index')->with(['message' => 'cancel success']);
    }


}