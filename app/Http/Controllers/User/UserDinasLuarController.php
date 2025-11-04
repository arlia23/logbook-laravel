<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DinasLuar;
use App\Models\DetailKehadiran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserDinasLuarController extends Controller
{
    public function index()
    {
        $dinasLuar = DinasLuar::where('user_id', Auth::id())->get();
        return view('user.dinas.index', compact('dinasLuar'));
    }

    public function create()
    {
        return view('user.dinas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan'    => 'required|string',
            'lokasi_kegiatan'  => 'required|string',
            'tgl_mulai'        => 'required|date',
            'tgl_selesai'      => 'required|date|after_or_equal:tgl_mulai',
            'no_surat_tugas'   => 'required|string',
            'tgl_surat_tugas'  => 'required|date',
            'jenis_tugas'      => 'required|string',
            'file_surat_tugas' => 'nullable|file|mimes:pdf,jpg,png',
        ]);

        $start = Carbon::parse($request->tgl_mulai);
        $end   = Carbon::parse($request->tgl_selesai);

        // 🚨 Cek overlap dinas luar sebelumnya
        $adaDL = DinasLuar::where('user_id', Auth::id())
            ->where(function ($q) use ($start, $end) {
                $q->whereBetween('tgl_mulai', [$start, $end])
                  ->orWhereBetween('tgl_selesai', [$start, $end])
                  ->orWhere(function ($q2) use ($start, $end) {
                      $q2->where('tgl_mulai', '<=', $start)
                         ->where('tgl_selesai', '>=', $end);
                  });
            })
            ->exists();

        if ($adaDL) {
            return back()->withErrors(['tgl_mulai' => "Kamu sudah mengisi Dinas Luar pada periode tersebut."]);
        }

        // 🚨 Cek tabrakan presensi (boleh update kalau status = A)
        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            if ($date->isSunday()) continue;

            $detail = DetailKehadiran::where('user_id', Auth::id())
                ->where('tanggal', $date->format('Y-m-d'))
                ->first();

            // ❌ Jika sudah ada status lain selain A, tolak
            if ($detail && in_array($detail->status, ['H', 'C', 'S'])) {
                return back()->withErrors([
                    'tgl_mulai' => "Tanggal {$date->format('d-m-Y')} sudah diisi dengan status {$detail->status}."
                ]);
            }

            // ❌ Jika ada data tapi bukan A, juga tolak
            if ($detail && $detail->status != 'A') {
                return back()->withErrors([
                    'tgl_mulai' => "Tanggal {$date->format('d-m-Y')} sudah memiliki status lain ({$detail->status})."
                ]);
            }
        }

        // ✅ Simpan data dinas luar
        $dinasLuar = new DinasLuar();
        $dinasLuar->user_id         = Auth::id();
        $dinasLuar->nama_pegawai    = Auth::user()->name;
        $dinasLuar->nama_kegiatan   = $request->nama_kegiatan;
        $dinasLuar->lokasi_kegiatan = $request->lokasi_kegiatan;
        $dinasLuar->tgl_mulai       = $request->tgl_mulai;
        $dinasLuar->tgl_selesai     = $request->tgl_selesai;
        $dinasLuar->no_surat_tugas  = $request->no_surat_tugas;
        $dinasLuar->tgl_surat_tugas = $request->tgl_surat_tugas;
        $dinasLuar->jenis_tugas     = $request->jenis_tugas;

        if ($request->hasFile('file_surat_tugas')) {
            $dinasLuar->file_surat_tugas = $request->file('file_surat_tugas')
                ->store('surat_tugas', 'public');
        }

        $dinasLuar->save();

        // ✅ Simpan ke tabel detail_kehadirans
        $this->saveDetailKehadiran($request->tgl_mulai, $request->tgl_selesai, 'DL');

        return redirect()->route('user.dinas.index')->with('success', 'Data dinas luar berhasil ditambahkan');
    }

    public function edit(DinasLuar $dinasLuar)
    {
        if ($dinasLuar->user_id !== Auth::id()) abort(403);
        return view('user.dinas.edit', compact('dinasLuar'));
    }

    public function update(Request $request, DinasLuar $dinasLuar)
    {
        if ($dinasLuar->user_id !== Auth::id()) abort(403);

        $request->validate([
            'nama_kegiatan'    => 'required|string',
            'lokasi_kegiatan'  => 'required|string',
            'tgl_mulai'        => 'required|date|in:' . $dinasLuar->tgl_mulai,
            'tgl_selesai'      => 'required|date|after_or_equal:tgl_mulai',
            'no_surat_tugas'   => 'required|string',
            'tgl_surat_tugas'  => 'required|date',
            'jenis_tugas'      => 'required|string',
            'file_surat_tugas' => 'nullable|file|mimes:pdf,jpg,png',
        ]);

        $dinasLuar->nama_kegiatan   = $request->nama_kegiatan;
        $dinasLuar->lokasi_kegiatan = $request->lokasi_kegiatan;
        $dinasLuar->tgl_selesai     = $request->tgl_selesai;
        $dinasLuar->no_surat_tugas  = $request->no_surat_tugas;
        $dinasLuar->tgl_surat_tugas = $request->tgl_surat_tugas;
        $dinasLuar->jenis_tugas     = $request->jenis_tugas;

        if ($request->hasFile('file_surat_tugas')) {
            $dinasLuar->file_surat_tugas = $request->file('file_surat_tugas')
                ->store('surat_tugas', 'public');
        }

        $dinasLuar->save();

        // 🧹 Hapus detail DL lama
        DetailKehadiran::where('user_id', Auth::id())
            ->whereBetween('tanggal', [$dinasLuar->tgl_mulai, $dinasLuar->tgl_selesai])
            ->where('status', 'DL')
            ->delete();

        // ✅ Simpan ulang
        $this->saveDetailKehadiran($dinasLuar->tgl_mulai, $request->tgl_selesai, 'DL');

        return redirect()->route('user.dinas.index')->with('success', 'Data dinas luar berhasil diperbarui');
    }

    public function destroy(DinasLuar $dinasLuar)
    {
        if ($dinasLuar->user_id !== Auth::id()) abort(403);

        DetailKehadiran::where('user_id', Auth::id())
            ->whereBetween('tanggal', [$dinasLuar->tgl_mulai, $dinasLuar->tgl_selesai])
            ->where('status', 'DL')
            ->delete();

        $dinasLuar->delete();

        return redirect()->route('user.dinas.index')->with('success', 'Data dinas luar berhasil dihapus.');
    }

    private function saveDetailKehadiran($tglMulai, $tglSelesai, $status)
    {
        $start = Carbon::parse($tglMulai);
        $end   = Carbon::parse($tglSelesai);

        while ($start->lte($end)) {
            if (!$start->isSunday()) {
                DetailKehadiran::updateOrCreate(
                    [
                        'user_id' => Auth::id(),
                        'tanggal' => $start->format('Y-m-d'),
                    ],
                    [
                        'status'   => $status,
                        'kegiatan' => null,
                    ]
                );
            }
            $start->addDay();
        }
    }
}
