@extends('template.index')

@section('main')
<div class="container">

    {{-- Header Judul & Tombol --}}
    <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
        <h4 class="mb-0">📋 Data Sakit</h4>
        <button class="btn btn-primary d-flex align-items-center gap-2 px-3 py-2" data-bs-toggle="modal" data-bs-target="#modalSakit" style="border-radius: 6px;">
            <span>+ Input Data Sakit</span>
        </button>
    </div>

    {{-- Notifikasi Sukses --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Tabel Data --}}
    <div class="table-responsive mt-5">
        <table class="table table-bordered align-middle text-center table-hover">
            <thead style="background-color: #d2d2f3;" class="align-middle">
                <tr>
                    <th style="width: 60px; white-space: nowrap;">No</th>
                    <th style="white-space: nowrap;">Nama Pegawai</th>
                    <th style="white-space: nowrap;">Keterangan</th>
                    <th style="white-space: nowrap;">Tgl Mulai</th>
                    <th style="white-space: nowrap;">Tgl Selesai</th>
                    <th style="white-space: nowrap;">No Surat</th>
                    <th style="white-space: nowrap;">Tgl Surat</th>
                    <th style="width: 150px; white-space: nowrap;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sakit as $index => $row)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="text-nowrap">{{ $row->nama_pegawai }}</td>
                    <td class="text-nowrap">{{ $row->keterangan }}</td>
                    <td class="text-nowrap">{{ $row->tgl_mulai }}</td>
                    <td class="text-nowrap">{{ $row->tgl_selesai }}</td>
                    <td class="text-nowrap">{{ $row->no_surat_ket_sakit }}</td>
                    <td class="text-nowrap">{{ $row->tgl_surat_ket_sakit }}</td>
                    <td>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('user.sakit.edit', $row->id) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <form action="{{ route('user.sakit.destroy', $row->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center">Belum ada data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Input Data Sakit --}}
<div class="modal fade" id="modalSakit" tabindex="-1" aria-labelledby="modalSakitLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{ route('user.sakit.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="modalSakitLabel">Input Data Sakit</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
              <label class="form-label">Nama Pegawai</label>
              <input type="text" name="nama_pegawai" class="form-control" value="{{ auth()->user()->name }}" readonly>
          </div>

          <div class="mb-3">
              <label class="form-label">Keterangan</label>
              <textarea name="keterangan" class="form-control" required></textarea>
          </div>

          <div class="row mb-3">
              <div class="col">
                  <label class="form-label">Tanggal Mulai</label>
                  <input type="date" name="tgl_mulai" class="form-control"
                         min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}" required>
              </div>
              <div class="col">
                  <label class="form-label">Tanggal Selesai</label>
                  <input type="date" name="tgl_selesai" class="form-control" required>
              </div>
          </div>

          <div class="row mb-3">
              <div class="col">
                  <label class="form-label">No Surat Keterangan Sakit</label>
                  <input type="text" name="no_surat_ket_sakit" class="form-control" required>
              </div>
              <div class="col">
                  <label class="form-label">Tanggal Surat</label>
                  <input type="date" name="tgl_surat_ket_sakit" class="form-control" required>
              </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-success">Simpan Data</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- SweetAlert Error --}}
@if(session('error'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: '{{ session('error') }}',
});
</script>
@endif
@endsection
