@extends('layouts.app')

@section('title', 'Form Menu')

@section('content')
<div class="card" style="max-width:480px">
    <h3>{{ $menu ? 'Edit' : 'Tambah' }} Menu</h3>

    <form method="POST" action="{{ $menu ? '/admin/menu/'.$menu->id : '/admin/menu' }}">
        @csrf
        @if($menu)
            @method('PUT')
        @endif

        <label>Nama Menu</label><br>
        <input type="text" name="nama_menu" style="width:100%"
               value="{{ old('nama_menu', $menu->nama_menu ?? '') }}" required><br><br>

        <label>Harga</label><br>
        <input type="number" name="harga" style="width:100%"
               value="{{ old('harga', $menu->harga ?? '') }}" required><br><br>

        <label>Kategori</label><br>
        <select name="kategori" style="width:100%; padding:7px">
            @foreach(['Makanan', 'Minuman', 'Snack'] as $k)
                <option value="{{ $k }}" @selected(old('kategori', $menu->kategori ?? '') === $k)>{{ $k }}</option>
            @endforeach
        </select><br><br>

        <button type="submit">Simpan</button>
        <a href="/admin/dashboard"><button type="button" class="btn-gray">Batal</button></a>
    </form>
</div>
@endsection