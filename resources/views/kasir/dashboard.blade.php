@extends('layouts.app')

@section('title', 'Dashboard Kasir')

@section('content')
<div class="card">
    <h3>Validasi Pembayaran</h3>
    <table>
        <tr><th>#</th><th>Siswa</th><th>Menu</th><th>Total</th><th>Pembayaran</th><th>Status</th><th>Aksi</th></tr>
        @forelse($pesanan as $p)
        <tr>
            <td>{{ $p->id }}</td>
            <td>{{ $p->user->username ?? '-' }}</td>
            <td>{{ $p->menu->nama_menu ?? '(dihapus)' }} x{{ $p->jumlah }}</td>
            <td>Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
            <td><strong>{{ $p->status_bayar }}</strong></td>
            <td>{{ $p->status }}</td>
            <td>
                @if($p->status_bayar !== 'Lunas')
                <form method="POST" action="/kasir/pesanan/{{ $p->id }}/lunas" style="display:inline">
                    @csrf
                    @method('PUT')
                    <button>Lunas</button>
                </form>
                @endif

                @if(!in_array($p->status, ['Siap Diambil', 'Selesai']))
                <form method="POST" action="/kasir/pesanan/{{ $p->id }}/siap" style="display:inline">
                    @csrf
                    @method('PUT')
                    <button class="btn-gray">Siap Diambil</button>
                </form>
                @endif
            </td>
        </tr>
        @empty
        <tr><td colspan="7">Belum ada pesanan.</td></tr>
        @endforelse
    </table>
</div>
@endsection