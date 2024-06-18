<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mandor\DashboardController;

Route::group(['prefix' => '/', 'middleware' => ['auth', 'user_type:mandor']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('mandor.dashboard');
});
