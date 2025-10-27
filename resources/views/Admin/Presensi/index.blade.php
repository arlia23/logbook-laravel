@extends('template.index')

@section('title', 'Data Presensi')

@section('main')
<div class="container">
    <h4 class="mb-3">📌 Data Presensi Semua User</h4>

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Filter --}}
    <form method="GET" class="mb-4">
        <div class="row g-2 align-items-end">
            <div class="col-md-3">
                <label for="user_id" class="form-label">Pilih User</label>
                <select name="user_id" id="user_id" class="form-control">
                    <option value="">-- Semua User --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ request('tanggal') }}">
            </div>

            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>

        </div>
    </form>

    {{-- Tabel --}}
    <table class="table align-middle table-striped table-bordered">
        <thead class="table-light">
            <tr>
                <th style="width: 60px;">No</th>
                <th>Nama User</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Jam Pulang</th>
                <th>Status</th>
                <th style="width: 150px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse($presensis as $index => $p)
            <tr>
                <td>{{ $presensis->firstItem() + $index }}</td>
                <td>{{ $p->user->name ?? '-' }}</td>
                <td>{{ $p->tanggal }}</td>
                <td>{{ $p->jam_masuk }}</td>
                <td>{{ $p->jam_pulang }}</td>
                <td>
                    @if(strtolower($p->status_kehadiran) == 'hadir')
                        <span class="badge bg-success">Hadir</span>
                    @elseif(strtolower($p->status_kehadiran) == 'izin')
                        <span class="badge bg-warning text-dark">Izin</span>
                    @elseif(strtolower($p->status_kehadiran) == 'sakit')
                        <span class="badge bg-info text-dark">Sakit</span>
                    @else
                        <span class="badge bg-secondary">{{ ucfirst($p->status_kehadiran ?? '-') }}</span>
                    @endif
                </td>
                <td>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.presensi.show', $p->user_id) }}" class="btn btn-info btn-sm">
                            Detail
                        </a>
                        <form action="{{ route('admin.presensi.destroy', $p->id) }}" method="POST"
                              onsubmit="return confirm('Hapus presensi ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center text-muted">Belum ada data presensi.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="d-flex justify-content-between align-items-center mt-3">
        <div>
            <p class="mb-0 text-muted small">
                Menampilkan {{ $presensis->firstItem() ?? 0 }} sampai {{ $presensis->lastItem() ?? 0 }}
                dari total {{ $presensis->total() ?? 0 }} data
            </p>
        </div>
        <div>
            {{ $presensis->onEachSide(1)->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
