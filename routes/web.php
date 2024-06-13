<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoutingController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__ . '/auth.php';

Route::group(['prefix' => '/', 'middleware'=>'auth'], function () {
    Route::get('', [RoutingController::class, 'index'])->name('root');
    Route::get('{first}/{second}/{third}', [RoutingController::class, 'thirdLevel'])->name('third');
    Route::get('{first}/{second}', [RoutingController::class, 'secondLevel'])->name('second');
    Route::get('{any}', [RoutingController::class, 'root'])->name('any');
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'user_type:admin']], function () {
    Route::get('/', fn() => view('admin.dashboard'))->name('admin.dashboard');
    Route::get('/{any}', [RoutingController::class, 'root'])->name('admin.any');
    Route::get('/{first}/{second}', [RoutingController::class, 'secondLevel'])->name('admin.second');
    Route::get('/{first}/{second}/{third}', [RoutingController::class, 'thirdLevel'])->name('admin.third');
});

Route::group(['prefix' => 'karyawan', 'middleware' => ['auth', 'user_type:karyawan']], function () {
    Route::get('/', fn() => view('karyawan.dashboard'))->name('karyawan.dashboard');
    Route::get('/{any}', [RoutingController::class, 'root'])->name('karyawan.any');
    Route::get('/{first}/{second}', [RoutingController::class, 'secondLevel'])->name('karyawan.second');
    Route::get('/{first}/{second}/{third}', [RoutingController::class, 'thirdLevel'])->name('karyawan.third');
});

Route::group(['prefix' => 'mandor', 'middleware' => ['auth', 'user_type:mandor']], function () {
    Route::get('/', fn() => view('mandor.dashboard'))->name('mandor.dashboard');
    Route::get('/admin/{any}', [RoutingController::class, 'root'])->name('mandor.any');
    Route::get('/{first}/{second}', [RoutingController::class, 'secondLevel'])->name('mandor.second');
    Route::get('/{first}/{second}/{third}', [RoutingController::class, 'thirdLevel'])->name('mandor.third');
});
