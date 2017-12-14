@extends('gallery.base')
@section('title', $image->filename)

@section('image')

    <div class="row">
        <div class="col mx-auto d-block">
            <img class="img-fluid" src="/image/{{ $image->id }}" alt="{{ $image->filename }}">
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
            <a class="btn btn-primary" href="/image/{{ $image->id }}/download">Download</a>
        </div>
    </div>

@endsection
