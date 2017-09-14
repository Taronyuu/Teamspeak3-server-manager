@extends('layouts.app')

@section('page_title', 'Configure server')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    {{ html()->form('POST', route('servers.configure', $server))->open() }}

                        @foreach($serverData as $key => $line)
                            <div class="form-group">
                                {{ html()->label(ucwords(str_replace('_', ' ', $key)), $key) }}
                                {{ html()->text($key, $line)->class('form-control') }}
                            </div>
                        @endforeach

                        <div class="form-group">
                            {{ html()->submit('Update!')->class('btn btn-success btn-block') }}
                        </div>

                    {{ html()->form()->close() }}
                </div>
            </div>
        </div>
    </div>
@endsection