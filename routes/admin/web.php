<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KaryawanController;
use App\Http\Controllers\Admin\KaryawanPelaksanaController;
use App\Http\Controllers\Admin\KaryawanPimpinanController;
use App\Http\Controllers\Admin\KegiatanController;
use App\Http\Controllers\Admin\MandorController;
use App\Http\Controllers\Admin\SupirController;
use App\Http\Controllers\Admin\MobilController;
use App\Http\Controllers\Admin\PertanyaanController;
use App\Http\Controllers\Admin\KuesionerController;
use App\Http\Controllers\Admin\ProfileController;

Route::group(['prefix' => '/', 'middleware' => ['auth', 'user_type:admin']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/list-karyawan-pelaksana', [KaryawanPelaksanaController::class, 'index'])->name('admin.list-karyawan-pelaksana');
    Route::get('/list-karyawan-pimpinan', [KaryawanPimpinanController::class, 'index'])->name('admin.list-karyawan-pimpinan');
    Route::get('/list-karyawan-tamu', [KaryawanController::class, 'index'])->name('admin.list-karyawan-tamu');
    
    Route::get('/list-kegiatan', [KegiatanController::class, 'index'])->name('admin.list-kegiatan');
    Route::get('/list-kegiatan/{id}', [KegiatanController::class, 'show'])->name('kegiatan.show');

    Route::get('/list-mandor', [MandorController::class, 'index'])->name('admin.list-mandor');

    Route::get('/list-supir', [SupirController::class, 'index'])->name('admin.list-supir');

    Route::get('/list-mobil', [MobilController::class, 'index'])->name('admin.list-mobil');

    Route::get('/pertanyaan', [PertanyaanController::class, 'index'])->name('admin.pertanyaan.index');
    Route::get('/pertanyaan/form/{pertanyaan?}', [PertanyaanController::class, 'form'])->name('pertanyaan.form');
    Route::post('/pertanyaan/store', [PertanyaanController::class, 'store'])->name('pertanyaan.store');
    Route::put('/pertanyaan/update/{pertanyaan}', [PertanyaanController::class, 'update'])->name('pertanyaan.update');
    Route::delete('/pertanyaan/{id}', [PertanyaanController::class, 'destroy'])->name('pertanyaan.destroy');

    /* Route Kuesioner */
    Route::get('/list-kuesioner', [KuesionerController::class, 'index'])->name('kuesioner.index');
    Route::get('/list-kuesioner/downloadPdf/{id}', [KuesionerController::class, 'downloadPdf'])->name('kuesioner.downloadPdf');

    /* Route Profile */
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/user/admin/update', [ProfileController::class, 'update'])->name('profile.user.admin.update');
});
