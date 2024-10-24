<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\AbsenController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\OwnerLoginController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\OwnerDashboardController;
use App\Http\Controllers\LaporanControllerOwner;
use App\Http\Controllers\GrafikController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Data Karyawan
Route::get('/data-karyawan', [KaryawanController::class, 'index'])->name('data-karyawan'); // Rute untuk menampilkan data karyawan
Route::post('/simpan-karyawan', [KaryawanController::class, 'simpanKaryawan'])->name('simpan-karyawan'); // Rute untuk menyimpan data karyawan baru
Route::post('/karyawan/nonaktifkan/{id_karyawan}', [KaryawanController::class, 'nonaktifkan'])->name('karyawan.nonaktifkan');

// Absensi
Route::get('/absensi', [AbsenController::class, 'index'])->name('absen');
Route::post('/absensi/simpan', [AbsenController::class, 'simpanAbsensi'])->name('simpan-absensi');
Route::delete('/absen/{id_karyawan}', [AbsenController::class, 'delete'])->name('absen.delete');

// Laporan
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
Route::post('/laporan/filter', [LaporanController::class, 'filter'])->name('laporan.filter');
Route::get('/laporan/download', [LaporanController::class, 'download'])->name('laporan.download');

// Profile dengan middleware auth
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Grafik
Route::get('/grafik', [GrafikController::class, 'index'])->name('grafik.index');

// Auth Routes
require __DIR__.'/auth.php';

// Rute untuk registrasi
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');

// Rute untuk login dan dashboard owner
Route::get('/owner/login', [OwnerLoginController::class, 'showLoginForm'])->name('owner.login');
Route::post('/owner/login', [OwnerLoginController::class, 'login']);
Route::middleware('auth')->group(function () {
    Route::get('/owner/dashboard', [OwnerDashboardController::class, 'index'])->name('owner.dashboard');
    Route::get('/owner/laporan', [LaporanControllerOwner::class, 'index'])->name('owner.laporan.index');
});

// Route untuk menampilkan form reset password
Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');

// Route untuk mengirimkan link reset password
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');


Route::post('/check-role', [AuthController::class, 'checkRole'])->name('check.role');

