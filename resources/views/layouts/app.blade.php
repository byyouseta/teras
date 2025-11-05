<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon" />

    <!-- Font & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/phosphor/regular/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}" />

    @stack('header')

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link" />
    <link rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }}" />

    {{-- <meta name="theme-color" content="#712cf9" /> --}}
    <link href="{{ asset('assets/css/sidebars.css') }}" rel="stylesheet" />

    <style>
        /* warna dasar sidebar */
        .pc-sidebar {
            background-color: #2f3e4e;
        }

        /* link menu */
        .pc-sidebar .nav-link {
            color: #1ea7ff;
            border-radius: .5rem;
            padding: .5rem .75rem;
            display: flex;
            align-items: center;
            /* full klik area */
            transition: background-color .15s ease, color .15s ease;
        }

        /* hover & focus */
        .pc-sidebar .nav-link:hover,
        .pc-sidebar .nav-link:focus {
            color: #fff;
            background-color: rgba(255, 255, 255, .1);
            text-decoration: none;
        }

        /* active (optional) */
        .pc-sidebar .nav-link.active {
            color: #fff;
            background-color: rgba(255, 255, 255, .15);
        }

        /* sub-menu */
        .pc-sidebar .collapse .nav-link {
            padding-left: 1.25rem;
            opacity: .95;
        }

        .pc-sidebar .collapse .nav-link:hover {
            opacity: 1;
        }

        /* ikon */
        .pc-sidebar .nav-link i {
            margin-right: .5rem;
        }

        .pc-sidebar .nav-link:hover i {
            color: inherit;
        }

        /* putar chevron saat terbuka */
        .pc-sidebar a[data-bs-toggle="collapse"] .ti-chevron-right {
            transition: transform .2s ease;
        }

        .pc-sidebar a[data-bs-toggle="collapse"][aria-expanded="true"] .ti-chevron-right {
            transform: rotate(90deg);
        }
    </style>

    {{-- <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            width: 100%;
            height: 3rem;
            background-color: #0000001a;
            border: solid rgba(0, 0, 0, 0.15);
            border-width: 1px 0;
            box-shadow:
                inset 0 0.5em 1.5em #0000001a,
                inset 0 0.125em 0.5em #00000026;
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -0.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        .btn-bd-primary {
            --bd-violet-bg: #712cf9;
            --bd-violet-rgb: 112.520718, 44.062154, 249.437846;
            --bs-btn-font-weight: 600;
            --bs-btn-color: var(--bs-white);
            --bs-btn-bg: var(--bd-violet-bg);
            --bs-btn-border-color: var(--bd-violet-bg);
            --bs-btn-hover-color: var(--bs-white);
            --bs-btn-hover-bg: #6528e0;
            --bs-btn-hover-border-color: #6528e0;
            --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
            --bs-btn-active-color: var(--bs-btn-hover-color);
            --bs-btn-active-bg: #5a23c8;
            --bs-btn-active-border-color: #5a23c8;
        }

        .bd-mode-toggle {
            z-index: 1500;
        }

        .bd-mode-toggle .bi {
            width: 1em;
            height: 1em;
        }

        .bd-mode-toggle .dropdown-menu .active .bi {
            display: block !important;
        }
    </style> --}}

    {{-- @livewireStyles --}}
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    {{-- @vite(['resources/js/app.js']) --}}
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
    @include('layouts.preloader')
    @include('layouts.sidebar')
    @include('layouts.header_menu')

    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="mb-0">@yield('header-title', 'Test Title')</h5>
                            </div>
                        </div>
                        <div class="col-md-12">
                            @yield('breadcrumb')
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            <div class="row">
                <!-- main start -->
                @yield('content')
                <!-- main end -->
            </div>


            <!-- [ Main Content ] end -->
        </div>
    </div>
    <!-- [ Main Content ] end -->

    @include('layouts.footer')
    <!-- Required Js -->
    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/js/theme.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/script.js') }}" data-navigate-once></script> --}}
    {{-- <script src="{{ asset('assets/js/theme.js') }}" data-navigate-once></script> --}}

    {{-- <script>
        document.addEventListener("livewire:navigated", () => {
            console.log("navigated");
            if (typeof menu_click === "function") {
                menu_click();
            }
        });
    </script> --}}

    @stack('scripts')
    {{-- @livewireScripts --}}
</body>

</html>
