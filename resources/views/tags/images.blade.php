@extends('tags.base')

@section('title', __('tags.images', ['tagname' => $tagname]))

@section('tag_content')
{{ $files->links('components.paginate') }}
<div class="row align-items-center mt-1">
    @foreach($files as $file)
    @include('components.image', ['file' => $file])
    
    @endforeach
</div>


@endsection