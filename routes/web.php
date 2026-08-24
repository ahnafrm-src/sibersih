<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\RuanganController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JadwalPelajaranController;
use App\Http\Controllers\Admin\SanggahanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;

// Route::get('/', [LaporanController::class, 'create']);

// ==========================================
// 🌐 ROUTE PUBLIC (Siswa / Perwakilan Kelas)
// ==========================================

// Form Submit Lapor Kebersihan oleh Siswa/Umum
Route::get('/lapor', [LaporanController::class, 'create'])->name('lapor.create');
Route::post('/lapor', [LaporanController::class, 'store'])->name('lapor.store');

// Submit Sanggahan oleh Siswa
Route::post('/sanggahan', [SanggahanController::class, 'store'])->name('sanggahan.store');


// ==========================================
// 🔐 ROUTE AUTH
// ==========================================
Route::get('login', [AuthController::class, 'showLogin'])->name('admin.login')->middleware('guest.auth');
Route::post('login', [AuthController::class, 'login'])->name('admin.login');


// ==========================================
// 🛡️ ROUTE GROUP ADMIN / GURU PIKET
// ==========================================
Route::prefix('admin')->name('admin.')->middleware('admin.auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Kelas & Ruangan
    Route::resource('kelas', KelasController::class)->parameters(['kelas' => 'kelas']);
    Route::resource('ruangan', RuanganController::class);

    // Jadwal Pelajaran
    Route::get('/jadwal-pelajaran', [JadwalPelajaranController::class, 'index'])->name('jadwal-pelajaran.index');
    Route::get('/jadwal-pelajaran/{kelas}', [JadwalPelajaranController::class, 'show'])->name('jadwal-pelajaran.show');
    Route::post('/jadwal-pelajaran/{kelas}', [JadwalPelajaranController::class, 'store'])->name('jadwal-pelajaran.store');
    Route::delete('/jadwal-pelajaran/{kelas}/{jadwalPelajaran}', [JadwalPelajaranController::class, 'destroy'])->name('jadwal-pelajaran.destroy');

    // Sanggahan
    Route::get('/sanggahan', [SanggahanController::class, 'index'])->name('sanggahan.index');
    Route::patch('/sanggahan/{sanggahan}/verifikasi', [SanggahanController::class, 'verifikasi'])->name('sanggahan.verifikasi');

    // Semua Laporan (Menu Admin untuk Kelola Laporan Masuk)
    Route::get('/laporan', [AdminLaporanController::class, 'index'])->name('laporan.index');
    Route::patch('/laporan/{laporan}/status', [AdminLaporanController::class, 'updateStatus'])->name('laporan.update-status');
    Route::delete('/laporan/{laporan}', [AdminLaporanController::class, 'destroy'])->name('laporan.destroy');
    Route::get('/laporan/{laporan}', [AdminLaporanController::class, 'show'])->name('laporan.show');
    Route::patch('/laporan/{laporan}/koreksi-kelas', [AdminLaporanController::class, 'koreksiKelas'])->name('laporan.koreksi-kelas');
});
