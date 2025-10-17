<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PoliController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\ObatController;

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
        Route::resource('dokters', DokterController::class);
        Route::resource('pasien', PasienController::class);
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
    });
