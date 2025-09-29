@extends('template.index')

@section('main')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">📊 Monitoring Mingguan Pegawai</h5>
        </div>
        <div class="card-body">
            <form method="get" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Minggu Mulai</label>
                    <input type="date" name="start" value="{{ $startOfWeek->toDateString() }}" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Minggu Selesai</label>
                    <input type="date" name="end" value="{{ $endOfWeek->toDateString() }}" class="form-control">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-show"></i> Tampilkan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-datatable table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Pegawai</th>
                        <th>Minggu</th>
                        <th>Catatan Pekerjaan</th>
                        <th>Catatan Supervisor</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item['user']->name }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($item['minggu_mulai'])->format('d M') }}
                                -
                                {{ \Carbon\Carbon::parse($item['minggu_selesai'])->format('d M Y') }}
                            </td>
                            <td>
                                @if($item['ringkasan_pekerjaan'])
                                    {!! nl2br(e($item['ringkasan_pekerjaan'])) !!}
                                @else
                                    <span class="text-muted"><i class="bx bx-info-circle"></i> Tidak ada data</span>
                                @endif
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
                                        <button type="submit" class="btn btn-sm btn-success">
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
                                        data-catatan="{{ $item['catatan_supervisor'] }}">
                                        <i class="bx bx-edit-alt"></i> Edit
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="post" action="{{ route('admin.monitoring.update') }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="edit-id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Catatan Supervisor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <textarea class="form-control" name="catatan_supervisor" id="edit-catatan" rows="4"></textarea>
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
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function () {
            document.getElementById('edit-id').value = this.dataset.id;
            document.getElementById('edit-catatan').value = this.dataset.catatan;
            new bootstrap.Modal(document.getElementById('editModal')).show();
        });
    });
});
</script>
@endpush
