@extends('template.index')

@section('title', 'Logbook')

@section('main')
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
      <h5 class="mb-0">Log Book</h5>

      {{-- 🔽 Filter Otomatis --}}
      <form method="GET" action="{{ route('logbook.index') }}" id="filterForm" class="d-flex align-items-center gap-2">

          {{-- Bulan --}}
          <select name="bulan" class="form-select form-select-sm auto-submit">
              @foreach(range(1, 12) as $b)
                  <option value="{{ $b }}" {{ $b == $bulan ? 'selected' : '' }}>
                      {{ DateTime::createFromFormat('!m', $b)->format('F') }}
                  </option>
              @endforeach
          </select>

          {{-- Tahun --}}
          <select name="tahun" class="form-select form-select-sm auto-submit">
              @foreach(range(date('Y')-2, date('Y')+1) as $t)
                  <option value="{{ $t }}" {{ $t == $tahun ? 'selected' : '' }}>{{ $t }}</option>
              @endforeach
          </select>

          {{-- Pencarian --}}
          <div class="input-group input-group-sm">
              <input 
                  type="text" 
                  name="search" 
                  value="{{ $search }}" 
                  placeholder="Search..." 
                  class="form-control" 
                  id="searchInput"
              >
              <button class="btn btn-outline-secondary" type="submit" id="searchBtn">
                  <i class="bx bx-search"></i>
              </button>
          </div>
      </form>

      {{-- 🔽 Tombol Cetak --}}
      <div>
          <a href="{{ route('logbook.cetak', 'wfo') }}?bulan={{ $bulan }}&tahun={{ $tahun }}" target="_blank" class="btn btn-success btn-sm">Cetak WFO</a>
          <a href="{{ route('logbook.cetak', 'wfh') }}?bulan={{ $bulan }}&tahun={{ $tahun }}" target="_blank" class="btn btn-primary btn-sm">Cetak WFH</a>
      </div>
  </div>

  <div class="table-responsive text-nowrap">
      <table class="table table-hover align-middle">
          <thead class="table-light">
              <tr>
                  <th>No</th>
                  <th>Tanggal</th>
                  <th>Kegiatan</th>
                  <th>Catatan Pekerjaan</th>
                  <th>Jam Masuk</th>
                  <th>Jam Pulang</th>
              </tr>
          </thead>
          <tbody>
              @forelse($logbooks as $index => $log)
              @php
                  $catatan = json_decode($log->catatan_pekerjaan, true);
              @endphp
              <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $log->tanggal }}</td>
                  <td><span class="badge bg-label-primary">{{ strtoupper($log->kegiatan) }}</span></td>
                  <td>
                      @if($catatan && count($catatan))
                          <ul class="mb-0">
                              @foreach($catatan as $c)
                                  <li>{{ $c['kegiatan'] }} ({{ $c['status'] }})</li>
                              @endforeach
                          </ul>
                      @else
                          -
                      @endif
                  </td>
                  <td>{{ $log->jam_masuk }}</td>
                  <td>{{ $log->jam_pulang ?? '-' }}</td>
              </tr>
              @empty
                  <tr><td colspan="6" class="text-center">Tidak ada data</td></tr>
              @endforelse
          </tbody>
      </table>
  </div>
</div>

{{-- 🔽 Script Auto Filter --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selects = document.querySelectorAll('.auto-submit');
    const form = document.getElementById('filterForm');
    const searchInput = document.getElementById('searchInput');

    // Otomatis submit kalau bulan/tahun berubah
    selects.forEach(select => {
        select.addEventListener('change', () => form.submit());
    });

    // Tekan Enter di search langsung submit
    searchInput.addEventListener('keypress', e => {
        if (e.key === 'Enter') {
            e.preventDefault();
            form.submit();
        }
    });
});
</script>
@endsection
