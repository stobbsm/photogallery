<div class="col align-self-center">
    <div class="card" style="width: 20rem;">
        <a href="{{ route('album.show', ['id' => $album->id]) }}">
            <img class="card-img-top" src="{{ route('album.thumbnail') }}" alt="{{ $album->name }}">
        </a>
        <div class="card-body">
            <h4 class="card-title">{{ $album->name }}</h4>
            <p class="card-text">{{ $album->desc }}</p>
            <a class="btn btn-primary" href="{{ route('album.show', ['id' => $album->id]) }}">{{ $album->name }}</a>
        </div>
    </div>
</div>