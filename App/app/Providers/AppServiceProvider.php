<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Modules\Core\App\Providers\CoreServiceProvider;
use Modules\PkgJustificatif\App\Providers\JustificatifServiceProvider;
use Modules\PkgSanction\App\Providers\PkgSanctionServiceProvider;
use Modules\PkgApprenant\App\Providers\PkgApprenantServiceProvider;
use Modules\PkgEntretienInscrition\App\Providers\PkgEntretienInscritionProvider;
use Modules\PkgAbsence\App\Providers\PkgAbsenceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    $this->app->register(CoreServiceProvider::class);
    $this->app->register(PkgApprenantServiceProvider::class);
    $this->app->register(JustificatifServiceProvider::class);
    $this->app->register(PkgSanctionServiceProvider::class);
    $this->app->register(PkgEntretienInscritionProvider::class);
    $this->app->register(PkgAbsenceProvider::class);

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
