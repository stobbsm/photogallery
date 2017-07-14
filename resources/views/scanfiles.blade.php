<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Verifying files in database</title>
</head>
<body>
  <h2>Verifying files in database</h2>
  <div>
    @php
      Artisan::call('photogallery:scan');
    @endphp
  </div>
</body>
</html>
