<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Operator\MemberUmkmController;
use App\Http\Controllers\Admin\Operator\OperatorController;
use App\Http\Controllers\Admin\Operator\ProdukUmkmController;
use App\Http\Controllers\API\KMeansController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CoverMenuController;
use App\Http\Controllers\Operator\OperatorEventController;
// use App\Http\Controllers\OperatorEventController as ControllersOperatorEventController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});
Route::get('auth/google', [AuthenticatedSessionController::class, 'redirectToGoogle'])->name('authgoogle');
Route::get('auth/google/callback', [AuthenticatedSessionController::class, 'handleGoogleCallback'])->middleware('web');;


Route::middleware('auth')->group(function () {

    // start admin route
    Route::get('/cover-menu', [CoverMenuController::class, 'index'])->name('cover-menu.index');
    Route::get('/cover-menu/data', [CoverMenuController::class, 'data'])
     ->name('cover-menu.data');
    Route::get('/cover-menu/{id}/edit', [CoverMenuController::class, 'edit'])->name('cover-menu.edit');
    Route::patch('/cover-menu/{coverMenu}', [CoverMenuController::class, 'update'])->name('cover-menu.update');

    // end admin route



    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

// CRUD Operator
Route::get('/operator', [OperatorController::class, 'index'])->name('operator.index');
Route::get('/operator/create', [OperatorController::class, 'create'])->name('operator.create');
Route::get('/operator/{id}/edit', [OperatorController::class, 'edit'])->name('operator.edit');
// Route store, update, destroy (POST, PUT, DELETE)
Route::post('/operator', [OperatorController::class, 'store'])->name('operator.store');
Route::put('/operator/{id}', [OperatorController::class, 'update'])->name('operator.update');
Route::delete('/operator/{id}', [OperatorController::class, 'destroy'])->name('operator.destroy');

// Member UMKM
Route::get('/member_umkm', [MemberUmkmController::class, 'index'])->name('member_umkm.index');
Route::get('/member_umkm/create', [MemberUmkmController::class, 'create'])->name('member_umkm.create');
Route::get('/member_umkm/{id}/edit', [MemberUmkmController::class, 'edit'])->name('member_umkm.edit');
// Route store, update, destroy (POST, PUT, DELETE)
Route::post('/member_umkm', [MemberUmkmController::class, 'store'])->name('member_umkm.store');
Route::put('/member_umkm/{id}', [MemberUmkmController::class, 'update'])->name('member_umkm.update');
Route::delete('/member_umkm/{id}', [MemberUmkmController::class, 'destroy'])->name('member_umkm.destroy');

// Produk UMKM
Route::get('/produk_umkm', [ProdukUmkmController::class, 'index'])->name('produk_umkm.index');
Route::get('/produk_umkm/create', [ProdukUmkmController::class, 'create'])->name('produk_umkm.create');
Route::get('/produk_umkm/{id}/edit', [ProdukUmkmController::class, 'edit'])->name('produk_umkm.edit');
// Route store, update, destroy (POST, PUT, DELETE)
Route::post('/produk_umkm', [ProdukUmkmController::class, 'store'])->name('produk_umkm.store');
Route::put('/produk_umkm/{id}', [ProdukUmkmController::class, 'update'])->name('produk_umkm.update');
Route::delete('/produk_umkm/{id}', [ProdukUmkmController::class, 'destroy'])->name('produk_umkm.destroy');

// Produk UMKM
Route::get('/operator_event', [OperatorEventController::class, 'index'])->name('operator_event.index');
Route::get('/operator_event/create', [OperatorEventController::class, 'create'])->name('operator_event.create');
Route::get('/operator_event/{id}/edit', [OperatorEventController::class, 'edit'])->name('operator_event.edit');
// Route store, update, destroy (POST, PUT, DELETE)
Route::post('/operator_event', [OperatorEventController::class, 'store'])->name('operator_event.store');
Route::put('/operator_event/{id}', [OperatorEventController::class, 'update'])->name('operator_event.update');
Route::delete('/operator_event/{id}', [OperatorEventController::class, 'destroy'])->name('operator_event.destroy');

Route::get('produk_umkm/klasterisasi', [ProdukUmkmController::class, 'klasterisasiProduk'])->name('produk_umkm.klaster');



});


require __DIR__ . '/auth.php';
