<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Monitoring;
use Illuminate\Support\Facades\Auth;

class UserMonitoringController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $monitorings = Monitoring::where('user_id', $user->id)
            ->orderBy('minggu_mulai', 'desc')
            ->get();

        return view('user.monitoring.index', compact('monitorings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'minggu_mulai' => 'required|date',
            'minggu_selesai' => 'required|date',
            'laporan' => 'required|string',
        ]);

        Monitoring::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'minggu_mulai' => $request->minggu_mulai,
                'minggu_selesai' => $request->minggu_selesai,
            ],
            [
                'laporan' => $request->laporan,
            ]
        );

        return redirect()->back()->with('success', 'Laporan berhasil dikirim ke supervisor.');
    }
}
