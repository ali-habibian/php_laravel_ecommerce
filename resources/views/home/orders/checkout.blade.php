@extends('home.layouts.home')

@section('title', 'ثبت سفارش')

@section('content')
<div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <ul>
                <li>
                    <a href="{{ route('home.index') }}">صفحه اصلی</a>
                </li>
                <li class="active"> سفارش </li>
            </ul>
        </div>
    </div>
</div>


<!-- compare main wrapper start -->
<div class="checkout-main-area pt-70 pb-70 text-right" style="direction: rtl;">

    <div class="container">

        @if(!session()->has('coupon'))
            <div class="customer-zone mb-20">
                <p class="cart-page-title">
                    کد تخفیف دارید؟
                    <a class="checkout-click3" data-toggle="collapse" href="#collapse-code"> میتوانید با کلیک در این قسمت کد خود را اعمال کنید </a>
                </p>
                <div class="checkout-login-info3 mr-3 collapse"
                     id="collapse-code"
                     style="@error('code') display: block; @enderror">
                    <form action="{{ route('home.cart.coupon.apply') }}" method="post">
                        @csrf
                        <div class="row">
                            <input type="text" placeholder="کد تخفیف" name="code" @error('code') class="mb-1" @enderror>
                            <input type="submit" value="اعمال کد تخفیف">
                        </div>
                        @error('code')
                            <p class="input-error-validation">
                                <strong>{{ $message }}</strong>
                            </p>
                        @enderror
                    </form>
                </div>
            </div>
        @endif

        <div class="checkout-wrap pt-30">
            <div class="row">

                <div class="col-lg-7">
                    <div class="billing-info-wrap mr-50">
                        <h3> آدرس تحویل سفارش </h3>

                        <div class="row">
                            <p>
                                لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان
                                گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است
                            </p>
                            <div class="col-lg-6 col-md-6">
                                <div class="billing-info tax-select mb-20">
                                    <label> انتخاب آدرس تحویل سفارش <abbr class="required"
                                                                          title="required">*</abbr></label>

                                    <select class="email s-email s-wid" id="address_select">
                                        @foreach($userAddress as $address)
                                            <option value="{{ $address->id }}"> {{ $address->title }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 pt-30">
                                <button class="collapse-address-create" type="submit"> ایجاد آدرس جدید </button>
                            </div>

                            <div class="col-lg-12">
                                <div class="collapse-address-create-content">

                                    <form action="{{ route('home.profile.addresses.store') }}" method="post">
                                        @csrf

                                        <div class="row">

                                            <div class="tax-select col-lg-6 col-md-6">
                                                <label>عنوان</label>
                                                <input type="text"
                                                       name="title"
                                                       placeholder="عنوان..."
                                                       value="{{ old('title') }}"
                                                       @error('title', 'storeAddress') class="mb-1" @enderror>

                                                @error('title', 'storeAddress')
                                                    <p class="input-error-validation">
                                                        <strong>{{ $message }}</strong>
                                                    </p>
                                                @enderror
                                                </div>

                                                <div class="tax-select col-lg-6 col-md-6">
                                                    <label>شماره تماس</label>
                                                    <input type="text"
                                                           name="tel"
                                                           placeholder="شماره تلفن ثابت با کد شهر یا شماره موبایل..."
                                                           value="{{ old('tel') }}"
                                                           @error('tel', 'storeAddress') class="mb-1" @enderror>

                                                    @error('tel', 'storeAddress')
                                                        <p class="input-error-validation">
                                                            <strong>{{ $message }}</strong>
                                                        </p>
                                                    @enderror
                                                </div>

                                                <div class="tax-select col-lg-6 col-md-6">
                                                    <label>استان</label>
                                                    <select class="email s-email s-wid province-select @error('province_id', 'storeAddress') mb-1 @enderror"
                                                            name="province_id">
                                                        @foreach($provinces as $province)
                                                            <option value="{{ $province->id }}"
                                                                    @selected($province->id == old('province_id'))>{{ $province->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                    @error('province_id', 'storeAddress')
                                                    <p class="input-error-validation">
                                                            <strong>{{ $message }}</strong>
                                                        </p>
                                                    @enderror
                                                </div>

                                                <div class="tax-select col-lg-6 col-md-6">
                                                    <label>شهر</label>
                                                    <select class="email s-email s-wid city-select @error('city_id', 'storeAddress') mb-1 @enderror"
                                                            name="city_id">
                                                    </select>

                                                    @error('city_id', 'storeAddress')
                                                        <p class="input-error-validation">
                                                            <strong>{{ $message }}</strong>
                                                        </p>
                                                    @enderror
                                                </div>

                                                <div class="tax-select col-lg-6 col-md-6">
                                                    <label>آدرس</label>
                                                    <input type="text"
                                                           name="address"
                                                           placeholder="آدرس..."
                                                           value="{{ old('address') }}"
                                                           @error('address', 'storeAddress') class="mb-1" @enderror>

                                                    @error('address', 'storeAddress')
                                                        <p class="input-error-validation">
                                                            <strong>{{ $message }}</strong>
                                                        </p>
                                                    @enderror
                                                </div>

                                                <div class="tax-select col-lg-6 col-md-6">
                                                    <label>کد پستی</label>
                                                    <input type="text"
                                                           name="postal_code"
                                                           placeholder="کد پستی..."
                                                           value="{{ old('postal_code') }}"
                                                           @error('postal_code', 'storeAddress') class="mb-1" @enderror>

                                                    @error('postal_code', 'storeAddress')
                                                        <p class="input-error-validation">
                                                            <strong>{{ $message }}</strong>
                                                        </p>
                                                    @enderror
                                                </div>

                                            <div class=" col-lg-12 col-md-12">

                                                <button class="cart-btn-2" type="submit"> ثبت آدرس جدید
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ORDER SECTION -->
                <div class="col-lg-5">
                    <form action="{{ route('home.orders.payment') }}" method="post">
                        @csrf
                        <div class="your-order-area">
                            <h3> سفارش شما </h3>
                            <div class="your-order-wrap gray-bg-4">
                                <div class="your-order-info-wrap">
                                    <div class="your-order-info">
                                        <ul>
                                            <li> محصول <span> جمع </span></li>
                                        </ul>
                                    </div>
                                    <div class="your-order-middle">
                                        <ul>
                                            @foreach(Cart::getContent() as $item)
                                                <li class="d-flex justify-content-between">
                                                    <div>
                                                        {{ Str::limit($item->name, 35, '…') }}
                                                        <div dir="rtl">
                                                            <p class="mb-0 mt-0" style="font-size: 12px">{{ number_format($item->price) }} * {{ $item->quantity }}</p>
                                                            <p class="mb-0 mt-0" style="font-size: 12px">
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
                                                    <span>
                                                        {{ number_format($item->getPriceSum()) }}
                                                        تومان
                                                    </span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="your-order-info order-subtotal">
                                        <ul>
                                            <li> مبلغ کل سفارش :
                                                <span>
                                                    {{ number_format(Cart::getTotal() + cartTotalDiscountAmount())}}
                                                    تومان
                                                </span>
                                            </li>
                                        </ul>
                                    </div>

                                    @if(cartTotalDiscountAmount() > 0)
                                        <div class="your-order-info order-subtotal" style="color: #ff3535">
                                            <ul>
                                                <li> مبلغ تخفیف ها :
                                                    <span>
                                                        {{ number_format(cartTotalDiscountAmount())}}
                                                        تومان
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                    @endif

                                    @if(session()->has('coupon'))
                                        <div class="your-order-info order-subtotal" style="color: #ff3535">
                                            <ul>
                                                <li> مبلغ کد تخفیف :
                                                    <span>
                                                        {{ number_format(session('coupon.amount')) }}
                                                        تومان
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                    @endif

                                    <div class="your-order-info order-shipping">
                                        <ul>
                                            <li> هزینه ارسال
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
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="your-order-info order-total">
                                        <ul>
                                            <li>جمع کل
                                                <span>
                                                    {{ number_format(cartTotalAmount()) }}
                                                    تومان
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="payment-method">
                                    <div class="pay-top sin-payment">
                                        <input id="zarinpal" class="input-radio" type="radio" value="{{ \App\Constants\PaymentTypes::ZARINPAL }}"
                                               checked="checked" name="payment_method">
                                        <label for="zarinpal"> درگاه پرداخت زرین پال </label>
                                        <div class="payment-box payment_method_bacs">
                                            <p>
                                                لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="pay-top sin-payment">
                                        <input id="pay" class="input-radio" type="radio" value="{{ \App\Constants\PaymentTypes::PAY }}"
                                               name="payment_method">
                                        <label for="pay">درگاه پرداخت پی</label>
                                        <div class="payment-box payment_method_bacs">
                                            <p>
                                                لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="address_id" id="address_input">
                            <div class="Place-order mt-40">
                                <button type="submit">ثبت سفارش</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- compare main wrapper end -->
@endsection

@push('scripts')
    @if ($errors->has('payment_error'))
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                Swal.fire({
                    icon: "error",
                    title: "خطا",
                    text: "{{ $errors->first('payment_error') }}",
                });
            });
        </script>
    @endif

    <script>
        let provinceSelect = $('.province-select');
        let citySelect = $('.city-select');
        let addressInput = $('#address_input');
        let addressSelect = $('#address_select');

        $(document).ready(function () {
            addressInput.val(addressSelect.val());
            addressSelect.on('change', function () {
                addressInput.val($(this).val());
            });

            let initialProvince = provinceSelect.val();
            let initialCity = provinceSelect.data('city-id'); // Retrieve city_id from a data attribute

            if (initialProvince) {
                loadCities(initialProvince, citySelect, initialCity);
            }

            provinceSelect.on('change', function () {
                let provinceId = provinceSelect.val();
                loadCities(provinceId, citySelect);
            });

            function loadCities(provinceId, citySelect, selectedCityId = null) {
                let path = "{{ route('get.cities', ['provinceId' => ':provinceId']) }}";
                path = path.replace(':provinceId', provinceId);

                if (provinceId) {
                    $.ajax({
                        url: path,
                        type: 'GET',
                        dataType: 'json',
                        success: function (data) {
                            citySelect.empty();
                            citySelect.append('<option value="" disabled selected>انتخاب شهر</option>');

                            $.each(data, function (key, city) {
                                let isSelected = selectedCityId && city.id == selectedCityId ? 'selected' : '';
                                citySelect.append('<option value="' + city.id + '" ' + isSelected + '>' + city.name + '</option>');
                            });
                        }
                    });
                } else {
                    citySelect.empty().append('<option value="">ابتدا استان را انتخاب کنید</option>');
                }
            }
        });
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
