@extends('template.index')

@section('main')
<div class="container">
    <h4>Cuti</h4>

    {{-- Tombol Input --}}
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalCuti">
        Input Data Cuti
    </button>

    {{-- Tabel Data Cuti --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Pegawai</th>
                <th>Jenis Cuti</th>
                <th>Keterangan</th>
                <th>Tgl Cuti</th>
                <th>Surat Cuti</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cuti as $c)
            <tr>
                <td>{{ $c->nama_pegawai }}</td>
                <td>{{ $c->jenis_cuti }}</td>
                <td>{{ $c->keterangan }}</td>
                <td>{{ $c->tgl_mulai }} s.d. {{ $c->tgl_selesai }}</td>
                <td>{{ $c->no_surat_cuti }}<br>{{ $c->tgl_surat_cuti }}</td>
                <td>
                    <a href="{{ route('user.cuti.edit', $c->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('user.cuti.destroy', $c->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"
                            onclick="return confirm('Yakin hapus data?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
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
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <textarea name="keterangan" class="form-control" required></textarea>
          </div>

          <div class="row mb-3">
            <div class="col">
              <label class="form-label">Tgl Mulai</label>
              <input type="date" name="tgl_mulai" class="form-control" required>
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
@endsection
