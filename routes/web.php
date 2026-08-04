<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\RuanganController;
use App\Http\Controllers\Admin\Dashboard;
use App\Http\Controllers\Admin\JadwalPelajaranController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', [AuthController::class, 'showLogin'])->name('admin.login')->middleware('guest.auth');
Route::post('login', [AuthController::class, 'login'])->name('admin.login');

Route::prefix('admin')->name('admin.')->middleware('admin.auth')->group(function () {
    route::get('/', [Dashboard::class, 'index'])->name('dashboard');

    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    //kelas
    Route::resource('kelas', KelasController::class)->parameters(['kelas' => 'kelas']);

    //ruangan
    Route::resource('ruangan', RuanganController::class);

    //jadwal pelajaran
    Route::get('/jadwal-pelajaran', [JadwalPelajaranController::class, 'index'])
        ->name('jadwal-pelajaran.index');

    Route::get('/jadwal-pelajaran/{kelas}', [JadwalPelajaranController::class, 'show'])
        ->name('jadwal-pelajaran.show');

    Route::post('/jadwal-pelajaran/{kelas}', [JadwalPelajaranController::class, 'store'])
        ->name('jadwal-pelajaran.store');

    Route::delete('/jadwal-pelajaran/{kelas}/{jadwalPelajaran}', [JadwalPelajaranController::class, 'destroy'])
        ->name('jadwal-pelajaran.destroy');
});
