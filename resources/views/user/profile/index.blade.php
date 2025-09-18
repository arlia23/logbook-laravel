@extends('template.index')

@section('main')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Profil Saya</h5>
            <a href="{{ route('user.profile.edit') }}" class="btn btn-primary btn-sm">
                <i class="bx bx-edit-alt"></i> Edit Profil
            </a>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="mb-3">
                <label class="form-label fw-bold">Nama</label>
                <div class="form-control">{{ $user->name }}</div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Email</label>
                <div class="form-control">{{ $user->email }}</div>
            </div>

            @if($user->tipe_user)
            <div class="mb-3">
                <label class="form-label fw-bold">Tipe User</label>
                <div class="form-control text-capitalize">{{ $user->tipe_user }}</div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
