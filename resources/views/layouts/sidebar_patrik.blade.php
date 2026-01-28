<div class="navbar-content">
    <ul class="pc-navbar">
        <li class="pc-item">
            <a href="{{ route('agenda.dashboard') }}" class="pc-link">
                <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                <span class="pc-mtext">Dashboard</span>
            </a>
        </li>

        <li class="pc-item pc-caption">
            <label>Menu</label>
            <i class="ti ti-dashboard"></i>
        </li>
        <li class="pc-item">
            <a href="{{ route('agenda.list') }}" class="pc-link">
                <span class="pc-micon"><i class="ti ti-typography"></i></span>
                <span class="pc-mtext">Agenda</span>
            </a>
        </li>
        <li class="pc-item">
            <a href="{{ route('agenda.presensi') }}" class="pc-link">
                <span class="pc-micon"><i class="ti ti-checks"></i></span>
                <span class="pc-mtext">Presensi</span>
            </a>
        </li>
        <li class="pc-item">
            <a href="../elements/icon-tabler.html" class="pc-link">
                <span class="pc-micon"><i class="ti ti-calendar-time"></i></span>
                <span class="pc-mtext">Timeline</span>
            </a>
        </li>

        <li class="pc-item pc-caption">
            <label>Master</label>
            <i class="ti ti-news"></i>
        </li>
        <li class="pc-item">
            <a href="{{ route('master.unit') }}" class="pc-link">
                <span class="pc-micon"><i class="ti ti-subtask"></i></span>
                <span class="pc-mtext">Unit</span>
            </a>
        </li>
        <li class="pc-item">
            <a href="{{ route('master.pegawai') }}" class="pc-link">
                <span class="pc-micon"><i class="ti ti-users"></i></span>
                <span class="pc-mtext">Pegawai</span>
            </a>
        </li>
        <li class="pc-item">
            <a href="{{ route('master.ruangan') }}" class="pc-link">
                <span class="pc-micon"><i class="ti ti-building-hospital"></i></span>
                <span class="pc-mtext">Ruangan</span>
            </a>
        </li>
    </ul>
</div>
