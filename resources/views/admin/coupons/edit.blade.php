@extends('admin.layouts.admin-layout')

@section('title', 'ویرایش کوپن')

@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 bg-white">

            <!-- Topbar -->
            <div class="mb-4">
                <h5 class="font-weight-bold">ویرایش کوپن: {{ $coupon->name }}</h5>
            </div>
            <!-- End Topbar -->

            <hr>

            @include('admin.sections.errors')
            <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="name">نام</label>
                        <input class="form-control" id="name" name="name" type="text" value="{{ old('name', $coupon->name) }}" autofocus>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="code">کد</label>
                        <input class="form-control" id="code" name="code" type="text" value="{{ old('code', $coupon->code) }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="type">نوع</label>
                        <select class="form-control" id="type" name="type" onchange="toggleFields()">
                            <option value="fixed" {{ old('type', $coupon->getRawOriginal('type')) == 'fixed' ? 'selected' : '' }}>مبلغی</option>
                            <option value="percent" {{ old('type', $coupon->getRawOriginal('type')) == 'percent' ? 'selected' : '' }}>درصدی</option>
                        </select>
                    </div>

                    <!-- Fixed Type: Amount Field -->
                    <div class="form-group col-md-3 fixedField">
                        <label for="amount">مبلغ</label>
                        <input class="form-control" id="amount" name="amount" type="text" value="{{ old('amount', $coupon->amount) }}">
                    </div>

                    <!-- Percent Type: Percentage and Max Amount Fields -->
                    <div class="form-group col-md-3 percentField d-none">
                        <label for="percent">درصد</label>
                        <input class="form-control" id="percent" name="percent" type="text" value="{{ old('percent', $coupon->percent) }}">
                    </div>

                    <div class="form-group col-md-3 percentField d-none">
                        <label for="max_percentage_amount">حداکثر مبلغ برای نوع درصدی</label>
                        <input class="form-control" id="max_percentage_amount" name="max_percentage_amount" type="text" value="{{ old('max_percentage_amount', $coupon->max_percentage_amount) }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label> تاریخ انقضا </label>
                        <div class="input-group">
                            <div class="input-group-prepend order-2">
                                <span class="input-group-text">
                                    <i class="fas fa-clock"></i>
                                </span>
                            </div>
                            <input data-jdp type="text" value="{{ old('expires_at', verta($coupon->expires_at)->formatDate()) }}" name="expires_at" class="form-control">
                        </div>
                    </div>

                    <div class="form-group col-12">
                        <label for="description">توضیحات</label>
                        <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $coupon->description) }}</textarea>
                    </div>
                </div>

                <button class="btn btn-outline-primary mt-5" type="submit">ویرایش</button>
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

                    // Clear input values when hiding
                    $(element).find("input").val("");
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

                    // Clear input values when hiding
                    $(element).find("input").val("");
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