<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use App\Models\User;
use Illuminate\Http\Request;

class PresensiController extends Controller
{
    /**
     * Tampilkan daftar presensi dengan filter user & tanggal
     */
    public function index(Request $request)
    {
        // Ambil semua user untuk dropdown filter
        $users = User::orderBy('name', 'asc')->get();

        // Query dasar presensi (dengan relasi user)
        $query = Presensi::with('user');

        // Filter berdasarkan user_id
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        // Urutkan dari terbaru dan paginate
        $presensis = $query->orderBy('tanggal', 'desc')->paginate(10);

        // Kirim data ke view
        return view('admin.presensi.index', compact('users', 'presensis'));
    }

    /**
     * Detail presensi per user
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $presensis = Presensi::where('user_id', $id)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('admin.presensi.show', compact('user', 'presensis'));
    }

    /**
     * Hapus data presensi tertentu
     */
    public function destroy($id)
    {
        $presensi = Presensi::findOrFail($id);
        $presensi->delete();

        return redirect()
            ->route('admin.presensi.index')
            ->with('success', 'Presensi berhasil dihapus.');
    }
}
