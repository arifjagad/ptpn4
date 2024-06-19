<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KaryawanController;
use App\Http\Controllers\Admin\KaryawanPelaksanaController;
use App\Http\Controllers\Admin\KaryawanPimpinanController;
use App\Http\Controllers\Admin\KegiatanController;
use App\Http\Controllers\Admin\MandorController;
use App\Http\Controllers\Admin\SupirController;

Route::group(['prefix' => '/', 'middleware' => ['auth', 'user_type:admin']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/list-karyawan-pelaksana', [KaryawanPelaksanaController::class, 'index'])->name('admin.list-karyawan-pelaksana');
    Route::get('/list-karyawan-pimpinan', [KaryawanPimpinanController::class, 'index'])->name('admin.list-karyawan-pimpinan');
    Route::get('/list-karyawan-tamu', [KaryawanController::class, 'index'])->name('admin.list-karyawan-tamu');
    
    Route::get('/list-kegiatan', [KegiatanController::class, 'index'])->name('admin.list-kegiatan');
    Route::get('/list-kegiatan/{id}', [KegiatanController::class, 'show'])->name('kegiatan.show');

    Route::get('/list-mandor', [MandorController::class, 'index'])->name('admin.list-mandor');

    Route::get('/list-supir', [SupirController::class, 'index'])->name('admin.list-supir');
});
