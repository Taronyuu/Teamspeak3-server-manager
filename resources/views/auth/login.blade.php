@extends('app')

@section('page_title', 'Login')

@section('content')
    {!! Form::open(['action' => 'Auth\AuthController@postLogin', 'method' => 'post', 'role' => 'form']) !!}
    <div class="row">
        @include('partials.messages')
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('email', 'Email') !!}
                {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Your email...', 'required' => 'true']) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('password', 'Password') !!}
                {!! Form::password('password', ['class' => 'form-control', 'required' => 'true']) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::submit('Create', ['class' => 'btn btn-primary', 'style' => 'width: 100%']) !!}
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection