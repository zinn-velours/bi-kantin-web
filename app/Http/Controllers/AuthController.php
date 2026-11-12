<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

        public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Username atau password salah.');
        }

        if ($user->status !== 'aktif') {
            return back()->with('error', 'Akun Anda non-aktif. Hubungi admin.');
        }

        session(['user' => [
            'id'       => $user->id,
            'username' => $user->username,
            'role'     => $user->role,
        ]]);

        return match ($user->role) {
            'admin' => redirect('/admin/dashboard'),
            'kasir' => redirect('/kasir/dashboard'),
            default => redirect('/siswa/dashboard'),
        };
    }

    public function showRegister()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|max:50|unique:users,username',
            'password' => 'required|min:3|confirmed',
        ]);

        User::create([
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'role'     => 'siswa',
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil, silakan login.');
    }
    public function logout()
    {
        session()->forget('user');
        return redirect('/login');
    }
}