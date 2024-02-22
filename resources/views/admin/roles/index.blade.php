@extends('admin.layouts.app')
@section('title', 'Roles')
@section('content')
<div class="card">
    <h1>
        Danh sách vai trò
    </h1>
    @if (session('message'))
    <h1 class="text-primary">{{ session('message')}}</h1>
    @endif

    <div><a href="{{ route('roles.create')}}" class="btn btn-primary">Tạo mới</a></div>
    <div>
        <table class="table table-hover">
            <tr>
                <th>#</th>
                <th>Tên</th>
                <th>Tên Hiển Thị</th>
                <th>Hoạt động</th>
            </tr>
            @foreach ($roles as $role)
            <tr>
                <td>{{ $role->id}}</td>
                <td>{{ $role->name}}</td>
                <td>{{ $role->display_name}}</td>
                <td>
                    <a href="{{ route('roles.edit', $role->id)}}" class="btn btn-success"><i class="fa fa-edit"></i></a>

                    <form action="{{ route('roles.destroy', $role->id) }}" id="form-delete{{ $role->id}}" method="post">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger" type="submit" data-id={{ $role->id }}><i
                                class="fa fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
        {{ $roles->links('pagination::bootstrap-5')}}
    </div>
</div>
@endsection