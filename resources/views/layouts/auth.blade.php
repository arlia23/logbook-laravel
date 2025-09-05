<!doctype html>
<html lang="en" class="layout-wide customizer-hide"
  data-assets-path="{{ asset('template/') }}/"
  data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'Sneat Template')</title>

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ asset('template/img/favicon/favicon.ico') }}" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

  <!-- Icons -->
  <link rel="stylesheet" href="{{ asset('template/vendor/fonts/iconify-icons.css') }}" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="{{ asset('template/vendor/css/core.css') }}" />
  <link rel="stylesheet" href="{{ asset('template/css/demo.css') }}" />
  <link rel="stylesheet" href="{{ asset('template/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
  <link rel="stylesheet" href="{{ asset('template/vendor/css/pages/page-auth.css') }}" />

  <!-- Helpers -->
  <script src="{{ asset('template/vendor/js/helpers.js') }}"></script>
  <script src="{{ asset('template/js/config.js') }}"></script>
</head>

<body>
  <!-- Content -->
  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner">
        @yield('content')
      </div>
    </div>
  </div>
  <!-- / Content -->

  <!-- Core JS -->
  <script src="{{ asset('template/vendor/libs/jquery/jquery.js') }}"></script>
  <script src="{{ asset('template/vendor/libs/popper/popper.js') }}"></script>
  <script src="{{ asset('template/vendor/js/bootstrap.js') }}"></script>
  <script src="{{ asset('template/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
  <script src="{{ asset('template/vendor/js/menu.js') }}"></script>
  <script src="{{ asset('template/js/main.js') }}"></script>
</body>
</html>
