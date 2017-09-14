@extends('layouts.app')

@section('page_title', 'Token summary')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Token</th>
                            <th>Date</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($server->tokens as $token)
                            <tr>
                                <td>{{ $token->token }}</td>
                                <td>{{ $token->created_at->format('Y-m-d H:i:s') }}</td>
                                <td><a href="{{ route('servers.delete_token', [$server, $token]) }}" class="btn btn-sm btn-danger">Delete</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if(! $server->tokens->count())
                <div class="alert alert-info">
                    You don't have any tokens.
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
		$('#flash-overlay-modal').modal();
    </script>
@endpush