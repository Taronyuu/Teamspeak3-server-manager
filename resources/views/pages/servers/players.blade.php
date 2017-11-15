@extends('layouts.app')

@section('title', 'View server players')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('servers.show', $server) }}" class="btn btn-primary btn-block">
                        Back to server
                    </a>
                    
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($players as $player)
                                @if(str_contains($player->client_nickname, 'serveradmin'))
                                    @continue
                                @endif

                                <tr>
                                    <td>{{ $player->client_nickname }}</td>
                                    <td>
                                        <form method="post" action="{{ route('servers.players.message', [$server, $player->clid]) }}">
                                            {{ csrf_field() }}
                                            <div class="input-group">
                                                <input type="text" name="message" class="form-control" placeholder="Send message">
                                                <span class="input-group-btn">
                                            <button class="btn btn-primary" type="button">Send</button>
                                          </span>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
