<?php

namespace App\Helpers;

use App\Models\DetailKehadiran;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class KehadiranHelper
{
    public static function hasConflict($tglMulai, $tglSelesai)
    {
        $start = Carbon::parse($tglMulai)->format('Y-m-d');
        $end   = Carbon::parse($tglSelesai)->format('Y-m-d');

        return DetailKehadiran::where('user_id', Auth::id())
            ->whereBetween('tanggal', [$start, $end])
            ->exists();
    }
}
