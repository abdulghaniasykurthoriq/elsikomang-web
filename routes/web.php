<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Operator\OperatorController;
use App\Http\Controllers\OperatorController as ControllersOperatorController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

// Route index, create, edit
Route::get('/operator', [OperatorController::class, 'index'])->name('operator.index');
Route::get('/operator/create', [OperatorController::class, 'create'])->name('operator.create');
Route::get('/operator/{id}/edit', [OperatorController::class, 'edit'])->name('operator.edit');

// Route store, update, destroy (POST, PUT, DELETE)
Route::post('/operator', [OperatorController::class, 'store'])->name('operator.store');
Route::put('/operator/{id}', [OperatorController::class, 'update'])->name('operator.update');
Route::delete('/operator/{id}', [OperatorController::class, 'destroy'])->name('operator.destroy');
});

require __DIR__ . '/auth.php';
