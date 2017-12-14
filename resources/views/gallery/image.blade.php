@extends('gallery.base')
@section('title', $image->filename)

@section('image')
    <!--
      @php
        print_r($image);
      @endphp
    -->
    <div class="row">
        <div class="col mx-auto d-block">
            <img class="img-fluid" src="{{ route('image.fetch', ['id' => $image->id]) }}" alt="{{ $image->filename }}">
        </div>
        <div class="col">
            <h4>{{ $image->fileinfo->title }}</h4>
            <p>{{ $image->fileinfo->desc }}</p>
            <ul>Tags:
            @forelse ($image->tags as $tag)
                <li>{{ $tag }}</li>
            @empty
                <p>No Tags</p>
            @endforelse
            </ul>
            <a class="btn btn-primary" href="{{ route('image.download', ['id' => $image->id]) }}">Download</a>
        </div>
    </div>

@endsection
