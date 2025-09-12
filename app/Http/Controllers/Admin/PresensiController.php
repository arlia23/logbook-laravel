<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use App\Models\User;
use Illuminate\Http\Request;

class PresensiController extends Controller
{
    // List semua presensi
    public function index()
    {
        $presensis = Presensi::with('user')->latest()->get();

        return view('admin.presensi.index', compact('presensis'));
    }

    // Detail presensi per user
    public function show($id)
    {
        $user = User::findOrFail($id);
        $presensis = Presensi::where('user_id', $id)->latest()->get();

        return view('admin.presensi.show', compact('user', 'presensis'));
    }

    // Hapus presensi (opsional)
    public function destroy($id)
    {
        $presensi = Presensi::findOrFail($id);
        $presensi->delete();

        return redirect()->route('admin.presensi.index')
            ->with('success', 'Presensi berhasil dihapus.');
    }
}
