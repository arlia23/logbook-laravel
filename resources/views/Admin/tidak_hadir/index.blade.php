@extends('template.index') {{-- Sesuaikan dengan layout admin kamu --}}
@section('title', 'Data Tidak Hadir')

@section('main')
<div class="container">
    <h4 class="mb-3">📄 Data Izin / Cuti / Sakit</h4>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Jenis</th>
                        <th>Tanggal</th>
                        <th>Alasan</th>
                        <th>File</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tidakHadir as $item)
                        <tr>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ $item->jenis }}</td>
                            <td>{{ $item->tanggal_mulai }} s/d {{ $item->tanggal_selesai }}</td>
                            <td>{{ Str::limit($item->alasan, 30) ?? '-' }}</td>
                            <td>
                                @if ($item->file_surat_tugas)
                                    <a href="{{ asset('storage/'.$item->file_surat_tugas) }}" target="_blank" class="btn btn-sm btn-info">
                                        Lihat
                                    </a>
                                @else
                                    <span class="badge bg-secondary">Tidak ada</span>
                                @endif
                            </td>
                            <td class="d-flex gap-2">
                                <a href="{{ route('admin.tidak_hadir.show', $item->id) }}" class="btn btn-sm btn-primary">
                                    Detail
                                </a>

                                <form action="{{ route('admin.tidak_hadir.destroy', $item->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data izin/cuti/sakit</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $tidakHadir->links() }} {{-- Pagination --}}
            </div>
        </div>
    </div>
</div>
@endsection
