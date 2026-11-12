@extends('layouts.app')

@section('title', 'Kelola Akun')

@section('content')
<div class="card">
    <h3>Kelola Akun <a href="/admin/users/create"><button style="float:right">+ Tambah Akun</button></a></h3>

    <form method="GET" action="/admin/users" style="margin-bottom:12px">
        <input type="text" name="q" placeholder="Cari username/email" value="{{ request('q') }}">
        <select name="role" style="padding:7px">
            <option value="">Semua role</option>
            @foreach(['admin', 'siswa', 'kasir'] as $r)
                <option value="{{ $r }}" @selected(request('role') === $r)>{{ $r }}</option>
            @endforeach
        </select>
        <button>Cari</button>
        <a href="/admin/users">Reset</a>
    </form>

    <table>
        <tr><th>ID</th><th>Username</th><th>Email</th><th>Role</th><th>Status</th><th>Aksi</th></tr>
        @forelse($users as $u)
        <tr>
            <td>{{ $u->id }}</td>
            <td>{{ $u->username }}</td>
            <td>{{ $u->email }}</td>
            <td>{{ $u->role }}</td>
            <td>{{ $u->status }}</td>
            <td>
                <a href="/admin/users/{{ $u->id }}/edit"><button type="button">Edit</button></a>
                <form method="POST" action="/admin/users/{{ $u->id }}" style="display:inline"
                      onsubmit="return confirm('Hapus akun ini?')">
                    @csrf
                    @method('DELETE')
                    <button style="background:#c0392b">Hapus</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="6">Tidak ada akun.</td></tr>
        @endforelse
    </table>

    <div style="margin-top:12px">{{ $users->links() }}</div>
</div>
@endsection