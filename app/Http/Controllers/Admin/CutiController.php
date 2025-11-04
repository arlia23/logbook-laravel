<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cuti;
use App\Models\User;
use App\Models\DetailKehadiran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class CutiController extends Controller
{
    // ✅ Menampilkan semua data cuti (filter bulan, tahun, nama)
    public function index(Request $request)
    {
        $query = Cuti::with('user')
            ->whereHas('user', function ($q) {
                $q->where('role', 'user');
            })
            ->orderBy('tgl_mulai', 'desc');

        // Filter nama user
        if ($request->filled('nama')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->nama . '%');
            });
        }

        // Filter bulan
        if ($request->filled('bulan')) {
            $query->whereMonth('tgl_mulai', $request->bulan);
        }

        // Filter tahun
        if ($request->filled('tahun')) {
            $query->whereYear('tgl_mulai', $request->tahun);
        }

        $cuti = $query->paginate(10);

        // Ambil daftar user (role user saja)
        $users = User::where('role', 'user')->orderBy('name')->get();

        return view('admin.cuti.index', compact('cuti', 'users'));
    }

    // ✅ Edit data cuti
    public function edit($id)
    {
        $cuti = Cuti::with('user')->findOrFail($id);
        return view('admin.cuti.edit', compact('cuti'));
    }

    // ✅ Update data cuti
    public function update(Request $request, $id)
    {
        $cuti = Cuti::findOrFail($id);

        $request->validate([
            'jenis_cuti'     => 'required|in:Cuti Tahunan,Cuti Alasan Penting,Cuti Melahirkan,Cuti Sakit,Cuti Urusan Keluarga',
            'keterangan'     => 'required|string',
            'tgl_mulai'      => 'required|date',
            'tgl_selesai'    => 'required|date|after_or_equal:tgl_mulai',
            'no_surat_cuti'  => 'required|string',
            'tgl_surat_cuti' => 'required|date',
        ]);

        DB::beginTransaction();
        try {
            // Hapus detail kehadiran lama
            $this->deleteDetailKehadiran($cuti->user_id, $cuti->tgl_mulai, $cuti->tgl_selesai);

            // Update data cuti
            $cuti->update($request->only([
                'jenis_cuti', 'keterangan', 'tgl_mulai', 'tgl_selesai', 'no_surat_cuti', 'tgl_surat_cuti'
            ]));

            // Simpan ulang detail kehadiran baru (status C)
            $this->saveDetailKehadiranReplaceRange($cuti->user_id, $request->tgl_mulai, $request->tgl_selesai, 'C');

            DB::commit();
            return redirect()->route('admin.cuti.index')->with('success', 'Data cuti berhasil diperbarui.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // ✅ Hapus data cuti
    public function destroy($id)
    {
        $cuti = Cuti::findOrFail($id);

        DB::beginTransaction();
        try {
            $this->deleteDetailKehadiran($cuti->user_id, $cuti->tgl_mulai, $cuti->tgl_selesai);
            $cuti->delete();

            DB::commit();
            return redirect()->route('admin.cuti.index')->with('success', 'Data cuti berhasil dihapus.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // 🔧 Simpan ulang detail kehadiran dalam range tanggal (status C)
    private function saveDetailKehadiranReplaceRange($userId, $tglMulai, $tglSelesai, $status)
    {
        $period = CarbonPeriod::create($tglMulai, $tglSelesai);

        foreach ($period as $date) {
            $tanggal = $date->format('Y-m-d');

            DetailKehadiran::where('user_id', $userId)
                ->whereDate('tanggal', $tanggal)
                ->delete();

            DetailKehadiran::create([
                'user_id'  => $userId,
                'tanggal'  => $tanggal,
                'status'   => $status,
                'kegiatan' => null,
            ]);
        }
    }

    // 🔧 Hapus detail kehadiran dalam rentang tanggal
    private function deleteDetailKehadiran($userId, $tglMulai, $tglSelesai)
    {
        $start = Carbon::parse($tglMulai)->format('Y-m-d');
        $end   = Carbon::parse($tglSelesai)->format('Y-m-d');

        DetailKehadiran::where('user_id', $userId)
            ->whereBetween(DB::raw('DATE(tanggal)'), [$start, $end])
            ->delete();
    }
}
