<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RekapKehadiranExport;
use App\Exports\RekapKehadiranDetailExport;

class RekapKehadiranController extends Controller
{
    public function index(Request $request)
    {
        $bulanAngka = str_pad($request->input('bulan', date('m')), 2, '0', STR_PAD_LEFT);
        $tahun = $request->input('tahun', date('Y'));
        $mode = $request->input('mode', 'rekap');
        $kategori = $request->input('kategori', '');
        $today = date('Y-m-d');

        $listBulan = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
            '04' => 'April', '05' => 'Mei', '06' => 'Juni',
            '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
            '10' => 'Oktober', '11' => 'November', '12' => 'Desember',
        ];

        $bulan = $listBulan[$bulanAngka] ?? $bulanAngka;
        $listTahun = range(date('Y') - 5, date('Y') + 1);
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $bulanAngka, $tahun);

        // 🔹 Ambil user (selain admin)
        $users = DB::table('users')->where('role', '!=', 'admin');
        if ($kategori) $users->where('tipe_user', $kategori);
        $users = $users->orderBy('name')->get();

        // 🔹 Daftar tanggal
        $tanggalList = [];
        $hariMingguIndex = [];
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $tgl = sprintf('%04d-%02d-%02d', $tahun, $bulanAngka, $i);
            $tanggalList[] = $tgl;
            if (date('N', strtotime($tgl)) == 7) $hariMingguIndex[] = $i - 1;
        }

        // 🔹 Ambil data presensi & izin
        $detailKehadiran = DB::table('detail_kehadirans')
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulanAngka)
            ->get()
            ->groupBy('user_id');

        $cuti  = DB::table('cuti')->select('user_id', 'tgl_mulai', 'tgl_selesai')->get()->groupBy('user_id');
        $sakit = DB::table('sakit')->select('user_id', 'tgl_mulai', 'tgl_selesai')->get()->groupBy('user_id');
        $dinas = DB::table('dinas_luar')->select('user_id', 'tgl_mulai', 'tgl_selesai')->get()->groupBy('user_id');

        // ==========================
        // 🔹 MODE REKAP BULANAN
        // ==========================
        if ($mode === 'rekap') {
            $hariKerja = collect($tanggalList)
                ->reject(fn($tgl) => date('N', strtotime($tgl)) == 7)
                ->count();

            $rekap = [];
            foreach ($users as $user) {
                $hadir = $dl = $cutiCount = $sakitCount = $alpha = $wfo = $wfh = 0;

                foreach ($tanggalList as $tgl) {
                    if (date('N', strtotime($tgl)) == 7) continue;
                    $status = null;

                    // Periksa cuti, sakit, dinas luar
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

                    // Periksa detail kehadiran
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
                    'id'     => $user->id,
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
        }
        // ==========================
        // 🔹 MODE DETAIL HARIAN
        // ==========================
        else {
            $rekap = [];
            foreach ($users as $user) {
                $baris = ['name' => $user->name, 'data' => []];
                foreach ($tanggalList as $tgl) {
                    if (date('N', strtotime($tgl)) == 7) {
                        $baris['data'][] = '';
                        continue;
                    }

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

                    if ($log) $status = $log->status;
                    if (!$status && $tgl <= $today) $status = 'A';

                    $baris['data'][] = $status ?? '';
                }
                $rekap[] = $baris;
            }
        }

        return view('admin.rekap.index', compact(
            'rekap', 'bulan', 'tahun', 'bulanAngka', 'listBulan', 'listTahun',
            'mode', 'kategori', 'daysInMonth', 'hariMingguIndex'
        ));
    }

    // ==========================
    // 🔹 EXPORT EXCEL
    // ==========================
    public function export(Request $request)
{
    $bulan = $request->input('bulan', date('m'));
    $tahun = $request->input('tahun', date('Y'));
    $mode = $request->input('mode', 'rekap');
    $kategori = $request->input('kategori', '');

    if ($mode === 'detail') {
        // export versi detail
        return Excel::download(
            new RekapKehadiranDetailExport($bulan, $tahun, $kategori),
            "detail_kehadiran_{$bulan}_{$tahun}.xlsx"
        );
    }

    // export versi rekap (default)
    return Excel::download(
        new RekapKehadiranExport($bulan, $tahun, $mode, $kategori),
        "rekap_kehadiran_{$bulan}_{$tahun}.xlsx"
    );
}
}
