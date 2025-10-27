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

<table class="table table-bordered table-striped align-middle">
    <thead class="table-light">
        <tr>
            <th>No</th>
            <th>Nama User</th>
            <th>Tanggal</th>
            <th>Kegiatan</th>
            <th>Catatan Pekerjaan</th>
            <th>Jam Masuk</th>
            <th>Jam Pulang</th>
            <th>Status</th>
            <th style="width: 150px;">Aksi</th>
        </tr>
    </thead>
    <tbody>
    @forelse($logbooks as $index => $logbook)
        <tr>
            <td>{{ $logbooks->firstItem() + $index }}</td>
            <td>{{ $logbook->user->name }}</td>
            <td>{{ $logbook->tanggal }}</td>
            <td>
                @if($logbook->kegiatan)
                    <span class="badge bg-primary">{{ $logbook->kegiatan }}</span>
                @else
                    <span class="text-muted">-</span>
                @endif
            </td>

            {{-- ===========================
                 CATATAN PEKERJAAN
            ============================ --}}
            <td>
                @php
                    $catatan = $logbook->catatan_pekerjaan;
                    $decoded = null;
                    if ($catatan && is_string($catatan)) {
                        $decoded = json_decode($catatan, true);
                    }
                @endphp

                @if(is_array($decoded))
                    <table class="table table-sm mb-0 custom-table">
                        <thead>
                            <tr>
                                <th style="width: 70%; padding: 6px 12px;">Catatan</th>
                                <th style="width: 30%; padding: 6px 12px;" class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($decoded as $item)
                                <tr>
                                    <td style="padding: 6px 12px;">{{ $item['kegiatan'] ?? '-' }}</td>
                                    <td class="text-center" style="padding: 6px 12px;">
                                        @if(isset($item['status']) && strtolower($item['status']) == 'selesai')
                                            <span class="badge bg-success">Selesai</span>
                                        @else
                                            <span class="badge bg-warning text-dark">{{ $item['status'] ?? 'Belum' }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @elseif($catatan)
                    <div style="padding: 4px 8px;">{{ $catatan }}</div>
                @else
                    <span class="text-muted">-</span>
                @endif
            </td>

            <td>{{ $logbook->jam_masuk }}</td>
            <td>{{ $logbook->jam_pulang }}</td>
            <td>
                @if(strtolower($logbook->status) == 'selesai')
                    <span >Selesai</span>
                @else
                    <span >{{ ucfirst($logbook->status) }}</span>
                @endif
            </td>

            <td>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.logbook.show', $logbook) }}" class="btn btn-info btn-sm">
                        <i class="bx bx-show"></i> Detail
                    </a>
                    <form action="{{ route('admin.logbook.destroy', $logbook) }}" method="POST"
                          onsubmit="return confirm('Yakin hapus logbook ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">
                            <i class="bx bx-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="9" class="text-center text-muted">Belum ada logbook</td>
        </tr>
    @endforelse
    </tbody>
</table>

<div class="d-flex justify-content-between align-items-center mt-3">
    <div>
        <p class="mb-0 text-muted small">
            Menampilkan {{ $logbooks->firstItem() }} sampai {{ $logbooks->lastItem() }}
            dari total {{ $logbooks->total() }} data
        </p>
    </div>
    <div>
        {{ $logbooks->onEachSide(1)->links('pagination::bootstrap-5') }}
    </div>
</div>

{{-- Tambahkan CSS langsung di bawah --}}
<style>
    /* Hanya untuk tabel di dalam Catatan Pekerjaan */
    .custom-table {
        border-collapse: collapse;
        width: 100%;
    }
    .custom-table th, .custom-table td {
        border: none !important; /* Hilangkan semua garis */
    }
    .custom-table tr {
        border-bottom: 1px solid #777676 !important; /* Garis horizontal tebal dan gelap */
    }
    .custom-table thead tr {
        border-bottom: 1.5px solid #504f4f !important; /* Garis header lebih tebal */
    }
</style>
@endsection
