@extends('gallery.base')

@section('title', __('gallery.edit'))

@section('image')
  <div class="row">
    <div class="col mx-auto d-block">
        <img class="img-fluid" src="{{ route('image.fetch', ['id' => $image->id]) }}" alt="{{ $image->filename }}">
    </div>
    <div class="col-md-4 border border-secondary rounded p-2">
      {!! Form::model(['action' => ['ImageController@update', $image->id ]]) !!}

        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">Title</span>
          </div>
          {!! Form::text('title', $image->fileinfo->title, ['class' => "form-control"]) !!}
        </div>

        <div class="form-group">
          {!! Form::label('desc', "Description") !!}
          {!! Form::textarea('desc', $image->fileinfo->desc, ['class' => "form-control"]) !!}
        </div>

        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="tags">Tags</span>
          </div>
          {!! Form::text('tags', null, ['class' => "form-control", 'placeholder' => "Seperate tags with a comma"]) !!}
        </div>

        <div class="d-flex justify-content-around border rounded p-2">
          @foreach ($image->tags as $tag)
              <p class="badge badge-pill badge-primary">{{ $tag }}</p>
          @endforeach
        </div>
        {!! Form::submit("Update Metadata", ['class' => "btn btn-primary"]) !!}
      {!! Form::close() !!}
    </div>
  </div>
@endsection
