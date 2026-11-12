<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\AdminController;

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
});

Route::middleware('role:siswa')->prefix('siswa')->group(function () {
    Route::get('/dashboard', [SiswaController::class, 'dashboard']);
    Route::post('/checkout', [SiswaController::class, 'checkout']);
});