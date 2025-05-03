<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Operator\MemberUmkmController;
use App\Http\Controllers\Admin\Operator\OperatorController;
use App\Http\Controllers\Admin\Operator\ProdukUmkmController;
use App\Http\Controllers\OperatorController as ControllersOperatorController;
use App\Http\Controllers\CoverMenuController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('auth')->group(function () {

    // start admin route
    Route::get('/cover-menu', [CoverMenuController::class, 'index'])->name('cover-menu.index');
    Route::get('/cover-menu/create', [CoverMenuController::class, 'create'])->name('cover-menu.create');
    Route::post('/cover-menu', [CoverMenuController::class, 'store'])->name('cover-menu.store');
    Route::get('/cover-menu/{id}/edit', [CoverMenuController::class, 'edit'])->name('cover-menu.edit');

    Route::patch('/cover-menu/{coverMenu}', [CoverMenuController::class, 'update'])->name('cover-menu.update');

    Route::delete('/cover-menu/{id}', [CoverMenuController::class, 'destroy'])->name('cover-menu.destroy');
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


});


require __DIR__ . '/auth.php';
