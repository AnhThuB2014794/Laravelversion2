@extends('admin.layouts.app')
@section('title', 'Roles')
@section('content')
<div class="card">
    <h1>
        Danh sách người dùng
    </h1>
    @if (session('message'))
    <h1 class="text-primary">{{ session('message')}}</h1>
    @endif

    <div><a href="{{ route('users.create')}}" class="btn btn-primary">Tạo mới</a></div>
    <div>
        <table class="table table-hover">
            <tr>
                <th>#</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Hoạt động</th>
            </tr>
            @foreach ($users as $item)
            <tr>
                <td>{{ $item->id}}</td>

                <td>{{ $item->name}}</td>
                <td>{{ $item->email}}</td>
                <td>{{ $item->phone}}</td>
                <td>
                    <a href="{{ route('users.edit', $item->id)}}" class="btn btn-success"><i class="fa fa-edit"></i></a>

                    <form action="{{ route('users.destroy', $item->id) }}" id="form-delete{{ $item->id}}" method="post">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger" type="submit" data-id={{ $item->id }}><i
                                class="fa fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
        {{ $users->links('pagination::bootstrap-5')}}
    </div>
</div>
@endsection