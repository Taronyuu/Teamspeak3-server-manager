@extends('layouts.app')

@section('page_title', 'Edit server')

@section('content')
    {{ html()->modelForm($server, 'PUT', route('servers.update', $server))->attribute('role', 'form')->open() }}

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {{ html()->label('Server Name', 'name') }}
                    {{ html()->text('name')->class('form-control')->placeholder('Server Name')->required() }}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {{ html()->label('slots', 'Slots') }}
                    {{ html()->input('number', 'slots')->class('form-control')->placeholder('4')->attribute('steps', '1') }}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {{ html()->submit('Save')->class('btn btn-primary btn-block') }}
                </div>
            </div>
        </div>

    {{ html()->closeModelForm() }}
@endsection