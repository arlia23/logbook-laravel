<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserRekapController extends Controller
{
    public function index(Request $request)
    {
        $bulanAngka = str_pad($request->input('bulan', date('m')), 2, '0', STR_PAD_LEFT);
        $tahun = $request->input('tahun', date('Y'));
        $mode = $request->input('mode', 'rekap');
        $kategori = $request->input('kategori', '');

        $listBulan = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
            '04' => 'April', '05' => 'Mei', '06' => 'Juni',
            '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
            '10' => 'Oktober', '11' => 'November', '12' => 'Desember',
        ];

        $bulan = $listBulan[$bulanAngka] ?? $bulanAngka;
        $listTahun = range(date('Y') - 5, date('Y') + 1);
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $bulanAngka, $tahun);

        // Ambil semua pegawai
        $users = DB::table('users')->where('role', '!=', 'admin');
        if ($kategori) $users->where('tipe_user', $kategori);
        $users = $users->orderBy('name')->get();

        $hariMingguIndex = [];

        // Referensi waktu
        $today = date('Y-m-d');
        $bulanSekarang = date('m');
        $tahunSekarang = date('Y');
        $tanggalHariIni = date('d');

        if ($mode === 'rekap') {
            // ✅ Hitung HK = total hari kerja sebulan penuh (tanpa Minggu)
            $hariKerja = 0;
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $tanggal = sprintf('%04d-%02d-%02d', $tahun, $bulanAngka, $day);
                if (date('N', strtotime($tanggal)) != 7) {
                    $hariKerja++;
                }
            }

            // Batas tanggal hanya sampai hari ini kalau bulan berjalan
            $lastDay = ($bulanAngka == $bulanSekarang && $tahun == $tahunSekarang)
                ? $tanggalHariIni
                : $daysInMonth;

            $query = DB::table('users')
                ->leftJoin('detail_kehadirans', function ($join) use ($tahun, $bulanAngka, $lastDay, $bulanSekarang, $tahunSekarang) {
                    $join->on('users.id', '=', 'detail_kehadirans.user_id')
                         ->whereYear('tanggal', $tahun)
                         ->whereMonth('tanggal', $bulanAngka);

                    // kalau bulan berjalan → batasi hanya sampai hari ini
                    if ($bulanAngka == $bulanSekarang && $tahun == $tahunSekarang) {
                        $join->whereDay('tanggal', '<=', $lastDay);
                    }
                })
                ->where('users.role', '!=', 'admin');

            if ($kategori) $query->where('users.tipe_user', $kategori);

            $rekap = $query->select(
                    'users.id', 'users.name',
                    DB::raw("$hariKerja as hk"),
                    DB::raw("COALESCE(SUM(CASE WHEN status = 'Hadir' THEN 1 ELSE 0 END),0) as hadir"),
                    DB::raw("COALESCE(SUM(CASE WHEN status = 'DL' THEN 1 ELSE 0 END),0) as dl"),
                    DB::raw("COALESCE(SUM(CASE WHEN status = 'Cuti' THEN 1 ELSE 0 END),0) as cuti"),
                    DB::raw("COALESCE(SUM(CASE WHEN status = 'Sakit' THEN 1 ELSE 0 END),0) as sakit"),
                    DB::raw("COALESCE(SUM(CASE WHEN kegiatan = 'WFO' THEN 1 ELSE 0 END),0) as wfo"),
                    DB::raw("COALESCE(SUM(CASE WHEN kegiatan = 'WFH' THEN 1 ELSE 0 END),0) as wfh")
                )
                ->groupBy('users.id', 'users.name')
                ->orderBy('users.name')
                ->get()
                ->map(function ($row) use ($tahun, $bulanAngka, $hariKerja, $bulanSekarang, $tahunSekarang, $tanggalHariIni, $daysInMonth) {
                    // ✅ Alpha dihitung hanya sampai hari ini kalau bulan berjalan
                    $effectiveHK = $hariKerja;
                    if ($bulanAngka == $bulanSekarang && $tahun == $tahunSekarang) {
                        $effectiveHK = 0;
                        for ($d = 1; $d <= $tanggalHariIni; $d++) {
                            $tanggal = sprintf('%04d-%02d-%02d', $tahun, $bulanAngka, $d);
                            if (date('N', strtotime($tanggal)) != 7) {
                                $effectiveHK++;
                            }
                        }
                    }
                    $row->alpha = $effectiveHK - ($row->hadir + $row->dl + $row->cuti + $row->sakit);
                    return $row;
                });

        } else {
            // Mode DETAIL
            $tanggalList = [];

            for ($i = 1; $i <= $daysInMonth; $i++) {
                $tanggal = sprintf('%04d-%02d-%02d', $tahun, $bulanAngka, $i);
                $tanggalList[] = $tanggal;

                if (date('N', strtotime($tanggal)) == 7) {
                    $hariMingguIndex[] = $i - 1; // 0-based index
                }
            }

            $logbookData = DB::table('logbooks')
                ->select('user_id', 'tanggal', 'kegiatan', 'status')
                ->whereYear('tanggal', $tahun)
                ->whereMonth('tanggal', $bulanAngka)
                ->get()
                ->groupBy('user_id');

            $rekap = [];

            foreach ($users as $user) {
                $baris = ['name' => $user->name, 'data' => []];

                foreach ($tanggalList as $tanggal) {
                    // Jika Minggu
                    if (date('N', strtotime($tanggal)) == 7) {
                        $baris['data'][] = '';
                        continue;
                    }

                    // Kalau tanggal belum lewat → kosong
                    if ($tanggal > $today) {
                        $status = '';
                    } else {
                        $log = isset($logbookData[$user->id])
                            ? $logbookData[$user->id]->firstWhere('tanggal', $tanggal)
                            : null;

                        if (!$log) {
                            $status = 'A'; // lewat tapi kosong → Alpha
                        } else {
                            if (strtolower($log->status) === 'selesai') {
                                switch (strtoupper($log->kegiatan)) {
                                    case 'WFO':
                                    case 'WFH':
                                        $status = 'H'; break;
                                    case 'DL':
                                        $status = 'DL'; break;
                                    case 'CUTI':
                                        $status = 'C'; break;
                                    case 'SAKIT':
                                        $status = 'S'; break;
                                    default:
                                        $status = 'H'; break;
                                }
                            } else {
                                $status = 'A';
                            }
                        }
                    }

                    $baris['data'][] = $status;
                }

                $rekap[] = $baris;
            }
        }

        return view('user.rekap.index', compact(
            'rekap', 'bulan', 'tahun', 'bulanAngka', 'listBulan', 'listTahun',
            'mode', 'kategori', 'daysInMonth', 'hariMingguIndex'
        ));
    }
}
