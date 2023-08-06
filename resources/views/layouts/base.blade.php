<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
   
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css"> <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    {{-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> --}}
    <link href="css/style.css" rel="stylesheet">
    <!-- Scripts -->
    {{-- @vite('resources/css/bootstrap.min.css') --}}
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}
    
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-dark bg-success sticky-top">
            <div class="container-fluid">
                <a class="navbar-brand text ps-4 fw-bold" href="/">Navbar</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                   
                    <ul class="navbar-nav ms-auto mb-2 me-5 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="/">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('postAd')}}"> <button class="btn btn-warning fw-bold rounded-pill text-dark btn-sm">Post Ad</button></a>
                        </li>
                        
                        @if (Route::has('login'))
                            @auth
                                @if (Auth::user()->user_type === 'ADM')

                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Dashboard
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="{{route('over-view')}}">Overview</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="{{route('my-ads')}}">My Ads</a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                        <li><a class="dropdown-item" href="{{route('admin.all-ads')}}">All Ads</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="{{route('admin.lodge')}}">Lodge</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="{{route('admin.location')}}">Location</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="{{route('admin.school')}}">School</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="{{route('admin.school-area')}}">School Area</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="{{route('draft')}}">Draft</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="{{route('bookmarks')}}"><i class="bi bi-bookmark"></i> Saved</a></li>
                        
                                    </ul>
                                </li>
        
                                    <li class="nav-item dropdown">
                                        <a id="navbarDropdowni" class="nav-link dropdown-toggle" href="#"
                                            role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false" v-pre>
                                            User({{explode(' ', trim( Auth::user()->name) )[0]}})
                                        </a>

                                        {{-- <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown"> --}}
                                        <ul class="dropdown-menu" aria-labelledby="navbarDropdowni">
                                            <a class="dropdown-item" href="{{route('profile.edit')}}">Profile</a>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                class="d-none">
                                                @csrf
                                            </form>
                                        </ul>
                                        {{-- </div> --}}
                                    </li>
                                @else
                                    <li class="nav-item my-auto">
                                        <a class="nav-link" href="#"><i class="bi bi-bell-fill" style="font-size: 15px; color:yellow"><sub>4</sub></i></a>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownii" role="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            Dashboard
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownii">
                                            
                                            <li><a class="dropdown-item" href="{{route('my-ads')}}">My Ads</a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item" href="{{route('draft')}}">Draft</a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item" href="{{route('bookmarks')}}"><i class="bi bi-bookmark"></i> Saved</a></li>
                            
                                        </ul>
                                    </li>
                                    
                                    <li class="nav-item dropdown">
                                        <a id="navbarDropdowniii" class="nav-link dropdown-toggle" href="#"
                                            role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false" v-pre>
                                            User({{explode(' ', trim( Auth::user()->name) )[0]}})
                                        </a>

                                        {{-- <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown"> --}}
                                        <ul class="dropdown-menu" aria-labelledby="navbarDropdowniii">
                                            <a class="dropdown-item" href="{{route('profile.edit')}}">Profile</a>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                class="d-none">
                                                @csrf
                                            </form>
                                        </ul>
                                        {{-- </div> --}}
                                    </li>
                                @endif
                            @else
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>

                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif
                            @endauth

                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>
   
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.js"></script>

    {{-- @vite('resources/js/slugify.js') --}}
    {{-- @vite('resources/js/bootstrap.min.js') --}}
    
    
    
</body>

</html>
