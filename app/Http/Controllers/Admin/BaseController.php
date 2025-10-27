<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetailKehadiran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\Logbook;
use App\Models\User;


class BaseController extends Controller
{
    // Dashboard admin
public function index()
{
    // === Hitung jumlah pegawai berdasarkan tipe_user ===
    $jumlahPNS = User::where('tipe_user', 'pns')->count();
    $jumlahP3K = User::where('tipe_user', 'p3k')->count();
    $jumlahPHL = User::where('tipe_user', 'phl')->count();

    // === Data tanggal hari ini dan awal bulan ===
    $today = now();
    $startMonth = $today->copy()->startOfMonth();
    $endMonth = $today->copy()->endOfMonth();

    // === Hitung jumlah user yang sudah isi logbook hari ini ===
    $usersTerisi = Logbook::whereDate('tanggal', $today)
        ->distinct('user_id')
        ->count('user_id');

    // === Hitung total semua user aktif dengan role "user" ===
    $totalUsers = User::where('role', 'user')->count();

    // === Hitung user yang belum isi logbook ===
    $usersBelumIsi = max(0, $totalUsers - $usersTerisi);

    // === Hitung persentase logbook ===
    $persentaseIsi = $totalUsers > 0 ? round(($usersTerisi / $totalUsers) * 100, 1) : 0;
    $persentaseTidakIsi = 100 - $persentaseIsi;

    // === Hitung status kehadiran bulan ini ===
    $hadir = DetailKehadiran::whereBetween('tanggal', [$startMonth, $endMonth])
        ->where('status', 'H')
        ->count();

    $dinasLuar = DetailKehadiran::whereBetween('tanggal', [$startMonth, $endMonth])
        ->where('status', 'DL')
        ->count();

    $cuti = DetailKehadiran::whereBetween('tanggal', [$startMonth, $endMonth])
        ->where('status', 'C')
        ->count();

    $sakit = DetailKehadiran::whereBetween('tanggal', [$startMonth, $endMonth])
        ->where('status', 'S')
        ->count();

    // === Total kehadiran untuk hitung persentase ===
    $totalKehadiran = $hadir + $dinasLuar + $cuti + $sakit;

    $persenHadir = $totalKehadiran > 0 ? round(($hadir / $totalKehadiran) * 100, 1) : 0;
    $persenDL = $totalKehadiran > 0 ? round(($dinasLuar / $totalKehadiran) * 100, 1) : 0;
    $persenCuti = $totalKehadiran > 0 ? round(($cuti / $totalKehadiran) * 100, 1) : 0;
    $persenSakit = $totalKehadiran > 0 ? round(($sakit / $totalKehadiran) * 100, 1) : 0;

    // === 💡 Tambahan: Hitung kehadiran hari ini ===
    $hadirHariIni = DetailKehadiran::whereDate('tanggal', $today)
        ->where('status', 'H') // H = Hadir
        ->whereHas('user', function ($q) {
            $q->where('role', 'user');
        })
        ->count();

    $totalUserAktif = User::where('role', 'user')->count();
    $tidakHadirHariIni = max(0, $totalUserAktif - $hadirHariIni);

    // === Kirim semua data ke view ===
    return view('template.base', compact(
        'jumlahPNS',
        'jumlahP3K',
        'jumlahPHL',
        'usersTerisi',
        'usersBelumIsi',
        'persentaseIsi',
        'persentaseTidakIsi',
        'hadir',
        'dinasLuar',
        'cuti',
        'sakit',
        'persenHadir',
        'persenDL',
        'persenCuti',
        'persenSakit',
        'hadirHariIni',
        'tidakHadirHariIni'
    ));
}




    // ✨ Tampilkan semua user (role = user) + fitur search
    public function dataUser(Request $request)
    {
        $query = User::where('role', 'user');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $users = $query->get();

        return view('Admin.DataUser.indexUser', compact('users'));
    }

    // Tampilkan semua admin (role = admin)
    public function dataAdmin()
    {
        $admins = User::where('role', 'admin')->get();
        return view('Admin.DataUser.indexAdmin', compact('admins'));
    }

    // Hapus user
    public function deleteUser(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->delete();

        return redirect()->route('data.user')->with('Delete', 'Berhasil Menghapus Data');
    }

    // Hapus admin
    public function deleteAdmin(Request $request)
    {
        $admin = User::findOrFail($request->id);
        $admin->delete();

        return redirect()->route('data.admin')->with('Delete', 'Berhasil Menghapus Admin');
    }

