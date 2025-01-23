@extends('home.layouts.home')

@section('title', 'ورود')

@section('content')
    <div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="{{ route('home.index') }}">صفحه اصلی</a>
                    </li>
                    <li class="active"> ورود </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="login-register-area pt-35 pb-35" style="direction: rtl;">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                    <div class="login-register-wrapper">
                        <div class="login-register-tab-list nav">
                            <a class="active" data-toggle="tab" href="#lg1">
                                <h4> ورود </h4>
                            </a>
                        </div>

                        <div class="tab-content">
                            <div id="lg1" class="tab-pane active">
                                <div class="login-form-container">
                                    <div class="login-register-form">
                                        <form action="{{ route('login') }}" method="post">
                                            @csrf

                                            <input class="@error('email') mb-1 @enderror" type="email" name="email" placeholder="ایمیل" value="{{ old('email') }}">
                                            @error('email')
                                                <div class="input-error-validation mb-1">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror

                                            <input class="@error('password') mb-1 @enderror" type="password" name="password" placeholder="رمز عبور">
                                            @error('password')
                                                <div class="input-error-validation mb-1">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror

                                            <div class="button-box">
                                                <div class="login-toggle-btn d-flex justify-content-between">
                                                    <div>
                                                        <input name="remember" type="checkbox" {{ old('remember') ? 'checked' : ''}}>
                                                        <label> مرا بخاطر بسپار </label>
                                                    </div>
{{--                                                    <a href="{{ route('password.request') }}"> فراموشی رمز عبور ! </a> TODO - implement password request page --}}
                                                </div>
                                                <button type="submit">ورود</button>
                                                <a href="{{ route('auth.redirect', 'google') }}" class="btn btn-google btn-block mt-4">
                                                    <i class="fab fa-google"></i>
                                                    ورود با حساب گوگل
                                                </a>
                                                <div class="text-center">
                                                    <div class="mt-2">یا</div>
                                                    <a href="{{ route('register') }}" class="btn btn-google btn-block mt-2">
                                                        ثبت نام با ایمیل
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