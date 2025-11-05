<div class="navbar-content">
    <ul class="pc-navbar">
        <li class="pc-item">
            <a href="{{ route('inovasi.index') }}" class="pc-link">
                <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                <span class="pc-mtext">Dashboard</span>
            </a>
        </li>

        <li class="pc-item pc-caption">
            <label>Menus</label>
            <i class="ti ti-dashboard"></i>
        </li>
        <li class="pc-item">
            <a href="{{ route('inovasi.list') }}" class="pc-link">
                <span class="pc-micon"><i class="ti ti-list-search"></i></span>
                <span class="pc-mtext">Daftar Inovasi</span>
            </a>
        </li>
        <li class="pc-item">
            <a href="{{ route('inovasi.pengajuan') }}" class="pc-link">
                <span class="pc-micon"><i class="ti ti-send"></i></span>
                <span class="pc-mtext">Pengajuan Inovasi</span>
            </a>
        </li>
        <li class="pc-item">
            <a href="{{ route('inovasi.status') }}" class="pc-link">
                <span class="pc-micon"><i class="ti ti-device-laptop"></i></span>
                <span class="pc-mtext">Status Pengajuan</span>
            </a>
        </li>
        <li class="pc-item">
            <a href="{{ route('inovasi.persetujuan') }}" class="pc-link">
                <span class="pc-micon"><i class="ti ti-checks"></i></span>
                <span class="pc-mtext">Persetujuan</span>
            </a>
        </li>
        <li class="pc-item">
            <a href="{{ route('inovasi.paparan') }}" class="pc-link">
                <span class="pc-micon"><i class="ti ti-presentation"></i></span>
                <span class="pc-mtext">Paparan Inovasi</span>
            </a>
        </li>
        <li class="pc-item">
            <a href="{{ route('inovasi.monitoring') }}" class="pc-link">
                <span class="pc-micon"><i class="ti ti-file-symlink"></i></span>
                <span class="pc-mtext">Monitoring Inovasi</span>
            </a>
        </li>
        @can('Inovasi-BA-List')
            <li class="pc-item">
                <a href="{{ route('inovasi.beritaacara') }}" class="pc-link">
                    <span class="pc-micon"><i class="ti ti-file-certificate"></i></span>
                    <span class="pc-mtext">Berita Acara</span>
                </a>
            </li>
        @endcan
        @can('Inovasi-Operator-List')
            <li class="pc-item pc-caption">
                <label>Master</label>
                <i class="ti ti-dashboard"></i>
            </li>
            <li class="pc-item">
                <a href="{{ route('inovasi.periode') }}" class="pc-link">
                    <span class="pc-micon"><i class="ti ti-calendar-time"></i></span>
                    <span class="pc-mtext">Periode</span>
                </a>
            </li>
        @endcan
    </ul>
</div>
