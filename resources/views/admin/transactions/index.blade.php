@extends('admin.layouts.admin-layout')

@section('title', 'لیست تراکنش ها')

@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 bg-white">

            <!-- Topbar -->
            <div class="d-flex flex-column text-center flex-md-row justify-content-md-between mb-4">
                <h5 class="font-weight-bold mb-3 mb-md-0">لیست تراکنش ها ({{ $transactions->total() }})</h5>
            </div>
            <!-- End Topbar -->

            <!-- Brands Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>نام کاربر</th>
                        <th>شماره سفارش</th>
                        <th>مبلغ</th>
                        <th>کد رهگیری (ref_id)</th>
                        <th>نام درگاه پرداخت</th>
                        <th>وضعیت</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($transactions as $key => $transaction)

                        <tr>
                            <td>{{ $transactions->firstItem() + $key }}</td>
                            <td>{{ $transaction->user->name }}</td>
                            <td>{{ $transaction->order->id }}</td>
                            <td>{{ number_format($transaction->amount) }} تومان</td>
                            <td>{{ $transaction->ref_id }}</td>
                            <td>{{ $transaction->gateway_name }}</td>
                            <td>
                                <span class="{{ $transaction->getRawOriginal('status') ? 'text-success' : 'text-danger' }}">
                                    {{ $transaction->status }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- End Brands Table -->

            <div class="d-flex justify-content-center mt-5">
                {{ $transactions->render() }}
            </div>
        </div>

    </div>
@endsection
