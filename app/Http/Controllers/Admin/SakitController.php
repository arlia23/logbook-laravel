<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sakit;
use Illuminate\Http\Request;

class SakitController extends Controller
{
    public function index()
    {
        $data = Sakit::all();
        return view('admin.sakit.index', compact('data'));
    }

    public function show($id)
    {
        $sakit = Sakit::findOrFail($id);
        return view('admin.sakit.show', compact('sakit'));
    }

    public function approve($id)
    {
        $sakit = Sakit::findOrFail($id);
        $sakit->status = 'disetujui';
        $sakit->save();

        return redirect()->back()->with('success', 'Izin sakit disetujui.');
    }

    public function reject($id)
    {
        $sakit = Sakit::findOrFail($id);
        $sakit->status = 'ditolak';
        $sakit->save();

        return redirect()->back()->with('error', 'Izin sakit ditolak.');
    }

    public function destroy($id)
    {
        Sakit::destroy($id);
        return redirect()->back()->with('success', 'Izin sakit dihapus.');
    }
}
