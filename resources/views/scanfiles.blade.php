<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>PhotoGallery - @lang('cmdline.verifying')</title>
</head>
<body>
  <h2>@lang('cmdline.verifying')</h2>
  <pre>
    @php
      Artisan::call('photogallery:scan');
    @endphp
  </pre>
</body>
</html>
