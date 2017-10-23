@extends('gallery.show')

@section('images')
  <!-- Display all the images -->
  @foreach($media as $file)
    @php
      $file_contents = file_get_contents($file->fullpath);
      $base64_img_contents = base64_encode($file_contents);
    @endphp
    <!-- {{ $file->fullpath }} -->
    <img width="50px" height="50px" src="/image/{{ $file->id }}">
  @endforeach

@endsection
