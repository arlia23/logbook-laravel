@extends('template.index')

@section('main')
<h1 class="mb-4">Kelola Logbook</h1>

<form method="GET" class="mb-3">
    <div class="row">
        <div class="col-md-3">
            <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
        </div>
        <div class="col-md-3">
            <select name="user_id" class="form-control">
                <option value="">-- Semua User --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary">Filter</button>
        </div>
    </div>
</form>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nama User</th>
            <th>Tanggal</th>
            <th>Kegiatan</th>
            <th>Catatan Pekerjaan</th>
            <th>Jam Masuk</th>
            <th>Jam Pulang</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($logbooks as $logbook)
        <tr>
            <td>{{ $logbook->user->name }}</td>
            <td>{{ $logbook->tanggal }}</td>
            <td>{{ Str::limit($logbook->kegiatan, 50) }}</td>
            <td>{{ $logbook->catatan_pekerjaan ?? '-' }}</td>
            <td>{{ $logbook->jam_masuk }}</td>
            <td>{{ $logbook->jam_pulang }}</td>
            <td>{{ $logbook->status }}</td>
            <td>
                <a href="{{ route('admin.logbook.show', $logbook) }}" class="btn btn-info btn-sm">Detail</a>
                <form action="{{ route('admin.logbook.destroy', $logbook) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus logbook?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm">Hapus</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="8" class="text-center">Belum ada logbook</td>
        </tr>
        @endforelse
    </tbody>
</table>

{{ $logbooks->links() }}
@endsection
