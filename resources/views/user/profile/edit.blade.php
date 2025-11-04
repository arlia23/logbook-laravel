@extends('template.index')

@section('main')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Edit Profil</h5>
            </div>

            <div class="card-body">
                <form action="{{ route('user.profile.update') }}" method="POST" class="mx-auto" style="max-width: 600px;">
                    @csrf
                    @method('PUT')

                    {{-- Nama --}}
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">Nama</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}"
                            required>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}"
                            required>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- NIP --}}
                    <div class="mb-3">
                        <label for="nip" class="form-label fw-bold">NIP</label>
                        <input type="text" name="nip" class="form-control" value="{{ old('nip', $user->nip) }}">
                    </div>

                    {{-- Unit / Fakultas --}}
                    <div class="mb-3">
                        <label for="unit_fakultas" class="form-label fw-bold">Unit / Fakultas</label>
                        <select name="unit_fakultas" class="form-select">
                            <option value="">-- Pilih Unit / Fakultas --</option>
                            @foreach (['BIRO AKADEMIS KEMAHASISWAAN', 'BIRO PERENCANAAN DAN HUBUNGAN MASYARAKAT', 'BIRO UMUM KEUANGAN', 'Fakultas Ekonomi dan Bisnis', 'Fakultas Hukum', 'Fakultas Ilmu Sosial dan Ilmu Politik', 'Fakultas Kedokteran', 'Fakultas Keguruan dan Ilmu Pendidikan', 'Fakultas Keperawatan', 'Fakultas Matematika dan Ilmu Pengetahuan Alam', 'Fakultas Perikanan dan Kelautan', 'Fakultas Pertanian', 'Fakultas Teknik', 'KANTOR URUSAN INTERNASIONAL', 'LPPM', 'LPPMP', 'P2K2', 'PASCASARJANA', 'Rektorat', 'RSP', 'Satuan Pengawas Internal', 'Security', 'UPA Bahasa', 'UPA Bimbingan Konseling', 'UPA Laboratorium Terpadu', 'UPA Layanan Uji Kompetensi', 'UPA Pengembangan Karir dan Kewirausahaan', 'UPA Percetakan dan Penerbitan', 'UPA Perpustakaan', 'UPA Teknologi Informasi dan Komunikasi'] as $unit)
                                <option value="{{ $unit }}"
                                    {{ old('unit_fakultas', $user->unit_fakultas) == $unit ? 'selected' : '' }}>
                                    {{ $unit }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Jabatan --}}
                    <div class="mb-3">
                        <label for="jabatan" class="form-label fw-bold">Jabatan</label>
                        <input type="text" name="jabatan" class="form-control"
                            value="{{ old('jabatan', $user->jabatan) }}">
                    </div>

                    {{-- Lokasi Presensi --}}
                    <div class="mb-3">
                        <label for="lokasi_presensi" class="form-label fw-bold">Lokasi Presensi</label>
                        <select name="lokasi_presensi" class="form-select" required>
                            <option value="">-- Pilih Lokasi Presensi --</option>
                            @foreach (['FEB', 'FH', 'FISIP', 'FK', 'FKIP', 'FKp', 'FMIPA', 'FP', 'FPK', 'FT', 'LPPM', 'LPPMP', 'Pascasarjana', 'Rektorat', 'RSP', 'UPT Bahasa', 'UPT Pustaka', 'UPT TIK'] as $lokasi)
                                <option value="{{ $lokasi }}"
                                    {{ old('lokasi_presensi', $user->lokasi_presensi) == $lokasi ? 'selected' : '' }}>
                                    {{ $lokasi }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    {{-- Nomor HP --}}
                    <div class="mb-3">
                        <label for="contact_phone" class="form-label fw-bold">Nomor HP</label>
                        <input type="text" name="contact_phone" class="form-control"
                            value="{{ old('contact_phone', $user->contact_phone) }}">
                    </div>

                    {{-- Email konfirm --}}
                    <div class="mb-3">
                        <label for="email_address" class="form-label fw-bold">Konfirmasi Email</label>
                        <input type="email" name="email_address" class="form-control"
                            value="{{ old('email_address', $user->email_address) }}">
                    </div>

                    {{-- Tempat & Tanggal Lahir --}}
                    <div class="mb-3">
                        <label for="tempat_lahir" class="form-label fw-bold">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control"
                            value="{{ old('tempat_lahir', $user->tempat_lahir) }}">
                    </div>
                    {{-- Tanggal Lahir --}}
<div class="mb-3">
    <label for="tanggal_lahir" class="form-label fw-bold">Tanggal Lahir</label>
    <div class="input-group">
        <input type="text" id="tanggal_lahir" name="tanggal_lahir" class="form-control"
            value="{{ old('tanggal_lahir', $user->tanggal_lahir ? \Carbon\Carbon::parse($user->tanggal_lahir)->format('Y-m-d') : '') }}"
            placeholder="Pilih tanggal lahir" autocomplete="off">
        <span class="input-group-text"><i class="bx bx-calendar"></i></span>
    </div>
</div>

                    {{-- Password --}}
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label for="password" class="form-label fw-bold">Password Baru</label>
                            <small class="text-muted" style="color: red">*Kosongkan jika tidak ingin ganti password</small>
                        </div>
                        <input type="password" id="password" name="password" class="form-control">
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label for="password_confirmation" class="form-label fw-bold">Konfirmasi Password</label>
                            <small class="text-muted " style="color: red">*Kosongkan jika tidak ingin ganti password</small>
                        </div>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                    </div>


                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="{{ route('user.profile.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    {{-- Bootstrap Datepicker --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/locales/bootstrap-datepicker.id.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            $('#tanggal_lahir').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true,
                orientation: "bottom auto",
                language: 'id',
                startView: 2,      // langsung buka tampilan tahun
                minViewMode: 0,    // tampil mode bulan dan tanggal juga
                startDate: new Date(1950, 0, 1), // mulai dari tahun 1950
                endDate: new Date() // sampai tahun ini
            });
        });
    </script>
@endpush

