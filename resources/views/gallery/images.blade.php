@extends('gallery.base')

@section('title', __('gallery.title_all_images'))

@section('image')
{{ $media->links('components.paginate') }}
<div class="row align-items-center mt-1">
    @foreach($media as $file)
    @include('components.image', ['file' => $file])
    @endforeach
</div>

@endsection
