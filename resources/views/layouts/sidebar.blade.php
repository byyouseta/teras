<!-- [ Sidebar Menu ] start -->
<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{ route('home') }}" class="b-brand text-primary">
                <!-- ========   Change your logo from here   ============ -->
                <img src="{{ asset('assets/images/logo-white.svg') }}" class="img-fluid logo-lg" alt="logo" />
            </a>
        </div>
        <div class="navbar-content">
            <ul class="nav flex-column mt-3">

                <li class="nav-item px-3 text-muted small text-light">
                    Main Menus
                </li>

                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link d-flex align-items-center">
                        <i class="ph ph-house-line me-2"></i> Home
                    </a>
                </li>

                <!-- Agenda -->
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" data-bs-toggle="collapse" href="#menuAgenda"
                        role="button" aria-expanded="false" aria-controls="menuAgenda">
                        <i class="ph ph-calendar-check me-2"></i> Agenda
                        <i class="ms-auto ti ti-chevron-right"></i>
                    </a>
                    <div class="collapse" id="menuAgenda">
                        <ul class="nav flex-column ms-4">
                            <li><a class="nav-link" href="{{ route('agenda.list') }}">Agenda</a></li>
                            <li><a class="nav-link" href="#!">Presensi</a></li>
                            <li><a class="nav-link" href="#!">Timeline</a></li>
                        </ul>
                    </div>
                </li>

                <!-- Master Data -->
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" data-bs-toggle="collapse" href="#menuMaster"
                        role="button" aria-expanded="false" aria-controls="menuMaster">
                        <i class="ph ph-database me-2"></i> Master Data
                        <i class="ms-auto ti ti-chevron-right"></i>
                    </a>
                    <div class="collapse" id="menuMaster">
                        <ul class="nav flex-column ms-4">
                            <li><a class="nav-link" href="{{ route('master.unit') }}">Unit</a></li>
                            <li><a class="nav-link" href="{{ route('master.pegawai') }}">Pegawai</a></li>
                            <li><a class="nav-link" href="{{ route('master.ruangan') }}">Ruangan</a></li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a href="../other/sample-page.html" class="nav-link d-flex align-items-center">
                        <i class="ph ph-question me-2"></i> Bantuan
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>

<!-- [ Sidebar Menu ] end -->
