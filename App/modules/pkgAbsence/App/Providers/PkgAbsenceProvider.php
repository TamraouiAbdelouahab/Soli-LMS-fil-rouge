<?php

namespace Modules\PkgAbsence\App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class PkgAbsenceProvider extends ServiceProvider
{
    /**
     * Register services.
     **/
    public function register(): void
    {
        // Register any bindings or services
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../Database/Migrations');
        $this->loadViewsFrom(__DIR__ . '/../../Resources/Views', 'pkg_absence');
    }
}
