<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    // Tampilkan profil user
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        return view('user.profile.index', compact('user'));
    }

    // Form edit profil
    public function edit()
    {
        /** @var User $user */
        $user = Auth::user();
        return view('user.profile.edit', compact('user'));
    }

    // Simpan perubahan profil
    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save(); // <-- WAJIB, supaya data tersimpan ke database

        return redirect()->route('user.profile.index')
            ->with('success', 'Profil berhasil diperbarui');
    }
}
