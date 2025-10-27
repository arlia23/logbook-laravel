@extends('template.index')

@section('title', 'Dashboard Data User')

@section('main')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Data User</h4>

    {{-- Alert --}}
    @if (Session::get('Sukses'))
        <div class="alert alert-success alert-dismissible" role="alert">
            {{ Session::get('Sukses') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if (Session::get('Delete'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            {{ Session::get('Delete') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Card Utama --}}
    <div class="card shadow-sm" style="margin-left: -26px;">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Tabel Data User</h5>

            {{-- Form Pencarian --}}
            <form action="{{ route('data.user') }}" method="GET" class="d-flex align-items-center gap-2">
                <input type="text" name="search" class="form-control form-control-sm"
                       placeholder="Cari berdasarkan nama..."
                       value="{{ request('search') }}"
                       style="width: 200px;">
                <button type="submit" class="btn btn-sm btn-outline-primary">
                    <i class="bx bx-search"></i> Cari
                </button>
            </form>

            {{-- Tombol Tambah --}}
            <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahUser">
                + Tambah User
            </a>
        </div>

        {{-- Tabel Data --}}
        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center mb-0 table-hover">
                <thead style="background-color: #e5e1ff;" class="fw-semibold text-dark">
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Konfirmasi Email</th>
                        <th>Tipe User</th>
                        <th>Role</th>
                        <th>NIP</th>
                        <th>Unit Fakultas</th>
                        <th>Jabatan</th>
                        <th>Lokasi Presensi</th>
                        <th>No. HP</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->email }}</td>
                            <td>{{ $row->email_address ?? '-' }}</td>
                            <td>{{ $row->tipe_user ?? '-' }}</td>
                            <td>{{ $row->role }}</td>
                            <td>{{ $row->nip ?? '-' }}</td>
                            <td>{{ $row->unit_fakultas ?? '-' }}</td>
                            <td>{{ $row->jabatan ?? '-' }}</td>
                            <td>{{ $row->lokasi_presensi ?? '-' }}</td>
                            <td>{{ $row->contact_phone ?? '-' }}</td>
                            <td>{{ $row->tempat_lahir ?? '-' }}</td>
                            <td>{{ $row->tanggal_lahir ?? '-' }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('data.user.edit', $row->id) }}" class="btn btn-sm btn-warning">
                                        <i class="bx bx-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#hapus{{ $row->id }}">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        {{-- Modal Hapus --}}
                        <div class="modal fade" id="hapus{{ $row->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('data.user.delete') }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-header">
                                            <h5 class="modal-title">Hapus User</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Yakin ingin menghapus user <strong>{{ $row->name }}</strong>?</p>
                                            <input type="hidden" name="id" value="{{ $row->id }}">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="14" class="text-center text-muted py-3">Belum ada data user.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Tambah User --}}
@include('Admin.DataUser.modalTambahUser')

{{-- Style tambahan --}}
<style>
    table th, table td {
        vertical-align: middle !important;
        text-align: center;
        white-space: nowrap;
    }
    table thead th {
        background: linear-gradient(to bottom right, #e5e1ff, #dcd8ff);
        color: #2e2a4d;
    }
    table tbody tr:hover {
        background-color: #f6f4ff;
        transition: 0.2s;
    }
</style>
@endsection
