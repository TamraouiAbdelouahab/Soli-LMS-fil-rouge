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
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../Database/Migrations');

        // Load routes with proper middleware
        // $this->registerRoutes();

        $this->loadViewsFrom(__DIR__ . '/../../Resources/Views', 'pkg-absence');
    }
}
