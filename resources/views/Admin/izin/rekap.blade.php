@extends('template.index')

@section('title', 'Rekap Izin Saat Hadir per Bulan')

@section('main')
<div class="container py-4">
     <h4 class="fw-bold mb-4 d-flex align-items-center">
                📊 Rekap Izin Saat Hadir per Bulan
            </h4>
    <div class="card shadow-sm border-0">
        <div class="card-body">

            {{-- Filter --}}
            <form method="GET" class="row g-3 align-items-center mb-4">
                <div class="col-md-4">
                    <label class="form-label mb-1 fw-semibold">Nama Pegawai</label>
                    <input type="text" name="nama" value="{{ request('nama') }}" class="form-control"
                        placeholder="Cari nama...">
                </div>

                <div class="col-md-3">
                    <label class="form-label mb-1 fw-semibold">Bulan</label>
                    <select name="bulan" class="form-select">
                        <option value="">-- Semua Bulan --</option>
                        @foreach(range(1, 12) as $b)
                            <option value="{{ $b }}" {{ request('bulan') == $b ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $b)->format('F') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label mb-1 fw-semibold">Tahun</label>
                    <select name="tahun" class="form-select">
                        @foreach(range(date('Y') - 2, date('Y') + 1) as $t)
                            <option value="{{ $t }}" {{ request('tahun', date('Y')) == $t ? 'selected' : '' }}>
                                {{ $t }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-primary w-100 d-flex align-items-center justify-content-center shadow-sm mt-6">
                        <i class="bx bx-search me-1"></i> Filter
                    </button>
                </div>
            </form>

            {{-- Judul tabel --}}
            <h6 class="fw-bold mt-7">📋 Daftar Pegawai Berdasarkan Jumlah Izin Saat Hadir</h6>

            {{-- Tabel Data --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center mb-0">
                    <thead style="background-color: #E9E4FF;">
                        <tr class="align-middle">
                            <th style="width: 60px;">NO</th>
                            <th>NAMA PEGAWAI</th>
                            <th>TOTAL IZIN</th>
                            <th>TOTAL DURASI (JAM)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rekaps as $i => $r)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td class="fw-semibold">{{ $r->name }}</td>
                                <td>{{ $r->total_izin }}</td>
                                <td>{{ number_format($r->total_durasi, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-muted py-3">Tidak ada data ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Tambahan CSS untuk sentuhan lembut --}}
<style>
    table thead th {
        color: #3c3c3c;
        font-weight: 600;
    }
    table tbody tr:nth-child(even) {
        background-color: #f9f9ff;
    }
    .table th, .table td {
        vertical-align: middle;
    }
</style>
@endsection
