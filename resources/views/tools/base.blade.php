@extends('base')

@section('content')
<div class="container">
    <div class="jumbotron">
        <h2>@yield('title')</h2>
    </div>
    <div class="border border-rounded">
        <p>Command output:</p>
        <hr class="my-2">
        <pre class="command-line">
            @section('command')
            
            @show
        </pre>
    </div>
</div>
@endsection
