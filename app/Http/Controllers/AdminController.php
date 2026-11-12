<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // ===== DASHBOARD =====
    public function dashboard()
    {
        $menus = Menu::all();
        $pesanan = Pesanan::with(['user', 'menu'])->orderByDesc('id')->get();

        return view('admin.dashboard', compact('menus', 'pesanan'));
    }

    // ===== CRUD MENU =====
    public function createMenu()
    {
        return view('admin.menu_form', ['menu' => null]);
    }

    public function storeMenu(Request $request)
    {
        Menu::create($this->validateMenu($request));
        return redirect('/admin/dashboard')->with('success', 'Menu berhasil ditambahkan.');
    }

    public function editMenu(Menu $menu)
    {
        return view('admin.menu_form', compact('menu'));
    }

    public function updateMenu(Request $request, Menu $menu)
    {
        $menu->update($this->validateMenu($request));
        return redirect('/admin/dashboard')->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroyMenu(Menu $menu)
    {
        $menu->delete();
        return back()->with('success', 'Menu berhasil dihapus.');
    }

    private function validateMenu(Request $request): array
    {
        return $request->validate([
            'nama_menu' => 'required|max:100',
            'harga'     => 'required|integer|min:0',
            'kategori'  => 'required|max:50',
        ]);
    }

    // ===== STATUS PESANAN =====
    public function updateStatus(Request $request, Pesanan $pesanan)
    {
        $request->validate([
            'status' => 'required|in:Menunggu Konfirmasi,Sedang Dimasak,Siap Diambil,Selesai',
        ]);

        $pesanan->update(['status' => $request->status]);

        return back()->with('success', 'Status pesanan diperbarui.');
    }
        // ===== CRUD AKUN =====
    public function users(Request $request)
    {
        $users = User::query()
            ->when($request->q, function ($query, $q) {
                $query->where(function ($w) use ($q) {
                    $w->where('username', 'like', "%{$q}%")
                      ->orWhere('email', 'like', "%{$q}%");
                });
            })
            ->when($request->role, fn ($query, $role) => $query->where('role', $role))
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.users', compact('users'));
    }

    public function createUser()
    {
        return view('admin.user_form', ['user' => null]);
    }

    public function storeUser(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|max:50|unique:users,username',
            'email'    => 'nullable|email|max:100',
            'password' => 'required|min:3',
            'role'     => 'required|in:admin,siswa,kasir',
            'status'   => 'required|in:aktif,nonaktif',
        ]);

        $data['password'] = Hash::make($data['password']);
        User::create($data);

        return redirect('/admin/users')->with('success', 'Akun berhasil ditambahkan.');
    }

    public function editUser(User $user)
    {
        return view('admin.user_form', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $data = $request->validate([
            'username' => "required|max:50|unique:users,username,{$user->id}",
            'email'    => 'nullable|email|max:100',
            'password' => 'nullable|min:3',
            'role'     => 'required|in:admin,siswa,kasir',
            'status'   => 'required|in:aktif,nonaktif',
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect('/admin/users')->with('success', 'Akun berhasil diperbarui.');
    }

    public function destroyUser(User $user)
    {
        if ($user->id === session('user.id')) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri.');
        }

        $user->delete(); // soft delete

        return back()->with('success', 'Akun dihapus (soft delete).');
    }
}