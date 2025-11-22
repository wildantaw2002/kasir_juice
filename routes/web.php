<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\menu_controller;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
Route::get('/dashboardd', [DashboardController::class, 'index'])->name('dashboardd');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route untuk menu - hanya bisa diakses oleh admin dan kasir yang sudah login
Route::middleware(['auth', 'role:admin,kasir'])->group(function () {
    Route::resource('menu', menu_controller::class);
});

// Route untuk kasir (POS)
Route::middleware(['auth', 'role:admin,kasir'])->group(function () {
    Route::get('/kasir', [TransaksiController::class, 'index'])->name('kasir.index');
    Route::post('/kasir/transaksi', [TransaksiController::class, 'store'])->name('kasir.store');
    Route::get('/kasir/history', [TransaksiController::class, 'history'])->name('kasir.history');
    Route::get('/kasir/transaksi/{id}', [TransaksiController::class, 'show'])->name('kasir.show');
    Route::get('/kasir/transaksi/{id}/print', [TransaksiController::class, 'printPDF'])->name('kasir.print');
});

require __DIR__.'/auth.php';
