<div class="mobile-off-canvas-active">
    <a class="mobile-aside-close">
        <i class="sli sli-close"></i>
    </a>

    <div class="header-mobile-aside-wrap">
        <div class="mobile-search">
            <form class="search-form" action="#">
                <input type="text" placeholder=" ... جستجو " />
                <button class="button-search">
                    <i class="sli sli-magnifier"></i>
                </button>
            </form>
        </div>

        <div class="mobile-menu-wrap">
            <!-- mobile menu start -->
            <div class="mobile-navigation">
                <!-- mobile menu navigation start -->
                <nav>
                    <ul class="mobile-menu text-right">
                        <li class="menu-item-has-children">
                            <a href="{{ route('home.index') }}"> صفحه اصلی </a>
                        </li>
                        <li class="menu-item-has-children">
                            <a href=javascript:void(0);>فروشگاه</a>

                            @php
                                $parentCategories = \App\Models\Category::whereNull('parent_id')->get();
                            @endphp

                            <ul class="dropdown">
                                @foreach($parentCategories as $parentCategory)
                                    @php $subCategories = $parentCategory->children; @endphp
                                    <li class="menu-item-has-children">
                                        <a href="{{ route('home.categories.show', $parentCategory->slug) }}">{{ $parentCategory->name }}</a>
                                        <ul class="dropdown">
                                           @foreach($subCategories as $subCategory)
                                                <li><a href="{{ route('home.categories.show', $subCategory->slug) }}"> {{ $subCategory->name }} </a></li>
                                           @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </li>

                        <li><a href="{{ route('home.compare.index') }}"> مقایسه محصولات </a></li>

                        <li><a href="contact-us.html">تماس با ما</a></li>

                        <li><a href="about_us.html"> در باره ما</a></li>
                    </ul>
                </nav>
                <!-- mobile menu navigation end -->
            </div>
            <!-- mobile menu end -->
        </div>

        <div class="mobile-curr-lang-wrap">
            <div class="single-mobile-curr-lang">
                <ul class="text-right">
                    @auth
                        <li class="my-3"><a href="{{ route('home.profile.index') }}">پروفایل</a></li>
                        {{-- logut form --}}
                        <form id="logput_form" action="{{ route('logout') }}" method="post">
                                            @csrf
                            <li class="my-3"><a href="javascript:$('#logput_form').submit();">خروج</a></li>
                                        </form>
                    @else
                        <li class="my-3"><a href="{{ route('login') }}">ورود</a></li>
                        <li class="my-3"><a href="{{ route('register') }}">ایجاد حساب</a></li>
                    @endauth
                </ul>
            </div>
        </div>

        <div class="mobile-social-wrap text-center">
            <a class="facebook" href="#"><i class="sli sli-social-facebook"></i></a>
            <a class="twitter" href="#"><i class="sli sli-social-twitter"></i></a>
            <a class="pinterest" href="#"><i class="sli sli-social-pinterest"></i></a>
            <a class="instagram" href="#"><i class="sli sli-social-instagram"></i></a>
            <a class="google" href="#"><i class="sli sli-social-google"></i></a>
        </div>
    </div>
</div>
