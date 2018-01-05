@extends('gallery.base')

@section('title', __('gallery.title_all_images'))

@section('styles')
    @parent

@endsection

@section('image')
  <div class="row align-items-center mt-1">
  @foreach($media as $file)
    <div class="col align-self-center">
        <div class="card" style="width: 20rem;">
            <a href="{{ route('image.show', ['id' => $file->id]) }}"><img class="card-img-top" src="{{ route('image.thumbnail', ['id' => $file->id]) }}" alt="{{ $file->filename }}"></a>
            <div class="card-body">
                <h4 class="card-title">{{ $file->fileinfo->title }}</h4>
                <p class="card-text">{{ $file->fullpath }}</p>
                <p class="card-text">
                @foreach($file->tags as $tag)
                    @if (!$loop->first)
                        ,
                    @endif
                    {{ $tag }}
                @endforeach
                </p>
                <a class="btn btn-primary" href="{{ route('image.show', ['id' => $file->id]) }}">{{ $file->filename }}</a>
            </div>
        </div>
    </div>
  @endforeach
  </div>

@endsection
