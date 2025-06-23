<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Modules\PkgJustificatif\App\Controllers\DashboardController;
use Modules\PkgJustificatif\App\Controllers\JustificationApprenantController;
use Modules\PkgJustificatif\App\Controllers\JustificationController;
use Modules\PkgJustificatif\App\Controllers\raisonController;

Route::get('justificatif/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'role:responsable des apprenants|responsable de formation'])
    ->name('Justificatifs.dashboard');


    // Justification Apprenant Routes

Route::prefix('justificatif/apprenant')->middleware(['auth', 'verified','role:apprenant'])->group(function () {
    Route::get('/', [JustificationApprenantController::class, 'index'])->name('Justificatifs.apprenant');
    Route::post('/', [JustificationApprenantController::class, 'store'])->name('Justificatifs.apprenant.store');
    Route::match(['POST', 'PUT'], '/{id}', [JustificationApprenantController::class, 'update'])->name('Justificatifs.apprenant.update');
});
// Route::get('justificatif/apprenant', [JustificationApprenantController::class, 'index'])
//     ->middleware(['auth', 'verified'])
//     ->name('Justificatifs.apprenant');
// Route::post('justificatif/apprenant', [JustificationApprenantController::class, 'store'])
//     ->middleware(['auth', 'verified'])
//     ->name('Justificatifs.apprenant.store');
// Route::match(['POST', 'PUT'], 'justificatif/apprenant/{id}', [JustificationApprenantController::class, 'update'])
//     ->middleware(['auth', 'verified'])
//     ->name('Justificatifs.apprenant.update');


    // Reaison Routes

    Route::prefix('justificatif/reason')->middleware(['auth', 'verified','role:responsable des apprenants|responsable de formation'])->group(function () {
        Route::get('/', [raisonController::class, 'index'])->name('reasons.home');
        Route::post('/', [raisonController::class, 'store'])->name('reasons.store');
        Route::delete('/{id}', [raisonController::class, 'destroy'])->name('reasons.destroy');
        Route::match(['POST', 'PUT'], '/{id}', [raisonController::class, 'update'])->name('reasons.update');
    });
// Route::get('justificatif/reason', [raisonController::class, 'index'])
//     ->middleware(['auth', 'verified'])
//     ->name('reasons.home');
// Route::post('justificatif/reason', [raisonController::class, 'store'])
//     ->middleware(['auth', 'verified'])
//     ->name('reasons.store');
// Route::delete('reason/{id}', [raisonController::class, 'destroy'])
//     ->middleware(['auth', 'verified'])
//     ->name('reasons.destroy');
// Route::match(['POST', 'PUT'], 'justificatif/reason/{id}', [raisonController::class, 'update'])
//     ->middleware(['auth', 'verified'])
//     ->name('reasons.update');





    // Justification Routes
    Route::prefix('justificatif')->middleware(['auth', 'verified','role:responsable des apprenants|responsable de formation'])->group(function () {
        Route::get('/home', [JustificationController::class, 'index'])->name('Justificatifs.home');
        Route::post('/', [JustificationController::class, 'store'])->name('Justificatifs.store');
        Route::delete('/{id}', [JustificationController::class, 'destroy'])->name('Justificatifs.destroy');
        Route::match(['POST', 'PUT'], '/{id}', [JustificationController::class, 'update'])->name('Justificatifs.update');
    });
// Route::get('justificatif/home', [JustificationController::class, 'index'])
//     ->middleware(['auth', 'verified'])
//     ->name('Justificatifs.home');
// Route::post('justificatif', [JustificationController::class, 'store'])
//     ->middleware(['auth', 'verified'])
//     ->name('Justificatifs.store');
// Route::delete('justificatif/{id}', [JustificationController::class, 'destroy'])
//     ->middleware(['auth', 'verified'])
//     ->name('Justificatifs.destroy');
// Route::match(['POST', 'PUT'], 'justificatif/{id}', [JustificationController::class, 'update'])
//     ->middleware(['auth', 'verified'])
//     ->name('Justificatifs.update');







