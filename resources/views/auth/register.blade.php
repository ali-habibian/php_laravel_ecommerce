@extends('home.layouts.home')

@section('title', 'ثبت نام')

@section('content')
    <div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="{{ route('home.index') }}">صفحه اصلی</a>
                    </li>
                    <li class="active"> ثبت نام </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="login-register-area pt-30 pb-30" style="direction: rtl;">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                    <div class="login-register-wrapper">
                        <div class="login-register-tab-list nav">
                            <a class="active" data-toggle="tab" href="#lg2">
                                <h4> ثبت نام </h4>
                            </a>
                        </div>
                        <div class="tab-content">
                            <div id="lg2" class="tab-pane active">
                                <div class="login-form-container">
                                    <div class="login-register-form">
                                        <form action="{{ route('register') }}" method="post">
                                            @csrf

                                            <input class="@error('name') mb-1 @enderror" name="name" placeholder="نام" type="text" value="{{ old('name') }}">
                                            @error('name')
                                                <div class="input-error-validation mb-1">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror

                                            <input class="@error('name') mb-1 @enderror" name="email" placeholder="ایمیل" type="email" value="{{ old('email') }}">
                                            @error('email')
                                                <div class="input-error-validation mb-1">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror

                                            <input class="@error('name') mb-1 @enderror" type="password" name="password" placeholder="رمز عبور">
                                            @error('password')
                                                <div class="input-error-validation mb-1">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror

                                            <input type="password" name="password_confirmation" placeholder="تکرار رمز عبور">

                                            <div class="button-box">
                                                <button type="submit">ثبت نام</button>
                                                <a href="{{ route('auth.redirect', 'google') }}" class="btn btn-google btn-block mt-4">
                                                    <i class="fab fa-google"></i>
                                                    ایجاد اکانت با گوگل
                                                </a>

                                                <div class="text-center mt-2">
                                                    <span>قبلا ثبت نام کرده‌ام!!</span>
                                                    <a href="{{ route('login') }}">
                                                         ورود
                                                    </a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection