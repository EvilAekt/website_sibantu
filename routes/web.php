<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/tentang', function () {
    return view('tentang');
})->name('tentang');

// --- BAGIAN LAPORAN (DIPERBAIKI) ---

// 1. Index
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');

// 2. Route Create & Store (HARUS DI ATAS {id})
Route::get('/laporan/create', [LaporanController::class, 'create'])->name('laporan.create');
Route::post('/laporan', [LaporanController::class, 'store'])->name('laporan.store');

// 3. Route Export (HARUS DI ATAS {id})
Route::get('/laporan/export/csv', [LaporanController::class, 'exportCSV'])->name('laporan.exportCSV');

// 4. Route Show/Detail (HARUS PALING BAWAH DI GRUP LAPORAN)
// Karena {id} menangkap segala sesuatu setelah /laporan/
Route::get('/laporan/{id}', [LaporanController::class, 'show'])->name('laporan.show');

// --- AKHIR BAGIAN LAPORAN ---

Route::get('/register-relawan', [RegisteredUserController::class, 'createRelawan'])->name('register.relawan');
Route::post('/register-relawan', [RegisteredUserController::class, 'storeRelawan']);

// Hapus salah satu route dashboard ini (kamu punya duplikat dashboard).
// Sebaiknya pakai yang Controller:
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->middleware(['auth'])->group(function () {
    // ...
    // HAPUS / GANTI BAGIAN YANG LAMA DENGAN INI:
    
    Route::get('/bantuan', [App\Http\Controllers\AdminController::class, 'bantuan'])->name('admin.bantuan');
    Route::get('/penyaluran', [App\Http\Controllers\AdminController::class, 'penyaluran'])->name('admin.penyaluran');
    Route::get('/pengaturan', [App\Http\Controllers\AdminController::class, 'pengaturan'])->name('admin.pengaturan');
});

require __DIR__.'/auth.php';