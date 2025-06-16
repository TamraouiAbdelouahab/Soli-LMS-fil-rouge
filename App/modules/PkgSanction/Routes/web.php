<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Modules\PkgSanction\App\Controllers\DashboardController;
use Modules\PkgSanction\App\Controllers\SanctionController;
use Modules\PkgSanction\App\Controllers\SanctionRulesController;

// Route::get('/dashboard', function () {
//     return Inertia::render('PkgSanction::Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('sanction/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'role:responsable des apprenants|responsable de formation'])
    ->name('sanction.dashboard');

Route::prefix('sanction/rules')->middleware(['auth', 'verified', 'role:responsable des apprenants|responsable de formation'])->group(function () {
    Route::get('/', [SanctionRulesController::class, 'index'])->name('sanction.rules.index');
    Route::post('/', [SanctionRulesController::class, 'store'])->name('sanction.rules.store');
    Route::put('/{id}', [SanctionRulesController::class, 'update'])->name('sanction.rules.update');
    Route::put('/{id}/toggle-status', [SanctionRulesController::class, 'toggleStatus'])->name('sanction.rules.toggleStatus');
    Route::delete('/{id}', [SanctionRulesController::class, 'destroy'])->name('sanction.rules.destroy');
});

Route::prefix('sanction/tracking')->middleware(['auth', 'verified', 'role:responsable des apprenants|responsable de formation'])->group(function () {
    Route::get('/', [SanctionController::class, 'index'])->name('sanction.tracking.index');
    Route::post('/calculate', [SanctionController::class, 'calculateSanctions'])->name('sanction.tracking.calculate');
    Route::post('/apply/{id}', [SanctionController::class, 'applicationSanction'])->name('sanction.tracking.apply');
    Route::delete('/{id}', [SanctionController::class, 'destroy'])->name('sanction.tracking.destroy');
});

Route::prefix('learner')->middleware(['auth', 'verified', 'role:apprenant'])->group(function () {
    Route::get('/sanctions', [SanctionController::class, 'learnerIndex'])->name('learner.sanction.index');
});

Route::post('/notifications/{id}/mark-as-read', function ($id) {
    $notification = auth()->user()->notifications()->findOrFail($id);
    $notification->markAsRead();
    return response()->noContent();
})->middleware(['auth'])->name('notifications.markAsRead');

// Route::get('sanction/tracking', function () {
//     return Inertia::render('PkgSanction::SanctionTracking');
// })->middleware(['auth', 'verified'])->name('sanction.tracking.index');