@extends('template.index')
@section('title', 'Rekap Kehadiran')

@section('main')
<div class="container">
    <h4 class="mb-3">📊 Rekap Kehadiran Bulan {{ $bulan }} - {{ $tahun }}</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form class="row g-2 mb-3">
        <div class="col-auto">
            <input type="number" name="bulan" class="form-control" value="{{ $bulan }}" min="1" max="12">
        </div>
        <div class="col-auto">
            <input type="number" name="tahun" class="form-control" value="{{ $tahun }}" min="2020" max="{{ date('Y') }}">
        </div>
        <div class="col-auto">
            <button class="btn btn-primary">Filter</button>
        </div>
        <div class="col-auto">
            <form action="{{ route('admin.rekap.generate') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">Generate Rekap</button>
            </form>
        </div>
    </form>

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Hadir</th>
                        <th>DL</th>
                        <th>Cuti</th>
                        <th>Sakit</th>
                        <th>Alpha</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rekap as $r)
                    <tr>
                        <td>{{ $r->user->name }}</td>
                        <td>{{ $r->jumlah_hadir }}</td>
                        <td>{{ $r->jumlah_dinas_luar }}</td>
                        <td>{{ $r->jumlah_cuti }}</td>
                        <td>{{ $r->jumlah_sakit }}</td>
                        <td>{{ $r->jumlah_alpha }}</td>
                        <td>
                            <a href="{{ route('admin.rekap.show', $r->id) }}" class="btn btn-sm btn-primary">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada data rekap</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $rekap->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
