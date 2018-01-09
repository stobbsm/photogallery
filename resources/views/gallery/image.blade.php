@extends('gallery.base')
@if(isset($image->fileinfo))
    @section('title', $image->fileinfo->title)
@endif

@section('image')
<div class="row">
    <div class="col mx-auto d-block">
        <img class="img-fluid" src="{{ route('image.fetch', ['id' => $image->id]) }}" alt="{{ $image->filename }}">
    </div>
    <div class="col-md-3 border border-primary rounded">
        <h4>{{ $image->fileinfo->title }}</h4>
        <p>{{ $image->fileinfo->desc }}</p>
        <p>Tags</p>
        <div class="border rounded p-2 my-2">
            @foreach ($image->tags as $tag)
            <p class="badge badge-pill badge-primary">{{ $tag->tag }}</p>
            @endforeach
        </div>
        <a class="btn btn-primary my-1" href="{{ route('image.edit', ['id' => $image->id]) }}">Edit Metadata</a>
        <a class="btn btn-primary my-1" href="{{ route('image.download', ['id' => $image->id]) }}">Download</a>
        <a class="btn btn-danger my-1" href="{{ action('ImageController@destroy', ['id' => $image->id]) }}">Delete</a>
    </div>
</div>

@endsection
