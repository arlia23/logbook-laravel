@extends('template.index')

@section('title', 'Monitoring Mingguan')

@section('main')
<div class="container-xxl flex-grow-1 container-p-y">

    {{-- 🔍 Filter Minggu + Pencarian Nama --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">📊 Monitoring Mingguan Pegawai</h5>
        </div>
        <div class="card-body">
            <form method="get" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Minggu Mulai</label>
                    <input type="date" name="start" value="{{ request('start', $startOfWeek->toDateString()) }}" class="form-control">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Minggu Selesai</label>
                    <input type="date" name="end" value="{{ request('end', $endOfWeek->toDateString()) }}" class="form-control">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Cari Nama Pegawai</label>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Ketik nama pegawai...">
                </div>

                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bx bx-search"></i> Tampilkan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ✅ Data Tabel Monitoring --}}
    <div class="card shadow-sm">
        <div class="card-datatable table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama Pegawai</th>
                        <th>Minggu</th>
                        <th>Catatan Supervisor</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $index => $item)
                        @if($item['user']->role === 'user') {{-- ✅ tampilkan hanya role user --}}
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item['user']->name }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($item['minggu_mulai'])->format('d M') }} -
                                    {{ \Carbon\Carbon::parse($item['minggu_selesai'])->format('d M Y') }}
                                </td>

                                <td>
                                    @if($item['catatan_supervisor'])
                                        <span class="badge bg-label-info">{{ $item['catatan_supervisor'] }}</span>
                                    @else
                                        <form method="post" action="{{ route('admin.monitoring.store') }}">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ $item['user']->id }}">
                                            <input type="hidden" name="minggu_mulai" value="{{ $item['minggu_mulai'] }}">
                                            <input type="hidden" name="minggu_selesai" value="{{ $item['minggu_selesai'] }}">
                                            <div class="mb-2">
                                                <textarea name="catatan_supervisor" rows="3" class="form-control"
                                                    placeholder="Tulis catatan supervisor..."></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-sm btn-success" title="Simpan Catatan">
                                                <i class="bx bx-save"></i> Simpan
                                            </button>
                                        </form>
                                    @endif
                                </td>

                                <td>
                                    @if($item['catatan_supervisor'] && $item['id'])
                                        <button type="button"
                                            class="btn btn-sm btn-outline-primary btn-edit"
                                            data-id="{{ $item['id'] }}"
                                            data-catatan="{{ $item['catatan_supervisor'] }}"
                                            title="Edit Catatan Supervisor">
                                            <i class="bx bx-edit-alt"></i> Edit
                                        </button>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Tidak ada data monitoring untuk minggu ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ✏️ Modal Edit --}}
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" action="{{ route('admin.monitoring.update') }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="edit-id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Catatan Supervisor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <textarea class="form-control" name="catatan_supervisor" id="edit-catatan" rows="4"
                        placeholder="Tulis catatan baru di sini..."></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $(document).on('click', '.btn-edit', function () {
        const id = $(this).data('id');
        const catatan = $(this).data('catatan');
        $('#edit-id').val(id);
        $('#edit-catatan').val(catatan);
        const modal = new bootstrap.Modal(document.getElementById('editModal'));
        modal.show();
    });
});
</script>
@endpush
