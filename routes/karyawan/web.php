<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Karyawan\DashboardController;
use App\Http\Controllers\Karyawan\KegiatanController;
use App\Http\Controllers\Karyawan\KuesionerController;

Route::group(['prefix' => '/', 'middleware' => ['auth', 'user_type:karyawan,karyawan pimpinan,karyawan pelaksana']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('karyawan.dashboard');

    Route::get('/kegiatan', [KegiatanController::class, 'index'])->name('karyawan.kegiatan');
    Route::get('/kegiatan/{id}', [KegiatanController::class, 'show'])->name('kegiatan.show');

    Route::get('/kuesioner', [KuesionerController::class, 'index'])->name('karyawan.kuesioner');
    Route::get('/kuesioner/jawaban/{id}', [KuesionerController::class, 'jawaban'])->name('kuesioner.jawaban');
    Route::put('/kuesioner/jawaban/{id}', [KuesionerController::class, 'update'])->name('kuesioner.update');
    Route::get('/kuesioner/downloadPdf/{id}', [KuesionerController::class, 'downloadPdf'])->name('kuesioner.downloadPdf');
});
