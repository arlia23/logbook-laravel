<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Sakit;
use App\Models\DetailKehadiran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserSakitController extends Controller
{
    public function index()
    {
        // ✅ Ambil hanya data sakit milik user login
        $sakit = Sakit::where('user_id', Auth::id())->get();
        return view('user.sakit.index', compact('sakit'));
    }

    public function create()
    {
        return view('user.sakit.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pegawai'        => 'required|string',
            'keterangan'          => 'required|string',
            'tgl_mulai'           => 'required|date',
            'tgl_selesai'         => 'required|date|after_or_equal:tgl_mulai',
            'no_surat_ket_sakit'  => 'required|string',
            'tgl_surat_ket_sakit' => 'required|date',
        ]);

        $start = Carbon::parse($request->tgl_mulai);
        $end   = Carbon::parse($request->tgl_selesai);

        // ✅ Cek overlap dengan DetailKehadiran
        $exists = DetailKehadiran::where('user_id', Auth::id())
            ->whereBetween('tanggal', [$start->format('Y-m-d'), $end->format('Y-m-d')])
            ->exists();

        if ($exists) {
            return back()->with('error', 'Sudah ada data kehadiran di tanggal tersebut, tidak bisa input sakit.');
        }

        $data = $request->all();
        $data['user_id'] = Auth::id();
        $sakit = Sakit::create($data);

        $this->saveDetailKehadiran($request->tgl_mulai, $request->tgl_selesai, 'S', $request->keterangan);

        return redirect()->route('user.sakit.index')->with('success', 'Data sakit berhasil ditambahkan');
    }

    public function show($id)
    {
        $sakit = Sakit::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('user.sakit.show', compact('sakit'));
    }

    public function edit($id)
    {
        $sakit = Sakit::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('user.sakit.edit', compact('sakit'));
    }

    public function update(Request $request, $id)
    {
        $sakit = Sakit::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'nama_pegawai'        => 'required|string',
            'keterangan'          => 'required|string',
            'tgl_selesai'         => 'required|date|after_or_equal:' . $sakit->tgl_mulai,
            'no_surat_ket_sakit'  => 'required|string',
            'tgl_surat_ket_sakit' => 'required|date',
        ]);

        // Hapus detail lama
        $this->deleteDetailKehadiran($sakit->tgl_mulai, $sakit->tgl_selesai, 'S');

        $sakit->update([
            'nama_pegawai'        => $request->nama_pegawai,
            'keterangan'          => $request->keterangan,
            'tgl_selesai'         => $request->tgl_selesai,
            'no_surat_ket_sakit'  => $request->no_surat_ket_sakit,
            'tgl_surat_ket_sakit' => $request->tgl_surat_ket_sakit,
        ]);

        // Simpan detail baru
        $this->saveDetailKehadiran($sakit->tgl_mulai, $request->tgl_selesai, 'S', $request->keterangan);

        return redirect()->route('user.sakit.index')->with('success', 'Data sakit berhasil diperbarui');
    }

    public function destroy($id)
    {
        $sakit = Sakit::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $this->deleteDetailKehadiran($sakit->tgl_mulai, $sakit->tgl_selesai, 'S');
        $sakit->delete();

        return redirect()->route('user.sakit.index')->with('success', 'Data sakit berhasil dihapus');
    }

    private function saveDetailKehadiran($tglMulai, $tglSelesai, $status, $keterangan)
{
    $start = Carbon::parse($tglMulai);
    $end = Carbon::parse($tglSelesai);

    for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
        DetailKehadiran::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'tanggal' => $date->format('Y-m-d'),
            ],
            [
                'status'   => $status,
                // 👉 khusus sakit (S) jangan isi kegiatan
                'kegiatan' => $status === 'S' ? null : ($keterangan ?? null),
            ]
        );
    }
}


    private function deleteDetailKehadiran($tglMulai, $tglSelesai, $status)
    {
        $start = Carbon::parse($tglMulai);
        $end = Carbon::parse($tglSelesai);

        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            DetailKehadiran::where('user_id', Auth::id())
                ->where('tanggal', $date->format('Y-m-d'))
                ->where('status', $status)
                ->delete();
        }
    }
}
