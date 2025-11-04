@extends('template.index')

@section('main')
<div class="container mt-4">
  <h5 class="fw-bold mb-4">📊 Rekap Izin Saat Hadir per Bulan</h5>

  {{-- ✅ Filter Form --}}
  <form action="{{ route('user.izinsaathadir.rekap') }}" method="GET" class="row g-3 mb-4 align-items-end">
    <div class="col-md-3">
      <label class="form-label">Nama Pegawai</label>
      <input type="text" name="search" class="form-control" placeholder="Cari nama..." value="{{ request('search') }}">
    </div>
    <div class="col-md-3">
      <label class="form-label">Bulan</label>
      <select name="bulan" class="form-select">
        <option value="">-- Semua Bulan --</option>
        @foreach(range(1, 12) as $b)
          <option value="{{ $b }}" {{ request('bulan') == $b ? 'selected' : '' }}>
            {{ \Carbon\Carbon::create()->month($b)->translatedFormat('F') }}
          </option>
        @endforeach
      </select>
    </div>
    <div class="col-md-3">
      <label class="form-label">Tahun</label>
      <select name="tahun" class="form-select">
        @for($t = date('Y'); $t >= date('Y') - 3; $t--)
          <option value="{{ $t }}" {{ request('tahun') == $t ? 'selected' : '' }}>{{ $t }}</option>
        @endfor
      </select>
    </div>
    <div class="col-md-3 text-end">
      <button type="submit" class="btn btn-primary">
        <i class="bx bx-search me-1"></i> Filter
      </button>
      
    </div>
  </form>

  {{-- ✅ Card Rekapan --}}
  <div class="card border-0 shadow-sm">
    <div class="card-body">
      <h6 class="fw-bold mb-3">Daftar Pegawai Berdasarkan Jumlah Izin Saat Hadir</h6>
      <div class="table-responsive">
        <table class="table table-striped align-middle">
          <thead style="background-color: #e2e5fd;">
            <tr>
              <th>No</th>
              <th>Nama Pegawai</th>
              <th>Total Izin</th>
              <th>Total Durasi (Jam)</th>
            </tr>
          </thead>
          <tbody>
            @forelse($rekaps as $index => $r)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $r->name }}</td>
                <td>{{ $r->total_izin ?? 0 }}</td>
                <td>{{ number_format($r->total_durasi ?? 0, 2) }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="text-center text-muted py-3">
                  Tidak ada data izin pada periode ini.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
