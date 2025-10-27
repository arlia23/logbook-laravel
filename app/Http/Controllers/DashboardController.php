<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Logbook;
use App\Models\DetailKehadiran;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // 🔹 Jumlah semua karyawan (bukan admin)
        $jumlahKaryawan = User::where('role', '!=', 'admin')->count();

        // 🔹 Jumlah user yang mengisi logbook hari ini (H, DL, C, S)
        $jumlahLogbook = DetailKehadiran::whereDate('tanggal', $today)
            ->whereIn('status', ['H', 'DL', 'C', 'S']) // status apapun yang dianggap pengisian
            ->whereHas('user', function ($query) {
                $query->where('role', 'user'); // hanya user biasa
            })
            ->select('user_id') // pilih berdasarkan user
            ->distinct() // pastikan satu user dihitung satu kali
            ->count('user_id');

        // 🔹 Jumlah user yang hadir hari ini (status H)
        $jumlahHadirHariIni = DetailKehadiran::whereDate('tanggal', $today)
            ->where('status', 'H')
            ->whereHas('user', function ($query) {
                $query->where('role', 'user');
            })
            ->count();

        return view('welcome', compact(
            'jumlahKaryawan',
            'jumlahLogbook',
            'jumlahHadirHariIni'
        ));
    }
}
