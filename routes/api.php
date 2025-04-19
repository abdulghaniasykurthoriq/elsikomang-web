<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\KritikDanSaranController;
use App\Http\Controllers\API\PariwisataController;
use App\Http\Controllers\API\ProdukController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SocialAuthController;



Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('login', [AuthController::class,'login']);
    Route::post('register', [AuthController::class,'register']);

    Route::get('google', [SocialAuthController::class, 'redirectToGoogle']);
    Route::get('google/callback', [SocialAuthController::class, 'handleGoogleCallback']);
});

Route::middleware(['auth:api'])->group(function(){
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('me', [AuthController::class,'me']);

    Route::post('auth/update', [AuthController::class,'update']);

});

Route::get('/produk', [ProdukController::class, 'index']);
Route::get('/produk/{id}', [ProdukController::class, 'show']);

Route::get('/pariwisata', [PariwisataController::class, 'index']);
Route::get('/pariwisata/{id}', [PariwisataController::class, 'show']);

Route::post('/kritiksaran', [KritikDanSaranController::class, 'create']);


