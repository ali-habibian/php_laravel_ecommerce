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
                                                    <span class="mr-2"> عنوان آدرس : <span> {{ $address->title }} </span> </span>
                                                </p>
                                                <p>
                                                    {{ $address->$address }}
                                                    <br>
                                                    <span> استان : {{ $address->province }} </span>
                                                    <span> شهر : {{ $address->city }} </span>
                                                </p>
                                                <p>
                                                    کدپستی :
                                                    {{ $address->postal_code }}
                                                </p>
                                                <p>
                                                    شماره موبایل :
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
                                                            <label>
                                                                عنوان
                                                            </label>
                                                            <input type="text" name="title" value="{{ $address->title }}">
                                                        </div>

{{--                                                        <div class="tax-select col-lg-6 col-md-6">--}}
{{--                                                            <label>--}}
{{--                                                                شماره تماس--}}
{{--                                                            </label>--}}
{{--                                                            <input type="text">--}}
{{--                                                        </div>--}}

                                                        <div class="tax-select col-lg-6 col-md-6">
                                                            <label>
                                                                استان
                                                            </label>
                                                            <select class="email s-email s-wid">
                                                                @foreach($provinces as $province)
                                                                    <option @selected($address->province_id == $province->id)>{{ $province->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="tax-select col-lg-6 col-md-6">
                                                            <label>
                                                                شهر
                                                            </label>
                                                            <select class="email s-email s-wid">
                                                                @foreach($cities as $city)
                                                                    <option @selected($address->city_id == $city->id)>{{ $city->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="tax-select col-lg-6 col-md-6">
                                                            <label>
                                                                آدرس
                                                            </label>
                                                            <input type="text" name="address" value="{{ $address->address }}">
                                                        </div>

                                                        <div class="tax-select col-lg-6 col-md-6">
                                                            <label>
                                                                کد پستی
                                                            </label>
                                                            <input type="text" name="postal_code" value="{{ $address->postal_code }}">
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

                                    <button class="collapse-address-create mt-3" type="submit"> ایجاد آدرس
                                        جدید </button>
                                    <div class="collapse-address-create-content">

                                        <form action="#">

                                            <div class="row">

                                                <div class="tax-select col-lg-6 col-md-6">
                                                    <label>
                                                        عنوان
                                                    </label>
                                                    <input type="text" required="" name="title">
                                                </div>
                                                <div class="tax-select col-lg-6 col-md-6">
                                                    <label>
                                                        شماره تماس
                                                    </label>
                                                    <input type="text">
                                                </div>
                                                <div class="tax-select col-lg-6 col-md-6">
                                                    <label>
                                                        استان
                                                    </label>
                                                    <select class="email s-email s-wid">
                                                        <option>Bangladesh</option>
                                                        <option>Albania</option>
                                                        <option>Åland Islands</option>
                                                        <option>Afghanistan</option>
                                                        <option>Belgium</option>
                                                    </select>
                                                </div>
                                                <div class="tax-select col-lg-6 col-md-6">
                                                    <label>
                                                        شهر
                                                    </label>
                                                    <select class="email s-email s-wid">
                                                        <option>Bangladesh</option>
                                                        <option>Albania</option>
                                                        <option>Åland Islands</option>
                                                        <option>Afghanistan</option>
                                                        <option>Belgium</option>
                                                    </select>
                                                </div>
                                                <div class="tax-select col-lg-6 col-md-6">
                                                    <label>
                                                        آدرس
                                                    </label>
                                                    <input type="text">
                                                </div>
                                                <div class="tax-select col-lg-6 col-md-6">
                                                    <label>
                                                        کد پستی
                                                    </label>
                                                    <input type="text">
                                                </div>

                                                <div class=" col-lg-12 col-md-12">

                                                    <button class="cart-btn-2" type="submit"> ثبت آدرس
                                                    </button>
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