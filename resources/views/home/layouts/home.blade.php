<!DOCTYPE html>
<html class="no-js" lang="fa">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title')</title>

    <!-- Custom styles for this template-->
    @vite('resources/scss/home/home.scss')

    @stack('style')

</head>

<body>
<div class="wrapper">

    {{-- Header --}}
    @include('home.sections.header')

    {{-- Mobile Off Canvas --}}
    @include('home.sections.mobile-off-canvas')

    {{-- Content --}}
    @yield('content')

    {{-- Footer --}}
    @include('home.sections.footer')

</div>

<!-- All JS is here
============================================ -->
<script src="{{ asset('/js/home/jquery-1.12.4.min.js') }}"></script>
<script src="{{ asset('/js/home/plugins.js') }}"></script>
@vite('resources/js/home/home.js')

{{--@include('sweet::alert')--}}

@yield('script')

</body>

</html>