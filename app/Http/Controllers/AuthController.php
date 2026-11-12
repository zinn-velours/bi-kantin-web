<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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

        $user = User::where('username', $request->username)
                    ->where('password', $request->password)
                    ->first();

        if (!$user) {
            return back()->with('error', 'Username atau password salah.');
        }

        session(['user' => [
            'id'       => $user->id,
            'username' => $user->username,
            'role'     => $user->role,
        ]]);

        if ($user->role === 'admin') {
            return redirect('/admin/dashboard');
        }
        return redirect('/siswa/dashboard');
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
            'password' => $data['password'],
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