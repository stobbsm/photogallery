@extends('base')

@section('content')
  <div class="container">
    <table class="table table-hover">
      <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email Address</th>
        <th>Created</th>
        <th>Last Modified</th>
      </tr>
      @foreach($users as $user)
        <tr>
          <td>{{ $user->id }}</td>
          <td>{{ $user->name }}</td>
          <td>{{ $user->email }}</td>
          <td>{{ $user->created_at }}</td>
          <td>{{ $user->updated_at }}</td>
          <td><a href="{{ action('UserController@edit', ['id' => $user->id]) }}"class="btn btn-primary">Edit</a></td>
        </tr>
      @endforeach
    </table>
  </div>
@endsection
