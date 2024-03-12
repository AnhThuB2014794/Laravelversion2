@extends('admin.layouts.app')
@section('title', 'Warehouse')
@section('content')
<div class="card">

    <h1>
        Quản lí kho hàng
    </h1>
    <div class="container-fluid pt-5">

        <div class="col card">
            <div>
                <table class="table table-hover">
                    <tr>
                       
                        <th>Sản phẩm</th>
                        <th>Size</th>
                        <th>Số lượng có sẵn</th>
                        <th>Số lượng bán ra</th>
                        <th>Số lượng còn lại</th>
                    </tr>

                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->product->name }}</td>
                            <td>{{ $product->size }}</td>
                            <td>{{ $product->quantity }}</td>
                            <td>{{ $product->total_quantity_sold  }}</td>
                            <td>{{ $product->quantity - $product->total_quantity_sold }}</td>
                        </tr>
                    @endforeach
                </table>
                
            </div>
        </div>

    </div>
</div>
@endsection
