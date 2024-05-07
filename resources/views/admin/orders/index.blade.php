 @extends('admin.layouts.app')
 @section('title', 'orders')
 @section('content')

 <div class="card">

     <h1>
         Đơn đặt hàng
     </h1>
     <div class="container-fluid pt-5">

         <div class="col card">
             <div class="table-responsive">
                 <table class="table table-bordered table-hover table-condensed">
                     <tr>
                         <th>#</th>
                         <th>Trạng thái</th>
                         <th>Tổng</th>
                         <!-- <th>Phí vận chuyển</th> -->
                         <th>Tên KH</th>
                         <!-- <th>Email KH</th> -->
                         <th>Địa chỉ</th>
                         <th>Ghi chú</th>
                         <th>Thanh toán</th>
                         <th>Ngày tạo đơn hàng</th>
                         <th>Ngày xác nhận</th>
                         <th>Hành động</th>
                     </tr>

                     @foreach ($orders as $item)
                     <tr>
                         <td>{{ $item->id }}</td>
                         <td>

                             <div class="input-group input-group-static mb-4">
                                 <select name="status" class="form-control select-status"
                                     data-action="{{ route('admin.orders.update_status', $item->id) }}">
                                     @foreach (config('order.status') as $status)
                                     <option value="{{ $status }}" {{ $status == $item->status ? 'selected' : '' }}>
                                         {{ $status }}
                                     </option>
                                     @endforeach
                                 </select>

                         </td>
                         <td>{{ number_format($item->total) }}VNĐ</td>

                         <!-- <td>{{ $item->ship }}VNĐ</td> -->
                         <td>{{ $item->customer_name }}</td>
                         <!-- <td>{{ $item->customer_email }}</td> -->

                         <td>{{ $item->customer_address }}</td>
                         <td>{{ $item->note }}</td>
                         <td>{{ $item->payment }}</td>
                         <td>{{ $item->created_at->format('d-m-Y') }}</td>
                         <td>{{ $item->updated_at->format('d-m-Y') }}</td>
                         <td><a href="{{ route('admin.orders.show', $item->id) }}" class="btn btn-primary">Chi tiết</a>
                         </td>

                     </tr>
                     @endforeach
                 </table>

             </div>
         </div>

     </div>
 </div>
 @endsection
 @section('script')
 <script src="{{ asset('admin/assets/js/orders/order.js') }}"></script>
 @endsection