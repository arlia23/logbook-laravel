<h3 style="text-align:center;">
    Detail Kehadiran Bulan {{ $bulanAngka }} Tahun {{ $tahun }}
</h3>

<table border="1" cellspacing="0" cellpadding="5">
    <thead style="background-color:#f2f2f2;">
        <tr>
            <th>Nama</th>
            @for($i = 1; $i <= $daysInMonth; $i++)
                @php
                    $tgl = sprintf('%04d-%02d-%02d', $tahun, $bulanAngka, $i);
                    $isSunday = date('N', strtotime($tgl)) == 7;
                @endphp
                <th @if($isSunday) style="background-color:#e0f2ff;" @endif>{{ $i }}</th>
            @endfor
        </tr>
    </thead>
    <tbody>
        @foreach($rekap as $r)
            <tr>
                <td>{{ $r['name'] }}</td>
                @foreach($r['data'] as $status)
                    <td>{{ $status }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
