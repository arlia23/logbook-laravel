@extends('template.index')

@section('title', 'Kelola Cuti Pegawai')

@section('main')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">📋 Daftar Cuti Pegawai</h4>
    </div>

    <!-- 🔍 FILTER SECTION -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.cuti.index') }}" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Nama Pegawai</label>
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
                    <label class="form-label">Bulan</label>
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
                    <label class="form-label">Tahun</label>
                    <select name="tahun" class="form-select">
                        <option value="">-- Semua Tahun --</option>
                        @for ($y = date('Y'); $y >= 2020; $y--)
                            <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bx bx-search"></i> Filter
                    </button>
                    <a href="{{ route('admin.cuti.index') }}" class="btn btn-secondary w-100">
                        <i class="bx bx-refresh"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- 📋 TABLE SECTION -->
    <div class="card shadow-sm">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bx bx-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bx bx-error-circle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive text-nowrap">
                <table class="table table-bordered align-middle">
                    <thead style="background-color: #d4d4f6;">
                        <tr>
                            <th class="text-center" style="width: 50px;">No</th>
                            <th>Nama Pegawai</th>
                            <th>Jenis Cuti</th>
                            <th>Keterangan</th>
                            <th>Tgl Mulai</th>
                            <th>Tgl Selesai</th>
                            <th>No Surat Cuti</th>
                            <th>Tgl Surat Cuti</th>
                            <th class="text-center" style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($cuti as $index => $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $item->user->name ?? '-' }}</td>
                            <td>{{ $item->jenis_cuti }}</td>
                            <td>{{ Str::limit($item->keterangan, 50) }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tgl_mulai)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tgl_selesai)->format('d/m/Y') }}</td>
                            <td>{{ $item->no_surat_cuti }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tgl_surat_cuti)->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                                    <i class="bx bx-edit"></i> Edit
                                </button>
                                <form action="{{ route('admin.cuti.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bx bx-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-warning">
                                        <h5 class="modal-title">Edit Data Cuti</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('admin.cuti.update', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Jenis Cuti</label>
                                                    <input type="text" name="jenis_cuti" class="form-control" value="{{ $item->jenis_cuti }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">No Surat Cuti</label>
                                                    <input type="text" name="no_surat_cuti" class="form-control" value="{{ $item->no_surat_cuti }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Tanggal Mulai</label>
                                                    <input type="date" name="tgl_mulai" class="form-control" value="{{ $item->tgl_mulai }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Tanggal Selesai</label>
                                                    <input type="date" name="tgl_selesai" class="form-control" value="{{ $item->tgl_selesai }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Tanggal Surat Cuti</label>
                                                    <input type="date" name="tgl_surat_cuti" class="form-control" value="{{ $item->tgl_surat_cuti }}">
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="form-label">Keterangan</label>
                                                    <textarea name="keterangan" rows="3" class="form-control">{{ $item->keterangan }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">Tidak ada data cuti ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- PAGINATION -->
            <div class="mt-3">
                {{ $cuti->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
