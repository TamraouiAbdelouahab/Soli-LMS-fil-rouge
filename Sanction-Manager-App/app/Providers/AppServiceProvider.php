<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Modules\Core\App\Providers\CoreServiceProvider;
use Modules\PkgSanction\App\Providers\PkgSanctionServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(CoreServiceProvider::class);
        $this->app->register(PkgSanctionServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
        View::addLocation(base_path('Modules/Core/Resources/Views'));
    }
}
