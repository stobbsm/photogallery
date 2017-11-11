<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ ENV('APP_NAME') }}</title>

        @section('styles')
            <link rel="stylesheet" href="css/app.css" type="text/css">
        @show
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @if (Auth::check())
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ url('/login') }}">Login</a>
                        <a href="{{ url('/register') }}">Register</a>
                    @endif
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Photogallery
                </div>


            </div>

        </div>
        <div class="footer">
            <div class="links">
                <a href="https://laravel.com">Made with Laravel</a>
                <a href="https://github.com/stobbsm/photogallery">GitHub</a>
                <a href="https://www.sproutingcommunications.com">Sponsored by Sprouting Communications</a>
            </div>
        </div>
    </body>
</html>
