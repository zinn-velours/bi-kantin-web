@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="card">
    <h3>Data Menu <a href="/admin/menu/create"><button style="float:right">+ Tambah Menu</button></a></h3>
    <table>
        <tr><th>Nama</th><th>Kategori</th><th>Harga</th><th>Aksi</th></tr>
        @forelse($menus as $m)
        <tr>
            <td>{{ $m->nama_menu }}</td>
            <td>{{ $m->kategori }}</td>
            <td>Rp {{ number_format($m->harga, 0, ',', '.') }}</td>
            <td>
                <a href="/admin/menu/{{ $m->id }}/edit"><button type="button">Edit</button></a>
                <form method="POST" action="/admin/menu/{{ $m->id }}" style="display:inline"
                      onsubmit="return confirm('Hapus menu ini?')">
                    @csrf
                    @method('DELETE')
                    <button style="background:#c0392b">Hapus</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="4">Belum ada menu.</td></tr>
        @endforelse
    </table>
</div>

<div class="card">
    <h3>Pesanan Masuk</h3>
    <table>
        <tr><th>#</th><th>Siswa</th><th>Menu</th><th>Jml</th><th>Total</th><th>Status</th></tr>
        @forelse($pesanan as $p)
        <tr>
            <td>{{ $p->id }}</td>
            <td>{{ $p->user->username ?? '-' }}</td>
            <td>{{ $p->menu->nama_menu ?? '(dihapus)' }}</td>
            <td>{{ $p->jumlah }}</td>
            <td>Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
            <td>
                <form method="POST" action="/admin/pesanan/{{ $p->id }}/status">
                    @csrf
                    @method('PUT')
                    <select name="status">
                        @foreach(['Menunggu Konfirmasi', 'Sedang Dimasak', 'Siap Diambil', 'Selesai'] as $s)
                            <option value="{{ $s }}" @selected($p->status === $s)>{{ $s }}</option>
                        @endforeach
                    </select>
                    <button>Ubah</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="6">Belum ada pesanan.</td></tr>
        @endforelse
    </table>
</div>
@endsection