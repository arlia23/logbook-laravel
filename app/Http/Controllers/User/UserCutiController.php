<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cuti;
use App\Models\DetailKehadiran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Barryvdh\DomPDF\Facade\Pdf;



class UserCutiController extends Controller
{
    public function index()
    {
        $cuti = Cuti::where('user_id', Auth::id())
            ->orderBy('tgl_mulai', 'desc')
            ->get();

        return view('user.cuti.index', compact('cuti'));
    }

    public function create()
    {
        return view('user.cuti.create');
    }

    public function store(Request $request)
{
    $today = Carbon::today();

    // Cek apakah user punya cuti aktif
    $adaCutiAktif = Cuti::where('user_id', Auth::id())
        ->where('tgl_selesai', '>=', $today) // masih dalam periode
        ->exists();

    if ($adaCutiAktif) {
        return back()->with('error', 'Anda masih dalam periode cuti. Tidak bisa input cuti baru sampai cuti selesai.');
    }

    $request->validate([
        'nama_pegawai'   => 'required|string',
        'jenis_cuti'     => 'required|in:Cuti Tahunan,Cuti Alasan Penting,Cuti Melahirkan,Cuti Sakit',
        'keterangan'     => 'required|string',
        'tgl_mulai'      => 'required|date|after_or_equal:today',
        'tgl_selesai'    => 'required|date|after_or_equal:tgl_mulai',
        'no_surat_cuti'  => 'required|string',
        'tgl_surat_cuti' => 'required|date',
    ]);

    DB::beginTransaction();
    try {
        $data = $request->only([
            'nama_pegawai','jenis_cuti','keterangan',
            'tgl_mulai','tgl_selesai','no_surat_cuti','tgl_surat_cuti'
        ]);
        $data['user_id'] = Auth::id();

        $cuti = Cuti::create($data);

        // Simpan detail per-hari (status C)
        $this->saveDetailKehadiranReplaceRange($data['tgl_mulai'], $data['tgl_selesai'], 'C');

        DB::commit();
        return redirect()->route('user.cuti.index')->with('success', 'Data cuti berhasil ditambahkan');
    } catch (\Throwable $e) {
        DB::rollBack();
        return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}


    public function edit(Cuti $cuti)
    {
        if ($cuti->user_id !== Auth::id()) abort(403);
        return view('user.cuti.edit', compact('cuti'));
    }

    public function update(Request $request, Cuti $cuti)
    {
        if ($cuti->user_id !== Auth::id()) abort(403);

        $request->validate([
            'nama_pegawai'   => 'required|string',
            'jenis_cuti'     => 'required|in:Cuti Tahunan,Cuti Alasan Penting,Cuti Melahirkan,Cuti Sakit',
            'keterangan'     => 'required|string',
            'tgl_mulai'      => 'required|date',
            'tgl_selesai'    => 'required|date|after_or_equal:tgl_mulai',
            'no_surat_cuti'  => 'required|string',
            'tgl_surat_cuti' => 'required|date',
        ]);

        DB::beginTransaction();
        try {
            // Hapus range lama di detail_kehadirans
            $this->deleteDetailKehadiran($cuti->tgl_mulai, $cuti->tgl_selesai);

            // Update cuti
            $cuti->update($request->only([
                'nama_pegawai','jenis_cuti','keterangan',
                'tgl_mulai','tgl_selesai','no_surat_cuti','tgl_surat_cuti'
            ]));

            // Simpan ulang range baru (status C)
            $this->saveDetailKehadiranReplaceRange($request->tgl_mulai, $request->tgl_selesai, 'C');

            DB::commit();
            return redirect()->route('user.cuti.index')->with('success', 'Data cuti berhasil diperbarui');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(Cuti $cuti)
    {
        if ($cuti->user_id !== Auth::id()) abort(403);

        DB::beginTransaction();
        try {
            // Hapus detail_kehadiran untuk range cuti
            $this->deleteDetailKehadiran($cuti->tgl_mulai, $cuti->tgl_selesai);

            $cuti->delete();

            DB::commit();
            return redirect()->route('user.cuti.index')->with('success', 'Data cuti berhasil dihapus');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Simpan detail kehadiran per-hari, menggantikan record lama (jika ada).
     */
    private function saveDetailKehadiranReplaceRange($tglMulai, $tglSelesai, $status)
    {
        $period = CarbonPeriod::create($tglMulai, $tglSelesai);

        foreach ($period as $date) {
            $tanggal = $date->format('Y-m-d');

            // hapus dulu baris lama (jika ada)
            DetailKehadiran::where('user_id', Auth::id())
                ->whereDate('tanggal', $tanggal)
                ->delete();

            // buat baris baru
            DetailKehadiran::create([
                'user_id'  => Auth::id(),
                'tanggal'  => $tanggal,
                'status'   => $status,
                'kegiatan' => null, // tidak perlu simpan kegiatan
            ]);
        }
    }

    /**
     * Hapus semua detail kehadiran dalam rentang tanggal untuk user aktif.
     */
    private function deleteDetailKehadiran($tglMulai, $tglSelesai)
    {
        $start = Carbon::parse($tglMulai)->format('Y-m-d');
        $end   = Carbon::parse($tglSelesai)->format('Y-m-d');

        DetailKehadiran::where('user_id', Auth::id())
            ->whereBetween(DB::raw('DATE(tanggal)'), [$start, $end])
            ->delete();
    }

public function downloadSurat($id)
{
    $cuti = Cuti::findOrFail($id);
    $user = Auth::user();

    $data = [
        'user' => $user,
        'cuti' => $cuti,
        'tglSurat' => Carbon::now()->translatedFormat('d F Y'),
        'tglMulai' => Carbon::parse($cuti->tgl_mulai)->translatedFormat('d F Y'),
        'tglSelesai' => Carbon::parse($cuti->tgl_selesai)->translatedFormat('d F Y'),
    ];

    $pdf = Pdf::loadView('user.cuti.surat_cuti_pdf', $data)
              ->setPaper('A4', 'portrait');

    return $pdf->download('Surat_Cuti_'.$user->name.'.pdf');
}


}
