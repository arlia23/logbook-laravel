<ul class="menu-inner py-1">
    <!-- Dashboards -->
    <li class="menu-item active open">
        <a href="{{ route('admin.home') }}" class="menu-link">
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
            <i class="fi fi-rr-user" style="margin-right: 12px;"></i>
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
            <i class="fi fi-rr-memo-pad"style="margin-right: 12px;"></i>
            <div class="text-truncate" data-i18n="Hadir">Hadir</div>
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
        </ul>
    </li>

      <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="fi fi-rs-edit" style="margin-right: 12px;"></i>
            <div class="text-truncate" data-i18n="Tidak Hadir">Tidak Hadir</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="{{ route('admin.dinas-luar.index') }}" class="menu-link">
                    <div class="text-truncate" data-i18n="Dinas Luar">Dinas Luar</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('admin.cuti.index') }}" class="menu-link">
                    <div class="text-truncate" data-i18n="Cuti">Cuti</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('admin.sakit.index') }}" class="menu-link">
                    <div data-i18n="Sakit">Sakit</div>
                </a>
            </li>
        </ul>
    </li>

    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
             <i class="fi fi-rs-book-copy" style="margin-right: 12px;"></i>
            <div class="text-truncate" data-i18n="Rekap">Rekap</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="{{ route('admin.rekap.index') }}" class="menu-link">
                    <div class="text-truncate" data-i18n="Rekap Kehadiran">Kehadiran</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('admin.izin.index') }}" class="menu-link">
                    <div class="text-truncate" data-i18n="Rekap Izin Saat Hadir">Izin Saat Hadir</div>
                </a>
            </li>
        </ul>
    </li>
   
     <li class="menu-item">
        <a href="{{ route('admin.monitoring.index') }}" class="menu-link">
            <i class="fi fi-rr-display-arrow-down" style="margin-right: 12px;"></i>
            <div data-i18n="Monitor">Monitor</div>
        </a>
    </li>

    <li class="menu-item">
        <a href="{{ route('logout') }}" class="menu-link"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fi fi-rr-power" style="margin-right: 12px;"></i>
            <div>Log Out</div>
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </li>

</ul>
