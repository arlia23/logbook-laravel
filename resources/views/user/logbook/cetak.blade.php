<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak {{ strtoupper($jenis) }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 5px; }
        th { background: #f0f0f0; }
        h3, p { text-align: center; margin: 0; }
        .ttd-container {
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
            padding: 0 40px;
        }
        .ttd {
            width: 45%;
            text-align: center;
        }
    </style>
</head>
<body>
    <h3>Laporan Pelaksanaan Bekerja dari {{ strtoupper($jenis) }}</h3>
    <p>Periode: {{ DateTime::createFromFormat('!m', $bulan)->format('F') }} {{ $tahun }}</p>
    <p>Nama Pegawai: {{ $user->name }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kegiatan</th>
                <th>Catatan</th>
                <th>Jam Masuk</th>
                <th>Jam Pulang</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logbooks as $i => $log)
                @php $catatan = json_decode($log->catatan_pekerjaan, true); @endphp
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $log->tanggal }}</td>
                    <td>{{ strtoupper($log->kegiatan) }}</td>
                    <td>
                        @if($catatan)
                            <ul style="margin:0;padding-left:15px;">
                                @foreach($catatan as $c)
                                    <li>{{ $c['kegiatan'] }}</li>
                                @endforeach
                            </ul>
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $log->jam_masuk }}</td>
                    <td>{{ $log->jam_pulang ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="ttd-container">
        <!-- Kolom kiri -->
        <div class="ttd">
            <strong>Atasan Atasan Langsung</strong><br><br><br><br>
            <u>________________________</u>
        </div>

        <!-- Kolom kanan -->
        <div class="ttd">
            Pekanbaru, {{ now()->format('d F Y') }}<br>
            <strong>Atasan Langsung</strong><br><br><br><br>
            <u>________________________</u>
        </div>
    </div>
</body>
</html>
