@extends('template.index')

@section('main')
    <div class="container">

        {{-- Header Judul & Tombol --}}
        <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
            <h4 class="mb-0">📋 Data Cuti</h4>
            <button class="btn btn-primary d-flex align-items-center gap-2 px-3 py-2" data-bs-toggle="modal"
                data-bs-target="#modalCuti" style="border-radius: 6px;">
                <span> + Input Data Cuti</span>
            </button>
        </div>

        {{-- Tabel Data Cuti --}}
        <div class="table-responsive mt-7">
            <table class="table table-bordered align-middle text-center table-hover">
                <thead style="background-color: #d4d4f6;" class="align-middle">
                    <tr>
                        <th style="width: 50px; white-space: nowrap;">No</th>
                        <th style="white-space: nowrap;">Nama Pegawai</th>
                        <th style="white-space: nowrap;">Jenis Cuti</th>
                        <th style="white-space: nowrap;">Keterangan</th>
                        <th style="white-space: nowrap;">Tgl Mulai</th>
                        <th style="white-space: nowrap;">Tgl Selesai</th>
                        <th style="white-space: nowrap;">No Surat Cuti</th>
                        <th style="white-space: nowrap;">Tgl Surat Cuti</th>
                        <th style="width: 150px; white-space: nowrap;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cuti as $i => $c)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td class="text-nowrap">{{ $c->nama_pegawai }}</td>
                            <td class="text-nowrap">{{ $c->jenis_cuti }}</td>
                            <td class="text-nowrap">{{ $c->keterangan }}</td>
                            <td class="text-nowrap">{{ $c->tgl_mulai }}</td>
                            <td class="text-nowrap">{{ $c->tgl_selesai }}</td>
                            <td class="text-nowrap">{{ $c->no_surat_cuti }}</td>
                            <td class="text-nowrap">{{ $c->tgl_surat_cuti }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('user.cuti.edit', $c->id) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <form action="{{ route('user.cuti.destroy', $c->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin hapus data?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                    <a href="{{ route('user.cuti.download', $c->id) }}" class="btn btn-sm btn-success">
                                        <i class="bi bi-file-earmark-pdf"></i> Surat
                                    </a>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Input Data --}}
    <div class="modal fade" id="modalCuti" tabindex="-1" aria-labelledby="modalCutiLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('user.cuti.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCutiLabel">Input Data Cuti</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Pegawai</label>
                            <input type="text" name="nama_pegawai" class="form-control"
                                value="{{ auth()->user()->name }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jenis Cuti</label>
                            <select name="jenis_cuti" class="form-control" required>
                                <option value="">-- Pilih Jenis Cuti --</option>
                                <option value="Cuti Tahunan">Cuti Tahunan</option>
                                <option value="Cuti Alasan Penting">Cuti Alasan Penting</option>
                                <option value="Cuti Melahirkan">Cuti Melahirkan</option>
                                <option value="Cuti Sakit">Cuti Sakit</option>
                                <option value="Cuti Urusan Keluarga">Cuti Urusan Keluarga</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control" required></textarea>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label">Tgl Mulai</label>
                                <input type="date" name="tgl_mulai" class="form-control"
                                    min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}" required>
                            </div>
                            <div class="col">
                                <label class="form-label">Tgl Selesai</label>
                                <input type="date" name="tgl_selesai" class="form-control" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label">No Surat Cuti</label>
                                <input type="text" name="no_surat_cuti" class="form-control" required>
                            </div>
                            <div class="col">
                                <label class="form-label">Tgl Surat Cuti</label>
                                <input type="date" name="tgl_surat_cuti" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- SweetAlert Error --}}
    @if (session('error'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
            })
        </script>
    @endif
@endsection
