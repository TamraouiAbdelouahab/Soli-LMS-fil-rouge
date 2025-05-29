<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Modules\PkgSanction\App\Controllers\DashboardController;
use Modules\PkgSanction\App\Controllers\SanctionRulesController;

// Route::get('/dashboard', function () {
//     return Inertia::render('PkgSanction::Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('sanction/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('sanction.dashboard');

Route::get('sanction/rules', [SanctionRulesController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('sanction.rules');

Route::post('sanction/rules', [SanctionRulesController::class, 'store'])
    ->middleware(['auth', 'verified'])
    ->name('sanction.rules.store');