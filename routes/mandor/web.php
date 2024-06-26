<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mandor\DashboardController;
use App\Http\Controllers\Mandor\SupirController;
use App\Http\Controllers\Mandor\MobilController;
use App\Http\Controllers\Mandor\KaryawanController;
use App\Http\Controllers\Mandor\KegiatanController;
use App\Http\Controllers\Mandor\KuesionerController;
use App\Http\Controllers\Mandor\ProfileController;

Route::group(['prefix' => '/', 'middleware' => ['auth', 'user_type:mandor']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('mandor.dashboard');

    /* Route Supir */
    Route::get('/supir', [SupirController::class, 'index'])->name('supir.index');
    Route::get('/supir/form/{supir?}', [SupirController::class, 'form'])->name('supir.form');
    Route::post('/supir/store', [SupirController::class, 'store'])->name('supir.store');
    Route::put('/supir/update/{supir}', [SupirController::class, 'update'])->name('supir.update');
    Route::delete('/supir/{id}', [SupirController::class, 'destroy'])->name('supir.destroy');

    /* Route Mobil */
    Route::get('/mobil', [MobilController::class, 'index'])->name('mobil.index');
    Route::get('/mobil/form/{mobil?}', [MobilController::class, 'form'])->name('mobil.form');
    Route::post('/mobil/store', [MobilController::class, 'store'])->name('mobil.store');
    Route::put('/mobil/update/{mobil}', [MobilController::class, 'update'])->name('mobil.update');
    Route::delete('/mobil/{id}', [MobilController::class, 'destroy'])->name('mobil.destroy');

    /* Route Karyawan */
    Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan.index');
    Route::get('/karyawan/form/{karyawan?}', [KaryawanController::class, 'form'])->name('karyawan.form');
    Route::post('/karyawan/store', [KaryawanController::class, 'store'])->name('karyawan.store');
    Route::put('/karyawan/update/{karyawan}', [KaryawanController::class, 'update'])->name('karyawan.update');
    Route::delete('/karyawan/{id}', [KaryawanController::class, 'destroy'])->name('karyawan.destroy');

    /* Route Kegiatan */
    Route::get('/kegiatan', [KegiatanController::class, 'index'])->name('kegiatan.index');
    Route::get('/kegiatan/form/{kegiatan?}', [KegiatanController::class, 'form'])->name('kegiatan.form');
    Route::post('/kegiatan/store', [KegiatanController::class, 'store'])->name('kegiatan.store');
    Route::put('/kegiatan/update/{kegiatan}', [KegiatanController::class, 'update'])->name('kegiatan.update');
    Route::delete('/kegiatan/{id}', [KegiatanController::class, 'destroy'])->name('kegiatan.destroy');

    Route::get('/karyawan/{type}', [KegiatanController::class, 'getKaryawanByType'])->name('karyawan.byType');
    Route::get('/kegiatan/{id}', [KegiatanController::class, 'show'])->name('kegiatan.show');
    Route::put('/kegiatan/finished/{id}', [KegiatanController::class, 'finished'])->name('kegiatan.finished');

    /* Route Kuesioner */
    Route::get('/kuesioner', [KuesionerController::class, 'index'])->name('kuesioner.index');
    Route::get('/kuesioner/downloadPdf/{id}', [KuesionerController::class, 'downloadPdf'])->name('kuesioner.downloadPdf');

    /* Route Profile */
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/user/mandor/update', [ProfileController::class, 'update'])->name('profile.user.mandor.update');
    Route::put('/profile/mandor/update', [ProfileController::class, 'updateMandor'])->name('profile.mandor.update');
});
