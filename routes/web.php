<?php


use App\Http\Controllers\Admin\Operator\LaporanTransaksiProdukController;
use App\Http\Controllers\Admin\Operator\MemberUmkmController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Operator\DashboardController as OperatorDashboardController;
use App\Http\Controllers\Admin\Operator\OperatorController;
use App\Http\Controllers\Admin\Operator\ProdukUmkmController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CoverMenuController;
use App\Http\Controllers\Operator\OperatorEventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\operator\DataPariwisataController;
use App\Http\Controllers\operator\LaporanPariwisataController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\OperatorMiddleware;
use App\Http\Controllers\Admin\IklanController;
use App\Http\Controllers\Admin\Operator\LaporanKlasterProdukController;

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




    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');




    Route::get('/iklan/{slug}', [IklanController::class, 'index'])->name('iklan.index');
    Route::get('/iklan/{slug}/create', [IklanController::class, 'create'])->name('iklan.create');
    Route::post('/iklan/{slug}/store', [IklanController::class, 'store'])->name('iklan.store');

});

// ===========================
// OPERATOR ROUTE
// ===========================
Route::middleware(['auth',OperatorMiddleware::class])->group(function () {
    Route::get('/{jenis}/dashboard', [OperatorDashboardController::class, 'index'])->name('operator.dashboard');
    Route::prefix('{jenis}')->group(function () {
        Route::resource('/data', DataPariwisataController::class)->names('operator.pariwisata.data');
        Route::resource('/laporan', LaporanPariwisataController::class)->names('operator.pariwisata.laporan');
        Route::resource('/produk_umkm', ProdukUmkmController::class)->except(['show']);
        Route::resource('/member_umkm', MemberUmkmController::class)->except(['show']);
        Route::resource('/event', OperatorEventController::class)->except(['show']);
        
        Route::get('/klasterisasi_umkm', [LaporanKlasterProdukController::class, 'index'])->name('klasterisasi-produk.index');

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
