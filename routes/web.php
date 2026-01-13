<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\DashboardController; // Existing one? Maybe unused now
use App\Http\Controllers\DonaturController;
use App\Http\Controllers\FundraiserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public
Route::get('/', function () {
    // Show top campaigns on home
    $campaigns = \App\Models\Campaign::where('status', 'active')->where('is_verified', true)->take(3)->get();
    return view('home', compact('campaigns'));
})->name('home');

Route::get('/tentang', function () {
    return view('tentang');
})->name('tentang');

// Static Pages
Route::controller(PageController::class)->group(function () {
    Route::get('/cara-melapor', 'caraMelapor')->name('pages.cara-melapor');
    Route::get('/syarat-ketentuan', 'syaratKetentuan')->name('pages.terms');
    Route::get('/kebijakan-privasi', 'kebijakanPrivasi')->name('pages.privacy');
    Route::get('/faq', 'faq')->name('pages.faq');
});

// Auth Routes (Custom, replacing Breeze/Default for these specific routes)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Public Campaign Routes
Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaigns.index');
Route::get('/campaigns/{slug}', [CampaignController::class, 'show'])->name('campaigns.show');
Route::get('/campaigns/{slug}/donate', [CampaignController::class, 'donate'])->name('campaigns.donate');
Route::post('/campaigns/{slug}/donate', [CampaignController::class, 'storeDonation'])->name('campaigns.storeDonation')->middleware('auth');
Route::get('/donations/success/{id}', [CampaignController::class, 'success'])->name('donations.success')->middleware('auth');
Route::post('/campaigns/{slug}/transaction', [TransactionController::class, 'store'])->name('transactions.store');

// Payment Simulation (Public access for callback)
Route::get('/payment/simulation/{code}', [TransactionController::class, 'simulation'])->name('payment.simulation');
Route::post('/payment/callback/{code}', [TransactionController::class, 'callback'])->name('payment.callback');

// Auth Routes (Breeze/Default)
require __DIR__ . '/auth.php';

// Authenticated Groups
Route::middleware(['auth', 'verified'])->group(function () {

    // Redirect /dashboard based on role
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->role === 'admin')
            return redirect()->route('admin.dashboard');
        if ($user->role === 'fundraiser')
            return redirect()->route('fundraiser.dashboard');
        return redirect()->route('user.dashboard');
    })->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Laporan (All users can see/create? Or logic specific?)
    // Allowing all auth users to create reports
    Route::resource('laporan', LaporanController::class);

    // --- Role Based Routes ---

    // Admin
    Route::middleware(['role:admin'])->prefix('admin')->as('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Report Management
        Route::get('/reports', [AdminController::class, 'reports'])->name('reports'); // New Route
        Route::post('/report/{id}/verify', [AdminController::class, 'verifyReport'])->name('report.verify');
        Route::post('/report/{id}/reject', [AdminController::class, 'rejectReport'])->name('report.reject');
        Route::post('/report/{id}/convert', [AdminController::class, 'convertToCampaign'])->name('report.convert');

        // Withdrawal Management
        Route::post('/withdrawal/{id}/approve', [AdminController::class, 'approveWithdrawal'])->name('withdrawal.approve');

        // User Verification (Relawan)
        Route::post('/user/{id}/verify', [AdminController::class, 'verifyUser'])->name('user.verify');
    });

    // Fundraiser
    Route::middleware(['role:fundraiser'])->prefix('fundraiser')->as('fundraiser.')->group(function () {
        Route::get('/dashboard', [FundraiserController::class, 'dashboard'])->name('dashboard');
        Route::post('/withdraw', [FundraiserController::class, 'withdraw'])->name('withdraw');
        Route::get('/withdrawals', [FundraiserController::class, 'withdrawals'])->name('withdrawals');

        // Campaign Management
        Route::resource('campaigns', FundraiserController::class)->except(['show', 'index']);

        // Campaign Updates
        Route::post('/campaigns/{id}/updates', [App\Http\Controllers\CampaignUpdateController::class, 'store'])->name('campaigns.updates.store');
        Route::delete('/campaigns/updates/{id}', [App\Http\Controllers\CampaignUpdateController::class, 'destroy'])->name('campaigns.updates.destroy');
    });


    // Donatur / Public User
    Route::middleware(['role:donatur'])->prefix('user')->as('user.')->group(function () {
        Route::get('/dashboard', [DonaturController::class, 'dashboard'])->name('dashboard');
        Route::get('/history', [DonaturController::class, 'history'])->name('history');
    });
});