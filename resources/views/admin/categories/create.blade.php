@extends('admin.layouts.app')
@section('title', 'Create Category')
@section('content')
<div class="card">
    <h1>Tạo danh mục</h1>
    <div>
        <form action="{{route('categories.store')}}" method="post">
            @csrf
            <div class="input-group input-group-static mb-4">
                <label for="">Tên</label>
                <input type="text" value="{{ old('name') }}" name="name" class="form-control">

                @error('name')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="input-group input-group-static mb4">
                <label name="group" class="ms-0">Danh mục cha</label>
                <select name="parent_id" class="form-control">
                    <option value="">Chọn danh mục cha</option>
                    @foreach ($parentCategories as $item)
                    <option value="{{ $item->id }}" {{ old('parent_id') == $item->id ? 'selected' : ''}}>
                        {{ $item->name }}</option>
                    @endforeach
                </select>

                @error('parent_ids')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-submit btn-primary">Lưu lại</button>

        </form>
    </div>
</div>
@endsection