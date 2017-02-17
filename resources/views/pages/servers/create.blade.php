@extends('app')

@section('page_title', 'Create server')

@section('content')
    {!! Form::open(['action' => 'ServerController@store', 'method' => 'post', 'role' => 'form']) !!}
    <div class="row">
        @include('partials.messages')
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('name', 'Server name') !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Server name...', 'required' => 'true']) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('slots', 'Slots') !!}
                {!! Form::number('slots', null, ['class' => 'form-control', 'placeholder' => 4, 'steps' => 1]) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::submit('Save', ['class' => 'btn btn-primary', 'style' => 'width: 100%']) !!}
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection