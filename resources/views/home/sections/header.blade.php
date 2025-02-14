<header class="header-area sticky-bar">
    <div class="main-header-wrap">
        <div class="container">
            <div class="row">
                <div class="col-xl-2 col-lg-2">
                    <div class="logo pt-40">
                        <a href="{{ route('home.index') }}">
                            <h3 class="font-weight-bold">Ali.Ecommerce</h3>
                        </a>
                    </div>
                </div>

                <div class="col-xl-7 col-lg-7">
                    <div class="main-menu text-center">
                        <nav>
                            <ul>
                                <li class="angle-shape">
                                    <a href="about_us.html"> ارتباط با ما </a>
                                </li>

                                <li><a href="contact-us.html"> تماس با ما </a></li>

                                <li><a href="{{ route('home.compare.index') }}"> مقایسه محصولات </a></li>

                                <li class="angle-shape">
                                    <a href="javascript:void(0)"> فروشگاه </a>

                                    @php
                                        $parentCategories = \App\Models\Category::whereNull('parent_id')->get();
                                    @endphp

                                    <ul class="mega-menu">
                                        @foreach($parentCategories as $parentCategory)
                                            @php $subCategories = $parentCategory->children; @endphp
                                            <li>
                                                <a class="menu-title" href="{{ route('home.categories.show', $parentCategory->slug) }}">{{ $parentCategory->name }}</a>

                                                <ul>
                                                    @foreach($subCategories as $subCategory)
                                                            <li><a href="{{ route('home.categories.show', $subCategory->slug) }}">{{ $subCategory->name }}</a> </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>

                                <li class="angle-shape">
                                    <a href="{{ route('home.index') }}"> صفحه اصلی </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-3">
                    <div class="header-right-wrap pt-40">
                        <div class="header-search">
                            <a class="search-active" href="#"><i class="sli sli-magnifier"></i></a>
                        </div>
                        <div class="cart-wrap">
                            <button class="icon-cart-active">
                                <span class="icon-cart">
                                    <i class="sli sli-bag"></i>
                                    @if(!Cart::isEmpty())
                                        <span class="count-style">{{ Cart::getContent()->count() }}</span>
                                    @endif
                                </span>

                                @if(!Cart::isEmpty())
                                    <span class="cart-price">
                                      {{ number_format(Cart::getTotal()) }}
                                    </span>
                                    <span>تومان</span>
                                @endif
                            </button>

                            @if(!Cart::isEmpty())
                                <div class="shopping-cart-content">
                                    <div class="shopping-cart-top">
                                        <a class="cart-close" href="#"><i class="sli sli-close"></i></a>
                                        <h4>سبد خرید</h4>
                                    </div>
                                    <ul>
                                        @foreach(Cart::getContent() as $item)
                                            <li class="single-shopping-cart">
                                                <div class="shopping-cart-title">
                                                    <h4>
                                                        <a dir="rtl" href="{{ route('home.products.show', $item->associatedModel->slug) }}">
                                                            {{ Str::limit($item->name, 17, '…') }}
                                                        </a>
                                                    </h4>
                                                    <span>{{ $item->quantity }} x {{ number_format($item->price) }}</span>
                                                    <div dir="rtl">
                                                        <p class="mb-0" style="font-size: 12px">
                                                            {{ \App\Models\Attribute::find($item->attributes->attribute_id)->name }}
                                                            : {{ $item->attributes->value }}
                                                        </p>

                                                        @if($item->attributes->is_sale)
                                                            <p style="color: red; font-size: 12px">
                                                                %{{ $item->attributes->percent_discount }} تخفیف
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="shopping-cart-img">
                                                    <a href="{{ route('home.products.show', $item->associatedModel->slug) }}">
                                                        <img alt="{{ $item->associatedModel->name }}" src="{{ asset($item->associatedModel->primary_image) }}" />
                                                    </a>
                                                    <div class="item-close">
                                                        <a href="{{ route('home.cart.remove.product', $item->id) }}"><i class="sli sli-close"></i></a>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="shopping-cart-bottom">
                                        <div class="shopping-cart-total d-flex justify-content-between align-items-center"
                                             style="direction: rtl;">
                                            <h4>
                                                جمع کل :
                                            </h4>
                                            <span class="shop-total">
                                              {{ number_format(Cart::getTotal()) }} تومان
                                            </span>
                                        </div>
                                        <div class="shopping-cart-btn btn-hover text-center">
                                            <a class="default-btn" href="{{ route('home.orders.checkout') }}">
                                                ثبت سفارش
                                            </a>
                                            <a class="default-btn" href="{{ route('home.cart.index') }}">
                                                سبد خرید
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="shopping-cart-content">
                                    <div class="shopping-cart-top">
                                        <a class="cart-close" href="#"><i class="sli sli-close"></i></a>
                                        <h4>سبد خرید</h4>
                                    </div>
                                    <p class="text-right">سبد خرید شما خالی است</p>
                                </div>
                            @endif
                        </div>

                        <div class="setting-wrap">
                            <button class="setting-active">
                                <i class="sli sli-settings"></i>
                            </button>
                            <div class="setting-content">
                                <ul class="text-right">
                                    @auth
                                        <li><a href="{{ route('home.profile.index') }}">پروفایل</a></li>
                                        {{-- logut form --}}
                                        <form id="logput_form" action="{{ route('logout') }}" method="post">
                                            @csrf
                                            <li><a href="javascript:$('#logput_form').submit();">خروج</a></li>
                                        </form>
                                    @else
                                        <li><a href="{{ route('login') }}">ورود</a></li>
                                        <li><a href="{{ route('register') }}">ایجاد حساب</a></li>
                                    @endauth
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- main-search start -->
        <div class="main-search-active">
            <div class="sidebar-search-icon">
                <button class="search-close">
                    <span class="sli sli-close"></span>
                </button>
            </div>
            <div class="sidebar-search-input">
                <form>
                    <div class="form-search">
                        <input id="search" class="input-text" value="" placeholder=" ...جستجو " type="search" />
                        <button>
                            <i class="sli sli-magnifier"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="header-small-mobile">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-6">
                    <div class="mobile-logo">
                        <a href="{{ route('home.index') }}">
                            <h4 class="font-weight-bold">Ali.Ecommerce</h4>
                        </a>
                    </div>
                </div>
                <div class="col-6">
                    <div class="header-right-wrap">
                        <div class="cart-wrap">
                            <button class="icon-cart-active">
                                <span class="icon-cart">
                                    <i class="sli sli-bag"></i>
                                    @if(!Cart::isEmpty())
                                        <span class="count-style">{{ Cart::getContent()->count() }}</span>
                                    @endif
                                </span>

                                @if(!Cart::isEmpty())
                                    <span class="cart-price">
                                      {{ number_format(Cart::getTotal()) }}
                                    </span>
                                    <span>تومان</span>
                                @endif
                            </button>
                            <div class="shopping-cart-content">
                                <div class="shopping-cart-top">
                                    <a class="cart-close" href="#"><i class="sli sli-close"></i></a>
                                    <h4>سبد خرید</h4>
                                </div>
                                <ul style="height: 400px;">
                                    @foreach(Cart::getContent() as $item)
                                        <li class="single-shopping-cart">
                                                <div class="shopping-cart-title">
                                                    <h4>
                                                        <a dir="rtl" href="{{ route('home.products.show', $item->associatedModel->slug) }}">
                                                            {{ Str::limit($item->name, 17, '…') }}
                                                        </a>
                                                    </h4>
                                                    <span>{{ $item->quantity }} x {{ number_format($item->price) }}</span>
                                                    <div dir="rtl">
                                                        <p class="mb-0" style="font-size: 12px">
                                                            {{ \App\Models\Attribute::find($item->attributes->attribute_id)->name }}
                                                            : {{ $item->attributes->value }}
                                                        </p>

                                                        @if($item->attributes->is_sale)
                                                            <p style="color: red; font-size: 12px">
                                                                %{{ $item->attributes->percent_discount }} تخفیف
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="shopping-cart-img">
                                                    <a href="{{ route('home.products.show', $item->associatedModel->slug) }}">
                                                        <img alt="{{ $item->associatedModel->name }}" src="{{ asset($item->associatedModel->primary_image) }}" />
                                                    </a>
                                                    <div class="item-close">
                                                        <a href="{{ route('home.cart.remove.product', $item->id) }}"><i class="sli sli-close"></i></a>
                                                    </div>
                                                </div>
                                            </li>
                                    @endforeach
                                </ul>
                                <div class="shopping-cart-bottom">
                                    <div class="shopping-cart-total d-flex justify-content-between align-items-center"
                                         style="direction: rtl;">
                                        <h4>
                                            جمع کل :
                                        </h4>
                                        <span class="shop-total">
                                          {{ number_format(Cart::getTotal()) }} تومان
                                        </span>
                                    </div>
                                    <div class="shopping-cart-btn btn-hover text-center">
                                        <a class="default-btn" href="{{ route('home.orders.checkout') }}">
                                            ثبت سفارش
                                        </a>
                                        <a class="default-btn" href="{{ route('home.cart.index') }}">
                                            سبد خرید
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mobile-off-canvas">
                            <a class="mobile-aside-button" href="#"><i class="sli sli-menu"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
