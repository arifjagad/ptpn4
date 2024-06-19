<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mandor\DashboardController;
use App\Http\Controllers\Mandor\SupirController;

Route::group(['prefix' => '/', 'middleware' => ['auth', 'user_type:mandor']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('mandor.dashboard');

    /* Route Supir */
    Route::get('/supir', [SupirController::class, 'index'])->name('supir.index');
    Route::get('/supir/form/{supir?}', [SupirController::class, 'form'])->name('supir.form');
    Route::post('/supir/store', [SupirController::class, 'store'])->name('supir.store');
    Route::put('/supir/update/{supir}', [SupirController::class, 'update'])->name('supir.update');
    Route::delete('/supir/{id}', [SupirController::class, 'destroy'])->name('supir.destroy');
});
