<!doctype html>
<html
  lang="en"
  class="layout-menu-fixed layout-compact"
  data-assets-path="{{ asset('template/') }}"
  data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title>@yield('title') | Sneat Dashboard</title>

  <meta name="description" content="Dashboard Logbook Universitas Riau" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ asset('template/img/favicon/favicon.ico') }}" />

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"
    rel="stylesheet" />

  <!-- Icons -->
  <link rel="stylesheet" href="{{ asset('template/vendor/fonts/iconify-icons.css') }}" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

  <!-- Core CSS -->
  <link rel="stylesheet" href="{{ asset('template/vendor/css/core.css') }}" />
  <link rel="stylesheet" href="{{ asset('template/css/demo.css') }}" />

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="{{ asset('template/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
  <link rel="stylesheet" href="{{ asset('template/vendor/libs/apex-charts/apex-charts.css') }}" />

  <!-- Helpers -->
  <script src="{{ asset('template/vendor/js/helpers.js') }}"></script>
  <script src="{{ asset('template/js/config.js') }}"></script>

  <!-- SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

 
    <!-- CSS Flaticon Uicons Regular Straight -->
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.0.0/uicons-regular-straight/css/uicons-regular-straight.css'>

    <!-- Flaticon Uicons Regular Rounded -->
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.0.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
</head>

@if(session('success'))
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const toastEl = document.createElement("div");
        toastEl.classList.add("toast", "align-items-center", "text-bg-success", "border-0");
        toastEl.setAttribute("role", "alert");
        toastEl.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
        document.body.appendChild(toastEl);
        const toast = new bootstrap.Toast(toastEl, { delay: 3000 });
        toast.show();
    });
</script>
@endif


<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

      <!-- Sidebar -->
      @include('template.sidebar')

      <!-- Layout container -->
      <div class="layout-page">

        <!-- Navbar -->
        @include('template.navbar')

        <!-- Content -->
        <div class="content-wrapper">
          <div class="container-xxl flex-grow-1 container-p-y">
            @yield('main')
          </div>

          @include('template.footer')
          <div class="content-backdrop fade"></div>
        </div>
        <!-- / Content -->
      </div>
      <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle" title="Toggle Menu"></div>
  </div>
  <!-- / Layout wrapper -->

  <!-- Core JS -->
  <script src="{{ asset('template/vendor/libs/jquery/jquery.js') }}"></script>
  <script src="{{ asset('template/vendor/libs/popper/popper.js') }}"></script>
  <script src="{{ asset('template/vendor/js/bootstrap.js') }}"></script>
  <script src="{{ asset('template/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
  <script src="{{ asset('template/vendor/js/menu.js') }}"></script>

  <!-- Vendors JS -->
  <script src="{{ asset('template/vendor/libs/apex-charts/apexcharts.js') }}"></script>

  <!-- Main JS -->
  <script src="{{ asset('template/js/main.js') }}"></script>
  <script src="{{ asset('template/js/dashboards-analytics.js') }}"></script>

  <!-- GitHub Buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>

  <!-- Optional: Fix Bootstrap conflict -->
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      // Pastikan tombol dapat diklik
      document.querySelectorAll("button").forEach(btn => {
        if (!btn.hasAttribute("aria-label") && !btn.title && !btn.textContent.trim()) {
          btn.setAttribute("aria-label", "button");
        }
      });
    });
  </script>
   @stack('scripts')
</body>

</html>
