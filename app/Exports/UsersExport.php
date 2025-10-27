<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class UsersExport implements FromCollection, WithHeadings
{
    protected $bulan;
    protected $tahun;
    protected $mode;

    public function __construct($bulan, $tahun, $mode = 'rekap')
    {
        $this->bulan = str_pad($bulan, 2, '0', STR_PAD_LEFT); // pastikan format 01-12
        $this->tahun = $tahun;
        $this->mode  = $mode;
    }

    public function collection()
    {
        return $this->mode === 'rekap'
            ? $this->getRekap()
            : $this->getDetail();
    }

    /**
     * ✅ Rekap bulanan
     */
    protected function getRekap()
    {
        $today = date('Y-m-d');
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $this->bulan, $this->tahun);

        $tanggalList = [];
        foreach (range(1, $daysInMonth) as $i) {
            $tanggal = sprintf('%04d-%02d-%02d', $this->tahun, $this->bulan, $i);
            if (date('N', strtotime($tanggal)) != 7) { // skip Minggu
                $tanggalList[] = $tanggal;
            }
        }
        $hariKerja = count($tanggalList);

        $users = DB::table('users')->where('role','!=','admin')->orderBy('name')->get();
        $detailKehadiran = DB::table('detail_kehadirans')
            ->whereYear('tanggal', $this->tahun)
            ->whereMonth('tanggal', $this->bulan)
            ->get()
            ->groupBy('user_id');

        // izin
        $cuti = DB::table('cuti')->select('user_id','tgl_mulai','tgl_selesai')->get()->groupBy('user_id');
        $sakit = DB::table('sakit')->select('user_id','tgl_mulai','tgl_selesai')->get()->groupBy('user_id');
        $dinas = DB::table('dinas_luar')->select('user_id','tgl_mulai','tgl_selesai')->get()->groupBy('user_id');

        $data = collect();
        foreach ($users as $user) {
            $hadir = $dl = $cutiCount = $sakitCount = $alpha = $wfo = $wfh = 0;

            foreach ($tanggalList as $tgl) {
                $status = null;

                // cek izin
                if (isset($cuti[$user->id])) {
                    foreach ($cuti[$user->id] as $c) {
                        if ($tgl >= $c->tgl_mulai && $tgl <= $c->tgl_selesai) {
                            $status = 'C'; break;
                        }
                    }
                }
                if (!$status && isset($sakit[$user->id])) {
                    foreach ($sakit[$user->id] as $s) {
                        if ($tgl >= $s->tgl_mulai && $tgl <= $s->tgl_selesai) {
                            $status = 'S'; break;
                        }
                    }
                }
                if (!$status && isset($dinas[$user->id])) {
                    foreach ($dinas[$user->id] as $d) {
                        if ($tgl >= $d->tgl_mulai && $tgl <= $d->tgl_selesai) {
                            $status = 'DL'; break;
                        }
                    }
                }

                // override absensi
                $log = isset($detailKehadiran[$user->id])
                    ? $detailKehadiran[$user->id]->firstWhere('tanggal', $tgl)
                    : null;

                if ($log) {
                    $status = $log->status;
                    if ($log->status == 'H' && $log->kegiatan == 'WFO') $wfo++;
                    if ($log->status == 'H' && $log->kegiatan == 'WFH') $wfh++;
                }

                // Alfa jika sudah lewat & tidak ada status
                if (!$status && $tgl <= $today) {
                    $status = 'A';
                }

                if ($status == 'H') $hadir++;
                elseif ($status == 'DL') $dl++;
                elseif ($status == 'C') $cutiCount++;
                elseif ($status == 'S') $sakitCount++;
                elseif ($status == 'A') $alpha++;
            }

            $data->push([
                'Nama Pegawai' => $user->name,
                'HK'           => $hariKerja,
                'Hadir'        => $hadir,
                'DL'           => $dl,
                'Cuti'         => $cutiCount,
                'Sakit'        => $sakitCount,
                'Alpha'        => $alpha,
                'WFO'          => $wfo,
                'WFH'          => $wfh,
            ]);
        }

        return $data;
    }

    /**
     * ✅ Detail harian
     */
    protected function getDetail()
    {
        $today = date('Y-m-d');
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $this->bulan, $this->tahun);

        $tanggalList = [];
        foreach (range(1, $daysInMonth) as $i) {
            $tanggalList[] = sprintf('%04d-%02d-%02d', $this->tahun, $this->bulan, $i);
        }

        $users = DB::table('users')->where('role','!=','admin')->orderBy('name')->get();
        $detailKehadiran = DB::table('detail_kehadirans')
            ->whereYear('tanggal', $this->tahun)
            ->whereMonth('tanggal', $this->bulan)
            ->get()
            ->groupBy('user_id');

        // izin
        $cuti = DB::table('cuti')->select('user_id','tgl_mulai','tgl_selesai')->get()->groupBy('user_id');
        $sakit = DB::table('sakit')->select('user_id','tgl_mulai','tgl_selesai')->get()->groupBy('user_id');
        $dinas = DB::table('dinas_luar')->select('user_id','tgl_mulai','tgl_selesai')->get()->groupBy('user_id');

        $data = collect();
        foreach ($users as $user) {
            $row = ['Nama Pegawai' => $user->name];

            foreach ($tanggalList as $tgl) {
                $status = null;

                if (date('N', strtotime($tgl)) == 7) {
                    $row[$tgl] = ''; // kosong Minggu
                    continue;
                }

                if (isset($cuti[$user->id])) {
                    foreach ($cuti[$user->id] as $c) {
                        if ($tgl >= $c->tgl_mulai && $tgl <= $c->tgl_selesai) {
                            $status = 'C'; break;
                        }
                    }
                }
                if (!$status && isset($sakit[$user->id])) {
                    foreach ($sakit[$user->id] as $s) {
                        if ($tgl >= $s->tgl_mulai && $tgl <= $s->tgl_selesai) {
                            $status = 'S'; break;
                        }
                    }
                }
                if (!$status && isset($dinas[$user->id])) {
                    foreach ($dinas[$user->id] as $d) {
                        if ($tgl >= $d->tgl_mulai && $tgl <= $d->tgl_selesai) {
                            $status = 'DL'; break;
                        }
                    }
                }

                $log = isset($detailKehadiran[$user->id])
                    ? $detailKehadiran[$user->id]->firstWhere('tanggal', $tgl)
                    : null;

                if ($log) {
                    $status = $log->status;
                }

                if (!$status && $tgl <= $today) {
                    $status = 'A';
                }

                $row[$tgl] = $status ?? '';
            }

            $data->push($row);
        }

        return $data;
    }

    /**
     * ✅ Heading kolom Excel
     */
    public function headings(): array
    {
        $bulanNama = date("F", mktime(0, 0, 0, $this->bulan, 1));
        $judul = ["Rekap Kehadiran Bulan {$bulanNama} Tahun {$this->tahun}"];

        if ($this->mode === 'rekap') {
            $header = ['Nama Pegawai','HK','Hadir','DL','Cuti','Sakit','Alpha','WFO','WFH'];
        } else {
            $header = ['Nama Pegawai'];
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $this->bulan, $this->tahun);
            foreach (range(1, $daysInMonth) as $i) {
                $header[] = $i;
            }
        }

        // row pertama = judul, row kedua = header tabel
        return [$judul, $header];
    }
}
