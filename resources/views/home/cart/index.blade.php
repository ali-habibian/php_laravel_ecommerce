@extends('home.layouts.home')

@section('title', 'سبد خرید')

@section('content')
<div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <ul>
                <li>
                    <a href="{{ route('home.index') }}"> صفحه اصلی </a>
                </li>
                <li class="active"> سبد خرید </li>
            </ul>
        </div>
    </div>
</div>

<div class="cart-main-area pt-95 pb-100 text-right" style="direction: rtl;">
    @if(Cart::isEmpty())
        <div class="container cart-empty-content">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center">
                    <i class="sli sli-basket"></i>
                    <h2 class="font-weight-bold my-4">سبد خرید شما خالی است.</h2>
                    <p class="mb-40">شما هیچ کالایی در سبد خرید خود ندارید.</p>
                    <a href="{{ route('home.index') }}" > ادامه خرید </a>
                </div>
            </div>
        </div>
    @else
        <div class="container">
            <h3 class="cart-page-title"> سبد خرید شما </h3>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">

                    <form action="{{ route('home.cart.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="table-content table-responsive cart-table-content">
                            <table>
                                <thead>
                                    <tr>
                                        <th> تصویر محصول </th>
                                        <th> نام محصول </th>
                                        <th> فی </th>
                                        <th> تعداد </th>
                                        <th> قیمت </th>
                                        <th> عملیات </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach(Cart::getContent() as $item)
                                        <tr>
                                            <td class="product-thumbnail">
                                                <a href="{{ route('home.products.show', $item->associatedModel->slug) }}">
                                                    <img class="w-50" src="{{ asset($item->associatedModel->primary_image) }}" alt="{{ $item->associatedModel->name }}">
                                                </a>
                                            </td>
                                            <td class="product-name text-right">
                                                <a href="{{ route('home.products.show', $item->associatedModel->slug) }}">
                                                    {{ $item->associatedModel->name }}
                                                </a>
                                                <div dir="rtl">
                                                    <p class="mb-0 mt-2" style="font-size: 12px">
                                                        {{ \App\Models\Attribute::find($item->attributes->attribute_id)->name }}
                                                        : {{ $item->attributes->value }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="product-price-cart">
                                                <span class="amount">
                                                    {{ number_format($item->price) }}
                                                    تومان
                                                </span>
                                                <div dir="rtl">
                                                    @if($item->attributes->is_sale)
                                                        <p style="color: red; font-size: 12px">
                                                            %{{ $item->attributes->percent_discount }} تخفیف
                                                        </p>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="product-quantity">
                                                <div class="cart-plus-minus">
                                                    <input class="cart-plus-minus-box" type="text" name="qtybutton[{{ $item->id }}]"
                                                           value="{{ $item->quantity }}" data-max="{{ $item->attributes->quantity }}">
                                                </div>
                                            </td>
                                            <td class="product-subtotal">
                                                {{ number_format($item->getPriceSum()) }}
                                                تومان
                                            </td>
                                            <td class="product-remove">
                                                <a href="{{ route('home.cart.remove.product', $item->id) }}"><i class="sli sli-close"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="cart-shiping-update-wrapper">
                                    <div class="cart-shiping-update">
                                        <a href="{{ route('home.index') }}"> ادامه خرید </a>
                                    </div>
                                    <div class="cart-clear">
                                        <button type="submit"> به روزرسانی سبد خرید </button>
                                        <a href="{{ route('home.cart.clear') }}"> پاک کردن سبد خرید </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="row justify-content-between">

                        <div class="col-lg-4 col-md-6">
                            <div class="discount-code-wrapper">
                                <div class="title-wrap">
                                    <h4 class="cart-bottom-title section-bg-gray"> کد تخفیف </h4>
                                </div>
                                <div class="discount-code">
                                    <p> کد تخفیف خود را وارد کنید: </p>
                                    <form action="{{ route('home.cart.coupon.apply') }}" method="post">
                                        @csrf
                                        <input type="text" name="code" @error('code') class="mb-1" @enderror>
                                        @error('code')
                                            <p class="input-error-validation">
                                                <strong>{{ $message }}</strong>
                                            </p>
                                        @enderror
                                        <button class="cart-btn-2" type="submit"> ثبت </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-12">
                            <div class="grand-totall">
                                <div class="title-wrap">
                                    <h4 class="cart-bottom-title section-bg-gary-cart"> مجموع سفارش </h4>
                                </div>
                                <h5>
                                    مبلغ کل سفارش :
                                    <span>
                                        {{ number_format(Cart::getTotal() + cartTotalDiscountAmount())}}
                                        تومان
                                    </span>
                                </h5>

                                @if(cartTotalDiscountAmount() > 0)
                                    <hr>
                                    <h5 style="color: #ff3535">
                                        مبلغ تخفیف ها :
                                        <span>
                                            {{ number_format(cartTotalDiscountAmount())}}
                                            تومان
                                        </span>
                                    </h5>
                                @endif

                                @if(session()->has('coupon'))
                                    <hr>
                                    <h5 style="color: #ff3535">
                                        مبلغ کد تخفیف :
                                        <span>
                                            {{ number_format(session('coupon.amount')) }}
                                            تومان
                                        </span>
                                    </h5>
                                @endif

                                <div class="total-shipping">
                                    <h5>
                                        هزینه ارسال :
                                        @if(cartTotalDeliveryAmount() == 0)
                                            <span>
                                                رایگان
                                            </span>
                                        @else
                                            <span>
                                            {{ number_format(cartTotalDeliveryAmount()) }}
                                            تومان
                                        </span>
                                        @endif
                                    </h5>

                                </div>
                                <h4 class="grand-totall-title">
                                    جمع کل:
                                    <span>
                                        {{ number_format(cartTotalAmount()) }}
                                        تومان
                                    </span>
                                </h4>
                                <a href="{{ route('home.orders.checkout') }}"> ادامه فرآیند خرید </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')

@endpush

@push('style')
    <style>
        .active-variation {
            background-color: #ff3535 !important;
            color: #fff !important;
        }
    </style>
@endpush
