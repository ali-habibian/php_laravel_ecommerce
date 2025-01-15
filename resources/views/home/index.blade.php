@extends('home.layouts.home')

@section('title', 'فروشگاه اینترنتی')

@section('content')
    {{-- Slider --}}
    <div class="slider-area section-padding-1">
        <div class="slider-active owl-carousel nav-style-1">
            @foreach($sliders as $slider)
                <div class="single-slider slider-height-1 bg-paleturquoise">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-12 col-sm-6 text-right">
                                <div class="slider-content slider-animated-1">
                                    <h1 class="animated">{{ $slider->title }}</h1>
                                    <p class="animated">
                                        {{ $slider->description }}
                                    </p>
                                    <div class="slider-btn btn-hover">
                                        <a class="animated" href="{{$slider->button_link}}">
                                            <i class="{{$slider->button_icon}}"></i>
                                            {{$slider->button_text}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-12 col-sm-6">
                                <div class="slider-single-img slider-animated-1">

                                    <img class="animated" src="{{ asset($slider->image) }}" alt="{{ $slider->title }}"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    {{-- End Slider --}}

    {{-- Index Top Banner Area --}}
    <div class="banner-area pt-100 pb-65">
        <div class="container">
            <div class="row">
                @foreach($indexTopBanners->chunk(3)->first() as $banner)
                    <div class="col-lg-4 col-md-4">
                        <div class="single-banner mb-30 scroll-zoom">
                            <a href="{{ $banner->button_link }}"><img class="animated" src="{{ asset($banner->image) }}"
                                                                      alt="{{ $banner->title }}"/></a>
                            <div class="banner-content-2 banner-position-5">
                                <h4>{{ $banner->title }}</h4>
                            </div>
                        </div>
                    </div>
                @endforeach

                @foreach($indexTopBanners->chunk(3)->last() as $banner)
                    <div class="col-lg-6 col-md-6">
                        <div class="single-banner mb-30 scroll-zoom">
                            <a href="{{ $banner->button_link }}"><img class="animated" src="{{ asset($banner->image) }}"
                                                                      alt="{{ $banner->title }}"/></a>
                            <div class="banner-content banner-position-6 text-right">
                                <h3>{{ $banner->title }}</h3>
                                <a href="{{ $banner->button_link }}">
                                    {{ $banner->button_text }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    {{-- End Index Top Banner Area --}}

    {{-- Product Area 1 --}}
    <div class="product-area pb-70">
        <div class="container">
            <div class="section-title text-center pb-40">
                <h2> لورم ایپسوم </h2>
                <p>
                    لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.
                    چاپگرها و متون
                    بلکه روزنامه و مجله
                </p>
            </div>
            <div class="product-tab-list nav pb-60 text-center flex-row-reverse">
                @foreach($parentCategories as $parentCategory)
                    <a class="{{ $loop->first ? 'active' : '' }}"
                       href="#product-{{ $parentCategory->id }}"
                       data-toggle="tab">
                        <h4>{{ $parentCategory->name }}</h4>
                    </a>
                @endforeach
            </div>
            <div class="tab-content jump-2">
                @foreach($parentCategories as $parentCategory)
                    <div id="product-{{ $parentCategory->id }}" class="tab-pane {{$loop->first ? 'active' : ''}}">
                        <div class="ht-products product-slider-active owl-carousel">
                            @foreach($parentCategory->uniqueProducts as $product)
                                <div class="ht-product ht-product-action-on-hover ht-product-category-right-bottom mb-30">
                                    <div class="ht-product-inner">
                                        <div class="ht-product-image-wrap">
                                            <a href="product-details.html" class="ht-product-image">
                                                <img src="{{ asset($product->primary_image) }}"
                                                     alt="{{ $product->name }}"/>
                                            </a>
                                            <div class="ht-product-action">
                                                <ul>
                                                    <li>
                                                        <a href="javascript:void(0)"
                                                           data-toggle="modal"
                                                           data-target="#productDetailModal-{{$product->id}}"
                                                           onclick="setActiveVariation({{ json_encode($product) }})"
                                                        >
                                                            <i class="sli sli-magnifier"></i>
                                                            <span class="ht-product-action-tooltip"> مشاهده سریع </span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <i class="sli sli-heart"></i>
                                                            <span class="ht-product-action-tooltip"> افزودن به علاقه مندی ها </span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <i class="sli sli-refresh"></i>
                                                            <span class="ht-product-action-tooltip"> مقایسه </span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <i class="sli sli-bag"></i>
                                                            <span class="ht-product-action-tooltip"> افزودن به سبد </span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="ht-product-content">
                                            <div class="ht-product-content-inner">
                                                <div class="ht-product-categories">
                                                    <a href="#">{{ $product->category->name }}</a>
                                                </div>
                                                <h4 class="ht-product-title text-right">
                                                    <a href="product-details.html"> {{ $product->name }} </a>
                                                </h4>
                                                <div class="ht-product-price">
                                                    @if($product->quantity_check)
                                                        @if($product->sale_check)
                                                            <span class="new">
                                                                {{ number_format($product->sale_check->sale_price) }}
                                                                تومان
                                                            </span>
                                                            <span class="old">
                                                                {{ number_format($product->sale_check->price) }}
                                                                تومان
                                                            </span>
                                                        @else
                                                            <span class="new">
                                                                {{ number_format($product->min_price->price) }}
                                                                تومان
                                                            </span>
                                                        @endif
                                                    @else
                                                        <div class="not-in-stock">
                                                            <p class="not-in-stock-text">
                                                                ناموجود
                                                            </p>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ht-product-ratting-wrap">
                                                    <span class="ht-product-ratting">
                                                        <span class="ht-product-user-ratting" style="width: 100%;">
                                                            <i class="sli sli-star"></i>
                                                            <i class="sli sli-star"></i>
                                                            <i class="sli sli-star"></i>
                                                            <i class="sli sli-star"></i>
                                                            <i class="sli sli-star"></i>
                                                        </span>
                                                        <i class="sli sli-star"></i>
                                                        <i class="sli sli-star"></i>
                                                        <i class="sli sli-star"></i>
                                                        <i class="sli sli-star"></i>
                                                        <i class="sli sli-star"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    {{-- End Product Area 1 --}}

    {{-- Testimonial Area --}}
    <div class="testimonial-area pt-80 pb-95 section-margin-1" style="background-image: url(assets/img/bg/bg-1.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 ml-auto mr-auto">
                    <div class="testimonial-active owl-carousel nav-style-1">
                        <div class="single-testimonial text-center">
                            <img src="assets/img/testimonial/testi-1.png" alt=""/>
                            <p>
                                لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک
                                است. چاپگرها و
                                متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد
                                نیاز و
                                کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد
                                گذشته، حال و
                                آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت
                            </p>
                            <div class="client-info">
                                <img src="assets/img/icon-img/testi.png" alt=""/>
                                <h5>لورم ایپسوم</h5>
                            </div>
                        </div>
                        <div class="single-testimonial text-center">
                            <img src="assets/img/testimonial/testi-2.png" alt=""/>
                            <p>
                                لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک
                                است. چاپگرها و
                                متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد
                                نیاز و
                                کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد
                                گذشته، حال و
                                آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت
                            </p>
                            <div class="client-info">
                                <img src="assets/img/icon-img/testi.png" alt=""/>
                                <h5>لورم ایپسوم</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End Testimonial Area --}}

    {{-- Product Area 2 --}}
    <div class="product-area pt-95 pb-70">
        <div class="container">
            <div class="section-title text-center pb-60">
                <h2>لورم ایپسوم</h2>
                <p>
                    لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها
                    و متون
                    بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است
                </p>
            </div>
            <div class="arrivals-wrap scroll-zoom">
                <div class="ht-products product-slider-active owl-carousel">
                    <!--Product Start-->
                    <div class="ht-product ht-product-action-on-hover ht-product-category-right-bottom mb-30">
                        <div class="ht-product-inner">
                            <div class="ht-product-image-wrap">
                                <a href="product-details.html" class="ht-product-image">
                                    <img src="assets/img/product/product-1.svg" alt="Universal Product Style"/>
                                </a>
                                <div class="ht-product-action">
                                    <ul>
                                        <li>
                                            <a href="#" data-toggle="modal" data-target="#exampleModal"><i
                                                        class="sli sli-magnifier"></i><span
                                                        class="ht-product-action-tooltip"> مشاهده سریع
                          </span></a>
                                        </li>
                                        <li>
                                            <a href="#"><i class="sli sli-heart"></i><span
                                                        class="ht-product-action-tooltip"> افزودن به
                            علاقه مندی ها </span></a>
                                        </li>
                                        <li>
                                            <a href="#"><i class="sli sli-refresh"></i><span
                                                        class="ht-product-action-tooltip"> مقایسه
                          </span></a>
                                        </li>
                                        <li>
                                            <a href="#"><i class="sli sli-bag"></i><span
                                                        class="ht-product-action-tooltip"> افزودن به سبد
                            خرید </span></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="ht-product-content">
                                <div class="ht-product-content-inner">
                                    <div class="ht-product-categories">
                                        <a href="#">لورم</a>
                                    </div>
                                    <h4 class="ht-product-title text-right">
                                        <a href="product-details.html"> لورم ایپسوم </a>
                                    </h4>
                                    <div class="ht-product-price">
                      <span class="new">
                        55,000
                        تومان
                      </span>
                                        <span class="old">
                        75,000
                        تومان
                      </span>
                                    </div>
                                    <div class="ht-product-ratting-wrap">
                      <span class="ht-product-ratting">
                        <span class="ht-product-user-ratting" style="width: 100%;">
                          <i class="sli sli-star"></i>
                          <i class="sli sli-star"></i>
                          <i class="sli sli-star"></i>
                          <i class="sli sli-star"></i>
                          <i class="sli sli-star"></i>
                        </span>
                        <i class="sli sli-star"></i>
                        <i class="sli sli-star"></i>
                        <i class="sli sli-star"></i>
                        <i class="sli sli-star"></i>
                        <i class="sli sli-star"></i>
                      </span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!--Product End-->
                    <!--Product Start-->
                    <div class="ht-product ht-product-action-on-hover ht-product-category-right-bottom mb-30">
                        <div class="ht-product-inner">
                            <div class="ht-product-image-wrap">
                                <a href="product-details.html" class="ht-product-image">
                                    <img src="assets/img/product/product-2.svg" alt="Universal Product Style"/>
                                </a>
                                <div class="ht-product-action">
                                    <ul>
                                        <li>
                                            <a href="#" data-toggle="modal" data-target="#exampleModal"><i
                                                        class="sli sli-magnifier"></i><span
                                                        class="ht-product-action-tooltip"> مشاهده سریع
                          </span></a>
                                        </li>
                                        <li>
                                            <a href="#"><i class="sli sli-heart"></i><span
                                                        class="ht-product-action-tooltip"> افزودن به
                            علاقه مندی ها </span></a>
                                        </li>
                                        <li>
                                            <a href="#"><i class="sli sli-refresh"></i><span
                                                        class="ht-product-action-tooltip"> مقایسه
                          </span></a>
                                        </li>
                                        <li>
                                            <a href="#"><i class="sli sli-bag"></i><span
                                                        class="ht-product-action-tooltip"> افزودن به سبد
                            خرید </span></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="ht-product-content">
                                <div class="ht-product-content-inner">
                                    <div class="ht-product-categories">
                                        <a href="#">لورم </a>
                                    </div>
                                    <h4 class="ht-product-title text-right">
                                        <a href="product-details.html">لورم ایپسوم</a>
                                    </h4>
                                    <div class="ht-product-price">
                      <span class="new">
                        25,000
                        تومان
                      </span>
                                    </div>
                                    <div class="ht-product-ratting-wrap">
                      <span class="ht-product-ratting">
                        <span class="ht-product-user-ratting" style="width: 100%;">
                          <i class="sli sli-star"></i>
                          <i class="sli sli-star"></i>
                          <i class="sli sli-star"></i>
                          <i class="sli sli-star"></i>
                          <i class="sli sli-star"></i>
                        </span>
                        <i class="sli sli-star"></i>
                        <i class="sli sli-star"></i>
                        <i class="sli sli-star"></i>
                        <i class="sli sli-star"></i>
                        <i class="sli sli-star"></i>
                      </span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!--Product End-->
                    <!--Product Start-->
                    <div class="ht-product ht-product-action-on-hover ht-product-category-right-bottom mb-30">
                        <div class="ht-product-inner">
                            <div class="ht-product-image-wrap">
                                <a href="product-details.html" class="ht-product-image">
                                    <img src="assets/img/product/product-3.svg" alt="Universal Product Style"/>
                                </a>
                                <div class="ht-product-action">
                                    <ul>
                                        <li>
                                            <a href="#" data-toggle="modal" data-target="#exampleModal"><i
                                                        class="sli sli-magnifier"></i><span
                                                        class="ht-product-action-tooltip"> مشاهده سریع
                          </span></a>
                                        </li>
                                        <li>
                                            <a href="#"><i class="sli sli-heart"></i><span
                                                        class="ht-product-action-tooltip"> افزودن به
                            علاقه مندی ها </span></a>
                                        </li>
                                        <li>
                                            <a href="#"><i class="sli sli-refresh"></i><span
                                                        class="ht-product-action-tooltip"> مقایسه
                          </span></a>
                                        </li>
                                        <li>
                                            <a href="#"><i class="sli sli-bag"></i><span
                                                        class="ht-product-action-tooltip"> افزودن به سبد
                            خرید </span></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="ht-product-content">
                                <div class="ht-product-content-inner">
                                    <div class="ht-product-categories">
                                        <a href="#">لورم</a>
                                    </div>
                                    <h4 class="ht-product-title text-right">
                                        <a href="product-details.html">لورم ایپسوم</a>
                                    </h4>
                                    <div class="ht-product-price">
                      <span class="new">
                        60,000
                        تومان
                      </span>
                                        <span class="old">
                        90,000
                        تومان
                      </span>
                                    </div>
                                    <div class="ht-product-ratting-wrap">
                      <span class="ht-product-ratting">
                        <span class="ht-product-user-ratting" style="width: 100%;">
                          <i class="sli sli-star"></i>
                          <i class="sli sli-star"></i>
                          <i class="sli sli-star"></i>
                          <i class="sli sli-star"></i>
                          <i class="sli sli-star"></i>
                        </span>
                        <i class="sli sli-star"></i>
                        <i class="sli sli-star"></i>
                        <i class="sli sli-star"></i>
                        <i class="sli sli-star"></i>
                        <i class="sli sli-star"></i>
                      </span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!--Product End-->
                    <!--Product Start-->
                    <div class="ht-product ht-product-action-on-hover ht-product-category-right-bottom mb-30">
                        <div class="ht-product-inner">
                            <div class="ht-product-image-wrap">
                                <a href="product-details.html" class="ht-product-image">
                                    <img src="assets/img/product/product-4.svg" alt="Universal Product Style"/>
                                </a>
                                <div class="ht-product-action">
                                    <ul>
                                        <li>
                                            <a href="#" data-toggle="modal" data-target="#exampleModal"><i
                                                        class="sli sli-magnifier"></i><span
                                                        class="ht-product-action-tooltip"> مشاهده سریع
                          </span></a>
                                        </li>
                                        <li>
                                            <a href="#"><i class="sli sli-heart"></i><span
                                                        class="ht-product-action-tooltip"> افزودن به
                            علاقه مندی ها </span></a>
                                        </li>
                                        <li>
                                            <a href="#"><i class="sli sli-refresh"></i><span
                                                        class="ht-product-action-tooltip"> مقایسه
                          </span></a>
                                        </li>
                                        <li>
                                            <a href="#"><i class="sli sli-bag"></i><span
                                                        class="ht-product-action-tooltip"> افزودن به سبد
                            خرید </span></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="ht-product-content">
                                <div class="ht-product-content-inner">
                                    <div class="ht-product-categories">
                                        <a href="#">لورم</a>
                                    </div>
                                    <h4 class="ht-product-title text-right">
                                        <a href="product-details.html">لورم ایپسوم</a>
                                    </h4>
                                    <div class="ht-product-price">
                      <span class="new">
                        60,000
                        تومان
                      </span>
                                    </div>
                                    <div class="ht-product-ratting-wrap">
                      <span class="ht-product-ratting">
                        <span class="ht-product-user-ratting" style="width: 100%;">
                          <i class="sli sli-star"></i>
                          <i class="sli sli-star"></i>
                          <i class="sli sli-star"></i>
                          <i class="sli sli-star"></i>
                          <i class="sli sli-star"></i>
                        </span>
                        <i class="sli sli-star"></i>
                        <i class="sli sli-star"></i>
                        <i class="sli sli-star"></i>
                        <i class="sli sli-star"></i>
                        <i class="sli sli-star"></i>
                      </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Product End-->
                    <!--Product Start-->
                    <div class="ht-product ht-product-action-on-hover ht-product-category-right-bottom mb-30">
                        <div class="ht-product-inner">
                            <div class="ht-product-image-wrap">
                                <a href="product-details.html" class="ht-product-image">
                                    <img src="assets/img/product/product-2.svg" alt="Universal Product Style"/>
                                </a>
                                <div class="ht-product-action">
                                    <ul>
                                        <li>
                                            <a href="#" data-toggle="modal" data-target="#exampleModal"><i
                                                        class="sli sli-magnifier"></i><span
                                                        class="ht-product-action-tooltip"> مشاهده سریع
                          </span></a>
                                        </li>
                                        <li>
                                            <a href="#"><i class="sli sli-heart"></i><span
                                                        class="ht-product-action-tooltip"> افزودن به
                            علاقه مندی ها </span></a>
                                        </li>
                                        <li>
                                            <a href="#"><i class="sli sli-refresh"></i><span
                                                        class="ht-product-action-tooltip"> مقایسه
                          </span></a>
                                        </li>
                                        <li>
                                            <a href="#"><i class="sli sli-bag"></i><span
                                                        class="ht-product-action-tooltip"> افزودن به سبد
                            خرید </span></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="ht-product-content">
                                <div class="ht-product-content-inner">
                                    <div class="ht-product-categories">
                                        <a href="#">لورم </a>
                                    </div>
                                    <h4 class="ht-product-title text-right">
                                        <a href="product-details.html">لورم ایپسوم</a>
                                    </h4>
                                    <div class="ht-product-price">
                      <span class="new">
                        60,000
                        تومان
                      </span>
                                    </div>
                                    <div class="ht-product-ratting-wrap">
                      <span class="ht-product-ratting">
                        <span class="ht-product-user-ratting" style="width: 100%;">
                          <i class="sli sli-star"></i>
                          <i class="sli sli-star"></i>
                          <i class="sli sli-star"></i>
                          <i class="sli sli-star"></i>
                          <i class="sli sli-star"></i>
                        </span>
                        <i class="sli sli-star"></i>
                        <i class="sli sli-star"></i>
                        <i class="sli sli-star"></i>
                        <i class="sli sli-star"></i>
                        <i class="sli sli-star"></i>
                      </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Product End-->
                </div>
            </div>
        </div>
    </div>
    {{-- End Product Area 2 --}}

    {{-- Index Bottom Banner Area --}}
    <div class="banner-area pb-120">
        <div class="container">
            <div class="row">
                @foreach($indexBottomBanners as $banner)
                    <div class="col-lg-6 col-md-6 text-right">
                        <div class="single-banner mb-30 scroll-zoom">
                            <a href="{{ $banner->button_link }}"><img src="{{ asset($banner->image) }}"
                                                                      alt="{{ $banner->title }}"/></a>
                            <div class="banner-content banner-position-3">
                                <h3>{{ $banner->title }}</h3>
                                <a href="{{ $banner->button_link }}">{{ $banner->button_text }}</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    {{-- End Index Bottom Banner Area --}}

    {{-- Feature Area --}}
    <div class="feature-area" style="direction: rtl;">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-4">
                    <div class="single-feature text-right mb-40">
                        <div class="feature-icon">
                            <img src="assets/img/icon-img/free-shipping.png" alt=""/>
                        </div>
                        <div class="feature-content">
                            <h4>لورم ایپسوم</h4>
                            <p>لورم ایپسوم متن ساختگی</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4">
                    <div class="single-feature text-right mb-40 pl-50">
                        <div class="feature-icon">
                            <img src="assets/img/icon-img/support.png" alt=""/>
                        </div>
                        <div class="feature-content">
                            <h4>لورم ایپسوم</h4>
                            <p>24x7 لورم ایپسوم</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4">
                    <div class="single-feature text-right mb-40">
                        <div class="feature-icon">
                            <img src="assets/img/icon-img/security.png" alt=""/>
                        </div>
                        <div class="feature-content">
                            <h4>لورم ایپسوم</h4>
                            <p>لورم ایپسوم متن ساختگی</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End Feature Area --}}

    <!-- Modal -->
    @foreach($parentCategories as $parentCategory)
        @foreach($parentCategory->uniqueProducts as $product)
            <!-- Modal -->
            <div class="modal fade product-detail-modal" id="productDetailModal-{{$product->id}}" tabindex="-1" role="dialog" aria-hidden="true"
                 data-active-variation="{{ $product->quantity_check ? ($product->sale_check ? $product->sale_check->id : $product->min_price->id) : '' }}">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">x</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-7 col-sm-12 col-xs-12" style="direction: rtl;">
                                    <div class="product-details-content quickview-content">
                                        <h2 class="text-right mb-4">{{ $product->name }}</h2>
                                        <div class="product-details-price variation-price-{{ $product->id }}">
                                            @if($product->quantity_check)
                                                @if($product->sale_check)
                                                    <span class="new">
                                                                {{ number_format($product->sale_check->sale_price) }}
                                                                تومان
                                                            </span>
                                                    <span class="old">
                                                                {{ number_format($product->sale_check->price) }}
                                                                تومان
                                                            </span>
                                                @else
                                                    <span class="new">
                                                                {{ number_format($product->min_price->price) }}
                                                                تومان
                                                            </span>
                                                @endif
                                            @else
                                                <div class="not-in-stock">
                                                            <p class="not-in-stock-text">
                                                                ناموجود
                                                            </p>
                                                        </div>
                                            @endif
                                        </div>
                                        <div class="pro-details-rating-wrap">
                                            <div class="pro-details-rating">
                                                <i class="sli sli-star yellow"></i>
                                                <i class="sli sli-star yellow"></i>
                                                <i class="sli sli-star yellow"></i>
                                                <i class="sli sli-star"></i>
                                                <i class="sli sli-star"></i>
                                            </div>
                                            <span>3 دیدگاه</span>
                                        </div>
                                        <p class="text-right">
                                            {{ $product->description }}
                                        </p>
                                        <div class="pro-details-list text-right">
                                            <ul class="text-right">
                                                @foreach($product->productAttributes()->with('attribute')->get() as $attribute)
                                                    <li>- {{ $attribute->attribute->name }}
                                                        : {{ $attribute->value }}</li>
                                                @endforeach
                                            </ul>
                                        </div>

                                        @if($product->quantity_check)
                                            <div class="pro-details-size-color text-right">
                                            <div class="pro-details-size">
                                                <span>{{ App\Models\Attribute::find($product->productVariations()->first()->attribute_id)->name }}</span>
                                                <div class="pro-details-size-content">
                                                    <ul>
                                                        @foreach($product->productVariations()->where('quantity', '>', 0)->get() as $variation)
                                                            <li>
                                                                <a class="variation-link-{{ $variation->id }} variation-btn"
                                                                   href="javascript:void(0)"
                                                                   onclick="getVariationInfo({{ json_encode($variation->only(['id', 'quantity', 'is_sale', 'sale_price', 'price'])) }}, {{ $product->id }}, this)">
                                                                    {{ $variation->value }}
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>

                                            </div>
                                            <div class="pro-details-quality">
                                                <div class="cart-plus-minus">
                                                    <input class="cart-plus-minus-box quantity-input-{{$product->id}}"
                                                           type="text"
                                                           name="qtybutton"
                                                           value="1"
                                                           data-max="5"/>
                                                </div>
                                                <div class="pro-details-cart">
                                                    <a href="#">افزودن به سبد خرید</a>
                                                </div>
                                                <div class="pro-details-wishlist">
                                                    <a title="Add To Wishlist"
                                                       href="#"><i class="sli sli-heart"></i></a>
                                                </div>
                                                <div class="pro-details-compare">
                                                    <a title="Add To Compare"
                                                       href="#"><i class="sli sli-refresh"></i></a>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="pro-details-meta">
                                            <span>دسته بندی :</span>
                                            <ul>
                                                <li><a href="#">{{ $product->category->parent->name }}
                                                        ، {{ $product->category->name }}</a></li>
                                            </ul>
                                        </div>
                                        <div class="pro-details-meta">
                                            <span>تگ ها :</span>
                                            <ul>
                                                @foreach($product->tags as $tag)
                                                    <li><a href="#"> {{$tag->name}}{{$loop->last? '' : '،'}} </a></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-5 col-sm-12 col-xs-12">
                                    <div class="tab-content quickview-big-img">
                                        <div id="pro-{{ $product->id }}" class="tab-pane fade show active">
                                            <img src="{{ asset($product->primary_image) }}" alt="{{ $product->name }}"/>
                                        </div>
                                        @foreach($product->productImages as $image)
                                            <div id="pro-image{{ $image->id }}" class="tab-pane fade">
                                            <img src="{{ asset($image->image) }}" alt="{{ $product->name }}"/>
                                        </div>
                                        @endforeach
                                    </div>
                                    <!-- Thumbnail Large Image End -->
                                    <!-- Thumbnail Image End -->
                                    <div class="quickview-wrap mt-15">
                                        <div class="quickview-slide-active owl-carousel nav nav-style-2" role="tablist">
                                            <a class="active" data-toggle="tab" href="#pro-{{ $product->id }}">
                                                <img src="{{ asset($product->primary_image) }}" alt="{{ $product->name }}"/>
                                            </a>
                                            @foreach($product->productImages as $image)
                                                <a data-toggle="tab" href="#pro-image{{ $image->id }}">
                                                    <img src="{{ asset($image->image) }}" alt="{{ $product->name }}"/>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endforeach
    <!-- Modal end -->
