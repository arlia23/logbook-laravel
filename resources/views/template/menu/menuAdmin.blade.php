<ul class="menu-inner py-1">
    <!-- Dashboards -->
    <li class="menu-item active open">
        <a href="{{ route('index.home') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-smile"></i>
            <div class="text-truncate" data-i18n="Dashboards">Dashboards</div>
        </a>
    </li>

    <!-- menu-->
    <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Menu</span>
    </li>

    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-dock-top"></i>
            <div class="text-truncate" data-i18n="User">User</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="{{ route('data.user') }}" class="menu-link">
                    <div class="text-truncate" data-i18n="Data User">Data User</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('data.admin') }}" class="menu-link">
                    <div class="text-truncate" data-i18n="Data Admin">Data Admin</div>
                </a>
            </li>
        </ul>
    </li>

    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-lock-open-alt"></i>
            <div class="text-truncate" data-i18n="Logbook">Logbook</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="{{ route('admin.logbook.index') }}" class="menu-link">
                    <div class="text-truncate" data-i18n="Logbook">Logbook</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('admin.presensi.index') }}" class="menu-link">
                    <div data-i18n="Presensi">Presensi</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('admin.tidak_hadir.index') }}" class="menu-link">
                    <div class="text-truncate" data-i18n="Basic">Tidak Hadir</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('admin.rekap.index') }}" class="menu-link">
                    <div class="text-truncate" data-i18n="Basic">Rekap Kehadiran</div>
                </a>
            </li>
        </ul>
    </li>

    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-cube-alt"></i>
            <div class="text-truncate" data-i18n="Misc">Misc</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="pages-misc-error.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Error">Error</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="pages-misc-under-maintenance.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Under Maintenance">Under Maintenance</div>
                </a>
            </li>
        </ul>
    </li>
</ul>
