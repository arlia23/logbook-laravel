<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Logbook;
use App\Models\Monitoring;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MonitoringController extends Controller
{
    public function index(Request $request)
    {
        $startOfWeek = Carbon::now()->startOfWeek(); 
        $endOfWeek   = Carbon::now()->endOfWeek();

        if ($request->has(['start', 'end'])) {
            $startOfWeek = Carbon::parse($request->start);
            $endOfWeek   = Carbon::parse($request->end);
        }

        $users = User::all();
        $data = [];

        foreach ($users as $user) {
            $logbooks = Logbook::where('user_id', $user->id)
                ->whereBetween('tanggal', [$startOfWeek, $endOfWeek])
                ->pluck('catatan_pekerjaan')
                ->filter()
                ->toArray();

            $ringkasan = implode("\n- ", $logbooks);

            $monitoring = Monitoring::where('user_id', $user->id)
                ->whereDate('minggu_mulai', $startOfWeek)
                ->whereDate('minggu_selesai', $endOfWeek)
                ->first();

            $data[] = [
                'user'                => $user,
                'ringkasan_pekerjaan' => $ringkasan,
                'catatan_supervisor'  => $monitoring?->catatan_supervisor,
                'id'                  => $monitoring?->id,
                'minggu_mulai'        => $startOfWeek->toDateString(),
                'minggu_selesai'      => $endOfWeek->toDateString(),
            ];
        }

        return view('admin.monitoring.index', compact('data', 'startOfWeek', 'endOfWeek'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'            => 'required|exists:users,id',
            'minggu_mulai'       => 'required|date',
            'minggu_selesai'     => 'required|date',
            'catatan_supervisor' => 'required|string',
        ]);

        Monitoring::updateOrCreate(
            [
                'user_id'      => $request->user_id,
                'minggu_mulai' => $request->minggu_mulai,
                'minggu_selesai' => $request->minggu_selesai,
            ],
            [
                'catatan_supervisor' => $request->catatan_supervisor,
            ]
        );

        return redirect()->back()->with('success', 'Catatan supervisor berhasil disimpan.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'id'                => 'required|exists:monitorings,id',
            'catatan_supervisor'=> 'required|string',
        ]);

        $monitoring = Monitoring::findOrFail($request->id);
        $monitoring->update([
            'catatan_supervisor' => $request->catatan_supervisor,
        ]);

        return redirect()->back()->with('success', 'Catatan supervisor berhasil diperbarui.');
    }
}
