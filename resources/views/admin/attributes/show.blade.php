@extends('admin.layouts.admin-layout')

@section('title', 'نمایش ویژگی')

@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">

            <!-- Topbar -->
            <div class="mb-4">
                <h5 class="font-weight-bold">ویژگی: {{ $attribute->name }}</h5>
            </div>
            <!-- End Topbar -->

            <hr>

            <div class="row">
                <div class="form-group col-md-3">
                    <label for="name">نام</label>
                    <input class="form-control" disabled type="text" value="{{ $attribute->name }}">
                </div>

                <div class="form-group col-md-3">
                    <label for="name">تاریخ ایجاد</label>
                    <input class="form-control" disabled type="text" value="{{ verta($attribute->created_at)->format('Y-m-d H:i') }}">
                </div>
            </div>

            <a href="{{ route('admin.attributes.index') }}" class="btn btn-dark mt-5">بازگشت</a>
        </div>
    </div>
@endsection
