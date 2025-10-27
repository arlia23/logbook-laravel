<h3 style="text-align:center;">
    Rekap Kehadiran Bulan {{ $bulanAngka }} Tahun {{ $tahun }}
</h3>
<p>Total Hari Kerja: <strong>{{ $hariKerja }}</strong></p>

<table border="1" cellspacing="0" cellpadding="5">
    <thead style="background-color:#f2f2f2;">
        <tr>
            <th>Nama</th>
            <th>HK</th>
            <th>Hadir</th>
            <th>Dinas Luar</th>
            <th>Cuti</th>
            <th>Sakit</th>
            <th>Alpha</th>
            <th>WFO</th>
            <th>WFH</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rekap as $r)
            <tr>
                <td>{{ $r->name }}</td>
                <td>{{ $r->hk }}</td>
                <td>{{ $r->hadir }}</td>
                <td>{{ $r->dl }}</td>
                <td>{{ $r->cuti }}</td>
                <td>{{ $r->sakit }}</td>
                <td>{{ $r->alpha }}</td>
                <td>{{ $r->wfo }}</td>
                <td>{{ $r->wfh }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
