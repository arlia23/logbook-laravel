<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function index()
    {
        return view('template.base');
    }

    public function dataUser()
    {
        $user = User::where('role', 'user')->get();
        return view('Admin.DataUser.indexUser', compact('user'));
    }
    public function deleteUser(Request $request)
    {
        $user = User::findorFail($request->id);
        // Storage::delete('$user->image');
        $user->delete();

        return redirect()->route('data.user')->with('Delete', 'Berhasil Menghapus Data');
    }
    public function dataAdmin()
    {
        $user = User::where('role', 'admin')->get();
        return view('Admin.DataUser.indexAdmin', compact('user'));
    }
    public function createAdmin(Request $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => $request->role,
        ]);
        return redirect()->back()->with('Sukses', 'Berhasil create data');
    }
    public function createUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|string',
            'password' => 'required|string|min:6',
            'tipe_user' => 'required|string',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => bcrypt($request->password),
            'tipe_user' => $request->tipe_user,
        ]);

        return redirect()->back()->with('Sukses', 'Berhasil create data');
    }
}
