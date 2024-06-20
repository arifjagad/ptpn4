<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Karyawan\DashboardController;

Route::group(['prefix' => '/', 'middleware' => ['auth', 'user_type:karyawan,karyawan pimpinan,karyawan pelaksana']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('karyawan.dashboard');

});
