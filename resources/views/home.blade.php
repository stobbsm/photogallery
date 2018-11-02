@extends('base')

@section('content')
<div class="container">
    <div class="card mx-auto">
        <h4 class="card-header">Dashboard</h4>
        
        <div class="card-body">
            @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif
            <div class="row">
                <div class="col-md-6">
                    <h5 class="card-title">User Information</h5>
                    <ul class="list-group">
                        <li class="list-group-item card-text">
                            Files added by you: {{ $userfiles }}
                        </li>
                        <li class="list-group-item card-text">
                            Encryption Key: {{ $key }}
                        </li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h5 class="card-title">File Statistics</h5>
                    <ul class="list-group">
                        <li class="list-group-item card-text">
                            Number of files indexed: {{ $files }}
                        </li>
                        <li class="list-group-item card-text">
                            Number of tags: {{ $tags }}
                        </li>
                        <li class="list-group-item card-text">
                            Number of files not tagged: {{ $untagged }}
                        </li>
                        <li class="list-group-item card-text">
                            Number of files without a title: {{ $untitled }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
