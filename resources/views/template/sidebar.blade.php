{{-- Debug sementara --}}
<p>Role: {{ Auth::user()->role }}</p>

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('index.home') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <span class="text-primary">
                    {{-- Logo SVG kamu --}}
                </span>
            </span>
            <span class="app-brand-text demo menu-text fw-bold ms-2">Sneat</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="bx bx-chevron-left d-block d-xl-none align-middle"></i>
        </a>
    </div>

    <div class="menu-divider mt-0"></div>
    <div class="menu-inner-shadow"></div>

    {{-- Kondisional menu sesuai role --}}
    @if(Auth::user()->role == 'admin')
        @include('template.menu.menuAdmin')
    @elseif(Auth::user()->role == 'user')
        @include('template.menu.menuUser')
    @endif
</aside>
