<?php

use Illuminate\Support\Facades\Route;

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

/*  */

Route::prefix('admin')->group(base_path('routes/admin/web.php'));
Route::prefix('mandor')->group(base_path('routes/mandor/web.php'));
Route::prefix('karyawan')->group(base_path('routes/karyawan/web.php'));

Route::group(['prefix' => '/', 'middleware'=>'auth'], function () {
    Route::redirect('/', '/login'); 
    Route::get('/dashboard', function () {
        if (auth()->user()->user_type === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif (auth()->user()->user_type === 'karyawan' || auth()->user()->user_type === 'karyawan pimpinan' || auth()->user()->user_type === 'karyawan pelaksana') {
            return redirect()->route('karyawan.dashboard');
        } elseif (auth()->user()->user_type === 'mandor') {
            return redirect()->route('mandor.dashboard');
        } else {
            return redirect('/'); 
        }
    });
});


