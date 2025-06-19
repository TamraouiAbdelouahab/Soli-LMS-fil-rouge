<?php

use Illuminate\Support\Facades\Route;
use Modules\PkgAbsence\App\Controllers\DashboardController;
use Modules\PkgAbsence\App\Controllers\AbsenceController; // ← ajoute ce use

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['web', 'auth'])->group(function () {

    // Dashboard des absences
    Route::get('/absence/dashboard', [DashboardController::class, 'index'])->name('absence.dashboard');

    // 👉 Routes absences (index + create)
    Route::prefix('absences')->name('Absences.')->group(function () {
        Route::get('/', [AbsenceController::class, 'index'])->name('index');
        Route::get('/create', [AbsenceController::class, 'create'])->name('create');
    });
});
