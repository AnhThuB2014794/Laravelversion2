@extends('admin.layouts.app')
@section('title', 'Create Product')
@section('content')
<div class="card">
    <h1>Hiển thị sản phẩm</h1>

    <div>

        <div class="row">
            <div class=" input-group-static col-5 mb-4">
                <label>Ảnh</label>
            </div>
            <div class="col-5">
                <img src="{{ $product->images ? asset('upload/' .$product->images->first()->url) : 'upload/default.png'}}"
                    id="show-image" alt="">
            </div>
        </div>

        <div class="input-group input-group-static mb-4">
            <label>Tên sản phẩm : {{ $product->name }}</label>

        </div>

        <div class="input-group input-group-static mb-4">
            <label>Giá : {{ $product->price }}</label>

        </div>

        <div class="input-group input-group-static mb-4">
            <label>Giảm giá : {{ $product->sale }}</label>

        </div>



        <div class="form-group">
            <p>Mô tả</p>
            <div class="row w-100 h-100">
                {!! $product->description !!}
            </div>
        </div>
        <div>
            <p>Size</p>
            @if($product->details->count() > 0)
            @foreach ($product->details as $detail)
            <p>Size: {{ $detail->size }} - quantity: {{ $detail->quantity}}</p>
            @endforeach
            @else
            <p>Sản phẩm này chưa nhập size</p>
            @endif
        </div>



    </div>
    <div>
        <p>Danh mục</p>
        @foreach ($product->categories as $item)
        <p>{{ $item->name}}</p>
        @endforeach
    </div>



</div>
</div>
@endsection