<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Formulir Surat Izin Keluar Kantor</title>
  <style>
    body {
      font-family: DejaVu Sans, sans-serif;
      font-size: 11.5px; /* lebih kecil agar mirip contoh */
      margin: 30px; /* dikurangi agar isi rapat */
      line-height: 1.4;
    }

    /* === KOP SURAT: 2 LAPIS GARIS === */
    .kop-container {
      width: 100%;
      border: 1px double #444;
      padding: 2px;
      box-sizing: border-box;
      margin-bottom: 10px;
    }

    .kop-table {
      width: 100%;
      border-collapse: collapse;
      border: 1px solid #444;
      table-layout: fixed;
    }

    .kop-table td {
      border: 1px solid #444;
      vertical-align: middle;
      padding: 6px;
    }

    .logo {
      width: 65px;
      height: auto;
    }

    .instansi {
      font-weight: bold;
      font-size: 13px;
      margin-top: 4px;
      line-height: 1.3;
    }

    .slogan {
      font-size: 10px;
      font-style: italic;
      margin-top: 2px;
    }

    .judul {
      font-weight: bold;
      font-size: 15px;
      line-height: 1.3;
      letter-spacing: 0.5px;
    }

    .info-dokumen {
      width: 100%;
      font-size: 10px;
      border-collapse: collapse;
    }

    .info-dokumen td {
      padding: 2px 4px;
      vertical-align: top;
    }

    /* === ISI SURAT === */
    .info-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
      font-size: 11.5px;
    }

    /* ✅ rapat dan sejajar */
    .info-table td {
      padding: 1px 3px;
      vertical-align: top;
      line-height: 1.2;
    }

    .info-table td:first-child {
      width: 130px; /* lebar kolom kiri agar titik dua sejajar */
    }

    p {
      margin: 5px 0;
      text-align: justify;
    }

    /* === TANDA TANGAN === */
    .signature {
      margin-top: 20px;
      width: 100%;
      border-collapse: collapse;
    }

    .signature td {
      width: 50%;
      vertical-align: top;
      padding-top: 10px;
    }

    .signature .jabatan {
      font-weight: normal;
    }

    .signature .nama {
      font-weight: bold;
      text-decoration: underline;
    }

    .signature .nip {
      font-size: 11px;
    }

    .signature td.right {
      padding-left: 130px; /* geser kanan sedikit */
    }

    /* === CATATAN ATASAN === */
    .catatan {
      margin-top: 50px;
      font-weight: bold;
    }
  </style>
</head>
<body>

  {{-- 🔹 KOP SURAT --}}
  <div class="kop-container">
    <table class="kop-table">
      <tr>
        <!-- KIRI -->
        <td style="width: 30%; text-align: center;">
          <img src="{{ public_path('template/img/layouts/logounri.png') }}" class="logo"><br>
          <div class="instansi">PERPUSTAKAAN<br>UNIVERSITAS RIAU</div>
          <div class="slogan">“The Best Solution In The Search”</div>
        </td>

        <!-- TENGAH -->
        <td style="width: 40%; text-align: center;">
          <div class="judul">
            FORMULIR SURAT IZIN<br>
            KELUAR KANTOR PADA JAM KERJA
          </div>
        </td>

        <!-- KANAN -->
        <td style="width: 30%;">
          <table class="info-dokumen">
            <tr><td>No. Dok.</td><td>: 09-740/Lib.UR/F-22</td></tr>
            <tr><td>Revisi</td><td>: 00</td></tr>
            <tr><td>Efektif</td><td>: 01-09-2016</td></tr>
            <tr><td>Halaman</td><td>: 1 dari 1</td></tr>
          </table>
        </td>
      </tr>
    </table>
  </div>

  {{-- 🔹 ISI SURAT --}}
  <p>Yang bertanda tangan di bawah ini :</p>

  <table class="info-table">
    <tr><td>Nama</td><td>: {{ $izin->user->name }}</td></tr>
    <tr><td>NIP/NIPH</td><td>: {{ $izin->user->nip ?? '-' }}</td></tr>
    <tr><td>Pangkat / Gol</td><td>: -</td></tr>
    <tr><td>Jabatan</td><td>: Staf IT</td></tr>
    <tr><td>Unit Kerja</td><td>: UPT Perpustakaan UNRI</td></tr>
  </table>

  <p>
    Untuk melakukan keperluan {{ strtolower($izin->jenis_izin) }}, yaitu {{ strtolower($izin->alasan) }},
    pada hari {{ \Carbon\Carbon::parse($izin->tanggal)->translatedFormat('l, d F Y') }}
    pada pukul {{ \Carbon\Carbon::parse($izin->jam_mulai)->format('H.i') }}
    sampai dengan pukul {{ \Carbon\Carbon::parse($izin->jam_selesai)->format('H.i') }}.
  </p>

  <p>Demikian untuk dipergunakan sebagaimana mestinya.</p>
<br>
  <p style="margin-top: 15px;">
    Pekanbaru, {{ \Carbon\Carbon::parse($izin->tanggal)->translatedFormat('d F Y') }}
  </p>

  {{-- 🔹 TANDA TANGAN --}}
  <table class="signature">
    <tr>
      <td class="jabatan">
        Diketahui atasan langsung,<br>
        Sub Koordinator TU/Koordinator Bidang
      </td>
      <td class="jabatan right">
        Hormat Saya,<br>
        Pemohon
      </td>
    </tr>
    <tr>
      <td style="height: 70px;"></td>
      <td></td>
    </tr>
    <tr>
      <td>
        <span class="nama">Evi Susanti, S.Si</span><br>
        <span class="nip">197712142008102002</span>
      </td>
      <td class="right">
        <span class="nama">{{ $izin->user->name }}</span><br>
        <span class="nip">{{ $izin->user->nip ?? '-' }}</span>
      </td>
    </tr>
  </table>

  {{-- 🔹 CATATAN --}}
  <div class="catatan">Catatan dari atasan:</div>

</body>
</html>
