@extends('template.index')

@section('title', 'Dashboard Data Admin')

@section('main')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Data Admin</h4>

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
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Tabel Data Admin</h5>
            <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahAdmin">
                + Tambah Admin
            </a>
        </div>

        {{-- Tabel --}}
        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center table-hover mb-0">
                <thead style="background-color: #e5e1ff;" class="fw-semibold text-dark">
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th>Nama Admin</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th style="width: 120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($admins as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->email }}</td>
                            <td>{{ $row->role }}</td>
                            <td>
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#hapus{{ $row->id }}">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </td>
                        </tr>

                        {{-- Modal Hapus --}}
                        <div class="modal fade" id="hapus{{ $row->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('data.admin.delete') }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-header">
                                            <h5 class="modal-title">Hapus Admin</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Yakin ingin menghapus admin <strong>{{ $row->name }}</strong>?</p>
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
                            <td colspan="5" class="text-center text-muted py-3">Belum ada data admin.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Tambah Admin --}}
<div class="modal fade" id="tambahAdmin" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('create.admin') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Admin Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Admin</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Admin</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" required>
                            <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">
                                <i class="bx bx-show"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select" required>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Script Toggle Password --}}
<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const icon = event.currentTarget.querySelector('i');
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            icon.classList.replace('bx-show', 'bx-hide');
        } else {
            passwordInput.type = "password";
            icon.classList.replace('bx-hide', 'bx-show');
        }
    }
</script>

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
