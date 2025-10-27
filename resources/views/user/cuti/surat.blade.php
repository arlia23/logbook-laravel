<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Izin Tidak Masuk Kantor</title>
    <style>
        body { font-family: "Times New Roman", serif; font-size: 13pt; }
        .kop { display: flex; align-items: center; border-bottom: 2px solid black; padding-bottom: 6px; margin-bottom: 10px; }
        .kop img { width: 90px; margin-right: 15px; }
        .header-text { text-align: center; flex-grow: 1; }
        .header-text h3 { margin: 0; font-size: 16pt; }
        .table-info td { padding: 2px 5px; vertical-align: top; }
        .ttd { margin-top: 40px; width: 100%; display: flex; justify-content: space-between; }
        .ttd div { text-align: center; }
        .catatan { margin-top: 30px; font-style: italic; }
    </style>
</head>
<body>

    <div class="kop">
        <img src="{{ public_path('logo_unri.png') }}" alt="Logo UNRI">
        <div class="header-text">
            <strong>PERPUSTAKAAN UNIVERSITAS RIAU</strong><br>
            <em>"The Best Solution In The Search"</em><br><br>
            <strong>FORMULIR SURAT PERMOHONAN IZIN TIDAK MASUK KANTOR</strong>
        </div>
    </div>

    <table class="table-info">
        <tr><td>Nama</td><td>:</td><td>{{ $user->name }}</td></tr>
        <tr><td>NIP/NIPH</td><td>:</td><td>{{ $user->nip ?? '-' }}</td></tr>
        <tr><td>Pangkat / Gol</td><td>:</td><td>{{ $user->pangkat ?? '-' }}</td></tr>
        <tr><td>Jabatan</td><td>:</td><td>{{ $user->jabatan ?? '-' }}</td></tr>
        <tr><td>Unit Kerja</td><td>:</td><td>{{ $user->unit_fakultas ?? '-' }}</td></tr>
    </table>

    <p style="text-align: justify; margin-top: 12px;">
        Dengan ini mengajukan permohonan izin untuk tidak masuk bekerja/kantor selama <strong>{{ $jumlahHari }} hari</strong>,
        pada hari <strong>{{ $hariMulai }} s/d {{ $hariSelesai }}</strong> tanggal
        <strong>{{ \Carbon\Carbon::parse($cuti->tgl_mulai)->format('d') }} s/d {{ \Carbon\Carbon::parse($cuti->tgl_selesai)->translatedFormat('d F Y') }}</strong>
        dengan alasan <strong>{{ $cuti->keterangan }}</strong>.
    </p>

    <p>Demikian permohonan ini, atas perhatian Bapak/Ibu diucapkan terima kasih.</p>

    <p>Pekanbaru, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>

    <div class="ttd">
        <div>
            Diketahui atasan langsung,<br>
            <strong>Sub Koordinator TU</strong><br><br><br><br>
            <u>Evi Susanti, S.Si</u><br>
            197712142008102002
        </div>
        <div>
            Hormat saya,<br>
            Pemohon<br><br><br><br>
            <u>{{ $user->name }}</u><br>
            {{ $user->nip }}
        </div>
    </div>

    <div class="catatan">
        <strong>Catatan dari atasan:</strong> ....................................................
    </div>
</body>
</html>
