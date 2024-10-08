<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'MyHobbies')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                MyHobbies
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        @auth
                            <a class="nav-link {{ Request::is('home') ? 'active' : '' }}" href="/home">Home</a>
                        @endauth
                        @guest
                            <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="/">Startseite</a>
                        @endguest
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('hobby*') ? 'active' : '' }}" href="/hobby">Hobbies</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('tags*') ? 'active' : '' }}" href="/tags">Tags</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('info') ? 'active' : '' }}" href="/info">Information</a>
                    </li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <a class="dropdown-item" href="/user/{{auth()->user()->id}}" onclick="event.preventDefault();
                                   document.getElementById('Profile').submit();">
                                    {{ __('Profile') }}
                                </a>

                                <form id="Profile" action="/user/{{auth()->user()->id}}"></form>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @isset($meldg_success)
            <div class="container">
                <div class="alert alert-success">
                    {!! $meldg_success !!}
                </div>
            </div>
        @endisset
        @isset($meldg_hinweis)
            <div class="container">
                <div class="alert alert-warning">
                    {!! $meldg_hinweis !!}
                </div>
            </div>
        @endisset

        @if($errors->any())
            <div class="container">
                <div class="alert alert-danger">
                    Bitte überprüfe Deine Eingaben.
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{!! $error !!}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        @yield('content')
    </main>
</div>
</body>
</html>
