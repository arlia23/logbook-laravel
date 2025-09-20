@extends('template.index')

@section('main')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card mb-4 mx-auto shadow-sm" style="max-width: 600px; border-radius: 12px;">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Profil Saya</h5>
            <a href="{{ route('user.profile.edit') }}" class="btn btn-primary btn-sm">
                <i class="bx bx-edit-alt"></i> Edit Profil
            </a>
        </div>

        <div class="card-body">
            {{-- Notifikasi sukses --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- Tampilkan data user --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Nama</label>
                <div class="form-control bg-light">{{ $user->name }}</div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Email</label>
                <div class="form-control bg-light">{{ $user->email }}</div>
            </div>

            @if($user->nip)
            <div class="mb-3">
                <label class="form-label fw-bold">NIP</label>
                <div class="form-control bg-light">{{ $user->nip }}</div>
            </div>
            @endif

            @if($user->unit_fakultas)
            <div class="mb-3">
                <label class="form-label fw-bold">Unit / Fakultas</label>
                <div class="form-control bg-light">{{ $user->unit_fakultas }}</div>
            </div>
            @endif

            @if($user->jabatan)
            <div class="mb-3">
                <label class="form-label fw-bold">Jabatan</label>
                <div class="form-control bg-light">{{ $user->jabatan }}</div>
            </div>
            @endif

            @if($user->lokasi_presensi)
            <div class="mb-3">
                <label class="form-label fw-bold">Lokasi Presensi</label>
                <div class="form-control bg-light">{{ $user->lokasi_presensi }}</div>
            </div>
            @endif

            @if($user->contact_phone)
            <div class="mb-3">
                <label class="form-label fw-bold">Nomor HP</label>
                <div class="form-control bg-light">{{ $user->contact_phone }}</div>
            </div>
            @endif

            @if($user->email_address)
            <div class="mb-3">
                <label class="form-label fw-bold">Email Lain</label>
                <div class="form-control bg-light">{{ $user->email_address }}</div>
            </div>
            @endif

            @if($user->tempat_lahir)
            <div class="mb-3">
                <label class="form-label fw-bold">Tempat Lahir</label>
                <div class="form-control bg-light">{{ $user->tempat_lahir }}</div>
            </div>
            @endif

            @if($user->tanggal_lahir)
            <div class="mb-3">
                <label class="form-label fw-bold">Tanggal Lahir</label>
                <div class="form-control bg-light">
                    {{ \Carbon\Carbon::parse($user->tanggal_lahir)->translatedFormat('d F Y') }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
