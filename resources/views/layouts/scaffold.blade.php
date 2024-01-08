<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }} | @stack('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('assets/img/526abf16cc3e74882fa7304abc0f841c.png') }}" type="image/x-icon">
    @include('partial.style')
    @stack('styles')
</head>
<body id="Body">
    @include('partial.header')
    @yield('content')
    @include('partial.script')
    @stack('scripts')
</body>
</html>
