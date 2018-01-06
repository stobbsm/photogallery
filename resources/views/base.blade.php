<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ ENV('APP_NAME') }} - @yield('title', 'Welcome')</title>
    @section('stylesheets')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
    @show
</head>
<body>
    
    <div class="container sticky-top">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="{{ url('/welcome') }}">{{ ENV('APP_NAME') }} <span class="badge badge-secondary">Beta</span></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#responsiveHidden" aria-controls="responsiveHidden" aria-expanded="false" aria-label="Toggle Navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="responsiveHidden">
                
                <ul class="navbar-nav mr-0 ml-auto">
                    @if (!Auth::check())
                    <li class="nav-item">
                        <a class="btn btn-outline-primary my-2 my-sm-0" href="{{ url('/login') }}">Login</a>
                    </li>
                    @else
                    @section('navbar')
                    
                    @show
                    <li class="nav-item">
                        <a class="btn btn-outline-primary my-2 my-sm-0" href="{{ url("/gallery") }}">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-primary my-2 my-sm-0" href="{{ url("/upload") }}">Upload Image</a>
                    </li>
                    @endif
                </ul>
                
            </div>
        </nav>
    </div>
    @section('content')
    
    @show
    
    @section('javascripts')
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
    @show
</body>
</html>
