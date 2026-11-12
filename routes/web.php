<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

// Halaman sementara untuk menguji middleware (akan diganti di tahap berikutnya)
Route::get('/admin/dashboard', function () {
    return 'Halo Admin, ' . session('user.username');
})->middleware('role:admin');

Route::get('/siswa/dashboard', function () {
    return 'Halo Siswa, ' . session('user.username');
})->middleware('role:siswa');