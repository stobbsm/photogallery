@extends('gallery.base')

@section('title', __('gallery.title_all_images'))

@section('image')
<div class="row align-items-center mt-1">
    @foreach($media as $file)
    @include('components.image', ['file' => $file])
    @endforeach
</div>

@endsection
