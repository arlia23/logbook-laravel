@extends('template.index')

@section('main')
<div class="container p-3">
    {{-- 🔽 Judul --}}
    <div class="mb-4 text-center">
        <h3 class="fw-bold">
            {{ ucfirst($mode) }} Kehadiran Bulan {{ $bulan }} Tahun {{ $tahun }}
            @if($kategori) ({{ strtoupper($kategori) }}) @endif
        </h3>
    </div>

    {{-- 🔽 Filter --}}
    <div class="mb-4">
        <form method="GET" action="{{ route('user.rekap.index') }}" class="d-flex flex-wrap gap-2 align-items-center justify-content-center">
            <select name="mode" class="form-select" style="width:160px;">
                <option value="rekap" {{ $mode == 'rekap' ? 'selected' : '' }}>Rekapitulasi</option>
                <option value="detail" {{ $mode == 'detail' ? 'selected' : '' }}>Detail</option>
            </select>

            <select name="kategori" class="form-select" style="width:160px;">
                <option value="">Semua</option>
                <option value="pns" {{ $kategori == 'pns' ? 'selected' : '' }}>PNS</option>
                <option value="phl" {{ $kategori == 'phl' ? 'selected' : '' }}>PHL</option>
                <option value="p3k" {{ $kategori == 'p3k' ? 'selected' : '' }}>P3K</option>
            </select>

            <select name="bulan" class="form-select" style="width:180px;">
                @foreach($listBulan as $key => $nama)
                    <option value="{{ $key }}" {{ ($bulanAngka == $key) ? 'selected' : '' }}>{{ $nama }}</option>
                @endforeach
            </select>

            <select name="tahun" class="form-select" style="width:120px;">
                @foreach($listTahun as $th)
                    <option value="{{ $th }}" {{ ($tahun == $th) ? 'selected' : '' }}>{{ $th }}</option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-primary">Filter</button>
        </form>
    </div>

    {{-- 🔽 Table --}}
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-bordered table-striped mb-0 text-center">
                <thead class="table-light">
                    <tr>
                        <th>Nama Pegawai</th>
                        @if($mode == 'rekap')
                            <th>HK</th><th>Hadir</th><th>DL</th><th>Cuti</th>
                            <th>Sakit</th><th>Alpha</th><th>WFO</th><th>WFH</th>
                        @else
                            @for($i = 1; $i <= $daysInMonth; $i++)
                                @php
                                    $tanggal = sprintf('%04d-%02d-%02d', $tahun, $bulanAngka, $i);
                                    $isSunday = date('N', strtotime($tanggal)) == 7;
                                @endphp
                                <th @if($isSunday) style="background-color: #d0e7ff;" @endif>{{ $i }}</th>
                            @endfor
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($rekap as $r)
                        @if($mode == 'rekap')
                            <tr>
                                <td class="text-start ps-3">{{ $r->name }}</td>
                                <td>{{ $r->hk }}</td>
                                <td>{{ $r->hadir }}</td>
                                <td>{{ $r->dl }}</td>
                                <td>{{ $r->cuti }}</td>
                                <td>{{ $r->sakit }}</td>
                                <td>{{ $r->alpha }}</td>
                                <td>{{ $r->wfo }}</td>
                                <td>{{ $r->wfh }}</td>
                            </tr>
                        @else
                            <tr>
                                <td class="text-start ps-3">{{ $r['name'] }}</td>
                                @foreach($r['data'] as $index => $status)
                                    @php
                                        $isSunday = in_array($index, $hariMingguIndex ?? []);
                                    @endphp
                                    <td @if($isSunday) style="background-color: #d0e7ff;" @endif>{{ $status }}</td>
                                @endforeach
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="{{ $mode == 'rekap' ? 9 : ($daysInMonth + 1) }}">Belum ada data untuk periode ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
