<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UnitFakultas;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('user.profile.index', compact('user'));
    }

    public function edit()
    {

        $user = Auth::user();
        return view('user.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        // ✅ Validasi input
        $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'required|email|unique:users,email,' . $user->id,
            'password'         => 'nullable|string|min:6|confirmed',
            'nip'              => 'nullable|string|max:50',
            'unit_fakultas'    => 'nullable|string|max:255',
            'jabatan'          => 'nullable|string|max:255',
            'lokasi_presensi'  => 'nullable|string|max:255',
            'contact_phone'    => 'nullable|string|max:50',
            'email_konfirm'    => 'nullable|email|max:255',
            'tempat_lahir'     => 'nullable|string|max:255',
            'tanggal_lahir'    => 'nullable|date',
        ]);

        // ✅ Update data user
        $user->fill($request->only([
            'name',
            'email',
            'nip',
            'unit_fakultas',
            'jabatan',
            'lokasi_presensi',
            'contact_phone',
            'email_konfirm',
            'tempat_lahir',
            'tanggal_lahir',
        ]));

        // ✅ Update password hanya jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()
            ->route('user.profile.index')
            ->with('success', 'Profil berhasil diperbarui');
    }
}
