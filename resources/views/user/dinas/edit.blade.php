@extends('template.index')

@section('main')
    <div class="container">
        <h4>Edit Data Dinas Luar</h4>

        <form action="{{ route('user.dinas.update', $dinasLuar->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nama_pegawai" class="form-label">Nama Pegawai</label>
                <input type="text" name="nama_pegawai" class="form-control"
                       value="{{ old('nama_pegawai', $dinasLuar->nama_pegawai) }}" readonly>
            </div>

            <div class="mb-3">
                <label for="nama_kegiatan" class="form-label">Nama Kegiatan</label>
                <input type="text" name="nama_kegiatan" class="form-control"
                       value="{{ old('nama_kegiatan', $dinasLuar->nama_kegiatan) }}" required>
            </div>

            <div class="mb-3">
                <label for="lokasi_kegiatan" class="form-label">Lokasi Kegiatan</label>
                <input type="text" name="lokasi_kegiatan" class="form-control"
                       value="{{ old('lokasi_kegiatan', $dinasLuar->lokasi_kegiatan) }}" required>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="tgl_mulai" class="form-label">Tanggal Mulai</label>
                    <input type="date" name="tgl_mulai" class="form-control"
                           value="{{ old('tgl_mulai', $dinasLuar->tgl_mulai) }}" required>
                </div>
                <div class="col">
                    <label for="tgl_selesai" class="form-label">Tanggal Selesai</label>
                    <input type="date" name="tgl_selesai" class="form-control"
                           value="{{ old('tgl_selesai', $dinasLuar->tgl_selesai) }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="no_surat_tugas" class="form-label">No Surat Tugas</label>
                <input type="text" name="no_surat_tugas" class="form-control"
                       value="{{ old('no_surat_tugas', $dinasLuar->no_surat_tugas) }}" required>
            </div>

            <div class="mb-3">
                <label for="tgl_surat_tugas" class="form-label">Tanggal Surat Tugas</label>
                <input type="date" name="tgl_surat_tugas" class="form-control"
                       value="{{ old('tgl_surat_tugas', $dinasLuar->tgl_surat_tugas) }}" required>
            </div>

            <div class="mb-3">
                <label for="jenis_tugas" class="form-label">Jenis Tugas</label>
                <select name="jenis_tugas" class="form-select" required>
                    <option value="">-- Pilih Jenis Tugas --</option>
                    <option value="ST Luar Kota" {{ old('jenis_tugas', $dinasLuar->jenis_tugas) == 'ST Luar Kota' ? 'selected' : '' }}>ST Luar Kota</option>
                    <option value="ST Dalam Kota" {{ old('jenis_tugas', $dinasLuar->jenis_tugas) == 'ST Dalam Kota' ? 'selected' : '' }}>ST Dalam Kota - Absen Online</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="file_surat_tugas" class="form-label">File Surat Tugas (PDF/JPG/PNG, max 400KB)</label>
                @if ($dinasLuar->file_surat_tugas)
                    <p>File saat ini: 
                        <a href="{{ asset('storage/' . $dinasLuar->file_surat_tugas) }}" target="_blank">Lihat File</a>
                    </p>
                @endif
                <input type="file" name="file_surat_tugas" class="form-control">
            </div>

            <div class="mb-3">
                <a href="{{ route('user.dinas.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Update Data</button>
            </div>
        </form>
    </div>
@endsection
