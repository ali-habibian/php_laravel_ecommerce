@extends('admin.layouts.admin-layout')

@section('title', 'نمایش تگ')

@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 bg-white">

            <!-- Topbar -->
            <div class="mb-4">
                <h5 class="font-weight-bold">تگ: {{ $tag->name }}</h5>
            </div>
            <!-- End Topbar -->

            <hr>

            <div class="row">
                <div class="form-group col-md-3">
                    <label for="name">نام</label>
                    <input class="form-control" disabled type="text" value="{{ $tag->name }}">
                </div>

                <div class="form-group col-md-3">
                    <label for="name">تاریخ ایجاد</label>
                    <input class="form-control" disabled type="text" value="{{ verta($tag->created_at)->format('Y-m-d H:i') }}">
                </div>
            </div>

            <a href="{{ route('admin.tags.index') }}" class="btn btn-dark mt-5">بازگشت</a>
        </div>
    </div>
@endsection
