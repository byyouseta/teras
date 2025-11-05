<!-- [ Header Topbar User Logout ] start -->
<header class="pc-header">
    <div class="header-wrapper"> <!-- [Mobile Media Block] start -->
        <div class="me-auto pc-mob-drp">
            <ul class="list-unstyled">
                <li class="pc-h-item pc-sidebar-collapse">
                    <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
                        <i class="ph ph-list"></i>
                    </a>
                </li>
                <li class="pc-h-item pc-sidebar-popup">
                    <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
                        <i class="ph ph-list"></i>
                    </a>
                </li>
            </ul>
        </div>
        <!-- [Mobile Media Block end] -->
        <div class="ms-auto">
            <ul class="list-unstyled">
                <li class="dropdown pc-h-item">
                    <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="ph ph-bell"></i>
                        <span class="badge bg-success pc-h-badge">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-notification dropdown-menu-end pc-h-dropdown">
                        <div class="dropdown-header d-flex align-items-center justify-content-between">
                            <h5 class="m-0">Notifications</h5>
                            <a href="#!" class="btn btn-link btn-sm">Mark all read</a>
                        </div>
                        {{-- <div class="dropdown-body text-wrap header-notification-scroll position-relative"
                            style="max-height: calc(100vh - 215px)">
                            <p class="text-span">Today</p>
                            <div class="card bg-transparent mb-0">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            <img class="img-radius avatar rounded-0"
                                                src="../assets/images/user/avatar-1.png"
                                                alt="Generic placeholder image" />
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <span class="float-end text-sm text-muted">2 min ago</span>
                                            <h5 class="text-body mb-2">UI/UX Design</h5>
                                            <p class="mb-0">
                                                Lorem Ipsum has been the industry's standard dummy text ever since
                                                the 1500s, when an unknown printer took a galley of
                                                type and scrambled it to make a type
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card bg-transparent mb-0">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            <img class="img-radius avatar rounded-0"
                                                src="../assets/images/user/avatar-2.png"
                                                alt="Generic placeholder image" />
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <span class="float-end text-sm text-muted">1 hour ago</span>
                                            <h5 class="text-body mb-2">Message</h5>
                                            <p class="mb-0">Lorem Ipsum has been the industry's standard dummy
                                                text ever since the 1500.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="text-span">Yesterday</p>
                            <div class="card bg-transparent mb-0">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            <img class="img-radius avatar rounded-0"
                                                src="../assets/images/user/avatar-3.png"
                                                alt="Generic placeholder image" />
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <span class="float-end text-sm text-muted">2 hour ago</span>
                                            <h5 class="text-body mb-2">Forms</h5>
                                            <p class="mb-0">Lorem Ipsum has been the industry's standard dummy
                                                text ever since the 1500s, when an unknown printer took a galley of
                                                type and scrambled it to make a type</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <div class="text-center py-2">
                            <a href="#!" class="link-danger">Clear all Notifications</a>
                        </div>
                    </div>
                </li>
                <li class="dropdown pc-h-item header-user-profile">
                    <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
                        <i class="ph ph-user-circle"></i>
                    </a>
                    <div
                        class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown p-0 overflow-hidden">
                        <div class="dropdown-header d-flex align-items-center justify-content-between bg-gray-500">
                            <div class="d-flex my-2">
                                <div class="flex-shrink-0">
                                    <img src="{{ asset('assets/images/user/avatar-2.png') }}" alt="user-image"
                                        class="user-avatar wid-35" />
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="text-white mb-1">{{ Auth::user()->name }}</h6>
                                    <span class="text-white text-opacity-75">{{ Auth::user()->email }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-body">
                            <div class="profile-notification-scroll position-relative"
                                style="max-height: calc(100vh - 225px)">
                                <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                    <span>
                                        <i class="ph ph-gear align-middle me-2"></i>
                                        <span>Profile</span>
                                    </span>
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    <div class="d-grid my-2">
                                        @csrf
                                        {{-- <button class="btn btn-primary btn-flat"> <i
                                                class="ph ph-sign-out align-middle me-2"
                                                onclick="event.preventDefault();
                                                this.closest('form').submit();"></i>Logout
                                        </button> --}}
                                        <!-- Authentication -->


                                        <button class="btn btn-primary" href="route('logout')"
                                            onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                            <i class="ph ph-sign-out align-middle me-2"></i>{{ __('Log Out') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</header>
<!-- [ Header ] end -->
