@extends('gallery.base')

@section('title', __('gallery.upload'))

@section('image')
<div class="border border-primary rounded">
    {!! Form::open(['action' => 'ImageController@store', 'files' => true, 'class' => 'd-flex p-2 flex-row justify-content-center']) !!}
    
    <div>
        {!! Form::label('image', "Please select an image to upload. Maximum size is $maxsize", ['class' => 'p-2 d-flex-inline']) !!}
        {!! Form::file('image', ['class' => 'form-control-file p-2 d-flex-inline']) !!}
    </div>
    {!! Form::submit("Upload") !!}
    {!! Form::close() !!}
</div>
@endsection
