<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\ObstController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PolController; // Untuk admin
use App\Http\Controllers\Pasien\PolController as PasienPolController;
use App\Http\Controllers\Dokter\JadwalPeriksaController as DokterJadwalPeriksaController;
use App\Http\Controllers\Dokter\PeriksaPasienController;
use App\Http\Controllers\Dokter\AlwayatPasienController;
use App\Http\Controllers\Pasien\PoliController as PasienPoliController; // ✅ Tambahkan ini

// =========================
// 🌐 ROUTE UTAMA
// =========================
Route::get('/', function () {
    return view('welcome');
});

// =========================
// 🔐 ROUTE AUTH
// =========================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);

// =========================
// 👨‍⚕️ PASIEN (Umum - tanpa login)
// =========================
Route::get('/pasien', function () {
    return view('pasien.index');
})->name('pasien.index');

// =========================
// 🧑‍💼 ADMIN (Hanya admin login)
// =========================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->group(function () {
        // Dashboard Admin
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        // CRUD Resource untuk Admin
        Route::resource('polis', PoliController::class);
        Route::resource('dokter', DokterController::class);
        Route::resource('pasien', PasienController::class); // ✅ cukup di sini
        Route::resource('obat', ObatController::class);
    });

// =========================
// 👩‍⚕️ DOKTER (Hanya dokter login)
// =========================
Route::middleware(['auth', 'role:dokter'])
    ->prefix('dokter')
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('dokter.dashboard');
        })->name('dokter.dashboard');
    });

// =========================
// 🧑‍⚕️ PASIEN (Hanya pasien login)
// =========================
Route::middleware(['auth', 'role:pasien'])
    ->prefix('pasien-area') // ⬅️ ubah prefix agar tidak bentrok dengan /pasien umum
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('pasien.dashboard');
        })->name('pasien.dashboard');
        
        // ✅ TAMBAHKAN ROUTE PENDAFTARAN POLI UNTUK PASIEN
        Route::get('/daftar', [PasienPoliController::class, 'get'])->name('pasien.daftar');
        Route::post('/daftar', [PasienPoliController::class, 'submit'])->name('pasien.daftar.submit');
    });