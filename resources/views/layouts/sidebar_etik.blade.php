<div class="navbar-content">
    <ul class="pc-navbar">
        <li class="pc-item">
            <a href="{{ route('etika.main') }}" class="pc-link">
                <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                <span class="pc-mtext">Dashboard</span>
            </a>
        </li>

        <li class="pc-item pc-caption">
            <label>Menus</label>
            <i class="ti ti-dashboard"></i>
        </li>
        <li class="pc-item">
            <a href="{{ route('etika.pelaporan') }}" class="pc-link">
                <span class="pc-micon"><i class="ti ti-mail"></i></span>
                <span class="pc-mtext">Pelaporan</span>
            </a>
        </li>
        @can('Etika-Operator-Update')
            <li class="pc-item">
                <a href="{{ route('etika.tindaklanjut') }}" class="pc-link">
                    <span class="pc-micon"><i class="ti ti-mail-opened"></i></span>
                    <span class="pc-mtext">Tindak Lanjut</span>
                </a>
            </li>
        @endcan
    </ul>
</div>
