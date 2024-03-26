<!-- Featured Start -->
@extends('client.layouts.app')
@section('title', 'Home')
@section('content')
<div class="row" style="margin-left: 50px">
    <div class="d-inline-flex">
        <p class="m-0"><a href="{{ route('client.home') }}">Trang chủ</a></p>
        <p class="m-0 px-2">/</p>
        <p class="m-0">Danh sách đơn hàng</p>
    </div>
</div>
<div class="container-fluid pt-5">
    @if (session('message'))
    <h1 class="text-primary">{{ session('message') }}</h1>
    @endif
    <div>
        <p class="m-0">Danh sách đơn hàng</p>
    </div>

    <div class="col">
        <div>
            <table class="table table-hover">
                <tr>
                    <th>#</th>

                    <th>Trạng thái</th>
                    <th>Tổng</th>
                    <th>Phí vận chuyển</th>
                    <th>Tên khách hàng</th>
                    <th>Email</th>
                    <th>Địa chỉ</th>
                    <th>Ghi chú</th>
                    <th>Hình thức thanh toán</th>


                </tr>

                @foreach ($orders as $item)
                <tr>
                    <td>{{ $item->id }}</td>

                    <td>{{ $item->status }}</td>
                    <td>{{number_format($item->total)  }}VNĐ</td>

                    <td>{{number_format($item->ship)  }}VNĐ</td>
                    <td>{{ $item->customer_name }}</td>
                    <td>{{ $item->customer_email }}</td>

                    <td>{{ $item->customer_address }}</td>
                    <td>{{ $item->note }}</td>
                    <td>{{ $item->payment }}</td>
                    <td>
                        @if ($item->status == 'pending')
                        <form action="{{ route('client.orders.cancel', $item->id) }}" id="form-cancel{{ $item->id }}"
                            method="post">
                            @csrf
                            <button class="btn btn-cancel btn-danger" data-id={{ $item->id }}>Hủy đơn hàng</button>
                        </form>
                        @endif

                    </td>
                </tr>
                @endforeach
            </table>
            {{ $orders->links('pagination::bootstrap-5') }}
        </div>
    </div>

</div>
@endsection
@section('script')
<script>
$(function() {

    $(document).on("click", ".btn-cancel", function(e) {
        e.preventDefault();
        let id = $(this).data("id");
        confirmDelete()
            .then(function() {
                $(`#form-cancel${id}`).submit();
            })
            .catch();
    });

});
</script>

@endsection