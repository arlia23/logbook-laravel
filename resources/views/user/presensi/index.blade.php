@extends('template.index')

@section('title', 'Presensi')

@section('main')
<div class="container-xxl flex-grow-1 container-p-y">

    {{-- Card Presensi Hari Ini --}}
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Presensi Hari Ini</h5>
        </div>
        <div class="card-body">

            {{-- Notifikasi Sukses --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- Tombol Presensi Masuk atau Status Masuk --}}
            @if(!$presensi || !$presensi->jam_masuk)
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPresensi">
                    <i class="bx bx-log-in"></i> Presensi Masuk
                </button>
            @else
                <button type="button" class="btn btn-success" disabled>
                    <i class="bx bx-time"></i>
                    Masuk: {{ \Carbon\Carbon::parse($presensi->jam_masuk)->format('H:i:s') }}
                </button>
            @endif

        </div>
    </div>

    {{-- Modal Presensi --}}
    <div class="modal fade" id="modalPresensi" tabindex="-1" aria-labelledby="modalPresensiLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form method="POST" action="{{ route('presensi.store') }}">
          @csrf
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalPresensiLabel">Presensi Masuk</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <label for="kegiatan" class="form-label">Pilih Kegiatan</label>
              <select name="kegiatan" id="kegiatan" class="form-select" required>
                <option value="">-- Pilih --</option>
                <option value="WFO">WFO</option>
                <option value="WFH">WFH</option>
              </select>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Rekam Jam Masuk</button>
            </div>
          </div>
        </form>
      </div>
    </div>

</div>
@endsection
