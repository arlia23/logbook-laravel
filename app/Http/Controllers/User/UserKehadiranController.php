<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DetailKehadiran;
use Carbon\Carbon;

class UserKehadiranController extends Controller
{
    // 🔹 Tampilkan rekap atau detail kehadiran user yang sedang login
    public function index(Request $request)
    {
        $user = Auth::user();
        $bulan = (int) $request->input('bulan', now()->month);
        $tahun = (int) $request->input('tahun', now()->year);
        $mode = $request->input('mode', 'rekap'); // rekap/detail

        // Ambil data kehadiran dari tabel detail_kehadirans
        $kehadiran = DetailKehadiran::where('user_id', $user->id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get();

        if ($mode === 'rekap') {
            $rekap = [
                'hadir' => $kehadiran->where('status', 'H')->count(),
                'dl'    => $kehadiran->where('status', 'DL')->count(),
                'cuti'  => $kehadiran->where('status', 'C')->count(),
                'sakit' => $kehadiran->where('status', 'S')->count(),
                'alpha' => $kehadiran->where('status', 'A')->count(),
                'wfo'   => $kehadiran->where('kegiatan', 'WFO')->count(),
                'wfh'   => $kehadiran->where('kegiatan', 'WFH')->count(),
            ];

            return view('user.kehadiran.rekapitulasi', compact('rekap', 'bulan', 'tahun'));
        }

        // Mode detail
        $daysInMonth = Carbon::createFromDate($tahun, $bulan, 1)->daysInMonth;
        $detail = [];

        for ($i = 1; $i <= $daysInMonth; $i++) {
            $date = Carbon::createFromDate($tahun, $bulan, $i);
            if ($date->isSunday()) {
                $detail[$i] = '';
                continue;
            }

            $record = $kehadiran->firstWhere('tanggal', $date->toDateString());
            $detail[$i] = $record->status ?? 'A';
        }

        return view('user.kehadiran.detail', compact('detail', 'bulan', 'tahun'));
    }

    // 🔹 Simpan kehadiran harian (Presensi)
    public function store(Request $request)
    {
        $request->validate([
            'kegiatan' => 'required|in:WFO,WFH',
        ]);

        $user = Auth::user();
        $tanggal = Carbon::today()->toDateString();

        // Cek apakah sudah absen
        $sudahAda = DetailKehadiran::where('user_id', $user->id)
            ->whereDate('tanggal', $tanggal)
            ->exists();

        if ($sudahAda) {
            return redirect()->back()->with('error', 'Anda sudah melakukan presensi hari ini.');
        }

        DetailKehadiran::create([
            'user_id' => $user->id,
            'tanggal' => $tanggal,
            'status'  => 'H',
            'kegiatan'=> $request->kegiatan,
        ]);

        return redirect()->back()->with('success', 'Presensi berhasil disimpan.');
    }
}
