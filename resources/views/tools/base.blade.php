<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>PhotoGallery - @yield('title')</title>
  @section('styles')
      <link rel="stylesheet" href="/css/app.css" type="text/css">
  @show
</head>
<body>
  <h2>@yield('title')</h2>
  Command output:
  <pre class="command-line">
    @section('command')

    @show
  </pre>
</body>
</html>
