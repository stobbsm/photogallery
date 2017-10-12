@extends('gallery.show')

@section('images')
    <!-- Display all the images -->
    @foreach($media as $file)
        <p>{{ $file->fullpath }}</p>
    @endforeach
@endsection