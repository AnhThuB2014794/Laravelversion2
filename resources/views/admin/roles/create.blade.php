@extends('admin.layouts.app')
@section('title', 'Create Roles')
@section('content')
<div class="card">
    <h1>Tạo vai trò</h1>
    <div>
        <form action="{{route('roles.store')}}" method="post">
            @csrf
            <div class="input-group input-group-static mb-4">
                <label for="">Tên</label>
                <input type="text" value="{{ old('name') }}" name="name" class="form-control">

                @error('name')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="input-group input-group-static mb-4">
                <label for="">Tên Hiển Thị</label>
                <input type="text" value="{{ old('display_name')}}" name="display_name" class="form-control">

                @error('display_name')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="input-group input-group-static mb4">
                <label name="group" class="ms-0">Nhóm</label>
                <select name="group" class="form-control">
                    <option value="system">Hệ thống</option>
                    <option value="user">Người dùng</option>
                </select>

                @error('group')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="">Sự cho phép</label>
                <div class="row">
                    @foreach ($permissions as $groupName => $permission)
                    <div class="col-5">
                        <h4>{{$groupName}}</h4>
                        <div>
                            @foreach($permission as $item)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $item->id }}"
                                    name="permission_ids[]">
                                <label for="customCheck1" class="custom-control-label">{{$item->display_name}}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <button type="submit" class="btn btn-submit btn-primary">Lưu lại</button>

        </form>
    </div>
</div>
@endsection