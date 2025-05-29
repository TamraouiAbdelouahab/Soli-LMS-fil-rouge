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

Route::prefix('sanction-rules')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [SanctionRulesController::class, 'index'])->name('sanction.rules.index');
    Route::post('/', [SanctionRulesController::class, 'store'])->name('sanction.rules.store');
    Route::put('/{id}', [SanctionRulesController::class, 'update'])->name('sanction.rules.update');
    Route::put('/{id}/toggle-status', [SanctionRulesController::class, 'toggleStatus'])->name('sanction.rules.toggleStatus');
    Route::delete('/{id}', [SanctionRulesController::class, 'destroy'])->name('sanction.rules.destroy');
});
