@extends('gallery.base')

@section('title', __('gallery.title_all_images'))

@section('styles')
    @parent

@endsection

@section('image')
  <div class="flex-center">
  @foreach($media as $file)
    <img src="/image/thumbnail/{{ $file->id }}" alt="{{ $file->filename }}">
  @endforeach
  </div>

@endsection
