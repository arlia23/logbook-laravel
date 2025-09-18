<!doctype html>

<html lang="en" class="layout-wide customizer-hide" data-assets-path="{{ asset('template/') }}/"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Demo: Register Basic - Pages | Sneat - Bootstrap Dashboard FREE</title>

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

      <!-- Kolom kiri: form register -->
      <div class="col-lg-4 d-flex align-items-center justify-content-center bg-white">
        <div class="authentication-wrapper authentication-basic container-p-y w-100">
          <div class="authentication-inner">
            <!-- Register Card -->
            <div class="card px-sm-6 px-0 shadow-lg">
              <div class="card-body">
                <!-- Logo -->
                <div class="app-brand justify-content-center mb-6">
                  <a href="#" class="app-brand-link gap-2">
                    <span class="app-brand-logo demo">
                      <span class="text-primary">
                        <!-- SVG logo kamu -->
                      </span>
                    </span>
                    <span class="app-brand-text demo text-heading fw-bold">Sneat</span>
                  </a>
                </div>
                <!-- /Logo -->

                <h4 class="mb-1">Adventure starts here 🚀</h4>

                <form id="formAuthentication" class="mb-6" method="POST" action="{{ route('register') }}">
                  @csrf
                  
                  <!-- Name -->
                  <div class="mb-6">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                        id="name" name="name" value="{{ old('name') }}"
                        placeholder="Enter your full name" required autofocus />
                    @error('name')
                      <small class="text-danger">{{ $message }}</small>
                    @enderror
                  </div>

                  <!-- Email -->
                  <div class="mb-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                        id="email" name="email" value="{{ old('email') }}"
                        placeholder="Enter your email" required />
                    @error('email')
                      <small class="text-danger">{{ $message }}</small>
                    @enderror
                  </div>

                  <!-- Password -->
                  <div class="form-password-toggle mb-6">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-group input-group-merge">
                      <input type="password" id="password"
                          class="form-control @error('password') is-invalid @enderror"
                          name="password" placeholder="********" required />
                      <span class="input-group-text cursor-pointer"><i class="icon-base bx bx-hide"></i></span>
                    </div>
                    @error('password')
                      <small class="text-danger">{{ $message }}</small>
                    @enderror
                  </div>

                  <!-- Confirm Password -->
                  <div class="form-password-toggle mb-6">
                    <label class="form-label" for="password_confirmation">Confirm Password</label>
                    <div class="input-group input-group-merge">
                      <input type="password" id="password_confirmation" class="form-control"
                          name="password_confirmation" placeholder="********" required />
                      <span class="input-group-text cursor-pointer"><i class="icon-base bx bx-hide"></i></span>
                    </div>
                  </div>

                  <!-- Tipe User -->
                  <div class="mb-6">
                    <label for="tipe_user" class="form-label">Tipe User</label>
                    <select class="form-select @error('tipe_user') is-invalid @enderror" id="tipe_user"
                        name="tipe_user">
                      <option value="" selected disabled>Pilih tipe user</option>
                      <option value="pns">PNS</option>
                      <option value="p3k">P3K</option>
                      <option value="magang">Magang</option>
                      <option value="cleaning">Cleaning</option>
                    </select>
                    @error('tipe_user')
                      <small class="text-danger">{{ $message }}</small>
                    @enderror
                  </div>

                  <button class="btn btn-primary d-grid w-100" type="submit">Sign Up</button>
                </form>

                <p class="text-center">
                  <span>Already have an account?</span>
                  <a href="auth-login-basic.html"><span>Sign in instead</span></a>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Kolom kanan: gambar -->
      <div class="col-lg-8 d-none d-lg-flex align-items-center justify-content-center bg-primary">
        <img src="{{ asset('template/img/backgrounds/regis.png') }}"
             alt="Login Illustration"
             class="img-fluid w-75 object-fit-cover">
      </div>

    </div>
  </div>

  <!-- JS kamu tetap -->
</body>


</html>
