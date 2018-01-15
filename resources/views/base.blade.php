<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') }} - @yield('title', 'Welcome')</title>
    @section('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @show
</head>
<body>
    @include('components.nav')
    
    @section('content')
    
    @show
    
    @include('components.footer')
    @section('javascripts')
    <script src="{{ asset('js/app.js') }}"></script>
    @show
</body>
</html>
