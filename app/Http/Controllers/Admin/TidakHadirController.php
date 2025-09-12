<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TidakHadir;
use Illuminate\Http\Request;

class TidakHadirController extends Controller
{
    public function index()
    {
        $tidakHadir = TidakHadir::with('user')->latest()->paginate(10);
        return view('admin.tidak_hadir.index', compact('tidakHadir'));
    }

    public function show($id)
    {
        $data = TidakHadir::with('user')->findOrFail($id);
        return view('admin.tidak_hadir.show', compact('data'));
    }

    public function destroy($id)
    {
        $data = TidakHadir::findOrFail($id);

        // Hapus file surat jika ada
        if ($data->file_surat_tugas && file_exists(storage_path('app/public/'.$data->file_surat_tugas))) {
            unlink(storage_path('app/public/'.$data->file_surat_tugas));
        }

        $data->delete();

        return redirect()->route('admin.tidak_hadir.index')->with('success', 'Data berhasil dihapus');
    }
}
