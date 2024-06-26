@extends('admin.layouts.app')
@section('title', 'Create Product')
@section('content')
<div class="card">
    <h1>Tạo mới sản phẩm</h1>

    <div>
        <form action="{{ route('products.store') }}" method="post" id="createForm" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class=" input-group-static col-5 mb-4">
                    <label>Ảnh</label>
                    <input type="file" accept="image/*" name="image" id="image-input" class="form-control">

                    @error('image')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
                <div class="col-5">
                    <img src="" id="show-image" alt="" width="300px">
                </div>
            </div>

            <div class="input-group input-group-static mb-4">
                <label>Tên sản phẩm</label>
                <input type="text" value="{{ old('name') }}" name="name" class="form-control">

                @error('name')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>

            <div class="input-group input-group-static mb-4">
                <label>Giá</label>
                <input type="number" step="0.1" value="{{ old('price') }}" name="price" class="form-control">
                @error('price')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>

            <div class="input-group input-group-static mb-4">
                <label>Giảm giá</label>
                <input type="number" value="0" value="{{ old('sale') }}" name="sale" class="form-control">
                @error('sale')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>



            <div class="form-group">
                <label>Mô tả</label>
                <div class="row w-100 h-100">
                    <textarea name="description" id="description" class="form-control" cols="4" rows="5"
                        style="width: 100%">{{ old('description') }} </textarea>
                </div>
                @error('description')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
            <!-- <input type="hidden" id="inputSize" name='sizes'> -->
            <!-- Button trigger modal -->
            <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddSizeModal">
                Thêm size
            </button> -->

            <!-- Modal -->
            <!-- <div class="modal fade" id="AddSizeModal" tabindex="-1" aria-labelledby="AddSizeModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="AddSizeModalLabel">Thêm size</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="AddSizeModalBody">

                        </div>
                        <div class="mt-3">
                            <button type="button" class="btn  btn-primary btn-add-size">Thêm</button>
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="form-group">
                <label for="sizes">Sizes</label>
                <input id="sizes" type="text" class="form-control" name="sizes"
                    placeholder="Vui lòng nhập size (VD: S,M,L,...)" required>
            </div>

            <div class="form-group">
                <label for="quantities">Số lượng</label>
                <input id="quantities" type="text" class="form-control" name="quantities"
                    placeholder="Vui lòng nhập số lượng sản phẩm tương ứng với các size (VD: 10,20,30,...)" required>
            </div>

    </div>
    <div class="input-group input-group-static mb-4">
        <label name="group" class="ms-0">Danh mục</label>
        <select name="category_ids[]" class="form-control" multiple>
            @foreach ($categories as $item)
            <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        </select>

        @error('category_ids')
        <span class="text-danger"> {{ $message }}</span>
        @enderror
    </div>

    <button type="submit" class="btn btn-submit btn-primary">Lưu lại</button>
    </form>
</div>
</div>
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.21/lodash.min.js"
    integrity="sha512-WFN04846sdKMIP5LKNphMaWzU7YpMyCU245etK3g/2ARYbPK9Ub18eG+ljU96qKRCWh+quCY7yefSmlkQw1ANQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('plugin/ckeditor5-build-classic/ckeditor.js') }}"></script>
<script>

</script>
<script src="{{ asset('admin/assets/js/product/product.js') }}"></script>
@endsection