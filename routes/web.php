<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Operator\LaporanTransaksiProdukController;
use App\Http\Controllers\Admin\Operator\MemberUmkmController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Operator\DashboardController as OperatorDashboardController;
use App\Http\Controllers\Admin\Operator\OperatorController;
use App\Http\Controllers\Admin\Operator\ProdukUmkmController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CoverMenuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\operator\DataPariwisataController;
use App\Http\Controllers\operator\LaporanPariwisataController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\OperatorMiddleware;


// Halaman login
Route::get('/', function () {
    return view('auth.login');
});
Route::get('auth/google', [AuthenticatedSessionController::class, 'redirectToGoogle'])->name('authgoogle');
Route::get('auth/google/callback', [AuthenticatedSessionController::class, 'handleGoogleCallback'])->middleware('web');

// ===========================
// ADMIN ROUTE
// ===========================
Route::middleware(['auth',AdminMiddleware::class])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Cover Menu
    Route::get('/cover-menu', [CoverMenuController::class, 'index'])->name('cover-menu.index');
    Route::get('/cover-menu/data', [CoverMenuController::class, 'data'])->name('cover-menu.data');
    Route::get('/cover-menu/{id}/edit', [CoverMenuController::class, 'edit'])->name('cover-menu.edit');
    Route::patch('/cover-menu/{coverMenu}', [CoverMenuController::class, 'update'])->name('cover-menu.update');

    Route::get('/laporan-transaksi-produk-umkm', [LaporanTransaksiProdukController::class, 'index'])->name('transaksi-produk-umkm.index');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/data', [UserController::class, 'data'])->name('users.data');;


    // CRUD Operator (dibuat oleh Admin)
    Route::resource('/operator', OperatorController::class)->except(['show']);
//     Route::get('/operator', [OperatorController::class, 'index'])->name('operator.index');
// Route::get('/operator/create', [OperatorController::class, 'create'])->name('operator.create');
// Route::get('/operator/{id}/edit', [OperatorController::class, 'edit'])->name('operator.edit');
// // Route store, update, destroy (POST, PUT, DELETE)
// Route::post('/operator', [OperatorController::class, 'store'])->name('operator.store');
// Route::put('/operator/{id}', [OperatorController::class, 'update'])->name('operator.update');
// Route::delete('/operator/{id}', [OperatorController::class, 'destroy'])->name('operator.destroy');


    // Member & Produk UMKM
    Route::resource('/member_umkm', MemberUmkmController::class)->except(['show']);
    Route::resource('/produk_umkm', ProdukUmkmController::class)->except(['show']);

//     // Member UMKM
// Route::get('/member_umkm', [MemberUmkmController::class, 'index'])->name('member_umkm.index');
// Route::get('/member_umkm/create', [MemberUmkmController::class, 'create'])->name('member_umkm.create');
// Route::get('/member_umkm/{id}/edit', [MemberUmkmController::class, 'edit'])->name('member_umkm.edit');
// // Route store, update, destroy (POST, PUT, DELETE)
// Route::post('/member_umkm', [MemberUmkmController::class, 'store'])->name('member_umkm.store');
// Route::put('/member_umkm/{id}', [MemberUmkmController::class, 'update'])->name('member_umkm.update');
// Route::delete('/member_umkm/{id}', [MemberUmkmController::class, 'destroy'])->name('member_umkm.destroy');

// // Produk UMKM
// Route::get('/produk_umkm', [ProdukUmkmController::class, 'index'])->name('produk_umkm.index');
// Route::get('/produk_umkm/create', [ProdukUmkmController::class, 'create'])->name('produk_umkm.create');
// Route::get('/produk_umkm/{id}/edit', [ProdukUmkmController::class, 'edit'])->name('produk_umkm.edit');
// // Route store, update, destroy (POST, PUT, DELETE)
// Route::post('/produk_umkm', [ProdukUmkmController::class, 'store'])->name('produk_umkm.store');
// Route::put('/produk_umkm/{id}', [ProdukUmkmController::class, 'update'])->name('produk_umkm.update');
// Route::delete('/produk_umkm/{id}', [ProdukUmkmController::class, 'destroy'])->name('produk_umkm.destroy');

});

// ===========================
// OPERATOR ROUTE
// ===========================
Route::middleware(['auth',OperatorMiddleware::class])->group(function () {
    Route::get('/{jenis}/dashboard', [OperatorDashboardController::class, 'index'])->name('operator.dashboard');
    Route::prefix('{jenis}')->group(function () {
        Route::resource('/data', DataPariwisataController::class)->names('operator.pariwisata.data');
        Route::resource('/laporan', LaporanPariwisataController::class)->names('operator.pariwisata.laporan');
        
    });
});


// ===========================
// Profile (umum)
// ===========================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
