<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Logbook;
use App\Models\Presensi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UserLogbookController extends Controller
{
    public function index()
    {
        $logbooks = Logbook::where('user_id', Auth::id())
            ->latest()
            ->get();

        $presensi = Presensi::where('user_id', Auth::id())
            ->whereDate('tanggal', today())
            ->first();

        return view('user.logbook.index', compact('logbooks', 'presensi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'catatan_pekerjaan' => 'array',
            'catatan_pekerjaan.*' => 'nullable|string',
            'status' => 'array',
            'status.*' => 'required|in:Selesai,Belum',
        ]);

        $userId = Auth::id();
        $today = now()->toDateString();
        $jamPulang = now()->format('H:i:s');

        // 🔵 Gunakan kode yang kamu minta di sini
        $catatanArray = [];
        foreach ($request->catatan_pekerjaan as $key => $val) {
            if (!empty($val)) {
                $catatanArray[] = [
                    'kegiatan' => $val,
                    'status'   => $request->status[$key],
                ];
            }
        }

        $logbook = Logbook::where('user_id', $userId)
            ->whereDate('tanggal', $today)
            ->first();

        if ($logbook) {
            $logbook->update([
                'catatan_pekerjaan' => json_encode($catatanArray),
                'jam_pulang'        => $jamPulang,
                'status'            => 'selesai'
            ]);
        }

        Presensi::where('user_id', $userId)
            ->whereDate('tanggal', $today)
            ->update(['jam_pulang' => $jamPulang]);

        return redirect()->route('logbook.index')->with('success', 'Logbook & presensi pulang berhasil disimpan.');
    }
}
