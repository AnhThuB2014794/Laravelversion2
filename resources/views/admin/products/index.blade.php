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
                <th>Hoạt động</th>
            </tr>
            @foreach ($products as $item)
            <tr>
                <td>{{ $item->id}}</td>
                <td><img src="{{ $item->images->count() > 0 ? asset('upload/' .$item->images->first()->url) : 'upload/default.jpg'}}"
                        width="200px" height="200px" alt=""></td>

                <td>{{ $item->name}}</td>
                <td>{{ $item->price}}</td>
                <td>{{ $item->sale}}</td>
                <td>
                    <a href="{{ route('products.edit', $item->id)}}" class="btn btn-success"><i
                            class="fa fa-edit"></i></a>

                    <form action="{{ route('products.destroy', $item->id) }}" id="form-delete{{ $item->id}}"
                        method="post">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger" type="submit" data-id={{ $item->id }}><i
                                class="fa fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
        {{ $products->links('pagination::bootstrap-5')}}
    </div>
</div>
@endsection