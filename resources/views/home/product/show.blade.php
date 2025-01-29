@extends('home.layouts.home')

@php
    $title = "دیجی شاپ | ".$product->name;
@endphp

@section('title', $title)

@section('content')
    <!-- Breadcrumb -->
    <div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
            <div class="container">
                <div class="breadcrumb-content text-center">
                    <ul>
                        <li>
                            <a href="{{ route('home.index') }}">صفحه اصلی</a>
                        </li>
                        <li class="active">
                            <a href="{{ route('home.categories.show', $product->category->slug) }}">فروشگاه</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    <!-- Breadcrumb end -->

    <!-- Product Details -->
    <div class="product-details-area pt-100 pb-95">
            <div class="container">
                <div class="row">

                    <div class="col-lg-6 col-md-6 order-2 order-sm-2 order-md-1" style="direction: rtl;">
                        <div class="product-details-content ml-30">
                            <h2 class="text-right"> {{ $product->name }} </h2>
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
                                <span>
                                    <a href="#">
                                        3
                                        دیدگاه
                                    </a>
                                </span>
                            </div>
                            <p class="text-right">
                                {{ $product->description }}
                            </p>
                            <div class="pro-details-list text-right">
                                <ul>
                                    @foreach($product->productAttributes()->with('attribute')->get() as $attribute)
                                        <li>- {{ $attribute->attribute->name }}
                                            : {{ $attribute->value }}</li>
                                    @endforeach
                                </ul>
                            </div>

                            @if($product->quantity_check)
                                <div class="pro-details-size-color">
                                    <div class="pro-details-size text-right">
                                        <span> {{ App\Models\Attribute::find($product->productVariations()->first()->attribute_id)->name }} </span>
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
                                <div class="pro-details-cart btn-hover">
                                    <a href="#"> افزودن به سبد خرید </a>
                                </div>
                                <div class="pro-details-wishlist">
                                    <a title="Add To Wishlist" href="#"><i class="sli sli-heart"></i></a>
                                </div>
                                <div class="pro-details-compare">
                                    <a title="Add To Compare" href="#"><i class="sli sli-refresh"></i></a>
                                </div>
                            </div>
                            @endif

                            <div class="pro-details-meta">
                                <span> دسته بندی : </span>
                                <ul>
                                    <li><a href="#">{{ $product->category->parent->name }}
                                            ، {{ $product->category->name }}</a></li>
                                </ul>
                            </div>
                            <div class="pro-details-meta">
                                <span> تگ : </span>
                                <ul>
                                    @foreach($product->tags as $tag)
                                        <li><a href="#"> {{$tag->name}}{{$loop->last? '' : '،'}} </a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 order-1 order-sm-1 order-md-2">
                        <div class="product-details-img">
                            <div class="zoompro-border zoompro-span" id="pro-{{ $product->id }}">
                                <img class="zoompro" src="{{ asset($product->primary_image) }}"
                                     data-zoom-image="{{ asset($product->primary_image) }}" alt="{{ $product->name }}"/>

                            </div>
                            <div id="gallery" class="mt-20 product-dec-slider">
                                <a data-image="{{ asset($product->primary_image) }}"
                                   data-zoom-image="{{ asset($product->primary_image) }}">
                                    <img width="90px" src="{{ asset($product->primary_image) }}" alt="{{ $product->name }}">
                                </a>
                                @foreach($product->productImages as $image)
                                    <a data-image="{{ asset($image->image) }}"
                                       data-zoom-image="{{ asset($image->image) }}">
                                        <img width="90px" src="{{ asset($image->image) }}" alt="{{ $product->name }}">
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    <!-- Product Details end -->

    <!-- Description - Review -->
    <div class="description-review-area pb-95">
            <div class="container">
                <div class="row" style="direction: rtl;">
                    <div class="col-lg-8 col-md-8">
                        <div class="description-review-wrapper">
                            <div class="description-review-topbar nav">
                                <a class="{{ $errors->count() > 0 ? '' : 'active' }}" data-toggle="tab" href="#des-details1"> توضیحات </a>
                                <a data-toggle="tab" href="#des-details3"> اطلاعات بیشتر </a>
                                <a class="{{ $errors->count() > 0 ? 'active' : '' }}" data-toggle="tab" href="#des-details2">
                                    دیدگاه
                                    (3)
                                </a>
                            </div>
                            <div class="tab-content description-review-bottom">
                                <div id="des-details1" class="tab-pane {{ $errors->count() > 0 ? '' : 'active' }}">
                                    <div class="product-description-wrapper">
                                        <p class="text-justify">
                                            {{ $product->description }}
                                        </p>
                                    </div>
                                </div>
                                <div id="des-details3" class="tab-pane">
                                    <div class="product-anotherinfo-wrapper text-right">
                                        <ul>
                                            @foreach($product->productAttributes()->with('attribute')->get() as $attribute)
                                                <li><span> {{ $attribute->attribute->name }} : </span>{{ $attribute->value }} </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div id="des-details2" class="tab-pane {{ $errors->count() > 0 ? 'active' : '' }}">

                                    <div class="review-wrapper">
                                        <div class="single-review">
                                            <div class="review-img">
                                                <img src="assets/img/product-details/client-1.jpg" alt="">
                                            </div>
                                            <div class="review-content text-right">
                                                <p class="text-right">
                                                    لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با
                                                    استفاده از طراحان گرافیک است.
                                                </p>
                                                <div class="review-top-wrap">
                                                    <div class="review-name">
                                                        <h4> علی شیخ </h4>
                                                    </div>
                                                    <div class="review-rating">
                                                        <i class="sli sli-star"></i>
                                                        <i class="sli sli-star"></i>
                                                        <i class="sli sli-star"></i>
                                                        <i class="sli sli-star"></i>
                                                        <i class="sli sli-star"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="single-review">
                                            <div class="review-img">
                                                <img src="assets/img/product-details/client-2.jpg" alt="">
                                            </div>
                                            <div class="review-content">
                                                <p class="text-right">
                                                    لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با
                                                    استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در
                                                    ستون و سطرآنچنان که لازم است
                                                </p>
                                                <div class="review-top-wrap text-right">
                                                    <div class="review-name">
                                                        <h4> علی شیخ </h4>
                                                    </div>
                                                    <div class="review-rating">
                                                        <i class="sli sli-star"></i>
                                                        <i class="sli sli-star"></i>
                                                        <i class="sli sli-star"></i>
                                                        <i class="sli sli-star"></i>
                                                        <i class="sli sli-star"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="single-review">
                                            <div class="review-img">
                                                <img src="assets/img/product-details/client-3.jpg" alt="">
                                            </div>
                                            <div class="review-content text-right">
                                                <p class="text-right">
                                                    لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با
                                                    استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در
                                                    ستون و سطرآنچنان که لازم است
                                                </p>
                                                <div class="review-top-wrap">
                                                    <div class="review-name">
                                                        <h4> علی شیخ </h4>
                                                    </div>
                                                    <div class="review-rating">
                                                        <i class="sli sli-star"></i>
                                                        <i class="sli sli-star"></i>
                                                        <i class="sli sli-star"></i>
                                                        <i class="sli sli-star"></i>
                                                        <i class="sli sli-star"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="ratting-form-wrapper text-right">
                                        <span> نوشتن دیدگاه </span>

                                        <div class="star-box-wrap">
                                            <div data-rating-stars="5"
                                                 data-rating-value="0"
                                                 data-rating-input="#rateInput">
                                            </div>
                                        </div>

                                        <div id="comments" class="ratting-form">
                                            <form action="{{ route('home.comments.store', $product) }}" method="POST">
                                                @csrf

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="rating-form-style mb-20">
                                                            <label> متن دیدگاه : </label>
                                                            <textarea name="text"></textarea>
                                                        </div>
                                                    </div>

                                                    <input type="hidden" id="rateInput" name="rate" value="0">

                                                    <div class="col-lg-12">
                                                        <div class="form-submit">
                                                            <input type="submit" value="ارسال">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                                            <div class="mt-4">
                                                 @include('home.sections.errors')
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="pro-dec-banner">
                            <a href="{{ route('home.categories.show', $product->category->slug) }}"><img src="{{ asset($productDetailPageBanner->image) }}" alt=""></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- Description - Review end -->

    <!-- Same Products -->
    <div class="product-area pb-70">
            <div class="container">
                <div class="section-title text-center pb-60">
                    <h2> محصولات مرتبط </h2>
                    <p>
                        لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.
                        چاپگرها و متون بلکه روزنامه و مجله
                    </p>
                </div>
                <div class="arrivals-wrap scroll-zoom">
                    <div class="ht-products product-slider-active owl-carousel">
                        @foreach($sameProducts as $sameProduct)
                            <!--Product Start-->
                            <div class="ht-product ht-product-action-on-hover ht-product-category-right-bottom mb-30">
                                    <div class="ht-product-inner">
                                        <div class="ht-product-image-wrap">
                                            <a href="{{ route('home.products.show', $sameProduct->slug) }}" class="ht-product-image">
                                                <img src="{{ asset($sameProduct->primary_image) }}"
                                                     alt="{{ $sameProduct->name }}"/>
                                            </a>
                                            <div class="ht-product-action">
                                                <ul>
                                                    <li>
                                                        <a href="javascript:void(0)"
                                                           data-toggle="modal"
                                                           data-target="#productDetailModal-{{$sameProduct->id}}"
                                                           onclick="setActiveVariationSameProduct({{ json_encode($sameProduct) }})"
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
                                                    <a href="#">{{ $sameProduct->category->name }}</a>
                                                </div>
                                                <h4 class="ht-product-title text-right">
                                                    <a href="{{ route('home.products.show', $sameProduct->slug) }}"> {{ $sameProduct->name }} </a>
                                                </h4>
                                                <div class="ht-product-price">
                                                    @if($sameProduct->quantity_check)
                                                        @if($sameProduct->sale_check)
                                                            <span class="new">
                                                                {{ number_format($sameProduct->sale_check->sale_price) }}
                                                                تومان
                                                            </span>
                                                            <span class="old">
                                                                {{ number_format($sameProduct->sale_check->price) }}
                                                                تومان
                                                            </span>
                                                        @else
                                                            <span class="new">
                                                                {{ number_format($sameProduct->min_price->price) }}
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
                                                         data-rating-value="{{ ceil($sameProduct->productRates->avg('rate')) }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <!--Product End-->
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    <!-- Product end -->

    <!-- Modal -->
    @foreach($sameProducts as $sameProduct)
        <!-- Modal -->
        <div class="modal fade product-detail-modal"
             id="productDetailModal-{{$sameProduct->id}}"
             tabindex="-1"
             role="dialog"
             aria-hidden="true">
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
                                        <h2 class="text-right mb-4">{{ $sameProduct->name }}</h2>
                                        <div class="product-details-price variation-price-{{ $sameProduct->id }}">
                                            @if($sameProduct->quantity_check)
                                                @if($sameProduct->sale_check)
                                                    <span class="new">
                                                                {{ number_format($sameProduct->sale_check->sale_price) }}
                                                                تومان
                                                            </span>
                                                    <span class="old">
                                                                {{ number_format($sameProduct->sale_check->price) }}
                                                                تومان
                                                            </span>
                                                @else
                                                    <span class="new">
                                                                {{ number_format($sameProduct->min_price->price) }}
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
                                                     data-rating-value="{{ ceil($sameProduct->productRates->avg('rate')) }}">
                                                </div>
                                            </div>
                                            <span>3 دیدگاه</span>
                                        </div>
                                        <p class="text-right">
                                            {{ $sameProduct->description }}
                                        </p>
                                        <div class="pro-details-list text-right">
                                            <ul class="text-right">
                                                @foreach($sameProduct->productAttributes()->with('attribute')->get() as $attribute)
                                                    <li>- {{ $attribute->attribute->name }}
                                                        : {{ $attribute->value }}</li>
                                                @endforeach
                                            </ul>
                                        </div>

                                        @if($sameProduct->quantity_check)
                                            <div class="pro-details-size-color text-right">
                                                <div class="pro-details-size">
                                                    <span>{{ App\Models\Attribute::find($sameProduct->productVariations()->first()->attribute_id)->name }}</span>
                                                    <div class="pro-details-size-content">
                                                        <ul>
                                                            @foreach($sameProduct->productVariations()->where('quantity', '>', 0)->get() as $variation)
                                                                <li>
                                                                    <a class="variation-link-{{ $variation->id }} variation-btn-same-product"
                                                                       href="javascript:void(0)"
                                                                       onclick="getVariationInfoSameProduct({{ json_encode($variation->only(['id', 'quantity', 'is_sale', 'sale_price', 'price'])) }}, {{ $sameProduct->id }}, this)">
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
                                                    <input class="cart-plus-minus-box quantity-input-{{$sameProduct->id}}"
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
                                                <li><a href="#">{{ $sameProduct->category->parent->name }}
                                                        ، {{ $sameProduct->category->name }}</a></li>
                                            </ul>
                                        </div>
                                        <div class="pro-details-meta">
                                            <span>تگ ها :</span>
                                            <ul>
                                                @foreach($sameProduct->tags as $tag)
                                                    <li><a href="#"> {{$tag->name}}{{$loop->last? '' : '،'}} </a></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-5 col-sm-12 col-xs-12">
                                    <div class="tab-content quickview-big-img">
                                        <div id="pro-{{ $sameProduct->id }}" class="tab-pane fade show active">
                                            <img src="{{ asset($sameProduct->primary_image) }}" alt="{{ $sameProduct->name }}"/>
                                        </div>
                                        @foreach($sameProduct->productImages as $image)
                                            <div id="pro-image{{ $image->id }}" class="tab-pane fade">
                                            <img src="{{ asset($image->image) }}" alt="{{ $sameProduct->name }}"/>
                                        </div>
                                        @endforeach
                                    </div>
                                    <!-- Thumbnail Large Image End -->
                                    <!-- Thumbnail Image End -->
                                    <div class="quickview-wrap mt-15">
                                        <div class="quickview-slide-active owl-carousel nav nav-style-2" role="tablist">
                                            <a class="active" data-toggle="tab" href="#pro-{{ $sameProduct->id }}">
                                                <img src="{{ asset($sameProduct->primary_image) }}"
                                                     alt="{{ $sameProduct->name }}"/>
                                            </a>
                                            @foreach($sameProduct->productImages as $image)
                                                <a data-toggle="tab" href="#pro-image{{ $image->id }}">
                                                    <img src="{{ asset($image->image) }}" alt="{{ $sameProduct->name }}"/>
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
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize the active variation
            const product = @json($product);
            setActiveVariation(product);
        });

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

    //     -------------------- same products --------------------
        function getVariationInfoSameProduct(variation, productId, element) {

            setVariationPriceAndQuantitySameProduct(variation, productId)

            // Remove 'active-variation' class from all links
            document.querySelectorAll('.variation-btn-same-product').forEach(link => {
                link.classList.remove('active-variation');
            });

            // Add 'active-variation' class to the clicked link
            element.classList.add('active-variation');
        }

        function setActiveVariationSameProduct(product) {
            // Remove 'active-variation' class from all links
            document.querySelectorAll('.variation-btn-same-product').forEach(link => {
                link.classList.remove('active-variation');
            });

            let activeVariationId;
            if (product.quantity_check) {
                if (product.sale_check) {
                    activeVariationId = product.sale_check.id;
                    setVariationPriceAndQuantitySameProduct(product.sale_check, product.id);
                } else {
                    activeVariationId = product.min_price.id;
                    setVariationPriceAndQuantitySameProduct(product.min_price, product.id);
                }
            }

            let activeLink = $(".variation-link-" + activeVariationId);
            if (activeLink) {
                activeLink.addClass('active-variation');
            }
        }

        function setVariationPriceAndQuantitySameProduct(variation, productId) { // only will be used in other methods
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
