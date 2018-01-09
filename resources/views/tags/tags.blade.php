@extends('tags.base')

@section('title', __("Tags"))

@section('tag_content')
<div class="jumbotron"
    <h1 class="display-4">Tag List</h2>
    <p class="lead">Click a tag to see the photos attached to it</p>
    <hr class="my-2">
    <p>Or click the button to view untagged or untitled files</p>
    <p class="lead">
        <a class="btn btn-primary btn-lg" href="{{ action('ImageController@notags') }}">Tag Files</a>
    </p>
</div>

<div class="row">
@foreach($tags as $tag)

    @if($loop->index % 5 == 0)
</div>
<div class="row">
    @endif
    <div class="col-2"><a href="{{ action('TagController@show', ['id' => $tag->id]) }}" class="badge badge-primary">{{ $tag->tag }}</a></div>
@endforeach
</div>
@endsection