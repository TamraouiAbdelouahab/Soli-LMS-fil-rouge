<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Modules\PkgAbsence\App\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/absence/dashboard', [DashboardController::class, 'index'])->name('absence.dashboard');
});