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
}

