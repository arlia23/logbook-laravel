@extends('template.index')

@section('title', 'Data Presensi')

@section('main')
<div class="container">
    <h4 class="mb-3">📌 Data Presensi Semua User</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama User</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Jam Pulang</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse($presensis as $p)
            <tr>
                <td>{{ $p->user->name ?? '-' }}</td>
                <td>{{ $p->tanggal }}</td>
                <td>{{ $p->jam_masuk }}</td>
                <td>{{ $p->jam_pulang }}</td>
                <td>{{ $p->status_kehadiran }}</td>
                <td>
                    <a href="{{ route('admin.presensi.show', $p->user_id) }}" class="btn btn-info btn-sm">
                        Detail
                    </a>
                    <form action="{{ route('admin.presensi.destroy', $p->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus presensi ini?')">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">Belum ada data presensi.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
