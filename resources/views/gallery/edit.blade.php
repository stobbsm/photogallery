@extends('gallery.base')

@section('title', __('gallery.edit'))

@section('image')
<div class="row">
    <div class="col mx-auto d-block">
        <img class="img-fluid" src="{{ route('image.fetch', ['id' => $image->id]) }}" alt="{{ $image->filename }}">
    </div>
    <div class="col-md-4 border border-secondary rounded p-2">
        {!! Form::open(['url' => action('ImageController@update', ['id' => $image->id]), 'method' => 'put']) !!}
        
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Title</span>
            </div>
            {!! Form::text('title', null, ['class' => "form-control", 'placeholder' => $image->fileinfo->title]) !!}
        </div>
        
        <div class="form-group">
            {!! Form::label('desc', "Description") !!}
            {!! Form::textarea('desc', null, ['class' => "form-control", 'placeholder' => $image->fileinfo->desc]) !!}
        </div>
        
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="tags">Tags</span>
            </div>
            {!! Form::text('tags', implode(', ', $tags), ['class' => "form-control", 'placeholder' => "Seperate tags with a comma"]) !!}
        </div>
        {!! Form::submit("Update Metadata", ['class' => "btn btn-primary"]) !!}
        <a class="btn btn-primary" href="{{ action('ImageController@show', ['id' => $image->id]) }}">Cancel</a>
        {!! Form::close() !!}
    </div>
</div>
@endsection
