<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sakit;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SakitController extends Controller
{
    public function index(Request $request)
    {
        $nama = $request->input('nama');
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        $query = Sakit::with('user');

        if ($nama) {
            $query->whereHas('user', function ($q) use ($nama) {
                $q->where('name', 'like', "%$nama%");
            });
        }

        if ($bulan && $tahun) {
            $query->whereMonth('tgl_mulai', $bulan)
                  ->whereYear('tgl_mulai', $tahun);
        }

        $sakit = $query->orderBy('tgl_mulai', 'desc')->get();
        $users = User::where('role', 'user')->orderBy('name')->get();

        return view('Admin.sakit.index', compact('sakit', 'users', 'nama', 'bulan', 'tahun'));
    }

    // ✅ Update data sakit
    public function update(Request $request, $id)
    {
        $request->validate([
            'keterangan' => 'required|string|max:255',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
            'no_surat_ket_sakit' => 'nullable|string|max:255',
            'tgl_surat_ket_sakit' => 'nullable|date',
        ]);

        $sakit = Sakit::findOrFail($id);
        $sakit->update($request->only(['keterangan', 'tgl_mulai', 'tgl_selesai', 'no_surat_ket_sakit', 'tgl_surat_ket_sakit']));

        return redirect()->back()->with('success', 'Data sakit berhasil diperbarui.');
    }

    // ✅ Hapus data sakit
    public function destroy($id)
    {
        $sakit = Sakit::findOrFail($id);
        $sakit->delete();

        return redirect()->back()->with('success', 'Data sakit berhasil dihapus.');
    }
}
