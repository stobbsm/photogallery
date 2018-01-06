<div class="col align-self-center">
    <div class="card" style="width: 20rem;">
        <a href="{{ route('image.show', ['id' => $file->id]) }}"><img class="card-img-top" src="{{ route('image.thumbnail', ['id' => $file->id]) }}" alt="{{ $file->fileinfo->title }}"></a>
        <div class="card-body">
            <h4 class="card-title">{{ $file->fileinfo->title }}</h4>
            <p class="card-text">{{ $file->desc }}</p>
            <p class="card-text">
                @foreach($file->tags as $tag)
                @if (!$loop->first)
                ,
                @endif
                {{ $tag->tag }}
                @endforeach
            </p>
            <a class="btn btn-primary" href="{{ route('image.show', ['id' => $file->id]) }}">{{ $file->fileinfo->title }}</a>
        </div>
    </div>
</div>