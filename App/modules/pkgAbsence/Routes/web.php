<?php

use Illuminate\Support\Facades\Route;
use Modules\PkgAbsence\App\Controllers\DashboardController;
use Modules\PkgAbsence\App\Controllers\AbsenceController; // ← déjà présent

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['web', 'auth'])->group(function () {

    // Dashboard des absences
    Route::get('/absence/dashboard', [DashboardController::class, 'index'])->name('absence.dashboard');

    // 👉 Routes absences CRUD
    Route::prefix('absences')->name('Absences.')->group(function () {
        Route::get('/', [AbsenceController::class, 'index'])->name('index');
        Route::post('/', [AbsenceController::class, 'store'])->name('store');
        Route::get('{id}/edit', [AbsenceController::class, 'edit'])->name('edit');
        Route::put('{id}', [AbsenceController::class, 'update'])->name('update');
        Route::delete('{id}', [AbsenceController::class, 'destroy'])->name('destroy');
    });
});
