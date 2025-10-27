<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ExcelController extends Controller
{
    public function exportUsers(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $mode  = $request->mode ?? 'rekap'; // default rekap

        $filename = $mode . '_' . $bulan . '_' . $tahun . '.xlsx';

        return Excel::download(
            new UsersExport($bulan, $tahun, $mode),
            $filename
        );
    }
}
