<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="icon" href="{{ asset('title-logo.jpg') }}" type="image/jpg" sizes="32X32">
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
  
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" /> {{-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> --}}
    <link href="css/style.css" rel="stylesheet">
    <!-- Scripts -->
    {{-- @vite('resources/css/bootstrap.min.css') --}}
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}
    <style>
        footer {
            padding: 10px;
            text-align: center;
            position: absolute;
            right: 0;
            left: 0;
            bottom: 0;
        }

        html {
            height: 100%;
            box-sizing: border-box;
        }

        body {
            position: relative;
            min-height: 100%;
            padding-bottom: 6rem;
            box-sizing: inherit;
        }

        #bottom-navbar {
            display: none;
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 50px;
            background-color: #ffffff;

        }

        .notification-badge {
            position: relative;
        }

        .badge-number {
            position: absolute;
            /* top: 50%; */
            left: 60%;
            top: 10%;
            transform: translate(-50%, -50%);
            padding: 1px 4px;
            background-color: red;
            border-radius: 50%;
            color: white;
            font-size: 8px;
        }

        .dropup .dropdown-toggle::after {
            content: none !important;
        }

        .navbar-toggler {
            width: 20px;
            height: 20px;
            position: relative;
            transition: .5s ease-in-out;
        }

        .navbar-toggler,
        .navbar-toggler:focus,
        .navbar-toggler:active,
        .navbar-toggler-icon:focus {
            outline: none;
            box-shadow: none;
            border: 0;
        }

        .navbar-toggler span {
            margin: 0;
            padding: 0;
        }

        .toggler-icon {
            display: block;
            position: absolute;
            height: 3px;
            width: 100%;
            background: rgb(179, 175, 175);
            border-radius: 1px;
            opacity: 1;
            left: 0;
            transform: rotate(0deg);
            transition: .25s ease-in-out;
        }

        .middle-bar {
            margin-top: 0;
        }
/* when navigation is clicked */
        .navbar-toggler .top-bar {
            margin-top: 0px;
            transform: rotate(135deg);
        }

        .navbar-toggler .middle-bar {
            opacity: 0;
            filter: alpha(opacity=0);
        }

        .navbar-toggler .bottom-bar {
            margin-top: 0px;
            transform: rotate(-135deg);
        }

        /* state when the nav bar is collapsed */

        .navbar-toggler.collapsed .top-bar {
            margin-top: -20px;
            transform: rotate(0deg);
        }

        .navbar-toggler.collapsed .middle-bar {
            opacity: 1;
            filter: alpha(opacity=100);
        }

        .navbar-toggler.collapsed .bottom-bar {
            margin-top: 20px;
            transform: rotate(0deg);
        }

        .icon a.active {
        padding-top: 8px;
        border-top: 2px solid green; 
    }
    </style>

</head>

