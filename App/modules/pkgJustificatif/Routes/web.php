<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Modules\PkgJustificatif\App\Controllers\DashboardController;
use Modules\PkgJustificatif\App\Controllers\JustificationController;

Route::get('justificatif/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('Justificatifs.dashboard');
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
