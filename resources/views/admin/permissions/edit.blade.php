@extends('admin.layouts.admin-layout')

@section('title', 'ویرایش مجوز')

@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 bg-white">

            <div class="mb-4">
                <h5 class="font-weight-bold">ویرایش مجوز: {{ $permission->display_name }}</h5>
            </div>

            <hr>

            @include('admin.sections.errors')
            <form action="{{ route('admin.permissions.update', $permission) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="name">نام</label>
                        <input class="form-control" id="name" name="name" type="text"
                               value="{{ old('name', $permission->name) }}"
                               autofocus>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="display_name">نام نمایشی</label>
                        <input class="form-control" id="display_name" name="display_name" type="text"
                               value="{{ old('display_name', $permission->display_name) }}">
                    </div>
                </div>

                <button class="btn btn-outline-primary mt-5" type="submit">ویرایش</button>
                <a href="{{ route('admin.permissions.index') }}" class="btn btn-dark mt-5 mr-2">بازگشت</a>
            </form>

        </div>
    </div>
@endsection
