<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;

class KasirController extends Controller
{
    public function dashboard()
    {
        $pesanan = Pesanan::with(['user', 'menu'])->orderByDesc('id')->get();

        return view('kasir.dashboard', compact('pesanan'));
    }

    public function lunas(Pesanan $pesanan)
    {
        $pesanan->update(['status_bayar' => 'Lunas']);

        return back()->with('success', 'Pembayaran pesanan #' . $pesanan->id . ' ditandai Lunas.');
    }

    public function siapDiambil(Pesanan $pesanan)
    {
        $pesanan->update(['status' => 'Siap Diambil']);

        return back()->with('success', 'Pesanan #' . $pesanan->id . ' siap diambil.');
    }
}