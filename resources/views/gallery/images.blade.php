@extends('gallery.base')

@section('title', __('gallery.title_all_images'))

@section('image')
<div class="container">
    @if(method_exists($media, 'links'))
    {{ $media->links('components.paginate') }}
    @endif
    @if($media->isEmpty())
    <div class="row d-flex justify-content-center">
        <p class="text-light w-75 border rounded text-center p-2 bg-secondary">No Images available</p>
    </div>
    @else
    <div class="row align-items-center mt-1">
        @foreach($media as $file)
            @include('components.image', ['file' => $file])
        @endforeach
    </div>
    @endif
</div>
@endsection
