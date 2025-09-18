@extends('template.index')

@section('main')
<div class="container">
    <h3>Input Data Sakit</h3>
    <form action="{{ route('user.sakit.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nama Pegawai</label>
            <input type="text" name="nama_pegawai" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label>Tanggal Mulai</label>
            <input type="date" name="tgl_mulai" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Tanggal Selesai</label>
            <input type="date" name="tgl_selesai" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>No Surat Keterangan Sakit</label>
            <input type="text" name="no_surat_ket_sakit" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Tanggal Surat</label>
            <input type="date" name="tgl_surat_ket_sakit" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('user.sakit.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
