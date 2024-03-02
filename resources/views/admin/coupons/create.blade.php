@extends('admin.layouts.app')
@section('title', 'Create Coupon')
@section('content')
<div class="card">
    <h1>Tạo mã giảm giá</h1>
    <div>
        <form action="{{ route('coupons.store') }}" method="post">
            @csrf

            <div class="input-group input-group-static mb-4">
                <label>Tên</label>
                <input type="text" value="{{ old('name') }}" name="name" class="form-control"
                    style="text-transform: uppercase">

                @error('name')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
            <div class="input-group input-group-static mb-4">
                <label>Giá trị</label>
                <input type="number" value="{{ old('value') }}" name="value" class="form-control">

                @error('value')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>

            <div class="input-group input-group-static mb-4">
                <label name="group" class="ms-0">Loại</label>
                <select name="type" class="form-control">
                    <option> Chọn Loại </option>
                    <option value="money"> Tiền </option>

                </select>
            </div>
            @error('type')
            <span class="text-danger"> {{ $message }}</span>
            @enderror

            <div class="input-group input-group-static mb-4">
                <label>Ngày hết hạn</label>
                <input type="date" value="{{ old('expery_date') }}" name="expery_date" class="form-control">

                @error('expery_date')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-submit btn-primary">Lưu lại</button>
        </form>
    </div>
</div>
@endsection