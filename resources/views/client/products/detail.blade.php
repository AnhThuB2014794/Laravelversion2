@extends('client.layouts.app')
@section('title', 'product detail')
@section('content')
<!-- Page Header Start -->
<div class="row" style="margin-left: 50px">
    <div class="d-inline-flex">
        <p class="m-0"><a href="">Trang chủ</a></p>
        <p class="m-0 px-2">/</p>
        <p class="m-0">Chi tiết sản phẩm</p>
    </div>
</div>
<!-- Page Header End -->
@if (session('message'))
<h2 class="" style="text-align: center; width:100%; color:red"> {{ session('message') }}</h2>
@endif

<!-- Shop Detail Start -->
<div class="container-fluid py-5">
    <form action="{{ route('client.carts.add')}}" method="POST" class="row px-xl-5">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <div class="col-lg-5 pb-5">
            <div id="product-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner border">
                    <div class="carousel-item active">
                        <img class="w-100 h-100"
                            src="{{ $product->images->count() > 0 ? asset('upload/' . $product->images->first()->url) : 'upload/default.png' }}"
                            alt="Image">
                    </div>

                </div>
                <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                    <i class="fa fa-2x fa-angle-left text-dark"></i>
                </a>
                <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                    <i class="fa fa-2x fa-angle-right text-dark"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-7 pb-5">
            <h3 class="font-weight-semi-bold">{{ $product->name }}</h3>
            <div class="d-flex mb-3">

            </div>
            <h3 class="font-weight-semi-bold mb-4">{{number_format( $product->price) }}VND</h3>
            <h5>Số lượng hàng còn:</h5>
            @foreach ($productDetails as $productDetail)
            @php
            // Tìm phần tử tương ứng trong $productOrders
            $order = $productOrders->firstWhere('product_size', $productDetail->size);
            // Tính số lượng còn lại
            $quantityRemaining = $productDetail->remaining_quantity - ($order ? $order->quantity_sold : 0);
            @endphp
            <p>Size: {{ $productDetail->size }}: Số lượng còn lại: {{ $quantityRemaining }}</p>
            @endforeach


            <div class="d-flex mb-4">
                <p class="text-dark font-weight-medium mb-0 mr-3">Size:</p>
                @if ($product->details->count() > 0)
                <form>
                    @foreach ($product->details as $size)
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" name="product_size" value="{{ $size->size }}"
                            id="size{{ $size->size }}">
                        <label for="size{{ $size->size }}" class="
                                        custom-control-label">{{ $size->size }}</label>
                    </div>
                    @endforeach
                </form>
                @else
                <p>Hết hàng</p>
                @endif

            </div>


            <!-- <div class="d-flex align-items-center mb-4 pt-2">
                <div class="input-group quantity mr-3" style="width: 130px;">
                    <div class="input-group-btn">
                        <button class="btn btn-primary btn-minus">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <input type="text" class="form-control bg-secondary text-center" value="1" readonly>
                    <div class="input-group-btn">
                        <button class="btn btn-primary btn-plus">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
                <button class="btn btn-primary px-3"><i class="fa fa-shopping-cart mr-1"></i> Add To Cart</button>
            </div> -->
            <div class="d-flex align-items-center mb-4 pt-2">
                <!-- <div class="input-group quantity mr-3" style="width: 130px;">
                    <div class="input-group-btn">
                        <button class="btn btn-primary btn-minus">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <input type="number" class="form-control bg-secondary text-center" value="1" min="1"
                        id="quantityInput">
                    <div class="input-group-btn">
                        <button class="btn btn-primary btn-plus">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>q -->
                <button class="btn btn-primary px-3" id="addToCartButton"><i class="fa fa-shopping-cart mr-1"></i> Thêm
                    vào giỏ hàng</button>
            </div>

            <div class="d-flex pt-2">
                <p class="text-dark font-weight-medium mb-0 mr-2">Chia sẻ:</p>
                <div class="d-inline-flex">
                    <a class="text-dark px-2" href="">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a class="text-dark px-2" href="">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a class="text-dark px-2" href="">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a class="text-dark px-2" href="">
                        <i class="fab fa-pinterest"></i>
                    </a>
                </div>
            </div>
        </div>
    </form>
    <div class="row px-xl-5">
        <div class="col">
            <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                <a class="nav-item nav-link active" data-toggle="tab" href="#tab-pane-1">Mô tả</a>
                <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-3">Phản hồi(0)</a>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="tab-pane-1">
                    <h4 class="mb-3">Mô tả về sản phẩm</h4>
                    {!! $product->description !!}
                </div>

                <div class="tab-pane fade" id="tab-pane-3">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="mb-4">1 review for {{ $product->name }}</h4>
                            <div class="media mb-4">

                                <div class="media-body">
                                    <h6>John Doe<small> - <i>01 Jan 2045</i></small></h6>
                                    <div class="text-primary mb-2">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                    <p>Diam amet duo labore stet elitr ea clita ipsum, tempor labore accusam ipsum et no
                                        at. Kasd diam tempor rebum magna dolores sed sed eirmod ipsum.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h4 class="mb-4">Leave a review</h4>
                            <small>Your email address will not be published. Required fields are marked *</small>
                            <div class="d-flex my-3">
                                <p class="mb-0 mr-2">Your Rating * :</p>
                                <div class="text-primary">
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                            </div>
                            <form>
                                <div class="form-group">
                                    <label for="message">Your Review *</label>
                                    <textarea id="message" cols="30" rows="5" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="name">Your Name *</label>
                                    <input type="text" class="form-control" id="name">
                                </div>
                                <div class="form-group">
                                    <label for="email">Your Email *</label>
                                    <input type="email" class="form-control" id="email">
                                </div>
                                <div class="form-group mb-0">
                                    <input type="submit" value="Leave Your Review" class="btn btn-primary px-3">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@section('script')

<script src="{{ asset('client/js/product.js') }}"></script>



@endsection