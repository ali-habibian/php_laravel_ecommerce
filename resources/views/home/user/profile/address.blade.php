@extends('home.layouts.home')

@section('title', 'پروفایل - آدرس ها')

@section('content')
    <div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <ul>
                <li>
                    <a href="{{ route('home.index') }}">صفحه اصلی</a>
                </li>
                <li class="active"> آدرس ها </li>
            </ul>
        </div>
    </div>
</div>

    <!-- my account wrapper start -->
    <div class="my-account-wrapper pt-100 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- My Account Page Start -->
                <div class="myaccount-page-wrapper">
                    <!-- My Account Tab Menu Start -->
                    <div class="row text-right" style="direction: rtl;">
                        <div class="col-lg-3 col-md-4">
                            @include('home.sections.profile.sidebar')
                        </div>
                        <!-- My Account Tab Menu End -->

                        <!-- My Account Tab Content Start -->
                        <div class="col-lg-9 col-md-8">
                            <div class="tab-content" id="myaccountContent">

                                <div class="myaccount-content address-content">
                                    <h3> آدرس ها </h3>

                                    @foreach($userAddress as $address)
                                        <div>
                                            <address>
                                                <p>
                                                    <strong> {{ auth()->user()->name }} </strong>
                                                    <span class="mr-2"> <strong>عنوان آدرس :</strong> <span> {{ $address->title }} </span> </span>
                                                </p>
                                                <p>
                                                    {{ $address->$address }}
                                                    <br>
                                                    <span> <strong>استان :</strong> {{ $address->province->name }} </span>
{{--                                                    <span> | </span>--}}
                                                    <span> <strong>شهر :</strong> {{ $address->city->name }} </span>
                                                </p>
                                                <p>
                                                    <strong>کدپستی :</strong>
                                                    {{ $address->postal_code }}
                                                </p>
                                                <p>
                                                    <strong>شماره موبایل :</strong>
                                                    {{ auth()->user()->mobile }}
                                                </p>

                                            </address>

                                            <a href="#" class="check-btn sqr-btn collapse-address-update">
                                                <i class="sli sli-pencil"></i>
                                                ویرایش آدرس
                                            </a>

                                            <div class="collapse-address-update-content">
                                                <form action="#">
                                                    <div class="row">
                                                        <div class="tax-select col-lg-6 col-md-6">
                                                            <label>عنوان</label>
                                                            <input type="text"
                                                                   name="title"
                                                                   placeholder="عنوان..."
                                                                   value="{{ old('title', $address->title) }}"
                                                                   @error('title', 'updateAddress') class="mb-1" @enderror>

                                                            @error('title', 'updateAddress')
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
                                                                   value="{{ old('tel', $address->tel) }}"
                                                                   @error('tel', 'updateAddress') class="mb-1" @enderror>

                                                            @error('tel', 'updateAddress')
                                                                <p class="input-error-validation">
                                                                    <strong>{{ $message }}</strong>
                                                                </p>
                                                            @enderror
                                                        </div>

                                                        <div class="tax-select col-lg-6 col-md-6">
                                                            <label>استان</label>
                                                            <select class="email s-email s-wid province-select @error('province_id', 'updateAddress') mb-1 @enderror"
                                                                    name="province_id">
                                                                @foreach($provinces as $province)
                                                                    <option value="{{ $province->id }}"
                                                                            @selected($province->id == old('province_id', $address->province_id))>{{ $province->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>

                                                            @error('province_id', 'updateAddress')
                                                                <p class="input-error-validation">
                                                                    <strong>{{ $message }}</strong>
                                                                </p>
                                                            @enderror
                                                        </div>

                                                        <div class="tax-select col-lg-6 col-md-6">
                                                            <label>شهر</label>
                                                            <select class="email s-email s-wid city-select @error('city_id', 'updateAddress') mb-1 @enderror"
                                                                    name="city_id">
                                                            </select>

                                                            @error('city_id', 'updateAddress')
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
                                                                   value="{{ old('address', $address->address) }}"
                                                                   @error('address', 'updateAddress') class="mb-1" @enderror>

                                                            @error('address', 'updateAddress')
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
                                                                   value="{{ old('postal_code', $address->postal_code) }}"
                                                                   @error('postal_code', 'updateAddress') class="mb-1" @enderror>

                                                            @error('postal_code', 'updateAddress')
                                                                <p class="input-error-validation">
                                                                    <strong>{{ $message }}</strong>
                                                                </p>
                                                            @enderror
                                                        </div>

                                                        <div class=" col-lg-12 col-md-12">
                                                            <button class="cart-btn-2" type="submit"> ویرایش
                                                                آدرس
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <hr>
                                    @endforeach

                                    <button class="collapse-address-create mt-3"
                                            type="submit"> ایجاد آدرس جدید </button>
                                    <div class="collapse-address-create-content"
                                         style="{{ count($errors->storeAddress) > 0 ? 'display: block;' : '' }}">

                                        <form action="{{ route('home.profile.address.store') }}" method="post">
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
                                                    <button class="cart-btn-2" type="submit"> ثبت آدرس</button>
                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- My Account Tab Content End -->
                    </div>
                </div> <!-- My Account Page End -->
            </div>
        </div>
    </div>
</div>
    <!-- my account wrapper end -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            let provinceSelect = $('.province-select');
            let citySelect = $('.city-select');

            function loadCities(provinceId, selectedCityId = null) {
                let path = "{{ route('get.cities', ['provinceId' => ':provinceId']) }}";
                path = path.replace(':provinceId', provinceId);

                if (provinceId) {
                    $.ajax({
                        url: path,
                        type: 'GET',
                        dataType: 'json',
                        success: function (data) {
                            citySelect.empty();
                            citySelect.append('<option value="" disabled>انتخاب شهر</option>');

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

            // Trigger AJAX on province change
            provinceSelect.on('change', function () {
                loadCities($(this).val());
            });

            // On page load, check if a province is already selected and load cities
            let initialProvince = provinceSelect.val();
            let initialCity = "{{ old('city_id') }}"; // Retrieve previous city selection

            if (initialProvince) {
                loadCities(initialProvince, initialCity);
            }
        });
    </script>
@endpush