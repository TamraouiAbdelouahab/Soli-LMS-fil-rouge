<?php

namespace Modules\PkgSanction\App\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Modules\PkgSanction\App\Console\Commands\RunDailySanctionCheck;

class PkgSanctionServiceProvider extends ServiceProvider
{

    protected $commands = [RunDailySanctionCheck::class];
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->commands($this->commands);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../Database/Migrations');

        // Load routes with proper middleware
        // $this->registerRoutes();

        $this->loadViewsFrom(__DIR__ . '/../../Resources/Views', 'pkg-sanction');

        $this->app->booted(function () {
            $schedule = app(Schedule::class);
            $schedule->command(RunDailySanctionCheck::class)->everyFiveMinutes();
        });
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
