@extends('base')

@section('content')
    <div class="container">
        <h2>@yield('title')</h2>
        Command output:
        <pre class="command-line">
            @section('command')

            @show
        </pre>
    </div>
@endsection
