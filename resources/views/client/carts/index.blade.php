<!-- Featured Start -->
@extends('client.layouts.app')
@section('title', 'Cart')
@section('content')


<div class="row px-xl-5">
    @if (session('message'))
    <div class="row">
        <h3 class="text-danger">{{ session('message') }}</h3>
    </div>
    @endif
    <div class="col-lg-8 table-responsive mb-5">
        <table class="table table-bordered text-center mb-0">
            <thead class="bg-secondary text-dark">
                <tr>
                    <th>Sản phẩm</th>
                    <th>Giá</th>
                    <th>Size</th>
                    <th>Giảm giá</th>
                    <th>Số lượng</th>
                    <th>Tổng</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody class="align-middle">
                @foreach ($cart->products as $item)
                <tr id="row-{{ $item->id }}">
                    <td class="align-middle"><img src="{{ $item->product->image_path }}" alt="" style="width: 50px;">
                        {{ $item->product->name }}</td>
                    <td class="align-middle">
                        <p style="{{ $item->product->sale ? 'text-decoration: line-through' : ''}}">
                            {{ number_format($item->product->price) }} VNĐ
                        </p>

                        @if ($item->product->sale)
                        <p>
                            {{ number_format($item->product->sale_price) }} VNĐ
                        </p>
                        @endif
                    </td>
                    <td class=" align-middle">{{ $item->product_size }}
                    </td>
                    <td class="align-middle">{{ $item->product->sale }}</td>
                    <td class="align-middle">
                        <div class="input-group quantity mx-auto" style="width: 100px;">
                            <div class="input-group-btn">
                                <button class="btn btn-sm btn-primary btn-minus btn-update-quantity"
                                    data-action="{{ route('client.carts.update_product_quantity', $item->id) }}"
                                    data-id="{{ $item->id }}">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <input type="number" class="form-control form-control-sm bg-secondary text-center p-0"
                                id="productQuantityInput-{{ $item->id }}" min="1" 
                                value="{{ $item->product_quantity }}" >
                            <div class="input-group-btn">
                                <button class="btn btn-sm btn-primary btn-plus btn-update-quantity"
                                    data-action="{{ route('client.carts.update_product_quantity', $item->id) }}"
                                    data-id="{{ $item->id }}">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </td>
                    <td class="align-middle">
                        <span
                            id="cartProductPrice{{ $item->id }}">
                            {{ number_format($item->product->sale ? $item->product->sale_price * $item->product_quantity : $item->product->price * $item->product_quantity) }}
                            VNĐ</span>

                    </td>
                    <td class="align-middle">
                        <button class="btn btn-sm btn-primary btn-remove-product"
                            data-action="{{ route('client.carts.remove_product', $item->id) }}"><i
                                class="fa fa-times"></i></button>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    <div class="col-lg-4">
        <form class="mb-5" method="POST" action="{{ route('client.carts.apply_coupon') }}">
            @csrf
            <div class="input-group">
                <input type="text" class="form-control p-4" value="{{ Session::get('coupon_code') }}" name="coupon_code"
                    placeholder="Mã giảm giá">
                <div class="input-group-append">
                    <button class="btn btn-primary">Áp dụng mã giảm giá</button>
                </div>
            </div>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#discountCodesModal" style="padding: 10px; margin: 10px">
                Xem danh sách mã giảm giá
            </button>
            <div class="modal fade" id="discountCodesModal" tabindex="-1" role="dialog" aria-labelledby="discountCodesModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="discountCodesModalLabel">Danh sách mã giảm giá <sup>(*)</sup>
                                
                            </h5> 
                                                          
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            
                        </div>
                        <div>
                            <i>                                   
                                (*Vui lòng xem danh sách mã giảm giá tại đây và nhập mã giảm giá vào ô mã giảm đã để nhận được khuyến mãi.) 
                            </i>
                        </div> 
                        
                        
                        <div class="modal-body">
                            <!-- Hiển thị danh sách mã giảm giá -->
                            <ul>
                                @foreach($coupons as $coupon)
                                    <li class="discount-code" data-code="{{ $coupon->name }}">
                                        {{ $coupon->name }} - {{ $coupon->value }} VNĐ
                                        
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="card border-secondary mb-5">
            <div class="card-header bg-secondary border-0">
                <h4 class="font-weight-semi-bold m-0">Tóm tắt giỏ hàng</h4>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3 pt-1">
                    <h6 class="font-weight-medium">Tổng phụ</h6>
                    <h6 class="font-weight-medium total-price" data-price="{{ $cart->total_price }}">
                        {{number_format($cart->total_price ) }} VNĐ</h6>
                </div>


                @if (session('discount_amount_price'))
                <div class="d-flex justify-content-between">
                    <h6 class="font-weight-medium">Mã giảm giá </h6>
                    <h6 class="font-weight-medium coupon-div" data-price="{{ session('discount_amount_price') }}">
                        {{number_format(session('discount_amount_price') ) }} VNĐ</h6>
                </div>
                @endif

            </div>
            <div class="card-footer border-secondary bg-transparent">
                <div class="d-flex justify-content-between mt-2">
                    <h5 class="font-weight-bold">Tổng</h5>
                    <h5 class="font-weight-bold total-price-all"></h5>
                </div>
                <a href="{{ route('client.checkout.index') }}" class="btn btn-block btn-primary my-3 py-3">Proceed
                    To Checkout</a>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $('.quantity button').on('click', function () {
        var button = $(this);
        var oldValue = button.parent().parent().find('input').val();
        if (button.hasClass('btn-plus')) {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            if (oldValue > 0) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 0;
            }
        }
        button.parent().parent().find('input').val(newVal);
    });
    $(function () {
        getTotalValue();

        function getTotalValue() {
            let total = $('.total-price').data('price');
            let couponPrice = $('.coupon-div')?.data('price') ?? 0;
            // $('.total-price-all').text(`${total - couponPrice} VNĐ`);
            var totalPrice = total - couponPrice;

            // Định dạng giá trị tiền tệ với dấu ngăn cách
            var formattedTotalPrice = totalPrice.toLocaleString('vi-VN');

            // Thay đổi nội dung của phần tử có class "total-price-all" thành giá trị tiền tệ đã định dạng
            $('.total-price-all').text(`${formattedTotalPrice}VNĐ`);
        }

    $(document).on('click', '.btn-remove-product', function (e) {
        let url = $(this).data('action');
        confirmDelete()
            .then(function () {
                $.post(url, res => {
                    let cart = res.cart;
                    let cartProductId = res.product_cart_id;
                    $('#productCountCart').text(cart.product_count);
                    $('.total-price')
                        .text(`${cart.total_price}`)
                        .data('price', cart.product_count);
                    $(`#row-${cartProductId}`).remove();
                    getTotalValue();
                });
            })
            .catch(function () {});
    });

    const TIME_TO_UPDATE = 1000;

    $(document).on(
        'click',
        '.btn-update-quantity',
        _.debounce(function (e) {
            let url = $(this).data('action');
            let id = $(this).data('id');
            let data = {
                product_quantity: $(`#productQuantityInput-${id}`).val(),
            };
            $.post(url, data, res => {
                let cartProductId = res.product_cart_id;
                let cart = res.cart;
                $('#productCountCart').text(cart.product_count);
                if (res.remove_product) {
                    $(`#row-${cartProductId}`).remove();
                } else {
                    $(`#cartProductPrice${cartProductId}`).html(
                        `${res.cart_product_price}VNĐ`
                    );
                }
                getTotalValue();
                
                // cartProductPrice
                // getTotalValue();
                $('.total-price').text(`${cart.total_price}VNĐ`);
                // getTotalValue();
                // $('.total-price-all').text(`${formattedTotalPrice}VNĐ`);
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Cập nhật thành công",
                    showConfirmButton: false,
                    timer: 1500,
                });
            });
        }, TIME_TO_UPDATE)
    );
});

</script>
{{-- <script src="{{ asset('client/cart/cart.js') }}"></script> --}}
@endsection