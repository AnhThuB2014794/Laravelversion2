@extends('admin.layouts.app')
@section('title', 'Products')
@section('content')
<div class="card">
    <h1>
        Danh sách sản phẩm
    </h1>
    @if (session('message'))
    <h1 class="text-primary">{{ session('message')}}</h1>
    @endif

    <div><a href="{{ route('products.create')}}" class="btn btn-primary">Tạo mới</a></div>
    <div>
        <table class="table table-hover">
            <tr>
                <th>#</th>
                <th>Ảnh</th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Giảm giá</th>
                <th>Ngày tạo</th>
                <th>Ngày cập nhật</th>
                <th>Hoạt động</th>
            </tr>
            @foreach ($products as $item)
            <tr>
                <td>{{ $item->id}}</td>
                <td><img src="{{ $item->images->count() > 0 ? asset('upload/' .$item->images->first()->url) : ''}}"
                        width="200px" height="200px" alt=""></td>

                <td>{{ $item->name}}</td>
                <td>{{ number_format($item->price)}}VNĐ</td>
                <td>{{ $item->sale}}</td>
                <td>{{ $item->created_at->format('d-m-Y') }}</td>
                <td>{{ $item->updated_at->format('d-m-Y') }}</td>
                <td>
                    @can('update-product')
                    <a href="{{ route('products.edit', $item->id)}}" class="btn btn-success"><i
                            class="fa fa-edit"></i></a>
                    @endcan

                    @can('show-product')
                    <a href="{{ route('products.show', $item->id)}}" class="btn btn-info"><i class="fa fa-eye"></i></a>
                    @endcan
                    @can('delete-product')
                    <form action="{{ route('products.destroy', $item->id) }}" id="form-delete{{ $item->id}}"
                        method="post">
                        @csrf
                        @method('delete')


                    </form>
                    <button class="btn btn-delete btn-danger" type="submit" data-id={{ $item->id }}>
                        <i class="fa fa-trash"></i></button>
                    @endcan
                </td>
            </tr>
            @endforeach
        </table>
        {{ $products->links('pagination::bootstrap-5')}}
    </div>
</div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
    crossorigin="anonymous">
</script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(() => {

        function confirmDelete() {
            return new Promise((resolve, reject) => {
                Swal.fire({
                    title: 'Bạn có chắc chắn muốn xóa?',
                    text: "Sẽ không thể khôi phục sau khi thực hiện chức năng này!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Chắc chắn, hãy xóa chúng!'

                }).then((result) => {
                    if (result.isConfirmed) {
                        resolve(true)
                    } else {
                        reject(false)
                    }
                })
            })
        }

        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            confirmDelete().then(function() {
                $(`#form-delete${id}`).submit();
            }).catch();
        })
    }

)
</script>
@endsection