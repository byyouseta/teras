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

        .header-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header-center {
            flex: 1;
            text-align: center;
        }

        .header-center .nav {
            display: inline-flex;
            gap: 15px;
        }

        .header-center .nav-link {
            color: #000 !important;
            /* hitam */
        }

        .header-center .nav-link:hover {
            color: #495057 !important;
            /* abu-abu saat hover */
        }
    </style>

    @stack('styles')
    @livewireStyles
</head>

<body data-pc-direction="ltr" data-pc-theme="light">
    <!-- ======= HEADER ======= -->
    <header class="pc-header">
        <div class="header-wrapper"> <!-- [Mobile Media Block] start -->
            <div class="me-auto pc-mob-drp">
                <ul class="list-unstyled">
                    <li>
                        <a href="{{ route('main') }}" class="b-brand text-primary">
                            <!-- ========   Change your logo from here   ============ -->
                            <img src="{{ asset('assets/images/Logo_Baru_RSUP.svg') }}" class="img-fluid logo-lg"
                                style="max-height: 35px;" alt="logo">
                        </a>
                    </li>
                </ul>
            </div>
            <!-- [Mobile Media Block end] -->
            <!-- Menu Tengah -->
            <div class="header-center">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('main') }}"><i
                                class="ti ti-home"></i>
                            TerasApps</a>
                    </li>
                    {{-- <li class="nav-item"><a href="#" class="nav-link">Menu 1</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Menu 2</a></li> --}}
                </ul>

            </div>

            <div class="ms-auto">
                <ul class="list-unstyled">
                    <li class="dropdown pc-h-item header-user-profile">
                        <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                            role="button" aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
                            <img src="{{ Auth::user()->foto ? route('profile.image', Auth::user()->foto) : asset('mantis/assets/images/user/avatar-2.jpg') }}"
                                alt="user-image" class="user-avtar">
                            <span>{{ Auth::user()->name }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                            <div class="dropdown-header">
                                <div class="d-flex mb-1">
                                    <div class="flex-shrink-0">
                                        <img src="{{ Auth::user()->foto ? route('profile.image', Auth::user()->foto) : asset('mantis/assets/images/user/avatar-2.jpg') }}"
                                            alt="user-image" class="user-avtar wid-35">
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1">{{ Auth::user()->name }}</h6>
                                        <span>{{ Auth::user()->pegawai->jabatan }}</span>
                                    </div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a href="#" class="pc-head-link bg-transparent"
                                            onclick="event.preventDefault();
                                                this.closest('form').submit();"><i
                                                class="ti ti-power text-danger"></i></a>
                                    </form>
                                </div>
                            </div>
                            <ul class="nav drp-tabs nav-fill nav-tabs" id="mydrpTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="drp-t1" data-bs-toggle="tab"
                                        data-bs-target="#drp-tab-1" type="button" role="tab"
                                        aria-controls="drp-tab-1" aria-selected="true"><i class="ti ti-user"></i>
                                        Profile</button>
                                </li>
                                {{-- <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="drp-t2" data-bs-toggle="tab"
                                        data-bs-target="#drp-tab-2" type="button" role="tab"
                                        aria-controls="drp-tab-2" aria-selected="false"><i
                                            class="ti ti-settings"></i> Setting</button>
                                </li> --}}
                            </ul>
                            <div class="tab-content" id="mysrpTabContent">
                                <div class="tab-pane fade show active" id="drp-tab-1" role="tabpanel"
                                    aria-labelledby="drp-t1" tabindex="0">
                                    <a href="{{ route('main') }}" class="dropdown-item">
                                        <i class="ti ti-layout-grid"></i>
                                        <span>Main Menu</span>
                                    </a>
                                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                        <i class="ti ti-edit-circle"></i>
                                        <span>Edit Profile</span>
                                    </a>
                                    {{-- <a href="#!" class="dropdown-item">
                                        <i class="ti ti-user"></i>
                                        <span>View Profile</span>
                                    </a>
                                    <a href="#!" class="dropdown-item">
                                        <i class="ti ti-clipboard-list"></i>
                                        <span>Social Profile</span>
                                    </a>
                                    <a href="#!" class="dropdown-item">
                                        <i class="ti ti-wallet"></i>
                                        <span>Billing</span>
                                    </a> --}}
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a href="#!" class="dropdown-item"
                                            onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                            <i class="ti ti-power"></i>
                                            <span>Logout</span>
                                        </a>
                                    </form>
                                </div>
                                {{-- <div class="tab-pane fade" id="drp-tab-2" role="tabpanel" aria-labelledby="drp-t2"
                                    tabindex="0">
                                    <a href="#!" class="dropdown-item">
                                        <i class="ti ti-help"></i>
                                        <span>Support</span>
                                    </a>
                                    <a href="#!" class="dropdown-item">
                                        <i class="ti ti-user"></i>
                                        <span>Account Settings</span>
                                    </a>
                                    <a href="#!" class="dropdown-item">
                                        <i class="ti ti-lock"></i>
                                        <span>Privacy Center</span>
                                    </a>
                                    <a href="#!" class="dropdown-item">
                                        <i class="ti ti-messages"></i>
                                        <span>Feedback</span>
                                    </a>
                                    <a href="#!" class="dropdown-item">
                                        <i class="ti ti-list"></i>
                                        <span>History</span>
                                    </a>
                                </div> --}}
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <!-- ======= END HEADER ======= -->

    <!-- ======= CONTENT ======= -->
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ breadcrumb ] start -->
            {{-- <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="page-header-title">
                                <h5 class="mb-0">
                                    @yield('header-title', 'Test Title')
                                </h5>
                            </div>
                        </div>
                        <div class="col-md-8">
                            @yield('breadcrumb')
                        </div>
                    </div>
                </div>
            </div> --}}
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            <div class="row justify-content-center align-items-center">
                {{-- {{ $slot }} --}}
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
