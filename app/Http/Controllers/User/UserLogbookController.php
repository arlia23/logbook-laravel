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
    public function index(Request $request)
    {
        $user = Auth::user();

        // Ambil bulan & tahun dari query string (default: bulan & tahun sekarang)
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));
        $jenis = $request->input('jenis'); // WFO / WFH / null (semua)
        $search = $request->input('search');

        $query = Logbook::where('user_id', $user->id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun);

        if ($jenis) {
            $query->where('kegiatan', $jenis);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('catatan_pekerjaan', 'like', "%$search%")
                    ->orWhere('kegiatan', 'like', "%$search%");
            });
        }

        $logbooks = $query->orderBy('tanggal', 'desc')->get();

        return view('user.logbook.index', compact('logbooks', 'bulan', 'tahun', 'jenis', 'search', 'user'));
    }

    public function cetak($jenis, Request $request)
{
    $user = Auth::user();
    $bulan = $request->input('bulan', date('m'));
    $tahun = $request->input('tahun', date('Y'));

    $logbooks = Logbook::where('user_id', $user->id)
        ->where('kegiatan', strtoupper($jenis))
        ->whereMonth('tanggal', $bulan)
        ->whereYear('tanggal', $tahun)
        ->orderBy('tanggal', 'asc')
        ->get();

    return view('user.logbook.cetak', compact('logbooks', 'bulan', 'tahun', 'user', 'jenis'));
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
