@extends('layouts.app')

@section('page_title', 'Server summary')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Ip</th>
                                <th>Slots</th>
                                <th>Created</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($servers as $server)
                                <tr>
                                    <td>{{ $server->name }}</td>
                                    <td>{{ $server->ip }}:{{ $server->port }}</td>
                                    <td>{{ $server->slots }}</td>
                                    <td>{{ $server->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <a href="{{ route('servers.show', $server) }}" class="btn btn-primary">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="text-center">
                    {{ $servers->links() }}
                </div>

                @if(! $servers->count())
                    <div class="alert alert-info">
                        You don't have any servers yet. Click <a href="{{ action('ServerController@create') }}">here</a> to
                        create one.
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
