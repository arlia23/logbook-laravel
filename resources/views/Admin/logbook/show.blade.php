@extends('template.index')

@section('main')
    <h1 class="mb-4">Detail Logbook</h1>

    <table class="table table-bordered">
        <tr>
            <th style="width: 200px;">Nama User</th>
            <td>{{ $logbook->user->name }}</td>
        </tr>
        <tr>
            <th>Tanggal</th>
            <td>{{ $logbook->tanggal }}</td>
        </tr>
        <tr>
            <th>Kegiatan</th>
            <td>{{ $logbook->kegiatan ?? '-' }}</td>
        </tr>
        <tr>
            <th>Catatan Pekerjaan</th>
            <td>
                @php
                    $catatan = $logbook->catatan_pekerjaan;
                    $decoded = null;
                    if ($catatan && is_string($catatan)) {
                        $decoded = json_decode($catatan, true);
                    }
                @endphp

                @if(is_array($decoded))
                    <div class="border rounded p-2" style="background-color: #fafafa;">
                        <ul class="list-unstyled mb-0">
                            @foreach($decoded as $item)
                                <li class="d-flex justify-content-between align-items-center border-bottom py-1">
                                    <span>{{ $item['kegiatan'] ?? '-' }}</span>
                                    @if(isset($item['status']) && strtolower($item['status']) == 'selesai')
                                        <span class="badge bg-success">{{ ucfirst($item['status']) }}</span>
                                    @else
                                        <span class="badge bg-warning text-dark">{{ $item['status'] ?? 'Belum' }}</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @elseif($catatan)
                    {{-- Jika bukan JSON --}}
                    <div class="p-2">{{ $catatan }}</div>
                @else
                    <span class="text-muted">-</span>
                @endif
            </td>
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
            <td>
                @if(strtolower($logbook->status) == 'selesai')
                    <span class="badge bg-success">Selesai</span>
                @else
                    <span class="badge bg-secondary">{{ ucfirst($logbook->status) }}</span>
                @endif
            </td>
        </tr>
    </table>

    <a href="{{ route('admin.logbook.index') }}" class="btn btn-secondary">Kembali</a>
@endsection
