<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProyectoLaborSocialController;
use App\Http\Controllers\RegistroHoraLaborSocialController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/proyecto-labor-social', [ProyectoLaborSocialController::class, 'store'])->name('proyecto.store');
    Route::post('/registro-horas', [RegistroHoraLaborSocialController::class, 'store'])->name('horas.store');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
