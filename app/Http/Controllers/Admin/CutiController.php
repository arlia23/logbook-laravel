<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cuti;
use Illuminate\Http\Request;

class CutiController extends Controller
{
    public function index()
    {
        $data = Cuti::all();
        return view('admin.cuti.index', compact('data'));
    }

    public function show($id)
    {
        $cuti = Cuti::findOrFail($id);
        return view('admin.cuti.show', compact('cuti'));
    }

    public function approve($id)
    {
        $cuti = Cuti::findOrFail($id);
        $cuti->status = 'disetujui';
        $cuti->save();

        return redirect()->back()->with('success', 'Cuti disetujui.');
    }

    public function reject($id)
    {
        $cuti = Cuti::findOrFail($id);
        $cuti->status = 'ditolak';
        $cuti->save();

        return redirect()->back()->with('error', 'Cuti ditolak.');
    }

    public function destroy($id)
    {
        Cuti::destroy($id);
        return redirect()->back()->with('success', 'Cuti dihapus.');
    }
}
