<?php

use App\Http\Controllers\Admin\Operator\MemberUmkmController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Operator\DashboardController as OperatorDashboardController;
use App\Http\Controllers\Admin\Operator\OperatorController;
use App\Http\Controllers\Admin\Operator\ProdukUmkmController;
use App\Http\Controllers\Operator\Pariwisata\PariwisataController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CoverMenuController;
use App\Http\Controllers\Operator\OperatorEventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Operator\Pariwisata\LaporanPariwisataController;
use App\Http\Controllers\Operator\Pariwisata\RekomendasiWisataController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\OperatorMiddleware;


use App\Http\Controllers\Admin\IklanController;
use App\Http\Controllers\Admin\LaporanTransaksiUmkmController;
use App\Http\Controllers\Admin\SplashScreenController;
use App\Http\Controllers\Admin\Operator\LaporanKlasterProdukController;
use App\Http\Controllers\Operator\BoxOffice\IklanContentController;
use App\Http\Controllers\Operator\BoxOffice\IklanController as BoxOfficeIklanController;
use App\Http\Controllers\Operator\Entertaiment\EntertaimentController;
use App\Http\Controllers\Operator\Event\OperatorEventController as EventOperatorEventController;
use App\Http\Controllers\Operator\Investasi\InvestasiController;
use App\Http\Controllers\Operator\Umkm\LaporanKlasterProdukController as UmkmLaporanKlasterProdukController;
use App\Http\Controllers\Operator\Umkm\MemberUmkmController as UmkmMemberUmkmController;
use App\Http\Controllers\Operator\Umkm\ProdukUmkmController as UmkmProdukUmkmController;

// Halaman login
Route::get('/', function () {
    return view('auth.login');
});
Route::get('auth/google', [AuthenticatedSessionController::class, 'redirectToGoogle'])->name('authgoogle');
Route::get('auth/google/callback', [AuthenticatedSessionController::class, 'handleGoogleCallback'])->middleware('web');

// ===========================
// ADMIN ROUTE
// ===========================
Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Cover Menu
    Route::get('/cover-menu', [CoverMenuController::class, 'index'])->name('cover-menu.index');
    Route::get('/cover-menu/data', [CoverMenuController::class, 'data'])->name('cover-menu.data');
    Route::get('/cover-menu/{id}/edit', [CoverMenuController::class, 'edit'])->name('cover-menu.edit');
    Route::patch('/cover-menu/{coverMenu}', [CoverMenuController::class, 'update'])->name('cover-menu.update');

    Route::get('/laporan-transaksi-produk-umkm', [LaporanTransaksiUmkmController::class, 'index'])->name('transaksi-produk-umkm.index');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');

    Route::get('/users/data', [UserController::class, 'data'])->name('users.data');;

    Route::resource('/splashscreen', SplashScreenController::class)->except(['show','create','store','destroy']);





    // CRUD Operator (dibuat oleh Admin)
    Route::resource('/operator', OperatorController::class)->except(['show']);




    // Route::prefix('iklan/{slug}')->name('iklan.')->group(function () {
    //     Route::get('/', [IklanController::class, 'index'])->name('index');
    //     Route::get('/create', [IklanController::class, 'create'])->name('create');
    //     Route::post('/store', [IklanController::class, 'store'])->name('store');
    // });
    


});

// ===========================
// OPERATOR ROUTE
// ===========================
Route::middleware(['auth', OperatorMiddleware::class])->group(function () {
    Route::get('/{jenis}/dashboard', [OperatorDashboardController::class, 'index'])->name('operator.dashboard');

    Route::prefix('{jenis}')->group(function () {
        Route::resource('/pariwisata', PariwisataController::class)
            ->names('operator.pariwisata.data')
            ->parameters(['pariwisata' => 'id']);

        Route::resource('/laporan', LaporanPariwisataController::class)
            ->names('operator.pariwisata.laporan');

        Route::get('/rekomendasi', [RekomendasiWisataController::class, 'index'])->name('operator.pariwisata.rekomendasi');
        

        Route::resource('/produk_umkm', UmkmProdukUmkmController::class)->except(['show']);
        Route::resource('/member_umkm', UmkmMemberUmkmController::class)->except(['show']);
        Route::resource('/event', EventOperatorEventController::class)->except(['show']);
        Route::resource('/entertaiment', EntertaimentController::class)->except(['show']);
        Route::resource('/investasi', InvestasiController::class)->except(['show']);
        Route::resource('/iklan', BoxOfficeIklanController::class)->except(['show']);
        // Route::resource('iklandata', IklanContentController::class)->except(['show']);
        // Route::resource('iklandata', IklanContentController::class)->parameters([
        //     'iklandata' => 'id',
        // ])->except(['show']);
        Route::get('/iklandata', [IklanContentController::class, 'index'])->name('iklandata.index');
        Route::get('/iklandata/create', [IklanContentController::class, 'create'])->name('iklandata.create');
        Route::post('/iklandata', [IklanContentController::class, 'store'])->name('iklandata.store');
        Route::get('/iklandata/{id}/edit', [IklanContentController::class, 'edit'])->name('iklandata.edit');
        Route::put('/iklandata/{id}', [IklanContentController::class, 'update'])->name('iklandata.update');
        Route::delete('/iklandata/{id}', [IklanContentController::class, 'destroy'])->name('iklandata.destroy');




        Route::get('/klasterisasi_umkm', [UmkmLaporanKlasterProdukController::class, 'index'])->name('klasterisasi-produk.index');

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
