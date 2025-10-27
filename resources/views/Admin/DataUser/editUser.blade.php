@extends('template.index')

@section('main')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Edit User</h5>
            </div>

            <div class="card-body">
                <form action="{{ route('data.user.update', $user->id) }}" method="POST" class="mx-auto"
                    style="max-width: 600px;">
                    @csrf
                    @method('PUT')

                    {{-- Nama --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}"
                            required>
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}"
                            required>
                    </div>

                      {{-- Email konfirm --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Konfirmasi Email</label>
                        <input type="email" name="email_address" class="form-control"
                            value="{{ old('email_address', $user->email_address) }}">
                    </div>

                    {{-- Role --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Role</label>
                        <select name="role" class="form-select" required>
                            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                    {{-- Tipe User --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tipe User</label>
                        <select name="tipe_user" class="form-select">
                            <option value="">-- Pilih Tipe User --</option>
                            <option value="pns" {{ $user->tipe_user == 'pns' ? 'selected' : '' }}>PNS</option>
                            <option value="p3k" {{ $user->tipe_user == 'p3k' ? 'selected' : '' }}>P3K</option>
                            <option value="phl" {{ $user->tipe_user == 'phl' ? 'selected' : '' }}>PHL</option>
                        </select>
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

                    {{-- NIP --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">NIP</label>
                        <input type="text" name="nip" class="form-control" value="{{ old('nip', $user->nip) }}">
                    </div>

                    {{-- Unit / Fakultas --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Unit / Fakultas</label>
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
                        <label class="form-label fw-bold">Jabatan</label>
                        <input type="text" name="jabatan" class="form-control"
                            value="{{ old('jabatan', $user->jabatan) }}">
                    </div>

                    {{-- Lokasi Presensi --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Lokasi Presensi</label>
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

                    {{-- Contact Phone --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">No. HP</label>
                        <input type="text" name="contact_phone" class="form-control"
                            value="{{ old('contact_phone', $user->contact_phone) }}">
                    </div>

                  

                    {{-- Tempat Lahir --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control"
                            value="{{ old('tempat_lahir', $user->tempat_lahir) }}">
                    </div>

                    {{-- Tanggal Lahir --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control"
                            value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}">
                    </div>

                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="{{ route('data.user') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection
