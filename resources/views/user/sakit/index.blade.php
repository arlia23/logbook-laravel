@extends('template.index')

@section('main')
<div class="container">
    <h3>Data Sakit</h3>
    <a href="{{ route('user.sakit.create') }}" class="btn btn-primary mb-3">+ Tambah Data Sakit</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Pegawai</th>
                <th>Keterangan</th>
                <th>Tgl Mulai</th>
                <th>Tgl Selesai</th>
                <th>No Surat</th>
                <th>Tgl Surat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sakit as $row)
            <tr>
                <td>{{ $row->nama_pegawai }}</td>
                <td>{{ $row->keterangan }}</td>
                <td>{{ $row->tgl_mulai }}</td>
                <td>{{ $row->tgl_selesai }}</td>
                <td>{{ $row->no_surat_ket_sakit }}</td>
                <td>{{ $row->tgl_surat_ket_sakit }}</td>
                <td>
                    <a href="{{ route('user.sakit.edit', $row->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('user.sakit.destroy', $row->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center">Belum ada data</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
