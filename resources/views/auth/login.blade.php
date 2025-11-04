<!doctype html>

<html lang="en" class="layout-wide customizer-hide" data-assets-path="{{ asset('template/') }}"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Demo: Login Basic - Pages | Sneat - Bootstrap Dashboard FREE</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('template/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('template/vendor/fonts/iconify-icons.css') }}" />

    <!-- Core CSS -->
    <!-- build:css assets/vendor/css/theme.css  -->

    <link rel="stylesheet" href="{{ asset('template/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/css/demo.css') }}" />

    <!-- Vendors CSS -->

    <link rel="stylesheet" href="{{ asset('template/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <!-- endbuild -->

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('template/vendor/css/pages/page-auth.css') }}" />

    <!-- Helpers -->
    <script src="{{ asset('template/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->

    <script src="{{ asset('template/js/config.js') }}"></script>
</head>

<body>
  <div class="container-fluid p-0">
    <div class="row g-0 min-vh-100">
      
      <!-- Kolom kanan: gambar lebih besar -->
      <div class="col-lg-8 d-none d-lg-flex align-items-center justify-content-center bg-primary position-relative" >
        <img src="{{ asset('template/img/backgrounds/logn.png') }}"
          alt="Login Illustration"
          class="img-fluid position-relative w-75"
          style="max-width: 100%;">
      </div>

       <!-- Kolom kiri: kotak login -->
      <div class="col-lg-4 d-flex align-items-center justify-content-center bg-white">
        <div class="authentication-wrapper authentication-basic container-p-y w-100">
          <div class="authentication-inner">
            <!-- Register -->
            <div class="card px-sm-6 px-0 shadow-lg rounded-4">
              <div class="card-body">
                <!-- Logo -->
                <div class="app-brand justify-content-center">
                  <a href="index.html" class="app-brand-link gap-2">
                    <!-- Logo svg asli kamu -->
                    <span class="app-brand-text demo text-heading fw-bold">Sneat</span>
                  </a>
                </div>
                <!-- /Logo -->
                <h4 class="mb-1">Welcome to Logboog Web! 👋</h4>
                <p class="mb-6">Please sign-in to your account and start the adventure</p>

                <form id="formAuthentication" class="mb-6" action="{{ route('login') }}" method="POST">
                  @csrf
                  <div class="mb-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                      id="email" name="email" value="{{ old('email') }}" required autofocus
                      placeholder="Enter your email" />
                    @error('email')
                      <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                  </div>

                  <div class="mb-6 form-password-toggle">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-group input-group-merge">
                      <input type="password" id="password"
                        class="form-control @error('password') is-invalid @enderror" name="password"
                        required placeholder="••••••••" />
                      <span class="input-group-text cursor-pointer"><i class="icon-base bx bx-hide"></i></span>
                    </div>
                    @error('password')
                      <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                  </div>

                  <div class="mb-8">
                    <div class="d-flex justify-content-between">
                      <div class="form-check mb-0">
                        <input class="form-check-input" type="checkbox" id="remember-me" name="remember" />
                        <label class="form-check-label" for="remember-me"> Remember Me </label>
                      </div>
                      @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">
                          <span>Forgot Password?</span>
                        </a>
                      @endif
                    </div>
                  </div>

                  <div class="mb-6">
                    <button class="btn btn-primary d-grid w-100" type="submit">Login</button>
                  </div>
                </form>

                <p class="text-center">
                  <span>New on our platform?</span>
                  <a href="{{ route('register') }}">
                    <span>Create an account</span>
                  </a>
                </p>
              </div>
            </div>
            <!-- /Register -->
          </div>
        </div>
      </div>
    </div>
  </div>
</body>


</html>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const togglePassword = document.querySelectorAll('.form-password-toggle .input-group-text');

    togglePassword.forEach(function(el) {
      el.addEventListener('click', function() {
        const input = this.previousElementSibling; // ambil input sebelum span
        if (input.type === "password") {
          input.type = "text";
          this.querySelector('i').classList.remove('bx-hide');
          this.querySelector('i').classList.add('bx-show');
        } else {
          input.type = "password";
          this.querySelector('i').classList.remove('bx-show');
          this.querySelector('i').classList.add('bx-hide');
        }
      });
    });
  });
</script>

