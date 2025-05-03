<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Operator\OperatorController;
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

    Route::get('/operator', [OperatorController::class, 'index'])->name('operator');

});

require __DIR__ . '/auth.php';