@endsection

@push('scripts')
    <script>
        function getVariationInfo(variation, productId, element) {

            setVariationPriceAndQuantity(variation, productId)

            // Remove 'active-variation' class from all links
            document.querySelectorAll('.variation-btn').forEach(link => {
                link.classList.remove('active-variation');
            });

            // Add 'active-variation' class to the clicked link
            element.classList.add('active-variation');
        }

        function setActiveVariation(product){
            // Remove 'active-variation' class from all links
            document.querySelectorAll('.variation-btn').forEach(link => {
                link.classList.remove('active-variation');
            });

            let activeVariationId;
            if(product.quantity_check){
                if(product.sale_check){
                    activeVariationId = product.sale_check.id;
                    setVariationPriceAndQuantity(product.sale_check, product.id);
                }else{
                    activeVariationId = product.min_price.id;
                    setVariationPriceAndQuantity(product.min_price, product.id);
                }
            }

            let activeLink = $(".variation-link-" + activeVariationId);
            if (activeLink) {
                activeLink.addClass('active-variation');
            }
        }

        function setVariationPriceAndQuantity(variation, productId) { // only will be used in other methods
            const variationPriceDiv = $(".variation-price-" + productId);
            variationPriceDiv.empty();

            if (variation.is_sale) {
                let spanSale = $('<span>', {
                    class: "new",
                    text: toPersianNum(number_format(variation.sale_price)) + " تومان",
                });

                let spanPrice = $('<span>', {
                    class: "old",
                    text: toPersianNum(number_format(variation.price)) + " تومان",
                });

                variationPriceDiv.append(spanSale, spanPrice);
            } else {
                let spanPrice = $('<span>', {
                    class: "new",
                    text: toPersianNum(number_format(variation.price)) + " تومان",
                });

                variationPriceDiv.append(spanPrice);
            }

            let quantityInput = $('.quantity-input-' + productId);
            quantityInput.attr('data-max', variation.quantity);
            quantityInput.val(1);
        }

    </script>

@endpush

@push('style')
    <style>
        .active-variation {
            background-color: #ff3535 !important;
            color: #fff !important;
        }
    </style>
@endpush
