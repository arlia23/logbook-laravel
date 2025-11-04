<ul class="menu-inner py-1">
    <!-- Dashboards -->
    <li class="menu-item active open">
        <a href="{{ route('user.home') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-smile"></i>
            <div class="text-truncate" data-i18n="Dashboards">Dashboards</div>
        </a>
    </li>

    <!-- menu-->
    <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Menu</span>
    </li>
    <li class="menu-item">
        <a href="{{ route('logbook.index') }}" class="menu-link">
            <i class="fi fi-rr-book" style="margin-right: 12px;"></i>
            <div data-i18n="Logbook">Logbook</div>
        </a>
    </li>


    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="fi fi-rs-edit" style="margin-right: 12px;"></i>
            <div class="text-truncate">Tidak Hadir</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="{{ route('user.dinas.index') }}" class="menu-link">
                    <div class="text-truncate">Dinas Luar</div>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('user.cuti.index') }}" class="menu-link">
                    <div>Cuti</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('user.sakit.index') }}" class="menu-link">
                    <div>Sakit</div>
                </a>
            </li>
        </ul>
    </li>
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
           <i class="fi fi-rs-memo-pad" style="margin-right: 12px;"></i>
            <div class="text-truncate">Laporan</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="{{ route('user.monitoring.index') }}" class="menu-link">
                    <div class="text-truncate" data-i18n="Catatan">Catatan Supervisor</div>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('user.rekap.index') }}" class="menu-link">
                    <div>Kehadiran</div>
                </a>
            </li>
        </ul>
    </li>
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="fi fi-rs-book-copy" style="margin-right: 12px;"></i>
            <div class="text-truncate" >Izin Saat Hadir</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="{{ route('user.izinsaathadir.index') }}" class="menu-link">
                    <div class="text-truncate" data-i18n="Catatan">Izin Saat Hadir</div>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('user.izinsaathadir.rekap') }}" class="menu-link">
                    <div>Rekapan</div>
                </a>
            </li>
        </ul>
    </li>
    <li class="menu-item">
        <a href="{{ route('user.help') }}" class="menu-link">
            <i class="fi fi-rs-life-ring" style="margin-right: 12px;"></i>
            <div data-i18n="Help">Help</div>
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

<!-- resources/views/template/menu/menuUser.blade.php -->
{{-- <li class="menu-item">
  <a href="{{ route('index.home') }}" class="menu-link">
    <i class="menu-icon tf-icons bx bx-home"></i>
    <div>Dashboard</div>
  </a>
</li>
<li class="menu-item">
  <a href="#" class="menu-link">
    <i class="menu-icon tf-icons bx bx-user"></i>
    <div>Profil</div>
  </a>
</li> --}}
