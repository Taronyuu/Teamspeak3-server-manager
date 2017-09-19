@extends('layouts.app')

@section('content')
<div class="row">

    <div class="col-sm-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Active Servers <span class="badge badge-dark float-right">{{ $server_count }}</span></h4>
                <p class="card-text">
                    A list of servers that are synced will show here. You can use the
                    artisan command to re-sync if needed.
                </p>
                <a href="{{ route('servers.index') }}" class="btn btn-primary">View Servers</a>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Total Slots <span class="badge badge-dark float-right">{{ $slots_count }}</span></h4>
                <p class="card-text">
                    The total slots of all the servers is calculated here. If you've
                    changed the slots from the server itself, please re-sync.
                </p>
                <a href="{{ route('servers.index') }}" class="btn btn-primary">View Servers</a>
            </div>
        </div>
    </div>

</div>
@endsection
