@extends('base')

@section('content')
<div class="container">
    <table class="table table-hover">
        <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Username</th>
                <th scope="col">Email Address</th>
                <th scope="col">Created</th>
                <th scope="col">Last Modified</th>
                <th scope="col"><a class="btn btn-sm btn-primary" href="{{ action('UserController@create') }}">New</a></th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                @if($user->id === Auth::user()->id)
                <tr class="table-active">
                @else
                <tr>
                @endif
                    <th scope="row">{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td>{{ $user->updated_at }}</td>
                    <td><a href="{{ action('UserController@edit', ['id' => $user->id]) }}"class="btn btn-primary">Edit</a></td>
                </tr>
            @endforeach

        </tbody>
    </table>
</div>
@endsection
