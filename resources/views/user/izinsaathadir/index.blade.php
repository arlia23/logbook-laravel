@extends('template.index')

@section('main')
    <div class="container mt-4">

        {{-- ✅ Alert sukses --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold">📄 Data Izin Saat Hadir</h5>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#izinModal">
                + Input Data Izin
            </button>
        </div>

        {{-- ✅ Tabel Data --}}
        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0" style="width: 100%; border-color: #dee2e6;">
                    <thead style="background-color: #c9c9f6; color: #000;">
                        <tr class="text-center">
                            <th style="width: 5%;">NO</th>
                            <th style="width: 15%;">NAMA PEGAWAI</th>
                            <th style="width: 15%;">JENIS IZIN</th>
                            <th style="width: 12%;">TANGGAL</th>
                            <th style="width: 12%;">JAM MULAI</th>
                            <th style="width: 12%;">JAM SELESAI</th>
                            <th style="width: 20%;">ALASAN</th> {{-- ✅ Tambahkan kolom alasan --}}
                            <th style="width: 9%;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($izins as $index => $izin)
                            <tr class="text-center">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $izin->user->name }}</td>
                                <td>{{ $izin->jenis_izin }}</td>
                                <td>{{ \Carbon\Carbon::parse($izin->tanggal)->format('d-m-Y') }}</td>
                                <td>{{ $izin->jam_mulai }}</td>
                                <td>{{ $izin->jam_selesai }}</td>
                                <td class="text-start">{{ $izin->alasan }}</td> {{-- ✅ Tampilkan alasan --}}
                                <td>
                                    <a href="{{ route('user.izinsaathadir.pdf', $izin->id) }}"
                                        class="btn btn-success btn-sm">
                                        <i class="bx bx-printer me-1"></i> Surat
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-3">
                                    Tidak ada data izin saat hadir
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ✅ Modal Input Data Izin --}}
    <div class="modal fade" id="izinModal" tabindex="-1" aria-labelledby="izinModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header  text-white">
                    <h5 class="modal-title" id="izinModalLabel">Input Data Izin Saat Hadir</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('user.izinsaathadir.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Pegawai</label>
                                <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Izin</label>
                                <select name="jenis_izin" class="form-select" required>
                                    <option value="" disabled selected>Pilih jenis izin</option>
                                    <option value="Kantor">Kantor</option>
                                    <option value="Pribadi">Pribadi</option>
                                </select>
                            </div>


                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Izin</label>
                                <input type="date" name="tanggal" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jam Mulai</label>
                                <input type="time" name="jam_mulai" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jam Selesai</label>
                                <input type="time" name="jam_selesai" class="form-control" required>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Alasan</label>
                                <textarea name="alasan" class="form-control" rows="3" placeholder="Tulis alasan izin..." required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
