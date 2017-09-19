<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TeamSpeak 3 Server Manager') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha256-NuCn4IvuZXdBaFKJOAcsU2Q3ZpwbdFisd5dux4jkQ5w=" crossorigin="anonymous" />
    {{--<link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-dark justify-content-between mb-5" style="background-color: #466778;">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('teamspeak.png') }}" height="30" class="d-inline-block align-top" alt="TeamSpeak Logo">
                {{ config('app.name', 'TeamSpeak 3 Server Manager') }}
            </a>

            @auth
                <div>
                    <span class="navbar-text my-2 my-sm-0 mr-3">{{ auth()->user()->email }}</span>
                    <a href="{{ route('logout') }}" class="btn btn-primary my-2 my-sm-0" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                </div>
            @else
                <div>
                    <a href="{{ route('register') }}" class="btn btn-primary my-2 my-sm-0">Register</a>
                </div>
            @endauth
        </nav>

        <div class="container-fluid">
            @include('flash::message')

            <div class="row">
                <div class="col-12 col-md-3 col-lg-3">
                    <nav class="nav nav-pills flex-column">
                        <a class="flex-sm-fill nav-link{{ (Request::route()->getName() == 'index' ? ' active' : '') }}" href="{{ url('/') }}">
                            <i class="fa fa-dashboard fa-fw"></i> Dashboard
                        </a>
                        <a class="flex-sm-fill nav-link{{ (Request::segment(1) == 'servers' && Request::route()->getName() != 'servers.create' ? ' active' : '') }}" href="{{ route('servers.index') }}">
                            <i class="fa fa-server fa-fw"></i> Servers
                        </a>
                        <a class="flex-sm-fill nav-link{{ (Request::route()->getName() == 'servers.create' ? ' active' : '') }}" href="{{ route('servers.create') }}">
                            <i class="fa fa-plus-square fa-fw"></i> Create Server
                        </a>
                    </nav>
                </div>

                <div class="col-12 col-md-9 col-lg-9">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    {{--<script src="{{ asset('js/app.js') }}"></script>--}}

    @stack('scripts')
</body>
</html>
