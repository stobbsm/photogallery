@extends('tags.base')

@section('title', __("Tags"))

@section('tag_content')
<div class="card mx-auto w-50">
    <h4 class="card-header">Tag List</h4>
    <div class="card-body">
        <div class="row">
            <h6 class="card-title">Click a tag to see the photos attached to it</h6>
        </div>
        <div class="row">
        @foreach($tags as $tag)
            <div class="col-md-auto">
                <a href="{{ action('TagController@show', ['id' => $tag->id]) }}" class="badge badge-primary">
                    {{ $tag->tag }}
                </a>
            </div>
        @endforeach
        </div>
    </div>
</div>

@endsection