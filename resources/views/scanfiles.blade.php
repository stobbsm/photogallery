<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>PhotoGallery - @lang('scanfiles.verifying')</title>
</head>
<body>
  <h2>@lang('scanfiles.verifying')</h2>
  <div>
    @php
      Artisan::call('photogallery:scan');
    @endphp
  </div>
</body>
</html>
