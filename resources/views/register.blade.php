@extends('layouts.app')

@section('title', 'Registrasi')

@section('content')
<div class="card" style="max-width:360px; margin:40px auto;">
    <h3>Registrasi Siswa</h3>
    <form method="POST" action="/register">
        @csrf
        <label>Username</label><br>
        <input type="text" name="username" value="{{ old('username') }}" required style="width:100%"><br><br>

        <label>Password</label><br>
        <input type="password" name="password" required style="width:100%"><br><br>

        <label>Konfirmasi Password</label><br>
        <input type="password" name="password_confirmation" required style="width:100%"><br><br>

        <button type="submit" style="width:100%">Daftar</button>
    </form>
    <p><a href="/login">Kembali ke login</a></p>
</div>
@endsection