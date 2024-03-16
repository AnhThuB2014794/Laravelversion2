@extends('admin.layouts.app')
@section('title', 'Show Detail Product')
@section('content')
<div class="card">
    <h1>Hiển thị sản phẩm</h1>

    <div>

        <div class="row">
            <div class=" input-group-static col-5 mb-4">
                <label >Ảnh</label>
            </div>
            <div class="col-5">
                <img src="{{ $product->images ? asset('upload/' .$product->images->first()->url) : 'upload/default.png'}}"
                    id="show-image" alt="">
            </div>
        </div>

        <div class="input-group input-group-static mb-4">
            <h5>Tên sản phẩm : {{ $product->name }}</h5>

        </div>

        <div class="input-group input-group-static mb-4">
            <h5>Giá : {{ number_format($product->price)  }}VNĐ</h5>

        </div>

        <div class="input-group input-group-static mb-4">
            <h5>Giảm giá :{{ $product->sale }} </h5>
            {{-- <p>{{ $product->sale }}</p> --}}
        </div>



        <div class="form-group">
            <h5 >Mô tả</h5>
            <div class="row w-100 h-100">
                {!! $product->description !!}
            </div>
        </div>
        <div>
            <h5 >Size</h5>
            @if($product->details->count() > 0)
            @foreach ($product->details as $detail)
            <p>Size: {{ $detail->size }} - Số lượng: {{ $detail->quantity}}</p>
            @endforeach
            @else
            <p>Sản phẩm này chưa nhập size</p>
            @endif
        </div>



    </div>
    <div>
        <h5>Danh mục</h5>
        @foreach ($product->categories as $item)
        <p>{{ $item->name}}</p>
        @endforeach
    </div>



</div>
</div>
@endsection