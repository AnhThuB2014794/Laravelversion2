<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/material-dashboard/pages/dashboard "
            target="_blank">
            <img src="admin/assets/img/icons/logo.jpg" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold text-white">Hello: {{auth()->user()->name}}</span>
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('dashboard.*') ? 'bg-gradient-primary active' :'' }} "
                    href="{{ route('dashboard.index')}}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                    </div>
                    <span class="nav-link-text ms-1">Thống Kê</span>
                </a>
            </li>
            @hasrole('super-admin')
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('roles.*') ? 'bg-gradient-primary active' :'' }} "
                    href="{{route('roles.index')}}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">table_view</i>
                    </div>
                    <span class="nav-link-text ms-1">Vai Trò</span>
                </a>
            </li>
            @endhasrole
            @can('show-user')
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('users.*') ? 'bg-gradient-primary active' :'' }} "
                    href="{{route('users.index')}}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">receipt_long</i>
                    </div>
                    <span class="nav-link-text ms-1">Người Dùng</span>
                </a>
            </li>
            @endcan
            @can('show-product')
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('products.*') ? 'bg-gradient-primary active' :'' }}"
                    href="{{route('products.index')}}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">view_in_ar</i>
                    </div>
                    <span class="nav-link-text ms-1">Sản Phẩm</span>
                </a>
            </li>
            @endcan

            @can('show-category')
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('categories.*') ? 'bg-gradient-primary active' :'' }} "
                    href="{{route('categories.index')}}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">format_textdirection_r_to_l</i>
                    </div>
                    <span class="nav-link-text ms-1">Danh mục</span>
                </a>
            </li>
            @endcan

            @can('show-coupon')
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('coupons.*') ? 'bg-gradient-primary active' :'' }} "
                    href="{{route('coupons.index')}}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">format_textdirection_r_to_l</i>
                    </div>
                    <span class="nav-link-text ms-1">Mã giảm giá</span>
                </a>
            </li>
            @endcan
            @can('update-order-status')
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.orders.*') ? 'bg-gradient-primary active' :'' }} "
                    href="{{route('admin.orders.index')}}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">shopping_cart</i>
                    </div>
                    <span class="nav-link-text ms-1">Đơn hàng</span>
                </a>
            </li>
            @endcan
            @can('show-warehouse')
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('warehouse.*') ? 'bg-gradient-primary active' :'' }} "
                    href="{{ route('warehouse.index') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">warehouse</i>
                    </div>
                    <span class="nav-link-text ms-1">Kho hàng</span>
                </a>
            </li>
            @endcan
            @can('show-material')
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('materials.*') ? 'bg-gradient-primary active' :'' }} "
                    href="{{ route('materials.index') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">
                            account_balance
                            </span></i>
                    </div>
                    <span class="nav-link-text ms-1">Sản phẩm nhập vào</span>
                </a>
            </li>
            @endcan
        </ul>
    </div>
</aside>