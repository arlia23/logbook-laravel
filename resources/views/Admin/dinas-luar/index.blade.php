@extends('template.index')

@section('main')
<style>
    table td,
    table th {
        white-space: nowrap;
        vertical-align: middle;
    }

    .table-wrapper {
        overflow-x: auto;
        white-space: nowrap;
    }
</style>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-semibold">📋 Data Dinas Luar Pegawai</h4>
    </div>

    {{-- 🔍 FILTER SECTION --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.dinas-luar.index') }}" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Nama Pegawai</label>
                    <select name="nama" class="form-select">
                        <option value="">-- Semua Pegawai --</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->name }}" {{ request('nama') == $user->name ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Bulan</label>
                    <select name="bulan" class="form-select">
                        <option value="">-- Semua Bulan --</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Tahun</label>
                    <select name="tahun" class="form-select">
                        <option value="">-- Semua Tahun --</option>
                        @for ($y = date('Y'); $y >= 2020; $y--)
                            <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Filter
                    </button>
                    <a href="{{ route('admin.dinas-luar.index') }}" class="btn btn-secondary w-100">
                        <i class="bi bi-arrow-repeat"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- ✅ Tabel Data Dinas Luar --}}
    <div class="table-wrapper shadow-sm rounded">
        <table class="table table-bordered table-hover align-middle" style="min-width: 1300px;">
            <thead class="table-primary text-center">
                <tr>
                    <th style="width: 5%;">No</th>
                    <th>Nama Pegawai</th>
                    <th>Email</th>
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
                @forelse ($data as $index => $item)
                    <tr>
                        <td>{{ $index + $data->firstItem() }}</td>
                        <td>{{ $item->user->name ?? '-' }}</td>
                        <td>{{ $item->user->email ?? '-' }}</td>
                        <td>{{ $item->nama_kegiatan }}</td>
                        <td>{{ $item->lokasi_kegiatan }}</td>
                        <td>{{ $item->tanggal_mulai ?? $item->tgl_mulai }}</td>
                        <td>{{ $item->tanggal_selesai ?? $item->tgl_selesai }}</td>
                        <td>{{ $item->no_surat_tugas }}</td>
                        <td>{{ $item->tgl_surat_tugas }}</td>
                        <td>{{ $item->jenis_tugas }}</td>
                        <td>
                            @if ($item->file_surat_tugas)
                                <a href="{{ asset('storage/' . $item->file_surat_tugas) }}" target="_blank"
                                   class="btn btn-sm btn-outline-primary">Lihat</a>
                            @else
                                <span class="text-muted">Tidak ada</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                {{-- Tombol Edit --}}
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $item->id }}">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </button>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('admin.dinas-luar.destroy', $item->id) }}" method="POST"
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

                    {{-- ✅ Modal Edit --}}
                    <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1"
                         aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content shadow-lg">
                                <form action="{{ route('admin.dinas-luar.update', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="modal-header bg-warning">
                                        <h5 class="modal-title" id="editModalLabel{{ $item->id }}">
                                            Edit Data Dinas Luar
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Nama Pegawai</label>
                                            <input type="text" class="form-control"
                                                   value="{{ $item->user->name ?? '-' }}" readonly>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Alasan</label>
                                            <input type="text" name="alasan" value="{{ $item->alasan }}"
                                                   class="form-control" required>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col">
                                                <label class="form-label fw-semibold">Tanggal Mulai</label>
                                                <input type="date" name="tanggal_mulai"
                                                       value="{{ $item->tanggal_mulai ?? $item->tgl_mulai }}"
                                                       class="form-control" required>
                                            </div>
                                            <div class="col">
                                                <label class="form-label fw-semibold">Tanggal Selesai</label>
                                                <input type="date" name="tanggal_selesai"
                                                       value="{{ $item->tanggal_selesai ?? $item->tgl_selesai }}"
                                                       class="form-control" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="12" class="text-muted">Belum ada data dinas luar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ✅ Pagination --}}
    <div class="mt-3 d-flex justify-content-end">
        {{ $data->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
