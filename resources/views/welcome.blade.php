@extends('base')

@section('content')
<div class="container">
    <div class="jumbotron">
        <h1>Welcome, to the Photogallery!</h1>
        <p class="lead">Welcome to your personal Photogallery! Use this platform to share your private images safely, knowing that only the people you share it with can see it!</p>
        <hr class="my=4">
        <p>Click the button below, and get started on your photo privacy adventure!</p>
        <p class="lead">
            <a class="btn btn-primary btn-lg" href="{{ url('/register') }}" role="button">Register</a>
        </p>
    </div>
</div>
@endsection
