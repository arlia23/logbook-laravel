@extends('template.index')

@section('title', 'Detail Presensi')

@section('main')
<div class="container">
    <h4 class="mb-3">📋 Detail Presensi: {{ $user->name }}</h4>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Jam Pulang</th>
                <th>Status Kehadiran</th>
            </tr>
        </thead>
        <tbody>
        @forelse($presensis as $p)
            <tr>
                <td>{{ $p->tanggal }}</td>
                <td>{{ $p->jam_masuk }}</td>
                <td>{{ $p->jam_pulang }}</td>
                <td>{{ $p->status_kehadiran }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center">Belum ada data presensi untuk user ini.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <a href="{{ route('admin.presensi.index') }}" class="btn btn-secondary">⬅ Kembali</a>
</div>
@endsection
