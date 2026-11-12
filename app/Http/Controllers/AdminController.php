<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Pesanan;
use Illuminate\Http\Request;

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
}