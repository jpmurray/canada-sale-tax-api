<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/home') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Rates <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ route('rates.index', ['province' => 'all']) }}">Federal</a></li>
                                <li><a href="{{ route('rates.index', ['province' => 'ab']) }}">Alberta</a></li>
                                <li><a href="{{ route('rates.index', ['province' => 'bc']) }}">British-Columbia</a></li>
                                <li><a href="{{ route('rates.index', ['province' => 'mb']) }}">Manitoba</a></li>
                                <li><a href="{{ route('rates.index', ['province' => 'nb']) }}">New-Brunswick</a></li>
                                <li><a href="{{ route('rates.index', ['province' => 'nl']) }}">Newfoundland and Labrador</a></li>
                                <li><a href="{{ route('rates.index', ['province' => 'nt']) }}">Northwest Territories</a></li>
                                <li><a href="{{ route('rates.index', ['province' => 'nu']) }}">Nunavut</a></li>
                                <li><a href="{{ route('rates.index', ['province' => 'on']) }}">Ontario</a></li>
                                <li><a href="{{ route('rates.index', ['province' => 'pe']) }}">Prince Edward Island</a></li>
                                <li><a href="{{ route('rates.index', ['province' => 'qc']) }}">Quebec</a></li>
                                <li><a href="{{ route('rates.index', ['province' => 'sk']) }}">Saskatchewan</a></li>
                                <li><a href="{{ route('rates.index', ['province' => 'yt']) }}">Yukon</a></li>
                            </ul>
                        </li>
                    </ul>

                    <ul class="nav navbar-nav">
                        <li><a href="{{ route('rates.create') }}">Add a rate</a></li>
                    </ul>   

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
