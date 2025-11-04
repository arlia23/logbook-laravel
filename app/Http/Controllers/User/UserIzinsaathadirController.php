<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Izinsaathadir;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserIzinsaathadirController extends Controller
{
    // ============================================================
    // 📋 INDEX: Tampilkan daftar izin user login
    // ============================================================
    public function index()
    {
        $izins = Izinsaathadir::with('user')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.izinsaathadir.index', compact('izins'));
    }

    // ============================================================
    // ➕ FORM CREATE IZIN
    // ============================================================
    public function create()
    {
        $user = Auth::user();
        $izins = Izinsaathadir::with('user')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.izinsaathadir.index', compact('user', 'izins'));
    }

    // ============================================================
    // 💾 SIMPAN IZIN
    // ============================================================
    public function store(Request $request)
    {
        $request->validate([
            'jenis_izin' => 'required',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'alasan' => 'required',
        ]);

        Izinsaathadir::create([
            'user_id' => Auth::id(),
            'jenis_izin' => $request->jenis_izin,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'alasan' => $request->alasan,
        ]);

        return redirect()->route('user.izinsaathadir.index')
            ->with('success', 'Izin saat hadir berhasil diajukan!');
    }

    // ============================================================
    // 🧾 CETAK PDF SURAT IZIN
    // ============================================================
    public function cetakPdf($id)
{
    $izin = Izinsaathadir::with('user')->findOrFail($id);

    // ✅ Tambahkan baris ini biar Carbon pakai Bahasa Indonesia
    \Carbon\Carbon::setLocale('id');
    app()->setLocale('id');

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('user.izinsaathadir.pdf', compact('izin'))
        ->setPaper('A4', 'portrait');

    return $pdf->download('surat_izin_' . $izin->user->name . '.pdf');
}


    // ============================================================
    // 🔍 LIHAT DETAIL IZIN
    // ============================================================
    public function show($id)
    {
        $izin = Izinsaathadir::with('user')->findOrFail($id);
        return view('user.izinsaathadir.show', compact('izin'));
    }

    // ============================================================
    // 🧾 REKAP IZIN SAAT HADIR PER BULAN (SEMUA USER)
    // ============================================================
    public function rekap(Request $request)
    {
        $bulan = $request->bulan ?? Carbon::now()->month;
        $tahun = $request->tahun ?? Carbon::now()->year;
        $search = $request->search;

        // Ambil semua user dengan role 'user'
        $query = User::where('role', 'user')
            ->select('users.id', 'users.name')
            ->addSelect([
                // Hitung total izin
                'total_izin' => Izinsaathadir::selectRaw('COUNT(*)')
                    ->whereColumn('user_id', 'users.id')
                    ->whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun),

                // Hitung total durasi izin dalam jam
                'total_durasi' => Izinsaathadir::selectRaw('SUM(TIME_TO_SEC(TIMEDIFF(jam_selesai, jam_mulai))) / 3600')
                    ->whereColumn('user_id', 'users.id')
                    ->whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun),
            ]);

        // Filter nama jika ada pencarian
        if ($search) {
            $query->where('users.name', 'like', "%{$search}%");
        }

        // Ambil semua user, urutkan dari izin terbanyak
        $rekaps = $query->orderByDesc('total_izin')->get();

        // Ubah nilai null jadi 0
        foreach ($rekaps as $r) {
            $r->total_izin = $r->total_izin ?? 0;
            $r->total_durasi = round($r->total_durasi ?? 0, 2);
        }

        return view('user.izinsaathadir.rekap', compact('rekaps', 'bulan', 'tahun', 'search'));
    }
}
