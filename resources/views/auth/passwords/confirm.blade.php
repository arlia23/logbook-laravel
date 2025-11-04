{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Confirm Password') }}</div>

                <div class="card-body">
                    {{ __('Please confirm your password before continuing.') }}

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Confirm Password') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}

@extends('layouts.auth') {{-- gunakan layout Sneat --}}

@section('title', 'Konfirmasi Password')

@section('content')
<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-4">
            <!-- Confirm Password Card -->
            <div class="card">
                <div class="card-body">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center mb-4">
                        <a href="{{ url('/') }}" class="app-brand-link gap-2">
                            <span class="app-brand-logo demo">
                                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" width="40">
                            </span>
                            <span class="app-brand-text demo text-body fw-bold">Trashsmart</span>
                        </a>
                    </div>

                    <h4 class="mb-2 text-center">Konfirmasi Password 🔒</h4>
                    <p class="mb-4 text-center">Silakan masukkan password Anda sebelum melanjutkan.</p>

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="mb-3 form-password-toggle">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group input-group-merge">
                                <input 
                                    id="password" 
                                    type="password" 
                                    class="form-control @error('password') is-invalid @enderror" 
                                    name="password" 
                                    required 
                                    autocomplete="current-password"
                                    placeholder="••••••••"
                                >
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary d-grid w-100">
                            Konfirmasi Password
                        </button>

                        @if (Route::has('password.request'))
                            <p class="text-center mt-3">
                                <a href="{{ route('password.request') }}">Lupa Password?</a>
                            </p>
                        @endif
                    </form>
                </div>
            </div>
            <!-- /Confirm Password Card -->
        </div>
    </div>
</div>
@endsection

