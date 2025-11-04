<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Izinsaathadir;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminIzinsaathadirController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan ?? Carbon::now()->month;
        $tahun = $request->tahun ?? Carbon::now()->year;
        $nama = $request->nama;

        // Ambil semua user yang role-nya 'user' saja
        $query = User::where('role', 'user')
            ->select('users.id', 'users.name')
            ->addSelect([
                // Hitung total izin
                'total_izin' => Izinsaathadir::selectRaw('COUNT(*)')
                    ->whereColumn('user_id', 'users.id')
                    ->whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun),

                // Hitung total durasi izin (jam)
                'total_durasi' => Izinsaathadir::selectRaw('SUM(TIME_TO_SEC(TIMEDIFF(jam_selesai, jam_mulai))) / 3600')
                    ->whereColumn('user_id', 'users.id')
                    ->whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun),
            ]);

        // Filter berdasarkan nama jika diinputkan
        if ($nama) {
            $query->where('users.name', 'like', "%{$nama}%");
        }

        // Urutkan berdasarkan total izin terbanyak
        $rekaps = $query->orderByDesc('total_izin')->get();

        // Pastikan nilai null jadi 0
        foreach ($rekaps as $r) {
            $r->total_izin = $r->total_izin ?? 0;
            $r->total_durasi = round($r->total_durasi ?? 0, 2);
        }

        return view('admin.izin.rekap', compact('rekaps', 'bulan', 'tahun', 'nama'));
    }
}
