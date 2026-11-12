@extends('layouts.app')

@section('title', 'Form Akun')

@section('content')
<div class="card" style="max-width:480px">
    <h3>{{ $user ? 'Edit' : 'Tambah' }} Akun</h3>

    <form method="POST" action="{{ $user ? '/admin/users/'.$user->id : '/admin/users' }}">
        @csrf
        @if($user)
            @method('PUT')
        @endif

        <label>Username</label><br>
        <input type="text" name="username" style="width:100%"
               value="{{ old('username', $user->username ?? '') }}" required><br><br>

        <label>Email</label><br>
        <input type="email" name="email" style="width:100%"
               value="{{ old('email', $user->email ?? '') }}"><br><br>

        <label>Password {{ $user ? '(isi hanya jika ingin reset)' : '' }}</label><br>
        <input type="password" name="password" style="width:100%" {{ $user ? '' : 'required' }}><br><br>

        <label>Role</label><br>
        <select name="role" style="width:100%; padding:7px">
            @foreach(['admin', 'siswa', 'kasir'] as $r)
                <option value="{{ $r }}" @selected(old('role', $user->role ?? '') === $r)>{{ $r }}</option>
            @endforeach
        </select><br><br>

        <label>Status</label><br>
        <select name="status" style="width:100%; padding:7px">
            @foreach(['aktif', 'nonaktif'] as $s)
                <option value="{{ $s }}" @selected(old('status', $user->status ?? 'aktif') === $s)>{{ $s }}</option>
            @endforeach
        </select><br><br>

        <button type="submit">Simpan</button>
        <a href="/admin/users"><button type="button" class="btn-gray">Batal</button></a>
    </form>
</div>
@endsection