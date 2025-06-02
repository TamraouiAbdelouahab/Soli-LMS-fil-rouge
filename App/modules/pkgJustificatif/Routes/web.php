<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Modules\PkgJustificatif\App\Controllers\DashboardController;
use Modules\PkgJustificatif\App\Controllers\HomeController;

Route::get('justificatif/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('Justificatifs.dashboard');
Route::get('justificatif/home', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('Justificatifs.home');
