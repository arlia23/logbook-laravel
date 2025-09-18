@extends('template.index')

@section('main')
<div class="container">
    <h3>Edit Data Sakit</h3>
    <form action="{{ route('user.sakit.update', $sakit->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Nama Pegawai</label>
            <input type="text" name="nama_pegawai" value="{{ $sakit->nama_pegawai }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control" required>{{ $sakit->keterangan }}</textarea>
        </div>
        <div class="mb-3">
            <label>Tanggal Mulai</label>
            <input type="date" name="tgl_mulai" value="{{ $sakit->tgl_mulai }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Tanggal Selesai</label>
            <input type="date" name="tgl_selesai" value="{{ $sakit->tgl_selesai }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>No Surat Keterangan Sakit</label>
            <input type="text" name="no_surat_ket_sakit" value="{{ $sakit->no_surat_ket_sakit }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Tanggal Surat</label>
            <input type="date" name="tgl_surat_ket_sakit" value="{{ $sakit->tgl_surat_ket_sakit }}" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('user.sakit.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
