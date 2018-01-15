@extends('base')

@section('content')
<div class="container">
    <div class="card mx-auto">
        <h4 class="card-header">Editing {{ $user->name }}</h4>

        <div class="card-body">
            {!! Form::open(['action' => ['UserController@update', $user->id], 'method' => 'put']) !!}
                <div class="row">
                    <div class="form-group col-md-6">
                        {!! Form::label('name', 'Your name') !!}
                        {!! Form::text('name', $user->name,  ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-md-6">
                        {!! Form::label('email', 'Email address') !!}
                        {!! Form::email('email', $user->email, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        {!! Form::label('password', 'Password') !!}
                        {!! Form::password('password', ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-md-6">
                        {!! Form::label('password_confirmation', 'Confirm Password') !!}
                        {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                    </div>
                </div>
            {!! Form::submit('Submit') !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection