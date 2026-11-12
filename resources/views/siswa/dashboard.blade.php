@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('head')
    {{-- Halaman refresh otomatis tiap 15 detik supaya status pesanan terbaru terlihat --}}
    <meta http-equiv="refresh" content="15">
@endsection

@section('content')
<div class="card">
    <h3>Katalog Menu</h3>
    <form method="POST" action="/siswa/checkout">
        @csrf
        <table>
            <tr><th>Menu</th><th>Kategori</th><th>Harga</th><th>Jumlah</th></tr>
            @foreach($menus as $m)
            <tr>
                <td>{{ $m->nama_menu }}</td>
                <td>{{ $m->kategori }}</td>
                <td>Rp {{ number_format($m->harga, 0, ',', '.') }}</td>
                <td><input type="number" min="0" value="0" name="jumlah[{{ $m->id }}]" style="width:70px"></td>
            </tr>
            @endforeach
        </table>
        <br>
        <button type="submit">Checkout Pesanan</button>
    </form>
</div>

<div class="card">
    <h3>Riwayat &amp; Status Pesanan</h3>
    <table>
    <tr><th>#</th><th>Menu</th><th>Jumlah</th><th>Total</th><th>Pembayaran</th><th>Status</th></tr>
        @forelse($pesanan as $p)
        <tr>
            <td>{{ $p->id }}</td>
            <td>{{ $p->menu->nama_menu ?? '(menu dihapus)' }}</td>
            <td>{{ $p->jumlah }}</td>
            <td>Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
           <td>{{ $p->status_bayar }}</td>
            <td><strong>{{ $p->status }}</strong></td>
        </tr>
        @empty
        <tr><td colspan="6">Belum ada pesanan.</td></tr>
        @endforelse
    </table>
</div>
@endsection