<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Formulir Izin Tidak Masuk Kantor</title>
<style>
  body {
    font-family: "Times New Roman", Times, serif;
    font-size: 12pt;
    margin: 40px;
  }

  /* === KOP SURAT: 2 LAPIS GARIS === */
  .kop-container {
    width: 100%;
    border: 1px double #444; /* Lapis luar: double */
    padding: 2px;
    box-sizing: border-box;
  }

  .kop-table {
    width: 100%;
    border-collapse: collapse;
    border: 1px solid #444; /* Lapis dalam: 1 garis tipis */
    table-layout: fixed;
  }

  .kop-table td {
    border: 1px solid #444; /* Hanya satu garis antar sel */
    vertical-align: middle;
    padding: 6px;
  }

  /* === LOGO DAN TEKS KIRI === */
  .logo {
    width: 70px;
    height: auto;
  }

  .instansi {
    font-weight: bold;
    font-size: 12pt;
    line-height: 1.3;
  }

  .slogan {
    font-style: italic;
    font-size: 10pt;
  }

  /* === TENGAH: JUDUL === */
  .judul {
    text-align: center;
    font-weight: bold;
    font-size: 13pt;
    line-height: 1.5;
  }

  /* === KANAN: INFO DOKUMEN === */
  .info-dokumen {
    width: 100%;
    border-collapse: collapse;
    font-size: 10pt;
  }

  .info-dokumen td {
    border: 1px solid #444;
    padding: 4px 6px;
  }

  .info-dokumen td:first-child {
    width: 45%;
  }

  /* === ISI SURAT === */
  .spasi { margin-top: 15px; }
  .small { font-size: 11pt; }

</style>
</head>
<body>

<!-- === KOP SURAT === -->
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
          FORMULIR SURAT<br>
          PERMOHONAN IZIN TIDAK<br>
          MASUK KANTOR
        </div>
      </td>

      <!-- KANAN -->
      <td style="width: 30%;">
        <table class="info-dokumen">
          <tr>
            <td>No. Dok.</td>
            <td>09-740/Lib.UR/F-16</td>
          </tr>
          <tr>
            <td>Revisi</td>
            <td>00</td>
          </tr>
          <tr>
            <td>Efektif</td>
            <td>01-09-2016</td>
          </tr>
          <tr>
            <td>Halaman</td>
            <td>1 dari 1</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</div>

<!-- === ISI SURAT === -->
<div class="spasi small">
  Yang bertanda tangan di bawah ini :
</div>

<table class="small spasi">
  <tr><td style="width: 180px;">Nama</td><td>:</td><td>{{ $user->name }}</td></tr>
  <tr><td>NIP/NIPH</td><td>:</td><td>{{ $user->nip ?? '-' }}</td></tr>
  <tr><td>Pangkat / Gol</td><td>:</td><td>{{ $user->pangkat ?? '-' }}</td></tr>
  <tr><td>Jabatan</td><td>:</td><td>{{ $user->jabatan ?? '-' }}</td></tr>
  <tr><td>Unit Kerja</td><td>:</td><td>{{ $user->unit_fakultas ?? '-' }}</td></tr>
</table>

<div class="spasi small">
  Dengan ini mengajukan permohonan izin untuk tidak masuk bekerja / kantor selama 
  {{ \Carbon\Carbon::parse($cuti->tgl_mulai)->diffInDays(\Carbon\Carbon::parse($cuti->tgl_selesai)) + 1 }} hari 
  pada hari {{ \Carbon\Carbon::parse($cuti->tgl_mulai)->translatedFormat('l') }} s/d 
  {{ \Carbon\Carbon::parse($cuti->tgl_selesai)->translatedFormat('l') }} 
  tanggal {{ \Carbon\Carbon::parse($cuti->tgl_mulai)->translatedFormat('d F Y') }} s/d 
  {{ \Carbon\Carbon::parse($cuti->tgl_selesai)->translatedFormat('d F Y') }}, 
  dengan alasan {{ $cuti->keterangan ?? '...' }}.
</div>


<div class="spasi small">
  Demikian permohonan ini, atas perhatian Bapak/Ibu diucapkan terima kasih.
</div>
<br><br>

<div class="spasi small">
  Pekanbaru, {{ $tglSurat }}
</div>

<table class="spasi small" style="width: 100%;">
  <tr>
    <td style="width: 50%; text-align: left;">
      Diketahui atasan langsung,<br>
      Sub Koordinator TU<br><br><br><br>
      <strong>Evi Susanti, S.Si</strong><br>
      197712142008102002
    </td>
    <td style="text-align: right;">
      Hormat Saya,<br>
      Pemohon<br><br><br><br>
      <strong>{{ $user->name }}</strong><br>
      {{ $user->nip ?? '-' }}
    </td>
  </tr>
</table>

<div class="spasi small">
  <strong>Catatan dari atasan:</strong>
</div>

</body>
</html>
