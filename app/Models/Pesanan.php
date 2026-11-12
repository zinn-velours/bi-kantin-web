<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Pesanan extends Model
{
    protected $table = 'pesanan';
    public $timestamps = false;

    protected $fillable = ['user_id', 'menu_id', 'jumlah', 'total_harga', 'status'];

        public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
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