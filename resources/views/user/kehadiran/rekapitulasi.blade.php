@extends('template.index')

@section('main')
<div class="card">
    <div class="card-header">Rekap Kehadiran Bulan {{ $bulan }}/{{ $tahun }}</div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Hadir (H)</th>
                    <th>Dinas Luar (DL)</th>
                    <th>Cuti (C)</th>
                    <th>Sakit (S)</th>
                    <th>Alfa (A)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $rekap['H'] }}</td>
                    <td>{{ $rekap['DL'] }}</td>
                    <td>{{ $rekap['C'] }}</td>
                    <td>{{ $rekap['S'] }}</td>
                    <td>{{ $rekap['A'] }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
