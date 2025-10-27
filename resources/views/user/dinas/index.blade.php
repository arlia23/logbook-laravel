@extends('template.index')

@section('main')
    {{-- ✅ SweetAlert untuk pesan error --}}
    @if ($errors->any())
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ $errors->first() }}",
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    <style>
        /* ✅ Pastikan semua kolom tampil sebaris tanpa patah */
        table td,
        table th {
            white-space: nowrap;
            vertical-align: middle;
        }

        /* ✅ Biar tabel bisa discroll kalau terlalu lebar */
        .table-wrapper {
            overflow-x: auto;
            white-space: nowrap;
        }
    </style>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-semibold">📋 Data Dinas Luar</h4>
            <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalDinasLuar">
                + Input Data Dinas Luar
            </button>
        </div>

        {{-- ✅ Tabel Data Dinas Luar --}}
        <div class="table-wrapper shadow-sm rounded">
            <table class="table table-bordered table-hover align-middle" style="min-width: 1300px;">
                <thead class="table-primary text-center">
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th>Nama Pegawai</th>
                        <th>Nama Kegiatan</th>
                        <th>Lokasi</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>No Surat Tugas</th>
                        <th>Tanggal Surat Tugas</th>
                        <th>Jenis Tugas</th>
                        <th>File</th>
                        <th style="width: 130px;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @forelse ($dinasLuar as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->nama_pegawai }}</td>
                            <td>{{ $item->nama_kegiatan }}</td>
                            <td>{{ $item->lokasi_kegiatan }}</td>
                            <td>{{ $item->tgl_mulai }}</td>
                            <td>{{ $item->tgl_selesai }}</td>
                            <td>{{ $item->no_surat_tugas }}</td>
                            <td>{{ $item->tgl_surat_tugas }}</td>
                            <td>{{ $item->jenis_tugas }}</td>
                            <td>
                                @if ($item->file_surat_tugas)
                                    <a href="{{ asset('storage/' . $item->file_surat_tugas) }}"
                                       target="_blank"
                                       class="btn btn-sm btn-outline-primary">
                                        Lihat
                                    </a>
                                @else
                                    <span class="text-muted">Tidak ada</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('user.dinas.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <form action="{{ route('user.dinas.destroy', $item->id) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-muted">Belum ada data dinas luar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ✅ Modal Input Data Dinas Luar --}}
    <div class="modal fade" id="modalDinasLuar" tabindex="-1" aria-labelledby="modalDinasLuarLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content shadow-lg">
                <form action="{{ route('user.dinas.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header ">
                        <h5 class="modal-title" id="modalDinasLuarLabel">Input Data Dinas Luar</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Pegawai</label>
                            <input type="text" name="nama_pegawai" class="form-control"
                                   value="{{ auth()->user()->name }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Kegiatan</label>
                            <input type="text" name="nama_kegiatan" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Lokasi Kegiatan</label>
                            <input type="text" name="lokasi_kegiatan" class="form-control" required>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label fw-semibold">Tanggal Mulai</label>
                                <input type="date" id="tgl_mulai" name="tgl_mulai" class="form-control"
                                       min="{{ now()->format('Y-m-d') }}" required>
                            </div>
                            <div class="col">
                                <label class="form-label fw-semibold">Tanggal Selesai</label>
                                <input type="date" id="tgl_selesai" name="tgl_selesai" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">No Surat Tugas</label>
                            <input type="text" name="no_surat_tugas" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tanggal Surat Tugas</label>
                            <input type="date" name="tgl_surat_tugas" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Jenis Tugas</label>
                            <select name="jenis_tugas" class="form-select" required>
                                <option value="">-- Pilih Jenis Tugas --</option>
                                <option value="ST Luar Kota">ST Luar Kota</option>
                                <option value="ST Dalam Kota">ST Dalam Kota - Absen Online</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">File Surat Tugas (PDF/JPG/PNG, max 400KB)</label>
                            <input type="file" name="file_surat_tugas" class="form-control">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ✅ Script validasi tanggal --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const tglMulai = document.getElementById("tgl_mulai");
            const tglSelesai = document.getElementById("tgl_selesai");

            tglMulai.addEventListener("change", function () {
                tglSelesai.min = this.value;
                if (tglSelesai.value < this.value) {
                    tglSelesai.value = this.value;
                }
            });
        });
    </script>
@endsection
