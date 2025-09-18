@extends('template.index') {{-- layout utama --}}

@section('main')
    <div class="container">
        <h4>Data Dinas Luar</h4>

        {{-- Tombol buka modal --}}
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalDinasLuar">
            Input Data Dinas Luar
        </button>

        {{-- Tabel data --}}
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Pegawai</th>
                    <th>Nama Kegiatan</th>
                    <th>Lokasi</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>No Surat Tugas</th>
                    <th>Tanggal Surat Tugas</th>
                    <th>Jenis Tugas</th>
                    <th>File</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dinasLuar as $item)
                    <tr>
                        <td>{{ $item->nama_pegawai }}</td>
                        <td>{{ $item->nama_kegiatan }}</td>
                        <td>{{ $item->lokasi_kegiatan }}</td>
                        <td>{{ $item->tgl_mulai }}</td>
                        <td>{{ $item->tgl_selesai }}</td>
                        <td>{{ $item->no_surat_tugas }}</td>
                        <td>{{ $item->tgl_surat_tugas }}</td>
                        <td>{{ $item->jenis_tugas }}</td>
                        <td>
                            @if ($item->file_surat_tugas)
                                <a href="{{ asset('storage/' . $item->file_surat_tugas) }}" target="_blank">Lihat</a>
                            @else
                                Tidak ada
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('user.dinas.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('user.dinas.destroy', $item->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Yakin hapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Modal Input Data Dinas Luar --}}
    <div class="modal fade" id="modalDinasLuar" tabindex="-1" aria-labelledby="modalDinasLuarLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('user.dinas.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDinasLuarLabel">Input Data Dinas Luar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="nama_pegawai" class="form-label">Nama Pegawai</label>
                            <input type="text" name="nama_pegawai" class="form-control"
                                value="{{ auth()->user()->name }}" readonly>
                        </div>


                        <div class="mb-3">
                            <label for="nama_kegiatan" class="form-label">Nama Kegiatan</label>
                            <input type="text" name="nama_kegiatan" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="lokasi_kegiatan" class="form-label">Lokasi Kegiatan</label>
                            <input type="text" name="lokasi_kegiatan" class="form-control" required>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label for="tgl_mulai" class="form-label">Tanggal Mulai</label>
                                <input type="date" name="tgl_mulai" class="form-control" required>
                            </div>
                            <div class="col">
                                <label for="tgl_selesai" class="form-label">Tanggal Selesai</label>
                                <input type="date" name="tgl_selesai" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="no_surat_tugas" class="form-label">No Surat Tugas</label>
                            <input type="text" name="no_surat_tugas" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="tgl_surat_tugas" class="form-label">Tanggal Surat Tugas</label>
                            <input type="date" name="tgl_surat_tugas" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="jenis_tugas" class="form-label">Jenis Tugas</label>
                            <select name="jenis_tugas" class="form-select" required>
                                <option value="">-- Pilih Jenis Tugas --</option>
                                <option value="ST Luar Kota">ST Luar Kota</option>
                                <option value="ST Dalam Kota">ST Dalam Kota - Absen Online</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="file_surat_tugas" class="form-label">File Surat Tugas (PDF/JPG/PNG, max
                                400KB)</label>
                            <input type="file" name="file_surat_tugas" class="form-control">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Data DL</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
