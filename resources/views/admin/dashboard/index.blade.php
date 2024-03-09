@extends('admin.layouts.app')

@section('content')
<div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
    <div class="card">
        <div class="card-header p-3 pt-2">
            <div
                class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">weekend</i>
            </div>
            <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Vai trò</p>
                <h4 class="mb-0">{{$roleCount}}</h4>
            </div>
        </div>
        <hr class="dark horizontal my-0">

    </div>
</div>
<div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
    <div class="card">
        <div class="card-header p-3 pt-2">
            <div
                class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">person</i>
            </div>
            <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Người dùng</p>
                <h4 class="mb-0">{{$userCount}}</h4>
            </div>
        </div>
        <hr class="dark horizontal my-0">

    </div>
</div>
<div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
    <div class="card">
        <div class="card-header p-3 pt-2">
            <div
                class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">person</i>
            </div>
            <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Danh mục</p>
                <h4 class="mb-0">{{$categoryCount}}</h4>
            </div>
        </div>
        <hr class="dark horizontal my-0">

    </div>
</div>
<div class="col-xl-3 col-sm-6">
    <div class="card">
        <div class="card-header p-3 pt-2">
            <div
                class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">weekend</i>
            </div>
            <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Sản phẩm</p>
                <h4 class="mb-0">{{$productCount}}</h4>
            </div>
        </div>
        <hr class="dark horizontal my-0">

    </div>
</div>

<div class="col-xl-3 col-sm-6 mt-4">
    <div class="card">
        <div class="card-header p-3 pt-2">
            <div
                class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">weekend</i>
            </div>
            <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Đơn hàng</p>
                <h4 class="mb-0">{{$orderCount}}</h4>
            </div>
        </div>
        <hr class="dark horizontal my-0">

    </div>
</div>
@endsection