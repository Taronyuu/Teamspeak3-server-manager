@extends('layouts.app')

@section('page_title', 'Create server')

@section('content')
    {{ html()->form('POST', route('servers.store'))->attribute('role', 'form')->open() }}

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {{ html()->label('Server Name', 'name') }}
                    {{ html()->text('name')->class('form-control')->placeholder('Server name...')->required() }}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {{ html()->label('Slots', 'slots') }}
                    {{ html()->input('number', 'slots')->class('form-control')->placeholder('4')->attribute('min', '1')->attribute('max', '9999')->attribute('steps', '1') }}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {{ html()->button('Save', 'submit')->class('btn btn-primary btn-block') }}
                </div>
            </div>
        </div>

    {{ html()->form()->close() }}
@endsection