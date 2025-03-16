@extends('admin.layouts.admin-layout')

@section('title', 'نمایش سفارش')

@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 bg-white">

            <!-- Topbar -->
            <div class="mb-4">
                <h5 class="font-weight-bold">سفارش: {{ $order->id }}</h5>
            </div>
            <!-- End Topbar -->

            <hr>

            <div class="row">
                <div class="form-group col-md-3">
                    <label>نام کاربر</label>
                    <input class="form-control" disabled type="text" value="{{ $order->user->name }}">
                </div>

                <div class="form-group col-md-3">
                    <label>کد کوپن</label>
                    <input class="form-control"
                           disabled
                           type="text"
                           value="{{ $order->coupon ? $order->coupon->code : 'استفاده نشده' }}">
                </div>

                <div class="form-group col-md-3">
                    <label>وضعیت</label>
                    <input class="form-control {{ $order->getRawOriginal('status') ? 'text-success' : 'text-danger' }}"
                           disabled
                           type="text"
                           value="{{ $order->status }}">
                </div>

                <div class="form-group col-md-3">
                    <label>مبلغ</label>
                    <input class="form-control"
                           disabled
                           type="text"
                           value="{{ number_format($order->total_amount) }} تومان">
                </div>

                <div class="form-group col-md-3">
                    <label>هزینه ارسال</label>
                    <input class="form-control"
                           disabled
                           type="text"
                           value="{{ number_format($order->delivery_charge) }} تومان">
                </div>

                <div class="form-group col-md-3">
                    <label>مبلغ کد تخفیف</label>
                    <input class="form-control"
                           disabled
                           type="text"
                           value="{{ $order->coupon ? number_format($order->coupon_discount) . ' تومان' : 'استفاده نشده' }}">
                </div>

                <div class="form-group col-md-3">
                    <label>مبلغ پرداختی</label>
                    <input class="form-control"
                           disabled
                           type="text"
                           value="{{ number_format($order->paying_amount) }} تومان">
                </div>

                <div class="form-group col-md-3">
                    <label>نوع پرداخت</label>
                    <input class="form-control" disabled type="text" value="{{ $order->payment_method }}">
                </div>

                <div class="form-group col-md-3">
                    <label>وضعیت پرداخت</label>
                    <input class="form-control {{ $order->getRawOriginal('payment_status') ? 'text-success' : 'text-danger' }}"
                           disabled
                           type="text"
                           value="{{ $order->payment_status }}">
                </div>

                <div class="form-group col-md-3">
                    <label>تاریخ سفارش</label>
                    <input class="form-control"
                           disabled
                           type="text"
                           value="{{ verta($order->created_at)->format('Y-m-d H:i') }}">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-12">
                    <label>آدرس</label>
                    <textarea class="form-control" disabled rows="3">{{ $order->address->address }}</textarea>
                </div>
            </div>

            <!-- Topbar -->
            <div class="mb-4 mt-4">
                <h5 class="font-weight-bold">محصولات</h5>
            </div>
            <!-- End Topbar -->

            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
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
                                    <a href="{{ route('admin.products.show', $orderItem->product) }}"><img
                                                width="70px"
                                                src="{{ asset($orderItem->product->primary_image) }}"
                                                alt="{{ $orderItem->product->name }}"></a>
                                </td>
                                <td class="product-name"><a href="{{ route('admin.products.show', $orderItem->product) }}"> {{ $orderItem->product->name }} </a></td>
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

            <a href="{{ route('admin.orders.index') }}" class="btn btn-dark mt-5">بازگشت</a>
        </div>
    </div>
@endsection
