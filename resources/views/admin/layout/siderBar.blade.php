<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="app-sidebar__user">
        <div>
            <p class="app-sidebar__user-name"><b>{{Auth::user()->full_name}}</b></p>
            <p class="app-sidebar__user-designation">Chào mừng bạn trở lại</p>
        </div>
    </div>
    <hr>
    <ul class="app-menu">
        <li>
            <a class="app-menu__item active" href="{{route('admin.index')}}">
                <i class="app-menu__icon fa-solid fa-gauge" style="font-size: 22px;"></i>
                <span class="app-menu__label">Bảng điều khiển</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item " href="{{route('admin.account')}}">
                <i class="app-menu__icon fa-solid fa-users"></i>
                <span class="app-menu__label">Quản lý Tài Khoản</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item" href="{{route('admin.category')}}">
                <i class="app-menu__icon fa-solid fa-list"></i>
                <span class="app-menu__label">Quản lý Danh Mục</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item" href="{{route('admin.product')}}">
                <i class="app-menu__icon fa-solid fa-shop"></i>
                <span class="app-menu__label">Quản lý Sản Phẩm</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item" href="{{route('admin.orders')}}">
                <i class="app-menu__icon fa-solid fa-cart-arrow-down"></i>
                <span class="app-menu__label">Quản lý Đơn Hàng</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item" href="{{route('admin.brands')}}">
                <i class="app-menu__icon fa-solid fa-n"></i>
                <span class="app-menu__label">Quản lý Nhãn Hàng</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item" href="{{route('admin.banners')}}">
                <i class="app-menu__icon fa-solid fa-b"></i>
                <span class="app-menu__label">Quản lý Banners</span>
            </a>
        </li>
        {{-- <li>
            <a class="app-menu__item" href="{{route('admin.comments')}}">
                <i class="app-menu__icon fa-solid fa-comments"></i>
                <span class="app-menu__label">Quản lý Comment</span>
            </a>
        </li> --}}
        <li>
            <a class="app-menu__item" href="{{route('admin.attribute')}}">
                <i class="app-menu__icon fa-solid fa-palette"></i>
                <span class="app-menu__label">Quản lý Thuộc Tính</span>
            </a>
        </li>
    </ul>
</aside>
<!-- end sidebar -->
