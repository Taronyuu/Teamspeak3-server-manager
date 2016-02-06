@extends('app')

@section('page_title', 'Token summary')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('partials.messages')
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
                    @foreach($tokens as $token)
                        <tr>
                            <td>{{ $token->token }}</td>
                            <td>{{ $token->created_at->format('Y-m-d H:i:s') }}</td>
                            <td><a href="{{ action('ServerController@deleteToken', [$server, $token]) }}" class="btn btn-xs btn-danger">Delete</a></td>                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @if(!$tokens->count())
                <div class="alert alert-info">
                    You don't have any tokens.
                </div>
            @endif
        </div>
    </div>
@endsection