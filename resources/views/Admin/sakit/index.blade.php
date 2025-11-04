@extends('template.index')

@section('main')
<style>
    table td, table th {
        white-space: nowrap;
        vertical-align: middle;
    }

    .table-wrapper {
        overflow-x: auto;
        white-space: nowrap;
    }
</style>

<div class="container mt-4">

    {{-- 📋 HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-semibold">📋 Data Sakit Pegawai</h4>
    </div>

    {{-- 🔍 FILTER --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.sakit.index') }}" class="row g-3 align-items-end">
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
                            <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}"
                                {{ request('bulan') == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
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
                            <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Filter
                    </button>
                    <a href="{{ route('admin.sakit.index') }}" class="btn btn-secondary w-100">
                        <i class="bi bi-arrow-repeat"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- ✅ NOTIFIKASI --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- ✅ TABEL DATA SAKIT --}}
    <div class="table-wrapper shadow-sm rounded">
        <table class="table table-bordered table-hover align-middle" style="min-width: 1000px;">
            <thead class="table-primary text-center">
                <tr>
                    <th style="width: 5%;">No</th>
                    <th>Nama Pegawai</th>
                    <th>Keterangan</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>No Surat</th>
                    <th>Tanggal Surat</th>
                    <th style="width: 150px;">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @forelse($sakit as $index => $row)
                    <tr>
                        {{-- Gunakan firstItem() hanya jika pagination aktif --}}
                        <td>{{ method_exists($sakit, 'firstItem') ? $loop->iteration + $sakit->firstItem() - 1 : $loop->iteration }}</td>
                        <td>{{ $row->user->name ?? '-' }}</td>
                        <td>{{ $row->keterangan }}</td>
                        <td>{{ $row->tgl_mulai }}</td>
                        <td>{{ $row->tgl_selesai }}</td>
                        <td>{{ $row->no_surat_ket_sakit ?? '-' }}</td>
                        <td>{{ $row->tgl_surat_ket_sakit ?? '-' }}</td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                {{-- Tombol Edit --}}
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $row->id }}">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </button>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('admin.sakit.destroy', $row->id) }}" method="POST"
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

                    {{-- 📝 MODAL EDIT --}}
                    <div class="modal fade" id="editModal{{ $row->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content shadow-lg">
                                <form action="{{ route('admin.sakit.update', $row->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="modal-header bg-warning text-dark">
                                        <h5 class="modal-title">Edit Data Sakit</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Nama Pegawai</label>
                                            <input type="text" class="form-control" value="{{ $row->user->name ?? '-' }}" readonly>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Keterangan</label>
                                            <input type="text" name="keterangan" class="form-control"
                                                   value="{{ $row->keterangan }}" required>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold">Tanggal Mulai</label>
                                                <input type="date" name="tgl_mulai" class="form-control"
                                                       value="{{ $row->tgl_mulai }}" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold">Tanggal Selesai</label>
                                                <input type="date" name="tgl_selesai" class="form-control"
                                                       value="{{ $row->tgl_selesai }}" required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold">No Surat</label>
                                                <input type="text" name="no_surat_ket_sakit" class="form-control"
                                                       value="{{ $row->no_surat_ket_sakit }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold">Tanggal Surat</label>
                                                <input type="date" name="tgl_surat_ket_sakit" class="form-control"
                                                       value="{{ $row->tgl_surat_ket_sakit }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="8" class="text-muted">Belum ada data sakit.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ✅ PAGINATION --}}
    @if(method_exists($sakit, 'links'))
        <div class="mt-3 d-flex justify-content-end">
            {{ $sakit->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
