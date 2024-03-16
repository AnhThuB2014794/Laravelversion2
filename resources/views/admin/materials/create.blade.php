@extends('admin.layouts.app')
@section('title','Create Import Product')
@section('content')
<div class="card">
    <h1>Create Import Material</h1>

    <div>
        <form action="{{route('materials.store') }}" method="post" id="createForm" enctype="multipart/form-data">
            @csrf

            

            <div class="input-group input-group-static mb-4">
                <label name="group" class="ms-0">Chọn sản phẩm</label>
                <select name="product_id" class="form-control" multiple >
                    
                    @foreach ($products as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>

                @error('products')
                    <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>


            <div class="input-group input-group-static mb-4">
                <label>Số lượng nhập vào</label>
                <input type="number"  value="{{ old('import_quantity') }}" name="import_quantity" class="form-control">
                @error('import_quantity')
                    <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>



            <div class="input-group input-group-static mb-4">
                <label>Giá nhập vào</label>
                <input type="number"  value="{{ old('import_price') }}" name="import_price" class="form-control">
                @error('import_price')
                    <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>

            <div class="input-group input-group-static mb-4">
                <label>Ngày nhập vào</label>
                <input type="date"  value="{{ old('import_date') }}" name="import_date" class="form-control">
                @error('import_date')
                    <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
            

            
           
    </div>
    
    <button type="submit" class="btn btn-submit btn-primary">Submit</button>
    </form>
</div>
</div>
@endsection
