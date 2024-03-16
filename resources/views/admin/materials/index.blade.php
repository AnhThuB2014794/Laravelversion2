@extends('admin.layouts.app')
@section('title', 'Import Product')
@section('content')
<div class="card">
    <h1>
        Danh sách sản phẩm nhập vào
    </h1>
    @if (session('message')) 
    <h1 class="text-primary">{{ session('message')}}</h1>
     @endif

    <div><a href="{{ route('materials.create') }}" class="btn btn-primary">Tạo mới</a></div>
    <div>
        <table class="table table-hover">
            <tr>
                <th>#</th>
                <th>Tên</th>
                <th>Số lượng nhập vào</th>
                <th>Giá nhập</th>
                <th>Ngày nhập vào</th>
                <th>Hoạt động</th>
            </tr>
            @foreach ($importMaterials as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->import_quantity }}</td>
                <td>{{ $item->import_price }}</td>
                <td>{{ $item->import_date }}</td>
                <td>

                    {{-- @can('update-coupon') --}}
                    <a href="{{ route('materials.edit', $item->id)}}" class="btn btn-success"><i
                            class="fa fa-edit"></i></a>
                    {{-- @endcan --}}

                    {{-- @can('delete-coupon'){{ route('coupons.destroy', $item->id) }} --}}
                    <form action="{{ route('materials.destroy', $item->id) }}" id="form-delete{{ $item->id}}"
                        method="post">
                        @csrf
                        @method('delete')

                    </form>
                    <button class="btn btn-delete btn-danger" type="submit" data-id="{{ $item->id }}"><i
                            class="fa fa-trash"></i></button>
                    {{-- @endcan --}}


                </td>
            </tr>
            @endforeach
        </table>
        {{ $importMaterials->links('pagination::bootstrap-5')}}
    </div>
</div>    
@endsection