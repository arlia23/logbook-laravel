@extends('template.index')

@section('main')
<div class="card">
    <div class="card-header">Detail Kehadiran Bulan {{ $bulan }}/{{ $tahun }}</div>
    <div class="card-body">
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>Nama Pegawai</th>
                    @foreach($detail as $tgl => $status)
                        <th>{{ $tgl }}</th>
                    @endforeach
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ auth()->user()->name }}</td>
                    @foreach($detail as $status)
                        <td>{{ $status }}</td>
                    @endforeach
                    <td>
                        {{ array_count_values($detail)['H'] ?? 0 }}H,
                        {{ array_count_values($detail)['DL'] ?? 0 }}DL,
                        {{ array_count_values($detail)['C'] ?? 0 }}C,
                        {{ array_count_values($detail)['S'] ?? 0 }}S,
                        {{ array_count_values($detail)['A'] ?? 0 }}A
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
