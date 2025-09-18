<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cuti;
use Illuminate\Http\Request;

class UserCutiController extends Controller
{
    public function index()
    {
        $cuti = Cuti::all();
        return view('user.cuti.index', compact('cuti'));
    }

    public function create()
    {
        return view('user.cuti.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pegawai' => 'required|string',
            'jenis_cuti' => 'required|in:Cuti Tahunan,Cuti Alasan Penting,Cuti Melahirkan,Cuti Sakit',
            'keterangan' => 'required|string',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date',
            'no_surat_cuti' => 'required|string',
            'tgl_surat_cuti' => 'required|date',
        ]);

        Cuti::create($request->all());

        return redirect()->route('user.cuti.index')->with('success', 'Data cuti berhasil ditambahkan');
    }

    public function edit(Cuti $cuti)
    {
        return view('user.cuti.edit', compact('cuti'));
    }

    public function update(Request $request, Cuti $cuti)
    {
        $request->validate([
            'nama_pegawai' => 'required|string',
            'jenis_cuti' => 'required|in:Cuti Tahunan,Cuti Alasan Penting,Cuti Melahirkan,Cuti Sakit',
            'keterangan' => 'required|string',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date',
            'no_surat_cuti' => 'required|string',
            'tgl_surat_cuti' => 'required|date',
        ]);

        $cuti->update($request->all());

        return redirect()->route('user.cuti.index')->with('success', 'Data cuti berhasil diperbarui');
    }

    public function destroy(Cuti $cuti)
    {
        $cuti->delete();
        return redirect()->route('user.cuti.index')->with('success', 'Data cuti berhasil dihapus');
    }
}
