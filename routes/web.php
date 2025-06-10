<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\IklanController;
use App\Http\Controllers\Operator\DashboardController as OperatorDashboardController;
use App\Http\Controllers\Admin\Operator\OperatorController;
use App\Http\Controllers\Operator\Pariwisata\PariwisataController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CoverMenuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Operator\Pariwisata\LaporanPariwisataController;
use App\Http\Controllers\Operator\Pariwisata\RekomendasiWisataController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\Admin\SplashScreenController;
use App\Http\Controllers\Operator\BoxOffice\IklanContentController;
use App\Http\Controllers\Operator\BoxOffice\IklanController as BoxOfficeIklanController;
use App\Http\Controllers\Operator\Entertaiment\EntertaimentController;
use App\Http\Controllers\Operator\Event\OperatorEventController as EventOperatorEventController;
use App\Http\Controllers\Operator\Investasi\InvestasiController;
use App\Http\Controllers\Operator\Umkm\LaporanKlasterProdukController as UmkmLaporanKlasterProdukController;
use App\Http\Controllers\Operator\Umkm\LaporanTransaksiUmkmController as UmkmLaporanTransaksiUmkmController;
use App\Http\Controllers\Operator\Umkm\LeastSquaresController;
use App\Http\Controllers\Operator\Umkm\MemberUmkmController as UmkmMemberUmkmController;
use App\Http\Controllers\Operator\Umkm\ProdukUmkmController as UmkmProdukUmkmController;
use App\Http\Middleware\CheckUserRoleMiddleware;

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
    Route::get('/cover-menu', [CoverMenuController::class, 'index'])->name('cover-menu.index');
    Route::get('/cover-menu/data', [CoverMenuController::class, 'data'])->name('cover-menu.data');
    Route::get('/cover-menu/{id}/edit', [CoverMenuController::class, 'edit'])->name('cover-menu.edit');
    Route::patch('/cover-menu/{coverMenu}', [CoverMenuController::class, 'update'])->name('cover-menu.update');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/data', [UserController::class, 'data'])->name('users.data');;
    Route::resource('/splashscreen', SplashScreenController::class)->except(['show','create','store','destroy']);
    Route::resource('/operator', OperatorController::class)->except(['show']);
});

// ===========================
// OPERATOR ROUTE
// ===========================
Route::middleware(['auth'])->group(function () {
    Route::get('/{jenis}/dashboard', [OperatorDashboardController::class, 'index'])->name('operator.dashboard');

    Route::middleware(CheckUserRoleMiddleware::class.':Operator investasi')->group(function () {
        Route::resource('/investasi', InvestasiController::class)->except(['show']);
    });
    Route::middleware(CheckUserRoleMiddleware::class.':Operator entertaiment')->group(function () {
        Route::resource('/entertaiment', EntertaimentController::class)->except(['show']);
    });
    Route::middleware(CheckUserRoleMiddleware::class.':Operator event')->group(function () {
        Route::resource('/event', EventOperatorEventController::class)->except(['show']);
    });
    Route::middleware(CheckUserRoleMiddleware::class.':Operator pariwisata')->group(function () {
        Route::resource('/pariwisata', PariwisataController::class)
            ->names('operator.pariwisata.data')
            ->parameters(['pariwisata' => 'id']);
        Route::resource('/laporan', LaporanPariwisataController::class)
            ->names('operator.pariwisata.laporan');
        Route::get('/rekomendasi', [RekomendasiWisataController::class, 'index'])->name('operator.pariwisata.rekomendasi');

    });
    Route::middleware(CheckUserRoleMiddleware::class.':Operator box office')->group(function () {

        Route::resource('/iklan', BoxOfficeIklanController::class)->only(['index']);
        Route::resource('iklandata', IklanContentController::class)->except(['show']);

    });
    Route::middleware(CheckUserRoleMiddleware::class.':Operator umkm')->group(function () {
        Route::resource('/produk_umkm', UmkmProdukUmkmController::class)->except(['show']);
        Route::resource('/member_umkm', UmkmMemberUmkmController::class)->except(['show']);
        Route::get('/klasterisasi_umkm', [UmkmLaporanKlasterProdukController::class, 'index'])->name('klasterisasi-produk.index');
        Route::get('/laporan-transaksi-produk-umkm', [UmkmLaporanTransaksiUmkmController::class, 'index'])->name('transaksi-produk-umkm.index');


        Route::get('/peramalan/proses', [UmkmLaporanTransaksiUmkmController::class, 'proses'])->name('peramalan.proses');


    Route::get('/simulasi', [LeastSquaresController::class, 'index'])->name('simulasi.ls.index');
    Route::post('/simulasi', [LeastSquaresController::class, 'proses'])->name('simulasi.ls.proses');

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
