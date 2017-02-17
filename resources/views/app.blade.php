<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.header')
</head>
<body>
<div id="wrapper">
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        @include('partials.nav')
    </nav>

    <div id="page-wrapper">
        <div class="container-fluid">

            @include('partials.page_header')

            @yield('content')

        </div>
    </div>
</div>

@include('partials.footer')

@yield('javascript')

</body>
</html>
