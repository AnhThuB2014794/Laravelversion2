@extends('admin.layouts.app')
@section('title', 'Edit User '.$user->name)
@section('content')
<div class="card">
    <h1>Cập nhật người dùng</h1>
    <div>
        <form action="{{route('users.update', $user->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <!-- <div class="row">
                <div class="input-group-static col-5 mb-4">
                    <label for="">Ảnh</label>
                    <input type="file" accept="image/*" name="image" class="form-control" id="image-input">

                    @error('image')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="col-5">
                    <img src="" id="show-image" alt="">
                </div>
            </div> -->


            <div class="input-group input-group-static mb-4">
                <label for="">Tên</label>
                <input type="text" value="{{ old('name') ?? $user->name}}" name="name" class="form-control">

                @error('name')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="input-group input-group-static mb-4">
                <label for="">Email</label>
                <input type="email" value="{{ old('email') ?? $user->email}}" name="email" class="form-control">

                @error('email')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="input-group input-group-static mb-4">
                <label for="">Số điện thoại</label>
                <input type="phone" value="{{ old('phone') ?? $user->phone}}" name="phone" class="form-control">

                @error('email')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="input-group input-group-static mb4">
                <label name="group" class="ms-0">Giới tính</label>
                <select name="gender" class="form-control" value={{ $user->gender}}>
                    <option value="male">Nam</option>
                    <option value="fe-male">Nữ</option>
                </select>

                @error('gender')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="input-group input-group-static mb-4">
                <label for="">Địa chỉ</label>
                <textarea name="address" class="form-control">{{ old('address') ?? $user->address}}</textarea>

                @error('address')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <!-- <div class="input-group input-group-static mb-4">
                <label for="">Mật khẩu</label>
                <input type="password" name="password" class="form-control">

                @error('password')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div> -->



            <div class="form-group">
                <label for="">Vai Trò</label>
                <div class="row">
                    @foreach ($roles as $groupName => $role)
                    <div class="col-5">
                        <h4>{{$groupName}}</h4>
                        <div>
                            @foreach($role as $item)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $item->id }}"
                                    name="role_ids[]" {{ $user->roles->contains('id', $item->id) ? 'checked' : ''}}>
                                <label for="customCheck1" class="custom-control-label">{{$item->display_name}}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <button type="submit" class="btn btn-submit btn-primary">Cập nhật</button>

        </form>
    </div>
</div>
@endsection

<!-- @section('script')
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
    crossorigin="anonymous">
</script>
<script>
$(document).ready(function() {
    $("#image-input").change(function() {
        readURL(this);
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#show-image').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
});
</script>
@endsection -->