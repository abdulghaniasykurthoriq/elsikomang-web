<?php

use App\Http\Controllers\API\AlamatController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CoverMenuController;
use App\Http\Controllers\API\EntertainmentController;
use App\Http\Controllers\API\EventController;
use App\Http\Controllers\API\IklanController;
use App\Http\Controllers\API\InvestasiController;
use App\Http\Controllers\API\KeranjangController;
use App\Http\Controllers\API\KritikDanSaranController;
use App\Http\Controllers\API\PariwisataController;
use App\Http\Controllers\API\ProdukController;
use App\Http\Controllers\API\RajaOngkirController;
use App\Http\Controllers\API\SplashScreenController;
use App\Http\Controllers\API\TransaksiController;
use App\Http\Controllers\API\WilayahController;
use App\Http\Controllers\API\WishlistController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('google', [AuthController::class, 'google']);
});
Route::post('refresh', [AuthController::class, 'refresh']);

Route::middleware(['auth:api'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('me', [AuthController::class, 'me']);

    Route::post('auth/update', [AuthController::class, 'update']);
    Route::post('auth/update-password', [AuthController::class, 'updatePassword']);
    Route::post('auth/update-foto', [AuthController::class, 'updateFoto']);
    Route::apiResource('alamats', AlamatController::class);

    Route::get('/keranjang-ku', [KeranjangController::class, 'index']);
    Route::get('/keranjang-ku/total', [KeranjangController::class, 'countKeranjang']);
    Route::post('/keranjang-ku/add', [KeranjangController::class, 'add']);
    Route::post('/keranjang-ku/minus', [KeranjangController::class, 'minus']);

    Route::get('/wishlist', [WishlistController::class, 'index']);
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle']);

    Route::post('/transaksi', [TransaksiController::class, 'store']);
    Route::get('/transaksi', [TransaksiController::class, 'index']);
    Route::get('/transaksi/status-count', [TransaksiController::class, 'countByStatus']);


    Route::post('/pariwisata-rekomendasi', [PariwisataController::class, 'rekomendasi']);
    Route::post('/pariwisata/rate', [PariwisataController::class, 'rate']);

});

Route::get('/provinsi', [WilayahController::class, 'provinsi']);
Route::get('/kota/{id}', [WilayahController::class, 'kota']);
Route::get('/kecamatan/{id}', [WilayahController::class, 'kecamatan']);
Route::get('/desa/{id}', [WilayahController::class, 'desa']);

Route::get('/produk', [ProdukController::class, 'index']);
Route::get('/produk/{id}', [ProdukController::class, 'show']);

Route::get('/pariwisata', [PariwisataController::class, 'index']);
Route::get('/pariwisata/{id}', [PariwisataController::class, 'show']);

Route::get('/events', [EventController::class, 'index']);
Route::get('/events/{id}', [EventController::class, 'show']);

Route::get('/entertaintments', [EntertainmentController::class, 'index']);
Route::get('/entertaintments/{id}', [EntertainmentController::class, 'show']);

Route::get('/investasi', [InvestasiController::class, 'index']);
Route::get('/investasi/{id}', [InvestasiController::class, 'show']);

Route::get('/iklan', [IklanController::class, 'index']);

 
Route::post('/kritiksaran', [KritikDanSaranController::class, 'create']);
Route::get('/cover-menu', [CoverMenuController::class, 'index']);
Route::get('/splashscreen', [SplashScreenController::class, 'index']);

Route::get('/transaksi/success', [TransaksiController::class, 'success']);
Route::post('/transaksi/callback', [TransaksiController::class, 'update']);



// Route::get('/wilayah/raga-ongkir', [WilayahController::class, 'importDestinasi']);
Route::post('/cek-ongkir', [RajaOngkirController::class, 'checkOngkir']);

 