<body style="overflow-x: hidden">
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-dark bg-success sticky-top">
            <div class="container-fluid">
                <a class="navbar-brand text ps-4 fw-bold" href="/"><img src="../loggo2.png" class="img-fluid"
                        style="width: 150px" alt=""></a>
                <button class="navbar-toggler collapsed d-flex d-lg-none flex-column justify-content-around" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="toggler-icon top-bar"></span>
                    <span class="toggler-icon middle-bar"></span>
                    <span class="toggler-icon bottom-bar"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <ul class="navbar-nav ms-auto mb-2 me-5 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="/">Home</a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="{{route('postAd')}}"> <button class="btn btn-secondary fw-bold text-light btn-sm">Post Lodge</button></a>
                        </li> --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle btn-sm fw-bold rounded-sm p-2 text-light"
                                style="background-color: green" href="#" id="navbarDropdownn" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Post Ad
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownn">
                                <li><a class="dropdown-item" href="{{ route('postLodge') }}">Post Lodge</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="{{ route('postService') }}">Post Service</a></li>
                            </ul>
                        </li>


                        @if (Route::has('login'))
                            @auth
                                @if (Auth::user()->user_type === 'ADM')
                                    <li class="nav-item notification-badge">
                                        <a class="nav-link text-decoration-none" aria-current="page"
                                            href="{{ route('notification') }}">
                                            Notification
                                            @if (auth()->user()->unreadNotifications->count() > 0)
                                                <span
                                                    style="font-size: 10px; background-color:red; border-radius: 10%; color:white; padding:1px 5px;">{{ auth()->user()->unreadNotifications->count() }}</span>
                                            @endif
                                        </a>
                                    </li>

                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
                                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Dashboard
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                            <li><a class="dropdown-item" href="{{ route('over-view') }}"><i
                                                        class="bi bi-speedometer2"></i> Overview</a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item" href="{{ route('admin.all-ads') }}"><i
                                                        class="bi bi-badge-ad-fill"></i> All Ads</a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item" href="{{ route('admin.lodge') }}"><i
                                                        class="bi bi-house"></i> Lodge</a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item" href="{{ route('admin.service') }}"><i
                                                        class="bi bi-tools"></i> Service</a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item" href="{{ route('admin.location') }}"><i
                                                        class="bi bi-geo-alt"></i> Location</a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item" href="{{ route('admin.school') }}"><i
                                                        class="bi bi-bank2"></i> School</a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item" href="{{ route('admin.school-area') }}"><i
                                                        class="bi bi-houses"></i> School Area</a></li>

                                        </ul>
                                    </li>

                                    <li class="nav-item dropdown">
                                        <a id="navbarDropdowni" class="nav-link dropdown-toggle" href="#"
                                            role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false" v-pre>
                                            User({{ explode(' ', trim(Auth::user()->name))[0] }})
                                        </a>

                                        {{-- <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown"> --}}
                                        <ul class="dropdown-menu" aria-labelledby="navbarDropdowni">
                                            <a class="dropdown-item" href="{{ route('profile.edit') }}"><i
                                                    class="bi bi-person"></i> Profile</a>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item" href="{{ route('my-ads') }}"><i
                                                        class="bi bi-badge-ad"></i> My Ads</a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item" href="{{ route('draft') }}"><i
                                                        class="bi bi-file-earmark"></i> Draft</a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item" href="{{ route('bookmarks') }}"><i
                                                        class="bi bi-bookmark"></i> Saved</a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item" href="{{ route('payment-history') }}"><i
                                                        class="bi bi-credit-card-2-back"></i> Transaction History</a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                                <i class="bi bi-box-arrow-right"></i> {{ __('Logout') }}
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                class="d-none">
                                                @csrf
                                            </form>
                                        </ul>
                                        {{-- </div> --}}
                                    </li>
                                @else
                                <li class="nav-item notification-badge">
                                    <a class="nav-link text-decoration-none" aria-current="page"
                                        href="{{ route('notification') }}">
                                        Notification
                                        @if (auth()->user()->unreadNotifications->count() > 0)
                                            <span
                                                style="font-size: 10px; background-color:red; border-radius: 10%; color:white; padding:1px 5px;">{{ auth()->user()->unreadNotifications->count() }}</span>
                                        @endif
                                    </a>
                                </li>

                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownii"
                                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Dashboard
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownii">

                                            <li><a class="dropdown-item" href="{{ route('my-ads') }}"><i
                                                        class="bi bi-badge-ad"></i> My Ads</a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item" href="{{ route('draft') }}"><i
                                                        class="bi bi-file-earmark"></i> Draft</a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item" href="{{ route('bookmarks') }}"><i
                                                        class="bi bi-bookmark"></i> Saved</a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item" href="{{ route('payment-history') }}"><i
                                                        class="bi bi-credit-card-2-back"></i> Transaction History</a></li>

                                        </ul>
                                    </li>

                                    <li class="nav-item dropdown">
                                        <a id="navbarDropdowniii" class="nav-link dropdown-toggle" href="#"
                                            role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false" v-pre>
                                            User({{ explode(' ', trim(Auth::user()->name))[0] }})
                                        </a>

                                        {{-- <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown"> --}}
                                        <ul class="dropdown-menu" aria-labelledby="navbarDropdowniii">
                                            <a class="dropdown-item" href="{{ route('profile.edit') }}"><i
                                                    class="bi bi-person"></i> Profile</a>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                                <i class="bi bi-box-arrow-right"></i> {{ __('Logout') }}
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

        <footer class="bg-success">
            <div class="container">
                <div class="row mt-3">
                   
                    <div class="col-md-6">
                        <p>
                            <a style="color: black" href="#"><i class="bi bi-instagram"></i> </a>
                            <a class="mx-3" style="color: black" href="#"><i class="bi bi-twitter"></i></a>
                            <a style="color: black" href="#"><i class="bi bi-facebook"></i></a>
                        </p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p class="text-light">&copy;
                            <script>
                                document.write(new Date().getFullYear())
                            </script> Tetmart. All rights reserved.
                        </p>
                    </div>
                </div>
            </div>
        </footer>


    </div>
        <!-- Bottom navbar -->
        <nav id="bottom-navbar" class="navbar fixed-bottom d-md-none">
            <div class="d-flex justify-content-evenly text-center">
                <div class="icon">
                    <a href="/" class="{{ request()->is('/') ? 'active' : ''}} text-decoration-none"><i class="bi bi-house-door" 
                        style="font-size: 20px; color: {{ request()->is('/') ? 'green' : 'black' }}"><p style="font-size: 10px;">Home</p></i></a>
                </div>
                
                <div class="icon">
                    <a href="{{ route('bookmarks') }}" class="{{ request()->is('bookmark') ? 'active' : ''}} text-decoration-none"><i class="bi bi-bookmark"
                        style="font-size: 20px; color: {{ request()->is('bookmark') ? 'green' : 'black' }}"><p style="font-size: 10px;">Saved</p></i></a>
                </div>

                <div class="dropup">
                    <i type="button" class="dropdown-toggle bi bi-plus-circle" data-bs-toggle="dropdown"
                        style="font-size: 20px; color: {{ request()->is('post-ad/lodge') || request()->is('post-ad/service') ? 'green' : 'black' }}">
                    <p style="font-size: 10px;">Sell</p></i>

                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('postLodge') }}">Post Lodge</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="{{ route('postService') }}">Post Service</a></li>
                    </ul>
                </div>
                <div class="icon notification-badge">
                    <a href="{{ route('notification') }}" class="{{ request()->is('notification') ? 'active' : ''}} text-decoration-none"><i class="bi bi-bell"
                        style="font-size: 20px; color: {{ request()->is('notification') ? 'green' : 'black' }}"><p style="font-size: 10px;">Notification</p></i>
                        @auth  
                        @if (auth()->user()->unreadNotifications->count() > 0)
                            <span class="badge-number">{{ auth()->user()->unreadNotifications->count() }}</span>
                        @endif
                        @endauth
                    </a>
                    <p style="font-size: 10px;">Notification</p>
                </div>
                <div class="icon">
                    <a href="{{ route('my-ads') }}" class="{{ request()->is('my-ads') ? 'active' : ''}} text-decoration-none"><i class="bi bi-badge-ad"
                        style="font-size: 20px; color: {{ request()->is('my-ads') ? 'green' : 'black' }}"><p style="font-size: 10px;">My Ads</p></i></a>
                </div>

            </div>
        </nav>

    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.js"></script>
    <script src="{{ asset('js/share.js') }}"></script>
    <script src="{{ asset('js/navBottom.js') }}"></script>

    {{-- @vite('resources/js/slugify.js') --}}
    {{-- @vite('resources/js/bootstrap.min.js') --}}

</body>

</html>
