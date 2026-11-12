<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function dashboard()
    {
        $menus = Menu::all();

        $pesanan = Pesanan::with('menu')
                    ->where('user_id', session('user.id'))
                    ->orderByDesc('id')
                    ->get();

        return view('siswa.dashboard', compact('menus', 'pesanan'));
    }

    public function checkout(Request $request)
    {
        // Ambil hanya menu yang jumlahnya lebih dari 0
        $items = collect($request->input('jumlah', []))
                    ->filter(fn ($jumlah) => (int) $jumlah > 0);

        if ($items->isEmpty()) {
            return back()->with('error', 'Isi jumlah minimal satu menu.');
        }

        foreach ($items as $menuId => $jumlah) {
            $menu = Menu::find($menuId);
            if (!$menu) {
                continue;
            }

            Pesanan::create([
                'user_id'     => session('user.id'),
                'menu_id'     => $menu->id,
                'jumlah'      => (int) $jumlah,
                'total_harga' => $menu->harga * (int) $jumlah,
                'status'      => 'Menunggu Konfirmasi',
            ]);
        }

        return redirect('/siswa/dashboard')->with('success', 'Pesanan berhasil dibuat.');
    }
}