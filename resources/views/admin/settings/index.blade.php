@extends('admin.layouts.admin-layout')

@section('title', 'تنظیمات تماس با ما')
@php
    if (!isset($setting)){
        $url = route('admin.settings.store');
        $method = "POST";
    } else {
        $url = route('admin.settings.update', $setting);
        $method = "PUT";
    }
@endphp
@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 bg-white">

            <div class="mb-4">
                <h5 class="font-weight-bold">تنظیمات تماس با ما</h5>
            </div>

            <hr>

            @include('admin.sections.errors')
            <form action="{{ $url }}" method="POST">
                @csrf
                @method($method)

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="address">آدرس</label>
                        <input class="form-control"
                               id="address"
                               name="address"
                               type="text"
                               value="{{ old('address') }}"
                               autofocus>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="phone">شماره تماس یک</label>
                        <input class="form-control"
                               id="phone"
                               name="phone"
                               type="text"
                               value="{{ old('phone') }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="phone_2">شماره تماس دو</label>
                        <input class="form-control"
                               id="phone_2"
                               name="phone_2"
                               type="text"
                               value="{{ old('phone_2') }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="instagram">اینستاگرام</label>
                        <input class="form-control"
                               id="instagram"
                               name="instagram"
                               type="text"
                               value="{{ old('instagram') }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="telegram">تلگرام</label>
                        <input class="form-control"
                               id="telegram"
                               name="telegram"
                               type="text"
                               value="{{ old('telegram') }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="facebook">فیسبوک</label>
                        <input class="form-control"
                               id="facebook"
                               name="facebook"
                               type="text"
                               value="{{ old('facebook') }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="email">ایمیل</label>
                        <input class="form-control"
                               id="email"
                               name="email"
                               type="email"
                               value="{{ old('email') }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="longitude">longitude</label>
                        <input class="form-control"
                               id="longitude"
                               name="longitude"
                               type="text"
                               value="{{ old('longitude') }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="latitude">latitude</label>
                        <input class="form-control"
                               id="latitude"
                               name="latitude"
                               type="text"
                               value="{{ old('latitude') }}">
                    </div>
                </div>

                <button class="btn btn-outline-primary mt-5 mb-3" type="submit">{{ isset($setting) ? 'ویرایش' : 'ثبت' }}</button>
            </form>

            @if(isset($setting))
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label>آدرس</label>
                        <input class="form-control" type="text" disabled value="{{ $setting->address }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label>شماره تماس یک</label>
                        <input class="form-control" type="text" disabled value="{{ $setting->phone }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label>شماره تماس دو</label>
                        <input class="form-control" type="text" disabled value="{{ $setting->phone_2 }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label>اینستاگرام</label>
                        <input class="form-control" type="text" disabled value="{{ $setting->instagram }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label>تلگرام</label>
                        <input class="form-control" type="text" disabled value="{{ $setting->telegram }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label>فیسبوک</label>
                        <input class="form-control" type="text" disabled value="{{ $setting->facebook }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label>ایمیل</label>
                        <input class="form-control" type="email" disabled value="{{ $setting->email }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label>longitude</label>
                        <input class="form-control" type="text" disabled value="{{ $setting->longitude }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label>latitude</label>
                        <input class="form-control" type="text" disabled value="{{ $setting->latitude }}">
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection
