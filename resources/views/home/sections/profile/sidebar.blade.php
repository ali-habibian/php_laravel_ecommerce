<div class="myaccount-tab-menu nav" role="tablist">

    <a href="{{ route('home.profile.index') }}" class="{{ Route::is('home.profile.index') ? 'active' : '' }}">
        <i class="sli sli-user ml-1"></i>
        پروفایل
    </a>

    <a href="#orders">
        <i class="sli sli-basket ml-1"></i>
        سفارشات
    </a>

    <a href="#address">
        <i class="sli sli-map ml-1"></i>
        آدرس ها
    </a>

    <a href="{{ route('home.profile.wishlist.index') }}" class="{{ Route::is('home.profile.wishlist.index') ? 'active' : '' }}">
        <i class="sli sli-heart ml-1"></i>
        لیست علاقه‌مندی ها
    </a>

    <a href="{{ route('home.profile.comments.index') }}" class="{{ Route::is('home.profile.comments.index') ? 'active' : '' }}">
        <i class="sli sli-bubble ml-1"></i>
        دیدگاه ها
    </a>

    <form id="logput_form" action="{{ route('logout') }}" method="post">
        @csrf
        <a href="javascript:$('#logput_form').submit();">
            <i class="sli sli-logout ml-1"></i>
            خروج
        </a>
    </form>

</div>