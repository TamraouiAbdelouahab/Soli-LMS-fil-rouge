<?php

namespace Modules\Core\App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../Database/Migrations');

        // foreach (glob(__DIR__ . '/../../Routes/*.php') as $routeFile) {
        //     $this->loadRoutesFrom($routeFile);
        // }
        $this->registerRoutes();

        $this->loadViewsFrom(__DIR__ . '/../../Resources/Views', 'Core');
    }

    protected function registerRoutes(): void
    {
        Route::middleware('web')
            ->group(function () {
                require __DIR__ . '/../../Routes/auth.php';
                require __DIR__ . '/../../Routes/web.php';
            });
    }
}
