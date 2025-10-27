<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class RekapKehadiranDetailExport implements FromView
{
    protected $bulan, $tahun, $kategori;

    public function __construct($bulan, $tahun, $kategori)
    {
        $this->bulan = str_pad($bulan, 2, '0', STR_PAD_LEFT);
        $this->tahun = $tahun;
        $this->kategori = $kategori;
    }

    public function view(): View
    {
        $bulanAngka = $this->bulan;
        $tahun = $this->tahun;
        $kategori = $this->kategori;
        $today = date('Y-m-d');

        // ambil semua user (kecuali admin)
        $users = DB::table('users')->where('role', '!=', 'admin');
        if ($kategori) $users->where('tipe_user', $kategori);
        $users = $users->orderBy('name')->get();

        // daftar tanggal di bulan itu
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $bulanAngka, $tahun);
        $tanggalList = [];
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $tanggalList[] = sprintf('%04d-%02d-%02d', $tahun, $bulanAngka, $i);
        }

        // ambil data presensi dan izin
        $detailKehadiran = DB::table('detail_kehadirans')
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulanAngka)
            ->get()
            ->groupBy('user_id');

        $cuti  = DB::table('cuti')->select('user_id', 'tgl_mulai', 'tgl_selesai')->get()->groupBy('user_id');
        $sakit = DB::table('sakit')->select('user_id', 'tgl_mulai', 'tgl_selesai')->get()->groupBy('user_id');
        $dinas = DB::table('dinas_luar')->select('user_id', 'tgl_mulai', 'tgl_selesai')->get()->groupBy('user_id');

        $rekap = [];
        foreach ($users as $user) {
            $baris = ['name' => $user->name, 'data' => []];

            foreach ($tanggalList as $tgl) {
                if (date('N', strtotime($tgl)) == 7) {
                    $baris['data'][] = ''; // Minggu kosong
                    continue;
                }

                $status = null;

                // cek izin (cuti/sakit/dinas)
                foreach (['cuti' => 'C', 'sakit' => 'S', 'dinas' => 'DL'] as $jenis => $kode) {
                    if (!$status && isset(${$jenis}[$user->id])) {
                        foreach (${$jenis}[$user->id] as $item) {
                            if ($tgl >= $item->tgl_mulai && $tgl <= $item->tgl_selesai) {
                                $status = $kode;
                                break;
                            }
                        }
                    }
                }

                // cek presensi
                $log = isset($detailKehadiran[$user->id])
                    ? $detailKehadiran[$user->id]->firstWhere('tanggal', $tgl)
                    : null;

                if ($log) $status = $log->status;
                if (!$status && $tgl <= $today) $status = 'A';

                $baris['data'][] = $status ?? '';
            }

            $rekap[] = $baris;
        }

        return view('exports.rekap_kehadiran_detail', [
            'rekap' => $rekap,
            'bulanAngka' => $bulanAngka,
            'tahun' => $tahun,
            'daysInMonth' => $daysInMonth,
        ]);
    }
}
