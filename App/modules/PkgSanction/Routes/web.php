<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Modules\PkgSanction\App\Controllers\DashboardController;

// Route::get('/dashboard', function () {
//     return Inertia::render('PkgSanction::Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('sanction/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('sanction.dashboard');

Route::get('sanction/rules', function () {
    return Inertia::render('PkgSanction::SanctionRules');
})->middleware(['auth', 'verified'])->name('sanction.rules');
