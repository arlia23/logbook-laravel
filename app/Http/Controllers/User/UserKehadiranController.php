<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kehadiran;
use Carbon\Carbon;

class UserKehadiranController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $bulan    = (int) $request->input('bulan', now()->month);
        $tahun    = (int) $request->input('tahun', now()->year);
        $model    = $request->input('model', 'rekapitulasi'); // default rekap
        $kategori = $request->input('kategori', 'all');       // PHL, P3K, PNS

        // Ambil data kehadiran user
        $kehadiran = Kehadiran::query()
            ->where('user_id', $user->id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get();

        if ($model === 'rekapitulasi') {
            $rekap = [
                'H'  => $kehadiran->where('status', 'H')->count(),
                'DL' => $kehadiran->where('status', 'DL')->count(),
                'C'  => $kehadiran->where('status', 'C')->count(),
                'S'  => $kehadiran->where('status', 'S')->count(),
                'A'  => $kehadiran->where('status', 'A')->count(),
            ];

            return view('user.kehadiran.rekapitulasi', compact('rekap', 'bulan', 'tahun', 'kategori'));
        }

        if ($model === 'detail') {
            $daysInMonth = Carbon::createFromDate($tahun, $bulan, 1)->daysInMonth;
            $detail = [];

            for ($i = 1; $i <= $daysInMonth; $i++) {
                $date = Carbon::createFromDate($tahun, $bulan, $i);

                if ($date->isSunday()) {
                    $detail[$i] = ''; // kosong kalau minggu
                } else {
                    $absen = $kehadiran->firstWhere('tanggal', $date->toDateString());
                    $detail[$i] = $absen?->status ?? 'A'; // default Alfa
                }
            }

            return view('user.kehadiran.detail', compact('detail', 'bulan', 'tahun', 'kategori'));
        }

        // fallback kalau model tidak valid
        return redirect()->back()->with('error', 'Model kehadiran tidak valid.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kegiatan' => 'required|in:WFO,WFH', // sesuaikan dengan pilihan yang kamu sediakan
        ]);

        $user = Auth::user();
        $tanggal = Carbon::today()->toDateString();

        // Cek apakah sudah ada presensi hari ini
        $sudahAda = Kehadiran::where('user_id', $user->id)
            ->whereDate('tanggal', $tanggal)
            ->exists();

        if ($sudahAda) {
            return redirect()->back()->with('error', 'Anda sudah melakukan presensi hari ini.');
        }

        Kehadiran::create([
            'user_id' => $user->id,
            'tanggal' => $tanggal,
            'status'  => 'H', // dianggap hadir
            'kegiatan'=> $request->kegiatan,
        ]);

        return redirect()->back()->with('success', 'Presensi berhasil disimpan.');
    }
}
