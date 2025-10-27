@extends('template.index')

@section('main')
<div class="container mt-4">

    <h4 class="mb-4 fw-semibold">📝 Catatan dari Supervisor</h4>

    <div class="table-responsive shadow-sm rounded-3">
        <table class="table table-bordered align-middle text-center table-hover mb-0">
            <thead style="background-color: #d8d6f9;" class="fw-semibold text-dark">
                <tr>
                    <th style="width: 60px;">No</th>
                    <th>Minggu Mulai</th>
                    <th>Minggu Selesai</th>
                    <th>Catatan Supervisor</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($monitorings as $index => $monitoring)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($monitoring->minggu_mulai)->format('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($monitoring->minggu_selesai)->format('d M Y') }}</td>
                        <td class="text-start">{{ $monitoring->catatan_supervisor ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-3">Belum ada catatan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

{{-- Sedikit tambahan gaya agar tabel tampak lebih halus --}}
<style>
    table.table th {
        background: linear-gradient(to bottom right, #d8d6f9, #c9c6ff);
        color: #3d3b60;
    }
    table.table td {
        vertical-align: middle;
    }
    table.table tbody tr:hover {
        background-color: #f5f3ff;
        transition: 0.2s;
    }
</style>
@endsection
