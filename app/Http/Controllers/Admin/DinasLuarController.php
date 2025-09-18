<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DinasLuar;
use Illuminate\Http\Request;

class DinasLuarController extends Controller
{
    public function index()
    {
        $data = DinasLuar::all();
        return view('admin.dinas_luar.index', compact('data'));
    }

    public function show($id)
    {
        $dinas = DinasLuar::findOrFail($id);
        return view('admin.dinas_luar.show', compact('dinas'));
    }

    public function approve($id)
    {
        $dinas = DinasLuar::findOrFail($id);
        $dinas->status = 'disetujui';
        $dinas->save();

        return redirect()->back()->with('success', 'Dinas luar disetujui.');
    }

    public function reject($id)
    {
        $dinas = DinasLuar::findOrFail($id);
        $dinas->status = 'ditolak';
        $dinas->save();

        return redirect()->back()->with('error', 'Dinas luar ditolak.');
    }

    public function destroy($id)
    {
        DinasLuar::destroy($id);
        return redirect()->back()->with('success', 'Dinas luar dihapus.');
    }
}
