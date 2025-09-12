@extends('template.index')
@section('title', 'Detail Rekap Kehadiran')

@section('main')
<div class="container">
    <h4 class="mb-3">📊 Detail Rekap Kehadiran</h4>

    <div class="card shadow">
        <div class="card-body">
            <p><strong>Nama:</strong> {{ $rekap->user->name }}</p>
            <p><strong>Bulan:</strong> {{ $rekap->bulan }}</p>
            <p><strong>Tahun:</strong> {{ $rekap->tahun }}</p>
            <p><strong>Jumlah Hadir:</strong> {{ $rekap->jumlah_hadir }}</p>
            <p><strong>Jumlah DL:</strong> {{ $rekap->jumlah_dinas_luar }}</p>
            <p><strong>Jumlah Cuti:</strong> {{ $rekap->jumlah_cuti }}</p>
            <p><strong>Jumlah Sakit:</strong> {{ $rekap->jumlah_sakit }}</p>
            <p><strong>Jumlah Alpha:</strong> {{ $rekap->jumlah_alpha }}</p>

            <a href="{{ route('admin.rekap.index') }}" class="btn btn-secondary mt-3">Kembali</a>
        </div>
    </div>
</div>
@endsection
