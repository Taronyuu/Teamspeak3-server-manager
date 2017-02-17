@extends('app')

@section('page_title', "Dashboard")

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('partials.messages')
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-comments fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{ $server_count }}</div>
                            <div>Active servers</div>
                        </div>
                    </div>
                </div>
                <a href="{{ action('ServerController@index') }}">
                    <div class="panel-footer">
                        <span class="pull-left">View</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection