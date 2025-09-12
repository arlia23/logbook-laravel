@extends('template.index')

@section('main')
    <h1 class="mb-4">Detail Logbook</h1>

    <table class="table table-bordered">
        <tr>
            <th>Nama User</th>
            <td>{{ $logbook->user->name }}</td>
        </tr>
        <tr>
            <th>Tanggal</th>
            <td>{{ $logbook->tanggal }}</td>
        </tr>
        <tr>
            <th>Kegiatan</th>
            <td>{{ $logbook->kegiatan }}</td>
        </tr>
        <tr>
            <th>Catatan Pekerjaan</th>
            <td>{{ $logbook->catatan_pekerjaan ?? '-' }}</td>
        </tr>
        <tr>
            <th>Jam Masuk</th>
            <td>{{ $logbook->jam_masuk }}</td>
        </tr>
        <tr>
            <th>Jam Pulang</th>
            <td>{{ $logbook->jam_pulang }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>{{ $logbook->status }}</td>
        </tr>
    </table>

    <a href="{{ route('admin.logbook.index') }}" class="btn btn-secondary">Kembali</a>
@endsection
