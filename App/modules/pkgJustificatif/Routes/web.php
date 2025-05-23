<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Modules\PkgJustificatif\App\Controllers\DashboardController;

Route::get('justificatif/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('Justificatifs.dashboard');