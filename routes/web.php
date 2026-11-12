<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SiswaController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);

// Halaman sementara admin (akan diganti di Tahap 7)
Route::get('/admin/dashboard', function () {
    return 'Halo Admin, ' . session('user.username');
})->middleware('role:admin');

Route::middleware('role:siswa')->prefix('siswa')->group(function () {
    Route::get('/dashboard', [SiswaController::class, 'dashboard']);
    Route::post('/checkout', [SiswaController::class, 'checkout']);
});