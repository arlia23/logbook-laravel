<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Logbook;
use App\Models\User;
use Illuminate\Http\Request;

class LogbookController extends Controller
{
    // Menampilkan semua logbook
    public function index(Request $request)
    {
        $query = Logbook::with('user');

        // Filter by tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $logbooks = $query->latest()->paginate(10);
        $users = User::all();

        return view('admin.logbook.index', compact('logbooks', 'users'));
    }

    // Menampilkan detail logbook
    public function show(Logbook $logbook)
    {
        return view('admin.logbook.show', compact('logbook'));
    }

    // (Opsional) Hapus logbook
    public function destroy(Logbook $logbook)
    {
        $logbook->delete();

        return redirect()->route('admin.logbook.index')
            ->with('success', 'Logbook berhasil dihapus.');
    }
}
