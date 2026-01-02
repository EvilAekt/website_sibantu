<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DashboardController; // ← tambahkan ini
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/tentang', function () {
    return view('tentang');
})->name('tentang');

Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');

Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
Route::get('/laporan/create', [LaporanController::class, 'create'])->name('laporan.create');
Route::post('/laporan', [LaporanController::class, 'store'])->name('laporan.store');

Route::get('/register-relawan', [RegisteredUserController::class, 'createRelawan'])->name('register.relawan');
Route::post('/register-relawan', [RegisteredUserController::class, 'storeRelawan']);

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';