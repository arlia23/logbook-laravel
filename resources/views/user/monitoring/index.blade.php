@extends('template.index') {{-- Sesuaikan dengan layout utama kamu --}}

@section('main')
    <div class="container">
        <h4>Catatan dari Supervisor</h4>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Minggu Mulai</th>
                    <th>Minggu Selesai</th>
                    <th>Catatan Supervisor</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($monitorings as $monitoring)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($monitoring->minggu_mulai)->format('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($monitoring->minggu_selesai)->format('d M Y') }}</td>
                        <td>{{ $monitoring->catatan_supervisor ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">Belum ada catatan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
