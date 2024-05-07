<!-- Featured Start -->
@extends('client.layouts.app')
@section('title', 'Home')
@section('content')
<div class="container-fluid pt-5">
    @if (session('message'))
    <h1 class="text-primary">{{ session('message') }}</h1>
    @endif

    <b>Danh sách đơn đặt hàng</b>
    <div class="col">
        <div>
            <table class="table table-hover">
                <tr>
                    <th>#</th>

                    <th>Trạng thái</th>
                    <th>Tổng</th>
                    <th>Phí vận chuyển</th>
                    <th>Tên Khách Hàng</th>
                    <th>Email</th>
                    <th>Địa chỉ</th>
                    <th>Ghi chú</th>
                    <th>Hình thức thanh toán</th>
                    <th>Hành động</th>

                </tr>

                @foreach ($orders as $item)
                <tr>
                    <td>{{ $item->id }}</td>

                    {{-- <td>{{ $item->status }}</td> --}}
                    <td>{{ $item->status }}</td>
                    <td>{{number_format($item->total)  }}VNĐ</td>

                    <td>{{number_format($item->ship)  }}VNĐ</td>
                    <td>{{ $item->customer_name }}</td>
                    <td>{{ $item->customer_email }}</td>

                    <td>{{ $item->customer_address }}</td>
                    <td>{{ $item->note }}</td>
                    <td>{{ $item->payment }}</td>
                    <td>
                        @if ($item->status == 'Chờ xác nhận')
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