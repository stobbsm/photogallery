@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li><span class="sr-only">Error:</span>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif