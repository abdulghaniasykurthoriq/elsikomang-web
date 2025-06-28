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
use App\Http\Controllers\Operator\BoxOffice\DashboardBoxOfficeController;
use App\Http\Controllers\Operator\BoxOffice\IklanContentController;
use App\Http\Controllers\Operator\BoxOffice\IklanController as BoxOfficeIklanController;
use App\Http\Controllers\Operator\Entertaiment\DashboardEntertaimentController;
use App\Http\Controllers\Operator\Entertaiment\EntertaimentController;
use App\Http\Controllers\Operator\Event\DashboardEventController;
use App\Http\Controllers\Operator\Event\OperatorEventController as EventOperatorEventController;
use App\Http\Controllers\Operator\Investasi\DashboardInvestasiController;
use App\Http\Controllers\Operator\Investasi\InvestasiController;
use App\Http\Controllers\Operator\Pariwisata\DashboardPariwisataController;
use App\Http\Controllers\Operator\Umkm\DashboardUmkmController;
use App\Http\Controllers\Operator\Umkm\LaporanKlasterProdukController as UmkmLaporanKlasterProdukController;
use App\Http\Controllers\Operator\Umkm\LaporanTransaksiUmkmController as UmkmLaporanTransaksiUmkmController;
use App\Http\Controllers\Operator\Umkm\LeastSquaresController;
use App\Http\Controllers\Operator\Umkm\MemberUmkmController as UmkmMemberUmkmController;
use App\Http\Controllers\Operator\Umkm\ProdukUmkmController as UmkmProdukUmkmController;
use App\Http\Middleware\CheckUserRoleMiddleware;
use App\Http\Controllers\Operator\Entertaiment;
use App\Http\Controllers\Operator\Umkm\TransaksiController;
use App\Http\Controllers\Operator\Umkm\VoucherController;

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
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
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

    Route::middleware(CheckUserRoleMiddleware::class.':Operator investasi')->group(function () {
        Route::get('/investasi/dashboard', [DashboardInvestasiController::class, 'index'])->name('investasi.dashboard');
        Route::resource('/investasi', InvestasiController::class)->except(['show']);
    });
    Route::middleware(CheckUserRoleMiddleware::class.':Operator entertainment')->group(function () {
        Route::get('/entertaiment/dashboard', [DashboardEntertaimentController::class, 'index'])->name('entertaiment.dashboard');
        Route::resource('/entertaiment', EntertaimentController::class)->except(['show']);
    });
    Route::middleware(CheckUserRoleMiddleware::class.':Operator event')->group(function () {
        Route::get('/event/dashboard', [DashboardEventController::class, 'index'])->name('event.dashboard');
        Route::resource('/event', EventOperatorEventController::class)->except(['show']);
    });
    Route::middleware(CheckUserRoleMiddleware::class.':Operator pariwisata')->group(function () {
        Route::get('/pariwisata/dashboard', [DashboardPariwisataController::class, 'index'])->name('pariwisata.dashboard');
        Route::resource('/pariwisata', PariwisataController::class)
            ->names('operator.pariwisata.data')
            ->parameters(['pariwisata' => 'id']);
            Route::resource('/laporan', LaporanPariwisataController::class)
            ->names('operator.pariwisata.laporan');
            Route::get('/rekomendasi', [RekomendasiWisataController::class, 'index'])->name('operator.pariwisata.rekomendasi');

    });
    Route::middleware(CheckUserRoleMiddleware::class.':Operator box office')->group(function () {
        Route::get('/box-office/dashboard', [DashboardBoxOfficeController::class, 'index'])->name('box-office.dashboard');
        Route::resource('/iklan', BoxOfficeIklanController::class)->except(['show']);
        Route::resource('iklandata', IklanContentController::class)->except(['show']);

    });
    Route::middleware(CheckUserRoleMiddleware::class.':Operator umkm')->group(function () {
        Route::get('/dashboard', [DashboardUmkmController::class, 'index'])->name('ProdukUmkm.dashboard');
        Route::resource('/produk_umkm', UmkmProdukUmkmController::class)->except(['show']);
        Route::resource('/member_umkm', UmkmMemberUmkmController::class)->except(['show']);
        Route::get('/klasterisasi_umkm', [UmkmLaporanKlasterProdukController::class, 'index'])->name('klasterisasi-produk.index');
        Route::post('/klasterisasi_umkm/process', [UmkmLaporanKlasterProdukController::class, 'process'])->name('klasterisasi-produk.process');

        Route::get('/laporan-transaksi-produk-umkm', [UmkmLaporanTransaksiUmkmController::class, 'index2'])->name('transaksi-produk-umkm.index');
        // Route::get('/laporan-transaksi-produk-umkm2', [UmkmLaporanTransaksiUmkmController::class, 'index2'])->name('laporan.index');
        Route::get('/laporan-transaksi-produk-umkm/{tahun}/{bulan}', [UmkmLaporanTransaksiUmkmController::class, 'showPerBulan'])->name('laporan.perbulan');
        Route::get('/peramalan/proses', [UmkmLaporanTransaksiUmkmController::class, 'proses'])->name('peramalan.proses');

        Route::get('/voucher', [VoucherController::class, 'index'])->name('voucher.index');
        Route::get('/voucher/create', [VoucherController::class, 'create'])->name('voucher.create');
        Route::post('/voucher', [VoucherController::class, 'store'])->name('voucher.store');
        Route::get('/voucher/{id}', [VoucherController::class, 'edit'])->name('voucher.edit');
        Route::put('/voucher/{id}', [VoucherController::class, 'update'])->name('voucher.update');
        Route::delete('/voucher/{id}', [VoucherController::class, 'destroy'])->name('voucher.destroy');

        Route::prefix('transaksi')->group(function () {
            Route::get('/', [TransaksiController::class, 'index'])->name('transaksi.index');
            Route::get('/data', [TransaksiController::class, 'data'])->name('transaksi.data');
            Route::put('/{id}/update-status', [TransaksiController::class, 'updateStatus'])->name('transaksi.updateStatus');
            Route::delete('/{id}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');


        });
        
        
    
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
