@extends('gallery.base')

@section('title', __('gallery.title_all_images'))

@section('styles')
    @parent

@endsection

@section('image')
  <div class="row align-items-center mt-1">
  @foreach($media as $file)
    {{--@if ($loop->index % 3 == 0 && !$loop->first)
        </div>
        <div class="row align-items-center mt-1">
    @endif--}}
    <div class="col align-self-center">
        <div class="card" style="width: 20rem;">
            <img class="card-img-top" src="{{ route('image.thumbnail', ['id' => $file->id]) }}" alt="{{ $file->filename }}">
            <div class="card-body">
                <h4 class="card-title">{{ $file->filename }}</h4>
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
