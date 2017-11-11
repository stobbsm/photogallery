@extends('gallery.base')
@section('title', $image->filename)

@section('image')

    <div class="img-frame">
        <img src="/image/{{ $image->id }}" alt="{{ $image->filename }}">
    </div>

@endsection
