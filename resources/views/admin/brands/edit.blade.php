@extends('admin.layouts.admin-layout')

@section('title', 'ویرایش برند')

@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">

            <!-- Topbar -->
            <div class="mb-4">
                <h5 class="font-weight-bold">ویرایش برند: {{ $brand->name }}</h5>
            </div>
            <!-- End Topbar -->

            <hr>

            @include('admin.sections.errors')
            <form action="{{ route('admin.brands.update', ['brand' => $brand]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="name">نام</label>
                        <input class="form-control" id="name" name="name" type="text" value="{{ old('name', $brand->name) }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="is_active">وضعیت</label>
                        <select class="form-control" id="is_active" name="is_active">
                            <option value="1" {{ old('is_active', $brand->getRawOriginal('is_active')) ? 'selected' : '' }}>فعال</option>
                            <option value="0" {{ !old('is_active', $brand->getRawOriginal('is_active')) ? 'selected' : '' }}>غیر فعال</option>
                        </select>
                    </div>
                </div>

                <button class="btn btn-outline-primary mt-5" type="submit">ویرایش</button>
                <a href="{{ route('admin.brands.index') }}" class="btn btn-dark mt-5 mr-2">بازگشت</a>
            </form>

        </div>
    </div>
@endsection
