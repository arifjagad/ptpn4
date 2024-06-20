<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Karyawan\DashboardController;
use App\Http\Controllers\Karyawan\KegiatanController;

Route::group(['prefix' => '/', 'middleware' => ['auth', 'user_type:karyawan,karyawan pimpinan,karyawan pelaksana']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('karyawan.dashboard');

    Route::get('/kegiatan', [KegiatanController::class, 'index'])->name('karyawan.kegiatan');
    Route::get('/kegiatan/{id}', [KegiatanController::class, 'show'])->name('kegiatan.show');
});
