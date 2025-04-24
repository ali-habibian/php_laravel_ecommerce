@extends('admin.layouts.admin-layout')

@section('title', 'ویرایش کاربر')

@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 bg-white">

            <div class="mb-4">
                <h5 class="font-weight-bold">ویرایش کاربر: {{ $user->name }}</h5>
            </div>

            <hr>

            @include('admin.sections.errors')
            <form action="{{ route('admin.users.update', ['user' => $user]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="name">نام</label>
                        <input class="form-control" id="name" name="name" type="text" value="{{ old('name', $user->name) }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="mobile">شماره تلفن همراه</label>
                        <input class="form-control" id="mobile" name="mobile" type="text" value="{{ old('mobile', $user->mobile) }}">
                    </div>
                </div>

                <button class="btn btn-outline-primary mt-5" type="submit">ویرایش</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-dark mt-5 mr-2">بازگشت</a>
            </form>

        </div>
    </div>
@endsection
