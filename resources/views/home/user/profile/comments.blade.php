@extends('home.layouts.home')

@section('title', 'پروفایل - دیدگاه ها')

@section('content')
<div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <ul>
                <li>
                    <a href="{{ route('home.index') }}">صفحه اصلی</a>
                </li>
                <li class="active"> دیدگاه ها </li>
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

                                <div class="myaccount-content">
                                    <h3> دیدگاه ها </h3>
                                    <div class="review-wrapper">

                                        <div class="single-review">
                                            <div class="review-img">
                                                <img src="assets/img/product-details/client-1.jpg" alt="">
                                            </div>
                                            <div class="review-content w-100 text-right">
                                                <p class="text-right">
                                                    لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت
                                                    چاپ و با
                                                    استفاده از طراحان گرافیک است.
                                                </p>
                                                <div class="review-top-wrap">
                                                    <div class="review-name d-flex align-items-center">
                                                        <h4>
                                                            برای محصول :
                                                        </h4>
                                                        <a class="mr-1" href="#" style="color:#ff3535;">
                                                            لورم ایپسوم </a>
                                                    </div>
                                                    <div>
                                                        در تاریخ :
                                                        22 تیر 1399
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="single-review">
                                            <div class="review-img">
                                                <img src="assets/img/product-details/client-2.jpg" alt="">
                                            </div>
                                            <div class="review-content w-100 text-right">
                                                <p class="text-right">
                                                    لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت
                                                    چاپ و با
                                                    استفاده از طراحان گرافیک است. چاپگرها و متون بلکه
                                                    روزنامه و مجله در
                                                    ستون و سطرآنچنان که لازم است
                                                </p>
                                                <div class="review-top-wrap text-right">
                                                    <div class="review-name d-flex align-items-center">
                                                        <h4>
                                                            برای محصول :
                                                            <a class="mr-1" href="#" style="color:#ff3535;">
                                                                لورم ایپسوم </a>
                                                        </h4>
                                                    </div>
                                                    <div>
                                                        در تاریخ :
                                                        22 تیر 1399
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="single-review">
                                            <div class="review-img">
                                                <img src="assets/img/product-details/client-1.jpg" alt="">
                                            </div>
                                            <div class="review-content w-100 text-right">
                                                <p class="text-right">
                                                    لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت
                                                    چاپ و با
                                                    استفاده از طراحان گرافیک است.
                                                </p>
                                                <div class="review-top-wrap">
                                                    <div class="review-name d-flex align-items-center">
                                                        <h4>
                                                            برای محصول :
                                                        </h4>
                                                        <a class="mr-1" href="#" style="color:#ff3535;">
                                                            لورم ایپسوم </a>
                                                    </div>
                                                    <div>
                                                        در تاریخ :
                                                        22 تیر 1399
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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