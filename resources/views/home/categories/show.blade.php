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
                      <option value="rate"
                              {{ (request()->has('sortBy') && request()->sortBy == 'rate') ? 'selected' : '' }}> بیشترین امتیاز
                      </option>
                    </select>
                  </div>
                </div>

              </div>

              <div class="shop-bottom-area mt-35">
                <div class="tab-content jump">

                  <div class="row ht-products" style="direction: rtl;">
                    @foreach($products as $product)
                      <div class="col-xl-4 col-md-6 col-lg-6 col-sm-6">
                        <!--Product Start-->
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
                                            <div data-rating-stars="5"
                                                 data-rating-readonly="true"
                                                 data-rating-value="{{ ceil($product->productRates->avg('rate')) }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Product End-->
                      </div>
                    @endforeach
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

    <!-- Modal -->
    @foreach($products as $product)
        <!-- Modal -->
        <div class="modal fade product-detail-modal"
             id="productDetailModal-{{$product->id}}"
             tabindex="-1"
             role="dialog"
             aria-hidden="true"
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
                                                <div data-rating-stars="5"
                                                     data-rating-readonly="true"
                                                     data-rating-value="{{ ceil($product->productRates->avg('rate')) }}">
                                                </div>
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
                                                <img src="{{ asset($product->primary_image) }}"
                                                     alt="{{ $product->name }}"/>
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
    <!-- Modal end -->

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

        function setActiveVariation(product) {
          // Remove 'active-variation' class from all links
          document.querySelectorAll('.variation-btn').forEach(link => {
            link.classList.remove('active-variation');
          });

          let activeVariationId;
          if (product.quantity_check) {
            if (product.sale_check) {
              activeVariationId = product.sale_check.id;
              setVariationPriceAndQuantity(product.sale_check, product.id);
            } else {
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
