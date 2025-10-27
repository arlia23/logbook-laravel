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
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        $user = Auth::user();
        $today = now()->toDateString();

        $presensi = Presensi::where('user_id', $user->id)
            ->whereDate('tanggal', $today)
            ->first();

        return view('user.presensi.index', compact('presensi'));
    }

    public function masuk(Request $request)
{
    $request->validate([
        'kegiatan' => 'required|in:WFO,WFH',
    ]);

    $user = Auth::user();
    $today = now()->toDateString();

    // Cek apakah sudah presensi hari ini
    $sudah = \App\Models\Presensi::where('user_id', $user->id)
        ->whereDate('tanggal', $today)
        ->exists();

    if ($sudah) {
        return back()->with('error', 'Anda sudah presensi hari ini.');
    }

    // Simpan presensi masuk
    $presensi = \App\Models\Presensi::create([
        'user_id' => $user->id,
        'tanggal' => $today,
        'jam_masuk' => now()->format('H:i:s'),
        'status' => 'H',
        'kegiatan' => $request->kegiatan,
    ]);

    // 🔹 Tambahkan otomatis ke detail_kehadirans
    \DB::table('detail_kehadirans')->updateOrInsert(
        [
            'user_id' => $user->id,
            'tanggal' => $today,
        ],
        [
            'status' => 'H',
            'kegiatan' => $request->kegiatan,
            'created_at' => now(),
            'updated_at' => now(),
        ]
    );

    // Buat logbook kosong untuk hari ini
    \App\Models\Logbook::updateOrCreate(
        ['user_id' => $user->id, 'tanggal' => $today],
        [
            'kegiatan' => $request->kegiatan,
            'catatan_pekerjaan' => json_encode([]),
            'status' => 'Belum',
            'jam_masuk' => now()->format('H:i:s'),
        ]
    );

    return redirect()->back()->with('success', 'Presensi masuk berhasil direkam!');
}


    public function pulang(Request $request)
    {
        $userId = Auth::id();
        $today = Carbon::today();

        // Validasi input logbook
        $request->validate([
            'catatan_pekerjaan' => 'required|array|min:1',
            'status' => 'required|array|min:1',
        ]);

        // Format catatan pekerjaan ke bentuk array
        $catatan = [];
        foreach ($request->catatan_pekerjaan as $i => $pekerjaan) {
            if (!empty($pekerjaan)) {
                $catatan[] = [
                    'kegiatan' => $pekerjaan,
                    'status' => $request->status[$i] ?? 'Belum',
                ];
            }
        }

        // Update presensi: tambahkan jam pulang
        $presensi = Presensi::where('user_id', $userId)
            ->whereDate('tanggal', $today)
            ->first();

        if ($presensi) {
            $presensi->update(['jam_pulang' => now()->format('H:i:s')]);
        }

        // Update logbook: simpan catatan & status
        $logbook = Logbook::updateOrCreate(
            ['user_id' => $userId, 'tanggal' => $today],
            [
                'catatan_pekerjaan' => json_encode($catatan),
                'jam_pulang' => now()->format('H:i:s'),
                'status' => collect($catatan)->contains('status', 'Belum') ? 'Belum' : 'Selesai',
                'kegiatan' => $presensi->kegiatan ?? 'WFO/WFH',
            ]
        );

        return redirect()->route('user.logbook.index')
            ->with('success', 'Presensi pulang dan logbook berhasil disimpan.');
    }
}