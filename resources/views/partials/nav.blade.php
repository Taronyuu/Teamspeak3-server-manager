<div class="navbar-header">
    <a class="navbar-brand" href="index.html">Teamspeak 3 server manager</a>
</div>
<div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav side-nav">
        <li @if(Request::is('/')) class="active" @endif>
            <a href="{{ action('DashboardController@index') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
        </li>
        <li @if(Request::is('servers')) class="active" @endif>
            <a href="{{ action('ServerController@index') }}"><i class="fa fa-fw fa-list"></i> Servers</a>
        </li>
        <li @if(Request::is('servers/create')) class="active" @endif>
            <a href="{{ action('ServerController@create') }}"><i class="fa fa-fw fa-plus"></i> Create server</a>
        </li>
    </ul>
</div>