    // Tambah user
    public function createUser(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'required|email|unique:users,email',
            'role'             => 'required|string',
            'password'         => 'required|string|min:5|confirmed',
            'tipe_user'        => 'nullable|string',
            'nip'              => 'nullable|string|max:50',
            'unit_fakultas'    => 'nullable|string|max:255',
            'jabatan'          => 'nullable|string|max:255',
            'lokasi_presensi'  => 'nullable|string|max:255',
            'contact_phone'    => 'nullable|string|max:50',
            'email_address'    => 'nullable|email|max:255',
            'tempat_lahir'     => 'nullable|string|max:255',
            'tanggal_lahir'    => 'nullable|date',
        ]);

        User::create([
            'name'             => $request->name,
            'email'            => $request->email,
            'role'             => $request->role,
            'password'         => Hash::make($request->password),
            'tipe_user'        => $request->tipe_user,
            'nip'              => $request->nip,
            'unit_fakultas'    => $request->unit_fakultas,
            'jabatan'          => $request->jabatan,
            'lokasi_presensi'  => $request->lokasi_presensi,
            'contact_phone'    => $request->contact_phone,
            'email_address'    => $request->email_address,
            'tempat_lahir'     => $request->tempat_lahir,
            'tanggal_lahir'    => $request->tanggal_lahir,
        ]);

        return redirect()->back()->with('Sukses', 'Berhasil membuat user baru');
    }

    // Tambah admin
    public function createAdmin(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'role'     => 'required|string',
            'password' => 'required|string|min:5|confirmed',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'role'     => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('Sukses', 'Berhasil membuat admin baru');
    }

    // Tampilkan form edit user oleh admin
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('Admin.DataUser.editUser', compact('user'));
    }

    // Update data user oleh admin
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'required|email|unique:users,email,' . $user->id,
            'password'         => 'nullable|string|min:5|confirmed',
            'tipe_user'        => 'nullable|string',
            'nip'              => 'nullable|string|max:50',
            'unit_fakultas'    => 'nullable|string|max:255',
            'jabatan'          => 'nullable|string|max:255',
            'lokasi_presensi'  => 'nullable|string|max:255',
            'contact_phone'    => 'nullable|string|max:50',
            'email_address'    => 'nullable|email|max:255',
            'tempat_lahir'     => 'nullable|string|max:255',
            'tanggal_lahir'    => 'nullable|date',
            'role'             => 'required|string',
        ]);

        $user->fill($request->only([
            'name', 'email', 'tipe_user', 'nip', 'unit_fakultas', 'jabatan',
            'lokasi_presensi', 'contact_phone', 'email_address',
            'tempat_lahir', 'tanggal_lahir', 'role'
        ]));

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('data.user')->with('Sukses', 'Profil user berhasil diperbarui');
    }
    public function statistikPegawai()
{
    $jumlahPNS = \App\Models\User::where('role', 'user')->where('tipe_user', 'pns')->count();
    $jumlahP3K = \App\Models\User::where('role', 'user')->where('tipe_user', 'p3k')->count();
    $jumlahPHL = \App\Models\User::where('role', 'user')->where('tipe_user', 'phl')->count();

    return view('admin.statistik_pegawai', compact('jumlahPNS', 'jumlahP3K', 'jumlahPHL'));
}

public function statistikLogbook()
{
    $totalUser = User::where('role', 'user')->count();

    $usersTerisi = Logbook::whereDate('tanggal', Carbon::today())
        ->whereIn('status', ['hadir', 'sakit', 'cuti', 'dinas luar'])
        ->distinct('user_id')
        ->count('user_id');

    $usersBelumIsi = max($totalUser - $usersTerisi, 0);

    // Hitung persentase
    $persentaseTidakIsi = $totalUser > 0 ? ($usersBelumIsi / $totalUser) * 100 : 0;
    $persentaseIsi = 100 - $persentaseTidakIsi;

    return view('template.base', compact(
        'totalUser',
        'usersTerisi',
        'usersBelumIsi',
        'persentaseTidakIsi',
        'persentaseIsi'
    ));
}
public function getHadirHariIni()
{
    $today = now();

    $hadirHariIni = \App\Models\DetailKehadiran::whereDate('tanggal', $today)
        ->where('status', 'H')
        ->whereHas('user', function ($q) {
            $q->where('role', 'user');
        })
        ->count();

    $totalUserAktif = \App\Models\User::where('role', 'user')->count();
    $tidakHadirHariIni = max(0, $totalUserAktif - $hadirHariIni);

    return response()->json([
        'hadirHariIni' => $hadirHariIni,
        'tidakHadirHariIni' => $tidakHadirHariIni,
    ]);
}

}
