<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Sakit;
use Illuminate\Http\Request;

class UserSakitController extends Controller
{
    public function index()
    {
        $sakit = Sakit::all();
        return view('user.sakit.index', compact('sakit'));
    }


    public function create()
    {
        return view('user.sakit.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pegawai' => 'required|string',
            'keterangan' => 'required|string',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date',
            'no_surat_ket_sakit' => 'required|string',
            'tgl_surat_ket_sakit' => 'required|date',
        ]);

        Sakit::create($request->all());

        return redirect()->route('user.sakit.index')->with('success', 'Data sakit berhasil ditambahkan');
    }

    public function edit($id)
    {
        $sakit = Sakit::findOrFail($id);
        return view('user.sakit.edit', compact('sakit'));
    }

    public function update(Request $request, $id)
    {
        $sakit = Sakit::findOrFail($id);

        $validated = $request->validate([
            'nama_pegawai' => 'required|string|max:255',
            'keterangan' => 'required|string',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
            'no_surat_ket_sakit' => 'required|string|max:100',
            'tgl_surat_ket_sakit' => 'required|date',
        ]);

        $sakit->update($validated);

        return redirect()->route('user.sakit.index')
            ->with('success', 'Data sakit berhasil diupdate');
    }

    public function destroy($id)
    {
        $sakit = Sakit::findOrFail($id);
        $sakit->delete();

        return redirect()->route('user.sakit.index')
            ->with('success', 'Data sakit berhasil dihapus');
    }
}
