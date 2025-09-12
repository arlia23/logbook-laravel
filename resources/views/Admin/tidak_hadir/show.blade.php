@extends('template.index')
@section('title', 'Detail Tidak Hadir')

@section('main')
<div class="container">
    <h4 class="mb-3">📄 Detail Izin / Cuti / Sakit</h4>

    <div class="card shadow">
        <div class="card-body">
            <p><strong>Nama:</strong> {{ $data->user->name }}</p>
            <p><strong>Jenis:</strong> {{ $data->jenis }}</p>
            <p><strong>Tanggal:</strong> {{ $data->tanggal_mulai }} s/d {{ $data->tanggal_selesai }}</p>
            <p><strong>Alasan:</strong> {{ $data->alasan ?? '-' }}</p>

            <p><strong>File Surat:</strong>
                @if ($data->file_surat_tugas)
                    <a href="{{ asset('storage/'.$data->file_surat_tugas) }}" target="_blank" class="btn btn-sm btn-info">
                        Lihat Surat
                    </a>
                @else
                    <span class="badge bg-secondary">Tidak ada</span>
                @endif
            </p>

            <a href="{{ route('admin.tidak_hadir.index') }}" class="btn btn-secondary mt-3">Kembali</a>
        </div>
    </div>
</div>
@endsection
