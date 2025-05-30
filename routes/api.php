<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CoverMenuController;
use App\Http\Controllers\API\KeranjangController;
use App\Http\Controllers\API\KritikDanSaranController;
use App\Http\Controllers\API\PariwisataController;
use App\Http\Controllers\API\ProdukController;
use App\Http\Controllers\API\SplashScreenController;
use App\Http\Controllers\API\TransaksiController;
use App\Http\Controllers\API\WishlistController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SocialAuthController;

Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    Route::get('google', [SocialAuthController::class, 'redirectToGoogle']);
    Route::get('google/callback', [SocialAuthController::class, 'handleGoogleCallback']);
});
Route::post('refresh', [AuthController::class, 'refresh']);

Route::middleware(['auth:api'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    // Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);

    Route::post('auth/update', [AuthController::class, 'update']);
    Route::post('auth/update-password', [AuthController::class, 'updatePassword']);
    Route::post('auth/update-foto', [AuthController::class, 'updateFoto']);

    Route::get('/keranjang-ku', [KeranjangController::class, 'index']);
    Route::post('/keranjang-ku/add', [KeranjangController::class, 'add']);
    Route::post('/keranjang-ku/minus', [KeranjangController::class, 'minus']);

    Route::get('/wishlist', [WishlistController::class, 'index']);
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle']);

    Route::post('/transaksi', [TransaksiController::class, 'store']);


    Route::post('/pariwisata-rekomendasi', [PariwisataController::class, 'rekomendasi']);

});

Route::get('/produk', [ProdukController::class, 'index']);
Route::get('/produk/{id}', [ProdukController::class, 'show']);

Route::get('/pariwisata', [PariwisataController::class, 'index']);
Route::get('/pariwisata/{id}', [PariwisataController::class, 'show']);

Route::post('/kritiksaran', [KritikDanSaranController::class, 'create']);

Route::get('/cover-menu', [CoverMenuController::class, 'index']);

Route::get('/splashscreen', [SplashScreenController::class, 'index']);

Route::get('/transaksi/success', [TransaksiController::class, 'success']);
Route::post('/transaksi/callback', [TransaksiController::class, 'update']);









