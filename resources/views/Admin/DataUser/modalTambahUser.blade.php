{{-- Modal Tambah User --}}
<div class="modal fade" id="tambahUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('create.user') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah User Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    {{-- Nama --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>

                     {{-- Email konfirm --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Konfirmasi Email</label>
                        <input type="email" name="email_address" class="form-control"
                            value="{{ old('email_address') }}">
                    </div>

                    {{-- Password --}}
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label for="password" class="form-label fw-bold">Password Baru</label>
                        </div>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label for="password_confirmation" class="form-label fw-bold">Konfirmasi Password</label>
                        </div>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="form-control" required>
                    </div>


                    {{-- Role --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Role</label>
                        <select name="role" class="form-select" required>
                            <option value="user" selected>User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                    {{-- Tipe User --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tipe User (Opsional)</label>
                        <select name="tipe_user" class="form-select">
                            <option value="">-- Pilih Tipe User --</option>
                            <option value="pns" {{ old('tipe_user') == 'pns' ? 'selected' : '' }}>PNS</option>
                            <option value="p3k" {{ old('tipe_user') == 'p3k' ? 'selected' : '' }}>P3K</option>
                            <option value="phl" {{ old('tipe_user') == 'phl' ? 'selected' : '' }}>PHL</option>
                        </select>
                    </div>

                    {{-- NIP --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">NIP</label>
                        <input type="text" name="nip" class="form-control" value="{{ old('nip') }}">
                    </div>

                    {{-- Unit / Fakultas --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Unit / Fakultas</label>
                        <select name="unit_fakultas" class="form-select">
                            <option value="">-- Pilih Unit / Fakultas --</option>
                            @foreach (['BIRO AKADEMIS KEMAHASISWAAN', 'BIRO PERENCANAAN DAN HUBUNGAN MASYARAKAT', 'BIRO UMUM KEUANGAN', 'Fakultas Ekonomi dan Bisnis', 'Fakultas Hukum', 'Fakultas Ilmu Sosial dan Ilmu Politik', 'Fakultas Kedokteran', 'Fakultas Keguruan dan Ilmu Pendidikan', 'Fakultas Keperawatan', 'Fakultas Matematika dan Ilmu Pengetahuan Alam', 'Fakultas Perikanan dan Kelautan', 'Fakultas Pertanian', 'Fakultas Teknik', 'KANTOR URUSAN INTERNASIONAL', 'LPPM', 'LPPMP', 'P2K2', 'PASCASARJANA', 'Rektorat', 'RSP', 'Satuan Pengawas Internal', 'Security', 'UPA Bahasa', 'UPA Bimbingan Konseling', 'UPA Laboratorium Terpadu', 'UPA Layanan Uji Kompetensi', 'UPA Pengembangan Karir dan Kewirausahaan', 'UPA Percetakan dan Penerbitan', 'UPA Perpustakaan', 'UPA Teknologi Informasi dan Komunikasi'] as $unit)
                                <option value="{{ $unit }}"
                                    {{ old('unit_fakultas') == $unit ? 'selected' : '' }}>
                                    {{ $unit }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Jabatan --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Jabatan</label>
                        <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan') }}">
                    </div>

                    {{-- Lokasi Presensi --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Lokasi Presensi</label>
                        <select name="lokasi_presensi" class="form-select" required>
                            <option value="">-- Pilih Lokasi Presensi --</option>
                            @foreach (['FEB', 'FH', 'FISIP', 'FK', 'FKIP', 'FKp', 'FMIPA', 'FP', 'FPK', 'FT', 'LPPM', 'LPPMP', 'Pascasarjana', 'Rektorat', 'RSP', 'UPT Bahasa', 'UPT Pustaka', 'UPT TIK'] as $lokasi)
                                <option value="{{ $lokasi }}"
                                    {{ old('lokasi_presensi') == $lokasi ? 'selected' : '' }}>
                                    {{ $lokasi }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- No. HP --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">No. HP</label>
                        <input type="text" name="contact_phone" class="form-control"
                            value="{{ old('contact_phone') }}">
                    </div>

                   

                    {{-- Tempat Lahir --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control"
                            value="{{ old('tempat_lahir') }}">
                    </div>

                    {{-- Tanggal Lahir --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control"
                            value="{{ old('tanggal_lahir') }}">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah User</button>
                </div>
            </form>
        </div>
    </div>
</div>
