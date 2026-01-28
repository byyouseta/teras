<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

    <!-- [Favicon] icon -->
    <link rel="icon" href="{{ asset('mantis/assets/images/favicon.svg') }}" type="image/x-icon">
    <!-- [Google Font] Family -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"
        id="main-font-link">

    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="{{ asset('mantis/assets/fonts/tabler-icons.min.css') }}">
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="{{ asset('mantis/assets/fonts/feather.css') }}">
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="{{ asset('mantis/assets/fonts/fontawesome.css') }}">
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="{{ asset('mantis/assets/fonts/material.css') }}">


    @stack('header')

    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="{{ asset('mantis/assets/css/style.css') }}" id="main-style-link">
    <link rel="stylesheet" href="{{ asset('mantis/assets/css/style-preset.css') }}">

    <style>
        /* Override agar konten & header full */
        .pc-container {
            margin-left: 0 !important;
        }

        .pc-header {
            margin-left: 0 !important;
            width: 100% !important;
            left: 0 !important;
        }

        .btn-teal {
            background-color: #14b8a6;
            color: #fff;
        }

        .btn-teal:hover,
        .btn-teal:focus {
            background-color: #0d9488;
            color: #fff;
        }
    </style>

    @stack('styles')
    @livewireStyles
</head>

<body data-pc-direction="ltr" data-pc-theme="light">
    <!-- ======= HEADER ======= -->
    <nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('assets/images/Logo_Baru_RSUP.svg') }}" class="img-fluid logo-lg"
                    style="max-height: 35px;" alt="logo">
            </a>
            <button class="navbar-toggler btn-sm" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                {{-- <span class="navbar-toggler-icon"></span> --}}
                <i class="ti ti-menu-2"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#"><i class="ti ti-home"></i>
                            TerasApps</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Dropdown
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" aria-disabled="true">Disabled</a>
                    </li> --}}
                </ul>
                <!-- Tombol Login kanan -->
                <div class="d-flex">
                    {{-- <a class="btn btn-sm btn-teal" href="{{ route('login') }}">
                        Login <i class="ti ti-login text-center"></i>
                    </a> --}}
                    @auth
                        <a href="{{ route('main') }}" type="button" class="btn btn-light-primary bg-light text-muted">
                            <span><i class="ti ti-layout-grid"></i> Main Menu</span>
                        </a>
                    @endauth
                    @guest
                        <a href="{{ route('login') }}" type="button" class="btn btn-light-primary bg-light text-muted">
                            <span>Login <i class="ti ti-login text-center"></i></span>
                        </a>
                    @endguest

                </div>
            </div>
        </div>
    </nav>
    <!-- ======= END HEADER ======= -->

    <!-- ======= CONTENT ======= -->
    <div class="pc-container">
        <div class="pc-content">

            <!-- [ Main Content ] start -->
            <div class="row justify-content-center align-items-center">
                @yield('content')
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
    <!-- ======= END CONTENT ======= -->

    <!-- JS bawaan Mantis -->
    <script src="{{ asset('mantis/assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('mantis/assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('mantis/assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('mantis/assets/js/fonts/custom-font.js') }}"></script>
    {{-- <script src="{{ asset('mantis/assets/js/pcoded.js') }}"></script> --}}
    <script src="{{ asset('mantis/assets/js/plugins/feather.min.js') }}"></script>

    @stack('scripts')
    @livewireScripts
</body>

</html>
