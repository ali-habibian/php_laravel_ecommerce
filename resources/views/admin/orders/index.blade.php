@extends('admin.layouts.admin-layout')

@section('title', 'لیست سفارشات')

@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 bg-white">

            <!-- Topbar -->
            <div class="d-flex flex-column text-center flex-md-row justify-content-md-between mb-4">
                <h5 class="font-weight-bold mb-3 mb-md-0">لیست سفارشات ({{ $orders->total() }})</h5>
            </div>
            <!-- End Topbar -->

            <!-- Brands Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>نام کاربر</th>
                        <th>وضعیت</th>
                        <th>مبلغ</th>
                        <th>نوع پرداخت</th>
                        <th>وضعیت پرداخت</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($orders as $key => $order)
                        <tr>
                            <td>{{ $orders->firstItem() + $key }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>
                                <span class="{{ $order->getRawOriginal('status') ? 'text-success' : 'text-danger' }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td>{{ number_format($order->paying_amount) }} تومان</td>
                            <td>{{ $order->payment_method }}</td>
                            <td>
                                <span class="{{ $order->getRawOriginal('payment_status') ? 'text-success' : 'text-danger' }}">
                                    {{ $order->payment_status }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">عملیات
                                    </button>

                                    <div class="dropdown-menu">
                                        <a class="dropdown-item text-right"
                                           href="{{ route('admin.orders.show', ['order' => $order]) }}">نمایش</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- End Brands Table -->

            <div class="d-flex justify-content-center mt-5">
                {{ $orders->render() }}
            </div>
        </div>

    </div>
@endsection
