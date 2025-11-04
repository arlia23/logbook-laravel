<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DinasLuar;
use App\Models\User;

class DinasLuarController extends Controller
{
    /**
     * ✅ Tampilkan semua data Dinas Luar (khusus role user)
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $nama = $request->input('nama');
        $bulan = $request->input('bulan');

        // 🔹 Ambil semua user dengan role user (untuk dropdown filter)
        $users = User::where('role', 'user')->orderBy('name', 'asc')->get();

        // 🔹 Query data dinas luar
        $data = DinasLuar::with('user')
            ->whereHas('user', function ($query) {
                $query->where('role', 'user');
            })
            ->when($nama, function ($query, $nama) {
                $query->whereHas('user', function ($q) use ($nama) {
                    $q->where('name', $nama);
                });
            })
            ->when($bulan, function ($query, $bulan) {
                $query->whereMonth('tanggal_mulai', $bulan);
            })
            ->when($search, function ($query, $search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                      ->orWhere('email', 'like', "%$search%");
                });
            })
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('admin.dinas-luar.index', compact('data', 'users', 'search'));
    }

    /**
     * ✅ Tampilkan detail data dinas luar
     */
    public function show($id)
    {
        $dinas = DinasLuar::with('user')->findOrFail($id);
        return view('admin.dinas-luar.show', compact('dinas'));
    }

    /**
     * ✅ Update data dinas luar
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'alasan' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'nullable|in:disetujui,ditolak,menunggu',
        ]);

        $dinas = DinasLuar::findOrFail($id);
        $dinas->update([
            'alasan' => $request->alasan,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status' => $request->status ?? $dinas->status,
        ]);

        return redirect()->route('admin.dinas-luar.index')->with('success', 'Data Dinas Luar berhasil diperbarui.');
    }

    /**
     * ✅ Hapus data dinas luar
     */
    public function destroy($id)
    {
        $dinas = DinasLuar::findOrFail($id);
        $dinas->delete();

        return redirect()->route('admin.dinas-luar.index')->with('success', 'Data Dinas Luar berhasil dihapus.');
    }
}
