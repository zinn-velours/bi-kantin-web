<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KasirController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware('role:admin')->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);

    Route::get('/menu/create', [AdminController::class, 'createMenu']);
    Route::post('/menu', [AdminController::class, 'storeMenu']);
    Route::get('/menu/{menu}/edit', [AdminController::class, 'editMenu']);
    Route::put('/menu/{menu}', [AdminController::class, 'updateMenu']);
    Route::delete('/menu/{menu}', [AdminController::class, 'destroyMenu']);

    Route::put('/pesanan/{pesanan}/status', [AdminController::class, 'updateStatus']);
        Route::get('/users', [AdminController::class, 'users']);
    Route::get('/users/create', [AdminController::class, 'createUser']);
    Route::post('/users', [AdminController::class, 'storeUser']);
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser']);
    Route::put('/users/{user}', [AdminController::class, 'updateUser']);
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser']);
});

Route::middleware('role:siswa')->prefix('siswa')->group(function () {
    Route::get('/dashboard', [SiswaController::class, 'dashboard']);
    Route::post('/checkout', [SiswaController::class, 'checkout']);
});

Route::middleware('role:kasir,admin')->prefix('kasir')->group(function () {
    Route::get('/dashboard', [KasirController::class, 'dashboard']);
    Route::put('/pesanan/{pesanan}/lunas', [KasirController::class, 'lunas']);
    Route::put('/pesanan/{pesanan}/siap', [KasirController::class, 'siapDiambil']);
});