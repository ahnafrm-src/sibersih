<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\KelasController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', [AuthController::class, 'showLogin'])->name('admin.login')->middleware('guest.auth');
Route::post('login', [AuthController::class, 'login']);

Route::prefix('admin')->name('admin.')->middleware('admin.auth')->group(function () {
    route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    //kelas
    Route::resource('kelas', KelasController::class);
});
