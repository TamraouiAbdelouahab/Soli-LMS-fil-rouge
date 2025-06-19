<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Modules\PkgJustificatif\App\Controllers\DashboardController;
use Modules\PkgJustificatif\App\Controllers\JustificationController;
use Modules\PkgJustificatif\App\Controllers\raisonController;

Route::get('justificatif/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('Justificatifs.dashboard');


    // Reaison Routes
Route::get('justificatif/reason', [raisonController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('reasons.home');
Route::post('justificatif/reason', [raisonController::class, 'store'])
    ->middleware(['auth', 'verified'])
    ->name('reasons.store');
Route::delete('reason/{id}', [raisonController::class, 'destroy'])
    ->middleware(['auth', 'verified'])
    ->name('reasons.destroy');
Route::match(['POST', 'PUT'], 'justificatif/reason/{id}', [raisonController::class, 'update'])
    ->middleware(['auth', 'verified'])
    ->name('reasons.update');



    // Justification Routes
Route::get('justificatif/home', [JustificationController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('Justificatifs.home');
Route::post('justificatif', [JustificationController::class, 'store'])
    ->middleware(['auth', 'verified'])
    ->name('Justificatifs.store');
Route::delete('justificatif/{id}', [JustificationController::class, 'destroy'])
    ->middleware(['auth', 'verified'])
    ->name('Justificatifs.destroy');
Route::match(['POST', 'PUT'], 'justificatif/{id}', [JustificationController::class, 'update'])
    ->middleware(['auth', 'verified'])
    ->name('Justificatifs.update');



