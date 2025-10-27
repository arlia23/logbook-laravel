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
        $today = date('Y-m-d'); // ✅ Hari ini

        $listBulan = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];

        $bulan = $listBulan[$bulanAngka] ?? $bulanAngka;
        $listTahun = range(date('Y') - 5, date('Y') + 1);
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $bulanAngka, $tahun);

        // Ambil semua user (kecuali admin)
        $users = DB::table('users')->where('role', '!=', 'admin');
        if ($kategori) {
            $users->where('tipe_user', $kategori);
        }
        $users = $users->orderBy('name')->get();

        // List semua tanggal dalam bulan
        $tanggalList = [];
        $hariMingguIndex = [];
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $tanggal = sprintf('%04d-%02d-%02d', $tahun, $bulanAngka, $i);
            $tanggalList[] = $tanggal;
            if (date('N', strtotime($tanggal)) == 7) {
                $hariMingguIndex[] = $i - 1;
            }
        }

        // Ambil semua detail kehadiran bulan ini
        $detailKehadiran = DB::table('detail_kehadirans')
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulanAngka)
            ->get()
            ->groupBy('user_id');

        // Ambil cuti, sakit, dinas luar
        $cuti = DB::table('cuti')
            ->select('user_id', 'tgl_mulai', 'tgl_selesai')
            ->get()
            ->groupBy('user_id');

        $sakit = DB::table('sakit')
            ->select('user_id', 'tgl_mulai', 'tgl_selesai')
            ->get()
            ->groupBy('user_id');

        $dinas = DB::table('dinas_luar')
            ->select('user_id', 'tgl_mulai', 'tgl_selesai')
            ->get()
            ->groupBy('user_id');

        if ($mode === 'rekap') {
            // ✅ Mode REKAP
            $hariKerja = 0;
            foreach ($tanggalList as $tgl) {
                if (date('N', strtotime($tgl)) != 7) {
                    $hariKerja++;
                }
            }

            $rekap = [];

            foreach ($users as $user) {
                $hadir = $dl = $cutiCount = $sakitCount = $alpha = $wfo = $wfh = 0;

                foreach ($tanggalList as $tgl) {
                    if (date('N', strtotime($tgl)) == 7) {
                        continue; // skip Minggu
                    }

                    $status = null; // default kosong

                    // cek izin
                    if (isset($cuti[$user->id])) {
                        foreach ($cuti[$user->id] as $c) {
                            if ($tgl >= $c->tgl_mulai && $tgl <= $c->tgl_selesai) {
                                $status = 'C';
                                break;
                            }
                        }
                    }
                    if (!$status && isset($sakit[$user->id])) {
                        foreach ($sakit[$user->id] as $s) {
                            if ($tgl >= $s->tgl_mulai && $tgl <= $s->tgl_selesai) {
                                $status = 'S';
                                break;
                            }
                        }
                    }
                    if (!$status && isset($dinas[$user->id])) {
                        foreach ($dinas[$user->id] as $d) {
                            if ($tgl >= $d->tgl_mulai && $tgl <= $d->tgl_selesai) {
                                $status = 'DL';
                                break;
                            }
                        }
                    }

                    // override dengan detail absensi
                    $log = isset($detailKehadiran[$user->id])
                        ? $detailKehadiran[$user->id]->firstWhere('tanggal', $tgl)
                        : null;

                    if ($log) {
                        $status = $log->status;
                        if ($log->status == 'H' && $log->kegiatan == 'WFO') {
                            $wfo++;
                        } elseif ($log->status == 'H' && $log->kegiatan == 'WFH') {
                            $wfh++;
                        }
                    }

                    // ✅ Alfa hanya dihitung kalau tanggal <= hari ini dan status masih kosong
                    if (!$status && $tgl <= $today) {
                        $status = 'A';
                    }

                    // Hitung agregasi
                    if ($status == 'H') $hadir++;
                    elseif ($status == 'DL') $dl++;
                    elseif ($status == 'C') $cutiCount++;
                    elseif ($status == 'S') $sakitCount++;
                    elseif ($status == 'A') $alpha++;
                }

                $rekap[] = (object)[
                    'id'    => $user->id,
                    'name'  => $user->name,
                    'hk'    => $hariKerja,
                    'hadir' => $hadir,
                    'dl'    => $dl,
                    'cuti'  => $cutiCount,
                    'sakit' => $sakitCount,
                    'alpha' => $alpha,
                    'wfo'   => $wfo,
                    'wfh'   => $wfh,
                ];
            }
        } else {
            // ✅ Mode DETAIL
            $rekap = [];

            foreach ($users as $user) {
                $baris = ['name' => $user->name, 'data' => []];

                foreach ($tanggalList as $tgl) {
                    if (date('N', strtotime($tgl)) == 7) {
                        $baris['data'][] = ''; // kosong Minggu
                        continue;
                    }

                    $status = null;

                    // cek izin
                    if (isset($cuti[$user->id])) {
                        foreach ($cuti[$user->id] as $c) {
                            if ($tgl >= $c->tgl_mulai && $tgl <= $c->tgl_selesai) {
                                $status = 'C';
                                break;
                            }
                        }
                    }
                    if (!$status && isset($sakit[$user->id])) {
                        foreach ($sakit[$user->id] as $s) {
                            if ($tgl >= $s->tgl_mulai && $tgl <= $s->tgl_selesai) {
                                $status = 'S';
                                break;
                            }
                        }
                    }
                    if (!$status && isset($dinas[$user->id])) {
                        foreach ($dinas[$user->id] as $d) {
                            if ($tgl >= $d->tgl_mulai && $tgl <= $d->tgl_selesai) {
                                $status = 'DL';
                                break;
                            }
                        }
                    }

                    // override absensi
                    $log = isset($detailKehadiran[$user->id])
                        ? $detailKehadiran[$user->id]->where('tanggal', '=', $tgl)->values()->first()
                        : null;


                    if ($log) {
                        $status = $log->status;
                    }

                    // Alfa hanya kalau sudah lewat atau hari ini
                    if (!$status && $tgl <= $today) {
                        $status = 'A';
                    }

                    $baris['data'][] = $status ?? '';
                }

                $rekap[] = $baris;
            }
        }

        return view('user.rekap.index', compact(
            'rekap',
            'bulan',
            'tahun',
            'bulanAngka',
            'listBulan',
            'listTahun',
            'mode',
            'kategori',
            'daysInMonth',
            'hariMingguIndex'
        ));
    }
}
