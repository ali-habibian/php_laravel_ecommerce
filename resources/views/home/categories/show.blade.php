@extends('home.layouts.home')

@php
    $title = "دیجی شاپ | ".$category->name. " ". $category->parentName();
@endphp
@section('title', $title)

@section('content')
    <div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
      <div class="container">
        <div class="breadcrumb-content text-center">
          <ul>
            <li>
              <a href="{{ route('home.index') }}">صفحه ای اصلی</a>
            </li>
            <li class="active">فروشگاه </li>
          </ul>
        </div>
      </div>
    </div>

    <div class="shop-area pt-95 pb-100">
        <div class="container">
          <div class="row flex-row-reverse text-right">
            <!-- sidebar -->
            <div class="col-lg-3 order-2 order-sm-2 order-md-1">
              <div class="sidebar-style mr-30">
                <div class="sidebar-widget">
                  <h4 class="pro-sidebar-title">جستجو </h4>
                  <div class="pro-sidebar-search mb-50 mt-25">
                    <form class="pro-sidebar-search-form" action="#">
                      <input id="searchInput" type="text" placeholder="... جستجو "
                             value="{{ (request()->has('search')) ? request()->search : '' }}">
                      <button type="button" onclick="doFilter()">
                        <i class="sli sli-magnifier"></i>
                      </button>
                    </form>
                  </div>
                </div>

                <div class="sidebar-widget">
                  <h4 class="pro-sidebar-title"> دسته بندی </h4>
                  <div class="sidebar-widget-list mt-30">
                    <ul>
                      <li>
                        {{ $category->parent->name }}
                      </li>
                        @foreach($category->parent->children as $childCategory)
                            <li>
                              <a href="{{ route('home.categories.show', $childCategory) }}"
                                 style="{{ ($childCategory->id === $category->id) ? 'color: #ff3535;' : '' }}">
                                {{ $childCategory->name }}
                              </a>
                            </li>
                        @endforeach
                    </ul>
                  </div>
                </div>
                <hr>

                  {{-- Attributes --}}
                  @foreach($attributes as $attribute)
                      <div class="sidebar-widget mt-30">
                    <h4 class="pro-sidebar-title">{{ $attribute->name }} </h4>
                    <div class="sidebar-widget-list mt-20">
                      <ul>
                        @foreach($attribute->values as $value)
                              <li>
                            <div class="sidebar-widget-list-left">
                              <input type="checkbox"
                                     class="attribute-{{ $attribute->id }}"
                                     value="{{$value->value}}"
                                     onchange="doFilter()"
                                      {{ (request()->has('attribute.'.$attribute->id) && in_array($value->value, explode('_', request()->attribute[$attribute->id]))) ? 'checked' : '' }}>
                              <a href=javascript:void(0)>{{$value->value}} </a>
                              <span class="checkmark"></span>
                            </div>
                          </li>
                          @endforeach
                      </ul>
                    </div>
                  </div>
                      <hr>
                  @endforeach

                  {{-- Variation --}}
                  <div class="sidebar-widget mt-30">
                <h4 class="pro-sidebar-title">{{$variation->name}} </h4>
                <div class="sidebar-widget-list mt-20">
                  <ul>
                    @foreach($variation->variationValues as $variationValue)
                          <li>
                      <div class="sidebar-widget-list-left">
                        <input type="checkbox"
                               class="variation"
                               value="{{ $variationValue->value }}"
                               onchange="doFilter()"
                                {{ (request()->has('variation') && in_array($variationValue->value, explode('_', request()->variation))) ? 'checked' : '' }}>
                        <a href=javascript:void(0)>{{ $variationValue->value }} </a>
                        <span class="checkmark"></span>
                      </div>
                    </li>
                      @endforeach
                  </ul>
                </div>
              </div>
              </div>
            </div>

            <!-- content -->
            <div class="col-lg-9 order-1 order-sm-1 order-md-2">
              <!-- shop-top-bar -->
              <div class="shop-top-bar" style="direction: rtl;">

                <div class="select-shoing-wrap">
                  <div class="shop-select">
                    <select id="sortBySelect" onchange="doFilter()">
                      <option value="default"> مرتب سازی </option>
                      <option value="maxPrice"
                              {{ (request()->has('sortBy') && request()->sortBy == 'maxPrice') ? 'selected' : '' }}> بیشترین قیمت
                      </option>
                      <option value="minPrice"
                              {{ (request()->has('sortBy') && request()->sortBy == 'minPrice') ? 'selected' : '' }}> کم ترین قیمت
                      </option>
                      <option value="latest"
                              {{ (request()->has('sortBy') && request()->sortBy == 'latest') ? 'selected' : '' }}> جدیدترین
                      </option>
                      <option value="oldest"
                              {{ (request()->has('sortBy') && request()->sortBy == 'oldest') ? 'selected' : '' }}> قدیمی ترین
                      </option>
                    </select>
                  </div>
                </div>

              </div>

              <div class="shop-bottom-area mt-35">
                <div class="tab-content jump">

                  <div class="row ht-products" style="direction: rtl;">
                    <div class="col-xl-4 col-md-6 col-lg-6 col-sm-6">
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
                                              class="sli sli-magnifier"></i><span class="ht-product-action-tooltip"> مشاهده سریع
                                    </span></a>
                                </li>
                                <li>
                                  <a href="#"><i class="sli sli-heart"></i><span class="ht-product-action-tooltip">
                                      افزودن به علاقه مندی ها </span></a>
                                </li>
                                <li>
                                  <a href="#"><i class="sli sli-refresh"></i><span class="ht-product-action-tooltip">
                                      مقایسه </span></a>
                                </li>
                                <li>
                                  <a href="#"><i class="sli sli-bag"></i><span class="ht-product-action-tooltip"> افزودن
                                      به سبد خرید </span></a>
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
                    </div>
                    <div class="col-xl-4 col-md-6 col-lg-6 col-sm-6">
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
                                              class="sli sli-magnifier"></i><span class="ht-product-action-tooltip"> مشاهده سریع
                                    </span></a>
                                </li>
                                <li>
                                  <a href="#"><i class="sli sli-heart"></i><span class="ht-product-action-tooltip">
                                      افزودن به
                                      علاقه مندی ها </span></a>
                                </li>
                                <li>
                                  <a href="#"><i class="sli sli-refresh"></i><span class="ht-product-action-tooltip">
                                      مقایسه
                                    </span></a>
                                </li>
                                <li>
                                  <a href="#"><i class="sli sli-bag"></i><span class="ht-product-action-tooltip"> افزودن
                                      به سبد
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
                    </div>
                    <div class="col-xl-4 col-md-6 col-lg-6 col-sm-6">
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
                                              class="sli sli-magnifier"></i><span class="ht-product-action-tooltip"> مشاهده سریع
                                    </span></a>
                                </li>
                                <li>
                                  <a href="#"><i class="sli sli-heart"></i><span class="ht-product-action-tooltip">
                                      افزودن به
                                      علاقه مندی ها </span></a>
                                </li>
                                <li>
                                  <a href="#"><i class="sli sli-refresh"></i><span class="ht-product-action-tooltip">
                                      مقایسه
                                    </span></a>
                                </li>
                                <li>
                                  <a href="#"><i class="sli sli-bag"></i><span class="ht-product-action-tooltip"> افزودن
                                      به سبد
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
                    </div>
                    <div class="col-xl-4 col-md-6 col-lg-6 col-sm-6">
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
                                              class="sli sli-magnifier"></i><span class="ht-product-action-tooltip"> مشاهده سریع
                                    </span></a>
                                </li>
                                <li>
                                  <a href="#"><i class="sli sli-heart"></i><span class="ht-product-action-tooltip">
                                      افزودن به
                                      علاقه مندی ها </span></a>
                                </li>
                                <li>
                                  <a href="#"><i class="sli sli-refresh"></i><span class="ht-product-action-tooltip">
                                      مقایسه
                                    </span></a>
                                </li>
                                <li>
                                  <a href="#"><i class="sli sli-bag"></i><span class="ht-product-action-tooltip"> افزودن
                                      به سبد
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
                    </div>
                    <div class="col-xl-4 col-md-6 col-lg-6 col-sm-6">
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
                                              class="sli sli-magnifier"></i><span class="ht-product-action-tooltip"> مشاهده سریع
                                    </span></a>
                                </li>
                                <li>
                                  <a href="#"><i class="sli sli-heart"></i><span class="ht-product-action-tooltip">
                                      افزودن به
                                      علاقه مندی ها </span></a>
                                </li>
                                <li>
                                  <a href="#"><i class="sli sli-refresh"></i><span class="ht-product-action-tooltip">
                                      مقایسه
                                    </span></a>
                                </li>
                                <li>
                                  <a href="#"><i class="sli sli-bag"></i><span class="ht-product-action-tooltip"> افزودن
                                      به سبد
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
                    <div class="col-xl-4 col-md-6 col-lg-6 col-sm-6">
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
                                              class="sli sli-magnifier"></i><span class="ht-product-action-tooltip"> مشاهده سریع
                                    </span></a>
                                </li>
                                <li>
                                  <a href="#"><i class="sli sli-heart"></i><span class="ht-product-action-tooltip">
                                      افزودن به علاقه مندی ها </span></a>
                                </li>
                                <li>
                                  <a href="#"><i class="sli sli-refresh"></i><span class="ht-product-action-tooltip">
                                      مقایسه </span></a>
                                </li>
                                <li>
                                  <a href="#"><i class="sli sli-bag"></i><span class="ht-product-action-tooltip"> افزودن
                                      به سبد خرید </span></a>
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
                    </div>
                    <div class="col-xl-4 col-md-6 col-lg-6 col-sm-6">
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
                                              class="sli sli-magnifier"></i><span class="ht-product-action-tooltip"> مشاهده سریع
                                    </span></a>
                                </li>
                                <li>
                                  <a href="#"><i class="sli sli-heart"></i><span class="ht-product-action-tooltip">
                                      افزودن به
                                      علاقه مندی ها </span></a>
                                </li>
                                <li>
                                  <a href="#"><i class="sli sli-refresh"></i><span class="ht-product-action-tooltip">
                                      مقایسه
                                    </span></a>
                                </li>
                                <li>
                                  <a href="#"><i class="sli sli-bag"></i><span class="ht-product-action-tooltip"> افزودن
                                      به سبد
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
                    </div>
                    <div class="col-xl-4 col-md-6 col-lg-6 col-sm-6">
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
                                              class="sli sli-magnifier"></i><span class="ht-product-action-tooltip"> مشاهده سریع
                                    </span></a>
                                </li>
                                <li>
                                  <a href="#"><i class="sli sli-heart"></i><span class="ht-product-action-tooltip">
                                      افزودن به
                                      علاقه مندی ها </span></a>
                                </li>
                                <li>
                                  <a href="#"><i class="sli sli-refresh"></i><span class="ht-product-action-tooltip">
                                      مقایسه
                                    </span></a>
                                </li>
                                <li>
                                  <a href="#"><i class="sli sli-bag"></i><span class="ht-product-action-tooltip"> افزودن
                                      به سبد
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
                    </div>
                    <div class="col-xl-4 col-md-6 col-lg-6 col-sm-6">
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
                                              class="sli sli-magnifier"></i><span class="ht-product-action-tooltip"> مشاهده سریع
                                    </span></a>
                                </li>
                                <li>
                                  <a href="#"><i class="sli sli-heart"></i><span class="ht-product-action-tooltip">
                                      افزودن به
                                      علاقه مندی ها </span></a>
                                </li>
                                <li>
                                  <a href="#"><i class="sli sli-refresh"></i><span class="ht-product-action-tooltip">
                                      مقایسه
                                    </span></a>
                                </li>
                                <li>
                                  <a href="#"><i class="sli sli-bag"></i><span class="ht-product-action-tooltip"> افزودن
                                      به سبد
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

                <div class="pro-pagination-style text-center mt-30">
                  <ul class="d-flex justify-content-center">
                    <li><a class="prev" href="#"><i class="sli sli-arrow-left"></i></a></li>
                    <li><a class="active" href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a class="next" href="#"><i class="sli sli-arrow-right"></i></a></li>
                  </ul>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>

    <form id="filterForm" method="GET" action="{{ url()->current() }}">
      <input type="hidden" id="filterSearch" name="search">
      <input type="hidden" id="filterSortBy" name="sortBy">

        @foreach($attributes as $attribute)
            <input type="hidden" name="attribute[{{ $attribute->id }}]" id="filterAttribute-{{ $attribute->id }}">
        @endforeach

        <input type="hidden" name="variation" id="filterVariation">
    </form>

@endsection

@push('scripts')
    <script>
       function doFilter() {
           let attributes = @json($attributes);
           attributes.map(attribute => {
               let attributeValues = $(`.attribute-${attribute.id}:checked`).map(function () {
                   return $(this).val();
               }).get().join('_');

               let filterAttribute = $(`#filterAttribute-${attribute.id}`);
               if (attributeValues === '') {
                   filterAttribute.prop('disabled', true)
               } else {
                   filterAttribute.val(attributeValues)
               }
           });

           let variation = $('.variation:checked').map(function () {
               return $(this).val();
           }).get().join('_');

           let filterVariation = $('#filterVariation');
           if (variation === '') {
               filterVariation.prop('disabled', true)
           } else {
               filterVariation.val(variation)
           }

           let sortBy = $('#sortBySelect').val();
           if (sortBy === 'default') {
               $('#filterSortBy').prop('disabled', true)
           } else {
               $('#filterSortBy').val(sortBy)
           }

           let searchKeyword = $('#searchInput').val();
           if (searchKeyword === '') {
               $('#filterSearch').prop('disabled', true)
           } else {
               $('#filterSearch').val(searchKeyword)
           }

           $('#filterForm').submit();
       }
  </script>
@endpush

@push('style')

@endpush
