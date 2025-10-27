<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class RekapKehadiranExport implements FromView
{
    protected $bulan, $tahun, $mode, $kategori;

    public function __construct($bulan, $tahun, $mode, $kategori)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
        $this->mode = $mode;
        $this->kategori = $kategori;
    }

    public function view(): View
    {
        $bulanAngka = str_pad($this->bulan, 2, '0', STR_PAD_LEFT);
        $tahun = $this->tahun;
        $kategori = $this->kategori;
        $today = date('Y-m-d');

        $users = DB::table('users')->where('role', '!=', 'admin');
        if ($kategori) $users->where('tipe_user', $kategori);
        $users = $users->orderBy('name')->get();

        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $bulanAngka, $tahun);
        $tanggalList = [];
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $tanggalList[] = sprintf('%04d-%02d-%02d', $tahun, $bulanAngka, $i);
        }

        $detailKehadiran = DB::table('detail_kehadirans')
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulanAngka)
            ->get()
            ->groupBy('user_id');

        $cuti  = DB::table('cuti')->select('user_id', 'tgl_mulai', 'tgl_selesai')->get()->groupBy('user_id');
        $sakit = DB::table('sakit')->select('user_id', 'tgl_mulai', 'tgl_selesai')->get()->groupBy('user_id');
        $dinas = DB::table('dinas_luar')->select('user_id', 'tgl_mulai', 'tgl_selesai')->get()->groupBy('user_id');

        $hariKerja = collect($tanggalList)
            ->reject(fn($tgl) => date('N', strtotime($tgl)) == 7)
            ->count();

        $rekap = [];

        foreach ($users as $user) {
            $hadir = $dl = $cutiCount = $sakitCount = $alpha = $wfo = $wfh = 0;

            foreach ($tanggalList as $tgl) {
                if (date('N', strtotime($tgl)) == 7) continue;
                $status = null;

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

                $log = isset($detailKehadiran[$user->id])
                    ? $detailKehadiran[$user->id]->firstWhere('tanggal', $tgl)
                    : null;

                if ($log) {
                    $status = $log->status;
                    if ($log->status == 'H' && $log->kegiatan == 'WFO') $wfo++;
                    elseif ($log->status == 'H' && $log->kegiatan == 'WFH') $wfh++;
                }

                if (!$status && $tgl <= $today) $status = 'A';

                match ($status) {
                    'H'  => $hadir++,
                    'DL' => $dl++,
                    'C'  => $cutiCount++,
                    'S'  => $sakitCount++,
                    'A'  => $alpha++,
                    default => null,
                };
            }

            $rekap[] = (object)[
                'name'   => $user->name,
                'hk'     => $hariKerja,
                'hadir'  => $hadir,
                'dl'     => $dl,
                'cuti'   => $cutiCount,
                'sakit'  => $sakitCount,
                'alpha'  => $alpha,
                'wfo'    => $wfo,
                'wfh'    => $wfh,
            ];
        }

        return view('exports.rekap_kehadiran', compact('rekap', 'bulanAngka', 'tahun', 'hariKerja'));
    }
}
