@extends('admin.layouts.app')
@section('title', 'Category')
@section('content')
<div class="card">
    <h1>
        Danh sách danh mục
    </h1>
    @if (session('message'))
    <h1 class="text-primary">{{ session('message')}}</h1>
    @endif

    <div><a href="{{ route('categories.create')}}" class="btn btn-primary">Tạo mới</a></div>
    <div>
        <table class="table table-bordered table-hover table-condensed">
            <tr>
                <th>#</th>
                <th>Tên</th>
                <th>Danh mục cha</th>
                <th>Hoạt động</th>
            </tr>
            @foreach ($categories as $item)
            <tr>
                <td>{{ $item->id}}</td>
                <td>{{ $item->name}}</td>
                <td>{{ $item->parent_name}}</td>
                <td>
                    @can('update-category')
                    <a href="{{ route('categories.edit', $item->id)}}" class="btn btn-success"><i
                            class="fa fa-edit"></i></a>
                    @endcan

                    @can('delete-category')
                    <form action="{{ route('categories.destroy', $item->id) }}" id="form-delete{{ $item->id}}"
                        method="post">
                        @csrf
                        @method('delete')

                    </form>
                    <button class="btn btn-delete btn-danger" type="submit" data-id={{ $item->id }}><i
                            class="fa fa-trash"></i></button>
                    @endcan
                </td>
            </tr>
            @endforeach
        </table>
        {{ $categories->links('pagination::bootstrap-5')}}
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