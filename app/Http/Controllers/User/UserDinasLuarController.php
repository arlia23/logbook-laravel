<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DinasLuar;
use Illuminate\Http\Request;

class UserDinasLuarController extends Controller
{
    public function index()
    {
        $dinasLuar = DinasLuar::all();
        return view('user.dinas.index', compact('dinasLuar'));
    }

    public function create()
    {
        return view('user.dinas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pegawai' => 'required|string',
            'nama_kegiatan' => 'required|string',
            'lokasi_kegiatan' => 'required|string',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date',
            'no_surat_tugas' => 'required|string',
            'tgl_surat_tugas' => 'required|date',
            'jenis_tugas' => 'required|string',
            'file_surat_tugas' => 'nullable|file|mimes:pdf,jpg,png',
        ]);

        $data = $request->all();

        if ($request->hasFile('file_surat_tugas')) {
            $data['file_surat_tugas'] = $request->file('file_surat_tugas')->store('surat_tugas', 'public');
        }

        DinasLuar::create($data);

        return redirect()->route('user.dinas.index')->with('success', 'Data dinas luar berhasil ditambahkan');
    }

    public function edit(DinasLuar $dinasLuar)
    {
        return view('user.dinas.edit', compact('dinasLuar'));
    }

    public function update(Request $request, DinasLuar $dinasLuar)
    {
        $request->validate([
            'nama_pegawai' => 'required|string',
            'nama_kegiatan' => 'required|string',
            'lokasi_kegiatan' => 'required|string',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date',
            'no_surat_tugas' => 'required|string',
            'tgl_surat_tugas' => 'required|date',
            'jenis_tugas' => 'required|string',
            'file_surat_tugas' => 'nullable|file|mimes:pdf,jpg,png',
        ]);

        $data = $request->all();

        if ($request->hasFile('file_surat_tugas')) {
            $data['file_surat_tugas'] = $request->file('file_surat_tugas')->store('surat_tugas', 'public');
        }

        $dinasLuar->update($data);

        return redirect()->route('user.dinas.index')->with('success', 'Data dinas luar berhasil diperbarui');
    }

    public function destroy(DinasLuar $dinasLuar)
    {
        $dinasLuar->delete();
        return redirect()->route('user.dinas.index')->with('success', 'Data dinas luar berhasil dihapus');
    }
}
