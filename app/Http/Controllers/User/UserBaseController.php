<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Presensi;
use App\Models\User;
use App\Models\Logbook;
use App\Models\DetailKehadiran;
use Carbon\Carbon;

class UserBaseController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $today = Carbon::today();

        // ✅ Ambil data presensi hari ini
        $presensi = Presensi::where('user_id', $userId)
            ->whereDate('tanggal', $today)
            ->first();

        // ✅ Hitung jumlah berdasarkan tipe_user
        $jumlahPNS = User::where('role', 'user')->where('tipe_user', 'pns')->count();
        $jumlahP3K = User::where('role', 'user')->where('tipe_user', 'p3k')->count();
        $jumlahPHL = User::where('role', 'user')->where('tipe_user', 'phl')->count();

        // ✅ Cek logbook hari ini
        $logbook = Logbook::where('user_id', $userId)
            ->whereDate('tanggal', $today)
            ->first();

        // ✅ Cek apakah sudah punya status hari ini di detail_kehadiran
        $hasOtherStatus = DetailKehadiran::where('user_id', $userId)
            ->whereDate('tanggal', $today)
            ->whereIn('status', ['H', 'C', 'S', 'DL'])
            ->exists();

        // ✅ Kalau tidak ada logbook dan tidak punya status lain → tandai ALFA
        if (!$logbook && !$hasOtherStatus) {
            DetailKehadiran::firstOrCreate(
                [
                    'user_id' => $userId,
                    'tanggal' => $today,
                ],
                [
                    'status' => 'A',
                    'kegiatan' => null,
                    'catatan' => 'Tidak mengisi logbook',

                ]
            );
        }

        // ✅ Hitung total logbook terisi & tidak terisi bulan ini
        $startMonth = Carbon::now()->startOfMonth();
        $endMonth = Carbon::now()->endOfMonth();

        // 🔹 Hitung jumlah hari aktif (Senin–Sabtu)
        $totalHari = 0;
        $loopDate = $startMonth->copy();
        while ($loopDate->lte($endMonth)) {
            if (!$loopDate->isSunday()) {
                $totalHari++;
            }
            $loopDate->addDay();
        }

        $totalIsi = Logbook::where('user_id', $userId)
            ->whereBetween('tanggal', [$startMonth, $endMonth])
            ->count();

        $totalTidakIsi = max(0, $totalHari - $totalIsi);

        // 🔹 Hitung persentase logbook
        $persenIsi = $totalHari > 0 ? round(($totalIsi / $totalHari) * 100, 1) : 0;
        $persenTidakIsi = 100 - $persenIsi;

        // ✅ Hitung persentase kehadiran (H, DL, C, S) bulan ini
        $totalKehadiran = DetailKehadiran::where('user_id', $userId)
            ->whereBetween('tanggal', [$startMonth, $endMonth])
            ->count();

        $countHadir = DetailKehadiran::where('user_id', $userId)
            ->whereBetween('tanggal', [$startMonth, $endMonth])
            ->where('status', 'H')->count();

        $countDL = DetailKehadiran::where('user_id', $userId)
            ->whereBetween('tanggal', [$startMonth, $endMonth])
            ->where('status', 'DL')->count();

        $countCuti = DetailKehadiran::where('user_id', $userId)
            ->whereBetween('tanggal', [$startMonth, $endMonth])
            ->where('status', 'C')->count();

        $countSakit = DetailKehadiran::where('user_id', $userId)
            ->whereBetween('tanggal', [$startMonth, $endMonth])
            ->where('status', 'S')->count();

        // 🔹 Persentase dari total kehadiran aktif (hindari pembagian nol)
        if ($totalKehadiran > 0) {
            $persenHadir = round(($countHadir / $totalKehadiran) * 100, 1);
            $persenDL = round(($countDL / $totalKehadiran) * 100, 1);
            $persenCuti = round(($countCuti / $totalKehadiran) * 100, 1);
            $persenSakit = round(($countSakit / $totalKehadiran) * 100, 1);
        } else {
            $persenHadir = $persenDL = $persenCuti = $persenSakit = 0;
        }

        // ✅ Kirim semua ke view
        return view('user.home', compact(
            'presensi',
            'jumlahPNS',
            'jumlahP3K',
            'jumlahPHL',
            'totalIsi',
            'totalTidakIsi',
            'persenIsi',
            'persenTidakIsi',
            'persenHadir',
            'persenDL',
            'persenCuti',
            'persenSakit'
        ));
    }
}
