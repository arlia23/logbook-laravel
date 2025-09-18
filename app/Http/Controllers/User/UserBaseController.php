<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // ✅ Tambahkan ini
use App\Models\Presensi;

class UserBaseController extends Controller
{
    public function index()
    {
        // Ambil data presensi user login
        $presensi = Presensi::where('user_id', Auth::id())
            ->whereDate('tanggal', today())
            ->first();

        return view('user.home', compact('presensi'));
    }
}
