<div class="navbar-content">
    <ul class="pc-navbar">
        <li class="pc-item">
            <a href="{{ route('akses.index') }}" class="pc-link">
                <span class="pc-micon"><i class="ti ti-home"></i></span>
                <span class="pc-mtext">Home</span>
            </a>
        </li>
        <li class="pc-item pc-caption">
            <label>Master</label>
            <i class="ti ti-dashboard"></i>
        </li>
        {{-- @can('list-roles') --}}
        <li class="pc-item">
            <a href="{{ route('master.users') }}" class="pc-link">
                <span class="pc-micon"><i class="ti ti-users"></i></span>
                <span class="pc-mtext">Users</span>
            </a>
        </li>
        {{-- @endcan --}}
        <li class="pc-item pc-caption">
            <label>Roles And Permission</label>
            <i class="ti ti-dashboard"></i>
        </li>
        @can('Akses-Roles-List')
            <li class="pc-item">
                <a href="{{ route('akses.roles') }}" class="pc-link">
                    <span class="pc-micon"><i class="ti ti-lock-access"></i></span>
                    <span class="pc-mtext">Roles</span>
                </a>
            </li>
        @endcan
        @can('Akses-Permission-List')
            <li class="pc-item">
                <a href="{{ route('akses.permission') }}" class="pc-link">
                    <span class="pc-micon"><i class="ti ti-accessible"></i></span>
                    <span class="pc-mtext">Permission</span>
                </a>
            </li>
        @endcan
    </ul>
</div>
