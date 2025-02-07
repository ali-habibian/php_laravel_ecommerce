@extends('admin.layouts.admin-layout')

@section('title', 'نمایش کوپن')

@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 bg-white">

            <!-- Topbar -->
            <div class="mb-4">
                <h5 class="font-weight-bold">کوپن: {{ $coupon->name }}</h5>
            </div>
            <!-- End Topbar -->

            <hr>

            <div class="row">
                <div class="form-group col-md-3">
                    <label>نام</label>
                    <input class="form-control" disabled type="text" value="{{ $coupon->name }}">
                </div>

                <div class="form-group col-md-3">
                    <label>کد</label>
                    <input class="form-control" disabled type="text" value="{{ $coupon->code }}">
                </div>

                <div class="form-group col-md-3">
                    <label>نوع</label>
                    <input class="form-control" disabled type="text" value="{{ $coupon->type }}">
                </div>

                <!-- Fixed Type: Amount Field -->
                <div class="form-group col-md-3 {{ $coupon->getRawOriginal('type') === 'fixed' ? '' : 'd-none' }}">
                    <label>مبلغ</label>
                    <input class="form-control" disabled type="text" value="{{ number_format($coupon->amount) }}">
                </div>

                <!-- Percent Type: Percentage and Max Amount Fields -->
                <div class="form-group col-md-3 {{ $coupon->getRawOriginal('type') === 'fixed' ? 'd-none' : '' }}">
                    <label>درصد</label>
                    <input class="form-control" disabled type="text" value="{{ $coupon->percent }}">
                </div>

                <div class="form-group col-md-3 {{ $coupon->getRawOriginal('type') === 'fixed' ? 'd-none' : '' }}">
                    <label>حداکثر مبلغ برای نوع درصدی</label>
                    <input class="form-control" disabled type="text" value="{{ number_format($coupon->max_percentage_amount) }}">
                </div>

                <div class="form-group col-md-3">
                    <label> تاریخ انقضا </label>
                    <div class="input-group">
                        <div class="input-group-prepend order-2">
                            <span class="input-group-text">
                                <i class="fas fa-clock"></i>
                            </span>
                        </div>
                        <input type="text" value="{{ verta($coupon->expires_at)->formatDate() }}" disabled class="form-control">
                    </div>
                </div>

                <div class="form-group col-12">
                    <label>توضیحات</label>
                    <textarea class="form-control" disabled rows="3">{{ $coupon->description }}</textarea>
                </div>
            </div>

            <a href="{{ route('admin.coupons.index') }}" class="btn btn-dark mt-5">بازگشت</a>
        </div>
    </div>
@endsection
