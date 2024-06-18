<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KaryawanController;
use App\Http\Controllers\Admin\KaryawanPelaksanaController;
use App\Http\Controllers\Admin\KaryawanPimpinanController;

Route::group(['prefix' => '/', 'middleware' => ['auth', 'user_type:admin']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/list-karyawan-pelaksana', [KaryawanPelaksanaController::class, 'index'])->name('admin.list-karyawan-pelaksana');
    Route::get('/list-karyawan-pimpinan', [KaryawanPimpinanController::class, 'index'])->name('admin.list-karyawan-pimpinan');
    Route::get('/list-karyawan-tamu', [KaryawanController::class, 'index'])->name('admin.list-karyawan-tamu');
});
