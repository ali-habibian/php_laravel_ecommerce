@extends('home.layouts.home')

@section('title', 'پروفایل - سفارشات')

@section('content')
    <div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <ul>
                <li>
                    <a href="{{ route('home.index') }}">صفحه اصلی</a>
                </li>
                <li class="active"> سفارشات </li>
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
                                        <h3>سفارشات</h3>
                                        <div class="myaccount-table table-responsive text-center">
                                            <table class="table table-bordered">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th> سفارش </th>
                                                        <th> تاریخ </th>
                                                        <th> وضعیت </th>
                                                        <th> جمع کل </th>
                                                        <th> عملیات </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if($orders->isEmpty())
                                                        <div class="alert alert-danger">
                                                            لیست سفارشات شما خالی می باشد
                                                        </div>
                                                    @endif

                                                    @foreach($orders as $key => $order)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td> {{ verta($order->created_at)->format('%d %B، %Y') }} </td>
                                                            <td>{{ $order->status }}</td>
                                                            <td>
                                                                {{number_format($order->paying_amount )}}
                                                                تومان
                                                            </td>
                                                            <td><a href="#" data-toggle="modal"
                                                                   data-target="#ordersDetails-{{$order->id}}"
                                                                   class="check-btn sqr-btn "> نمایش جزئیات </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
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

    <!-- Modal Order Detail -->
    @foreach($orders as $order)
        <div class="modal fade" id="ordersDetails-{{$order->id}}" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12" style="direction: rtl;">
                                <form action="#">
                                    <div class="table-content table-responsive cart-table-content">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th> تصویر محصول </th>
                                                    <th> نام محصول </th>
                                                    <th> فی </th>
                                                    <th> تعداد </th>
                                                    <th> قیمت کل </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($order->orderItems as $orderItem)
                                                    <tr>
                                                        <td class="product-thumbnail">
                                                            <a href="{{ route('home.products.show', $orderItem->product->slug) }}"><img
                                                                        width="70px"
                                                                        src="{{ asset($orderItem->product->primary_image) }}"
                                                                        alt="{{ $orderItem->product->name }}"></a>
                                                        </td>
                                                        <td class="product-name"><a href="{{ route('home.products.show', $orderItem->product->slug) }}"> {{ $orderItem->product->name }} </a></td>
                                                        <td class="product-price-cart"><span class="amount">
                                                                {{ number_format($orderItem->price) }}
                                                                تومان
                                                            </span></td>
                                                        <td class="product-quantity">
                                                            {{ $orderItem->quantity }}
                                                        </td>
                                                        <td class="product-subtotal">
                                                            {{ number_format($orderItem->price * $orderItem->quantity) }}
                                                            تومان
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <!-- Modal end -->
@endsection