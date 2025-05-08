@php
$usersShowClass = request()->is('admin-panel/management/users*')
|| request()->is('admin-panel/management/roles*')
|| request()->is('admin-panel/management/permissions*') ? 'show' : '';

$productsShowClass = request()->is('admin-panel/management/products*')
|| request()->is('admin-panel/management/categories*')
|| request()->is('admin-panel/management/attributes*')
|| request()->is('admin-panel/management/tags*')
|| request()->is('admin-panel/management/comments*') ? 'show' : '';

$ordersShowClass = request()->is('admin-panel/management/orders*')
|| request()->is('admin-panel/management/transactions*')
|| request()->is('admin-panel/management/coupons*') ? 'show' : '';
@endphp
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion pr-0" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Ali Ecommerce</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span> داشبورد </span></a>
    </li>

    <!--------------------------------- Users section --------------------------------->
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        کاربران
    </div>

    <!-- Nav Item - Users Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsers" aria-expanded="true"
           aria-controls="collapseUsers">
            <i class="fas fa-users"></i>
            <span> کاربران </span>
        </a>
        <div id="collapseUsers" class="collapse {{ $usersShowClass }}" aria-labelledby="headingUsers" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->is('admin-panel/management/users*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">لیست کاربران</a>
                <a class="collapse-item {{ request()->is('admin-panel/management/roles*') ? 'active' : '' }}" href="{{ route('admin.roles.index') }}">لیست نقش‌های کاربری</a>
                <a class="collapse-item {{ request()->is('admin-panel/management/permissions*') ? 'active' : '' }}" href="{{ route('admin.permissions.index') }}">لیست مجوز‌های دسترسی</a>
            </div>
        </div>
    </li>
    <!--------------------------------- End Users section ----------------------------->

    <!--------------------------------- Store section --------------------------------->
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        فروشگاه
    </div>

    <!-- Nav Item - Brands -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.brands.index') }}">
            <i class="fas fa-store"></i>
            <span> برندها </span></a>
    </li>

    <!-- Nav Item - Products Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProducts" aria-expanded="true"
           aria-controls="collapseProducts">
            <i class="fas fa-fw fa-cart-plus"></i>
            <span> محصولات </span>
        </a>
        <div id="collapseProducts" class="collapse {{ $productsShowClass }}" aria-labelledby="headingProducts" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->is('admin-panel/management/products*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">محصولات</a>
                <a class="collapse-item {{ request()->is('admin-panel/management/categories*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">دسته بندی ها</a>
                <a class="collapse-item {{ request()->is('admin-panel/management/attributes*') ? 'active' : '' }}" href="{{ route('admin.attributes.index') }}">ویژگی ها</a>
                <a class="collapse-item {{ request()->is('admin-panel/management/tags*') ? 'active' : '' }}" href="{{ route('admin.tags.index') }}">تگ ها</a>
                <a class="collapse-item {{ request()->is('admin-panel/management/comments*') ? 'active' : '' }}" href="{{ route('admin.comments.index') }}">دیدگاه ها</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Orders Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOrders" aria-expanded="true"
           aria-controls="collapseProducts">
            <i class="fas fa-handshake"></i>
            <span> سفارشات </span>
        </a>
        <div id="collapseOrders" class="collapse {{ $ordersShowClass }}" aria-labelledby="headingOrders" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->is('admin-panel/management/orders*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">سفارشات</a>
                <a class="collapse-item {{ request()->is('admin-panel/management/transactions*') ? 'active' : '' }}" href="{{ route('admin.transactions.index') }}">تراکنش ها</a>
                <a class="collapse-item {{ request()->is('admin-panel/management/coupons*') ? 'active' : '' }}" href="{{ route('admin.coupons.index') }}">کوپن‌ها</a>
            </div>
        </div>
    </li>
    <!--------------------------------- End store section --------------------------------->

    <!--------------------------------- Settings section --------------------------------->
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        تنظیمات
    </div>

    <!-- Nav Item - Brands -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.banners.index') }}">
            <i class="fas fa-image"></i>
            <span> بنرها </span></a>

        <a class="nav-link" href="{{ route('admin.settings.index') }}">
            <i class="fas fa-address-card"></i>
            <span> تماس با ما </span></a>
    </li>
    <!--------------------------------- End settings section --------------------------------->

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
