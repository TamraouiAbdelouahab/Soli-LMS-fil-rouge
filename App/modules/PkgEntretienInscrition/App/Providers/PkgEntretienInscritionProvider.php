<?php

namespace modules\PkgEntretienInscrition\App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class PkgEntretienInscritionProvider extends ServiceProvider
{
    /**
     * Register services.
     */
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

        // Load routes with proper middleware
        $this->registerRoutes();

        $this->loadViewsFrom(__DIR__ . '/../../Resources/Views', 'pkg-entretien-inscrition');
    }

    /**
     * Register the package routes.
     */
    protected function registerRoutes(): void
    {
        Route::group([
            'middleware' => ['web'], // Base web middleware
            'namespace' => null, // Use default namespace
        ], function () {
            foreach (glob(__DIR__ . '/../../Routes/*.php') as $routeFile) {
                // Load each route file within a auth middleware group
                Route::middleware(['auth'])->group(function () use ($routeFile) {
                    require $routeFile;
                });
            }
        });
    }
}
