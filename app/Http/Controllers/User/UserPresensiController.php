<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use App\Models\Presensi;
use App\Models\Logbook;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UserPresensiController extends Controller
{
    public function index()
    {
        $presensi = Presensi::where('user_id', Auth::id())
            ->whereDate('tanggal', today())
            ->first();

        return view('user.presensi.index', compact('presensi'));
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'kegiatan' => 'required|in:WFO,WFH'
        ]);

        $today = Carbon::today();

        // Cek apakah user sudah absen masuk
        $presensi = Presensi::firstOrCreate(
            ['user_id' => Auth::id(), 'tanggal' => $today],
            [
                'jam_masuk' => now(),
                'status_kehadiran' => 'Hadir'
            ]
        );

        // Simpan juga ke tabel logbook
        Logbook::firstOrCreate(
            ['user_id' => Auth::id(), 'tanggal' => $today],
            [
                'kegiatan' => $request->kegiatan,
                'jam_masuk' => now(),
                'status' => 'Belum'
            ]
        );

        return back()->with('success', 'Jam masuk berhasil direkam.');
    }public function masuk(Request $request)
{
    $userId = Auth::id();
    $today = Carbon::today();

    $presensi = Presensi::firstOrCreate(
        ['user_id' => $userId, 'tanggal' => $today],
        [
            'jam_masuk' => now(),
            'status_kehadiran' => 'Hadir'
        ]
    );

    // Buat logbook hari ini jika belum ada
    Logbook::firstOrCreate(
        ['user_id' => $userId, 'tanggal' => $today],
        [
            'kegiatan' => 'WFO', // atau sesuai pilihan
            'jam_masuk' => now(),
            'status' => 'Belum'
        ]
    );

    return back()->with('success', 'Presensi masuk berhasil.');
}


}
