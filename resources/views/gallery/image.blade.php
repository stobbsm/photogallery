@extends('gallery.base')
@section('title', $image->filename)

@section('image')

    <div class="row align-items-center">
        <div class="col-10 mx-auto d-block">
            <img class="img-fluid" src="/image/{{ $image->id }}" alt="{{ $image->filename }}">
        </div>
        <div class="col-2">
            <p>Image information</p>
        </div>
    </div>

@endsection
