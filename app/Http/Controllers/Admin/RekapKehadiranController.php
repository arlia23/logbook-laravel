<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RekapKehadiran;
use App\Models\User;
use Illuminate\Http\Request;

class RekapKehadiranController extends Controller
{
    // List semua rekap
    public function index(Request $request)
    {
        $tahun = $request->input('tahun', now()->year);
        $bulan = $request->input('bulan', now()->month);

        $rekap = RekapKehadiran::with('user')
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->paginate(10);

        return view('admin.rekap.index', compact('rekap', 'tahun', 'bulan'));
    }

    // Detail per user
    public function show($id)
    {
        $rekap = RekapKehadiran::with('user')->findOrFail($id);
        return view('admin.rekap.show', compact('rekap'));
    }

    // Generate rekap (opsional)
    public function generate()
    {
        // Ambil semua user dan presensi → hitung rekap ulang
        // Contoh sederhana:
        // (ini bisa kamu kembangkan sesuai logika perhitungan presensi)
        foreach (User::all() as $user) {
            RekapKehadiran::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'bulan' => now()->month,
                    'tahun' => now()->year,
                ],
                [
                    'jumlah_hadir' => rand(15, 22), // contoh dummy
                    'jumlah_dinas_luar' => rand(0, 2),
                    'jumlah_cuti' => rand(0, 1),
                    'jumlah_sakit' => rand(0, 1),
                    'jumlah_alpha' => rand(0, 3),
                ]
            );
        }

        return redirect()->route('admin.rekap.index')->with('success', 'Rekap berhasil digenerate ulang!');
    }
}
