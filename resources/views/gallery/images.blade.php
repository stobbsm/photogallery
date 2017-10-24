@extends('gallery.show')

@section('images')
  <!-- Display all the images -->
  @foreach($media as $file)
    <!-- Fullpath: {{ $file->fullpath }} -->
    <!-- Size: {{ $file->size }} -->
    <!-- Mimetype: {{ $file->mimetype }} -->
    <img src="/image/thumbnail/{{ $file->id }}">
  @endforeach

@endsection
