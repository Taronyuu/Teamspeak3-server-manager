@extends('layouts.app')

@section('title', $server->name)

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <td>Name:</td>
                                    <td>{{ $server->name }}</td>
                                </tr>
                                <tr>
                                    <td>Host: </td>
                                    <td>{{ $server->ip }}:{{ $server->port }}</td>
                                </tr>
                                <tr>
                                    <td>Slots:</td>
                                    <td>{{ $clientCount }}/{{ $server->slots }}</td>
                                </tr>
                                <tr>
                                    <td>Status:</td>
                                    <td>
                                        @if($server->status)
                                            <span class="badge badge-success">Online</span>
                                        @else
                                            <span class="badge badge-danger">Offline</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    {!! $viewer !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card mt-3">
                <div class="card-body">
                    <h4 class="card-title">Server Actions</h4>

                    <table class="table table-responsive">
                        <tbody>
                            @if($server->status)
                                <tr>
                                    <td><a href="{{ route('servers.restart', $server) }}" class="btn btn-warning btn-block"><i class="fa fa-repeat"></i> Restart</a></td>
                                </tr>
                                <tr>
                                    <td><a href="{{ route('servers.stop', $server) }}" class="btn btn-danger btn-block"><i class="fa fa-ban"></i> Stop</a></td>
                                </tr>
                            @else
                                <tr>
                                    <td><a href="{{ route('servers.start', $server) }}" class="btn btn-success btn-block"><i class="fa fa-play"></i> Start</a></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <h4 class="card-title">Server Configuration</h4>

                    <table class="table table-responsive">
                        <tbody>
                            <tr>
                                <td><a href="{{ route('servers.edit', $server) }}" class="btn btn-primary btn-block"><i class="fa fa-pencil"></i> Edit server</a></td>
                            </tr>
                            <tr>
                                <td><a href="{{ route('servers.reset_token', $server) }}" class="btn btn-primary btn-block"><i class="fa fa-plus"></i> Create token</a></td>
                            </tr>
                            <tr>
                                <td><a href="{{ route('servers.show_tokens', $server) }}" class="btn btn-primary btn-block"><i class="fa fa-list"></i> Token summary</a></td>
                            </tr>
                            <tr>
                                <td><a href="{{ route('servers.configure', $server) }}" class="btn btn-primary btn-block"><i class="fa fa-cog"></i> Configure server</a></td>
                            </tr>
                            <tr>
                                <td>
                                    {{ html()->form('DELETE', route('servers.destroy', $server))->open() }}
                                        <button type="button" class="btn btn-danger btn-block" onclick="deleteEntity(this, '{{ addslashes($server->name) }}')">
                                            <i class="fa fa-trash"></i> Delete server
                                        </button>
                                    {{ html()->form()->close() }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
		function deleteEntity(element, subject) {
			var r = confirm("Are you sure you want to delete the server " + subject + "?");

			if (r == true) {
				$(element).closest('form').submit();
			}

			return;
		}
    </script>
@endpush
