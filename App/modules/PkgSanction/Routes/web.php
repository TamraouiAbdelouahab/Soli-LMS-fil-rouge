<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Modules\PkgSanction\App\Controllers\DashboardController;

// Route::get('/dashboard', function () {
//     return Inertia::render('PkgSanction::Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');