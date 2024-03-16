@extends('admin.layouts.app')
@section('title', 'Order Detail')
@section('content')
<div class="card">

    @if (session('message'))
        <h1 class="text-primary">{{ session('message') }}</h1>
    @endif
{{-- <div>
    <button style="width: 50px; " class="btn-primary" onclick="printInvoice()">Print</button>
</div> --}}

    <h1>
        Order Detail - Order #{{ $order->id }}
    </h1>
    <p>Ngày tạo đơn hàng: {{ $order->created_at->format('d-m-y') }}</p>
    <div>
        <table class="table table-hover">
            <tr class="table-primary">
                
                <th>Product</th>
                <th>Size</th>
                <th>Quantity</th>

                {{-- <th>Action</th> --}}
            </tr>

            @foreach ($order->productOrders as $productOrder)
            <tr>
                <td>{{ $productOrder->product->name }}</td>
                <td>{{ $productOrder->product_size }}</td>

                <td>{{  $productOrder->product_quantity }}</td>
                

                
            </tr>
        @endforeach
        {{-- @foreach ($order->cart->cartProducts as $cartProduct)
        <tr>
            <td>{{ $cartProduct->productOrder->product->name }}</td>
            <td>{{ $cartProduct->productOrder->product_size }}</td>
            <td>{{ $cartProduct->productOrder->product_quantity }}</td>
        </tr>
    @endforeach --}}
         
            <tr class="table-dark">
                
                <th>Total: {{ number_format($order->total) }}VNĐ</th>
                <th></th>
                <th></th>

                {{-- <th>Action</th> --}}
            </tr>
            {{-- <tr>
                

            </tr> --}}
        </table>
       
    </div>

</div>
@endsection