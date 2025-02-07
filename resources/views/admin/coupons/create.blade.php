@extends('admin.layouts.admin-layout')

@section('title', 'ایجاد کوپن')

@section('content')
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-4 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">ایجاد کوپن</h5>
            </div>
            <hr>

            @include('admin.sections.errors')
            <form action="{{ route('admin.coupons.store') }}" method="POST">
                @csrf

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="name">نام</label>
                        <input class="form-control" id="name" name="name" type="text" value="{{ old('name') }}" autofocus>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="code">کد</label>
                        <input class="form-control" id="code" name="code" type="text" value="{{ old('code') }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="type">نوع</label>
                        <select class="form-control" id="type" name="type" onchange="toggleFields()">
                            <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>مبلغی</option>
                            <option value="percent" {{ old('type') == 'percent' ? 'selected' : '' }}>درصدی</option>
                        </select>
                    </div>

                    <!-- Fixed Type: Amount Field -->
                    <div class="form-group col-md-3 fixedField">
                        <label for="amount">مبلغ</label>
                        <input class="form-control" id="amount" name="amount" type="text" value="{{ old('amount') }}">
                    </div>

                    <!-- Percent Type: Percentage and Max Amount Fields -->
                    <div class="form-group col-md-3 percentField d-none">
                        <label for="percent">درصد</label>
                        <input class="form-control" id="percent" name="percent" type="text" value="{{ old('percent') }}">
                    </div>

                    <div class="form-group col-md-3 percentField d-none">
                        <label for="max_percentage_amount">حداکثر مبلغ برای نوع درصدی</label>
                        <input class="form-control" id="max_percentage_amount" name="max_percentage_amount" type="text" value="{{ old('max_percentage_amount') }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label> تاریخ انقضا </label>
                        <div class="input-group">
                            <div class="input-group-prepend order-2">
                                <span class="input-group-text">
                                    <i class="fas fa-clock"></i>
                                </span>
                            </div>
                            <input data-jdp type="text" value="{{ old('expires_at') }}" name="expires_at" class="form-control">
                        </div>
                    </div>

                    <div class="form-group col-12">
                        <label for="description">توضیحات</label>
                        <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    </div>
                </div>

                <button class="btn btn-outline-primary mt-5" type="submit">ثبت</button>
                <a href="{{ route('admin.coupons.index') }}" class="btn btn-dark mt-5 mr-2">بازگشت</a>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Toggle fields based on selected type
        function toggleFields() {
            let type = document.getElementById("type").value;

            if (type === "fixed") {
                $(".fixedField").each(function (index, element) {
                    if (element.classList.contains("d-none")) {
                        element.classList.remove("d-none");
                    }
                });

                $(".percentField").each(function (index, element) {
                    if (!element.classList.contains("d-none")) {
                        element.classList.add("d-none");
                    }
                })
            } else {
                $(".percentField").each(function (index, element) {
                    if (element.classList.contains("d-none")) {
                        element.classList.remove("d-none");
                    }
                });

                $(".fixedField").each(function (index, element) {
                    if (!element.classList.contains("d-none")) {
                        element.classList.add("d-none");
                    }
                })
            }
        }

        // Run on page load to handle old values
        document.addEventListener("DOMContentLoaded", function () {
            toggleFields();
        });
    </script>

    <script type="module">
        jalaliDatepicker.startWatch({
            'persianDigits': true
        });
    </script>
@endpush
