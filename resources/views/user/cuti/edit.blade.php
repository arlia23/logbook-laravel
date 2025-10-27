@extends('template.index')

@section('main')
<div class="container">
    <h4>Edit Data Cuti</h4>

    <form action="{{ route('user.cuti.update', $cuti->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nama Pegawai</label>
            <input type="text" name="nama_pegawai" class="form-control"
                   value="{{ $cuti->nama_pegawai }}" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">Jenis Cuti</label>
            <select name="jenis_cuti" class="form-control" required>
                <option value="">-- Pilih Jenis Cuti --</option>
                <option value="Cuti Tahunan" {{ $cuti->jenis_cuti == 'Cuti Tahunan' ? 'selected' : '' }}>Cuti Tahunan</option>
                <option value="Cuti Alasan Penting" {{ $cuti->jenis_cuti == 'Cuti Alasan Penting' ? 'selected' : '' }}>Cuti Alasan Penting</option>
                <option value="Cuti Melahirkan" {{ $cuti->jenis_cuti == 'Cuti Melahirkan' ? 'selected' : '' }}>Cuti Melahirkan</option>
                <option value="Cuti Sakit" {{ $cuti->jenis_cuti == 'Cuti Sakit' ? 'selected' : '' }}>Cuti Sakit</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <textarea name="keterangan" class="form-control" required>{{ $cuti->keterangan }}</textarea>
        </div>

        <div class="row mb-3">
            <div class="col">
              <label class="form-label">Tgl Mulai</label>
              <input type="date" name="tgl_mulai" class="form-control"
                     value="{{ $cuti->tgl_mulai }}" readonly>
            </div>
            <div class="col">
              <label class="form-label">Tgl Selesai</label>
              <input type="date" name="tgl_selesai" class="form-control"
                     value="{{ $cuti->tgl_selesai }}" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
              <label class="form-label">No Surat Cuti</label>
              <input type="text" name="no_surat_cuti" class="form-control"
                     value="{{ $cuti->no_surat_cuti }}" required>
            </div>
            <div class="col">
              <label class="form-label">Tgl Surat Cuti</label>
              <input type="date" name="tgl_surat_cuti" class="form-control"
                     value="{{ $cuti->tgl_surat_cuti }}" required>
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('user.cuti.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Update Data</button>
        </div>
    </form>
</div>
@endsection
