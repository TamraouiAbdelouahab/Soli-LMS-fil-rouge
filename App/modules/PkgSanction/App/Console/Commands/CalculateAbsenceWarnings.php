<?php

namespace Modules\PkgSanction\App\Console\Commands;

use Illuminate\Console\Command;
use Modules\PkgSanction\App\Services\SanctionCalculeeService;

class CalculateAbsenceWarnings extends Command
{
    protected $signature = 'sanctions:calculate-warnings';
    protected $description = 'Send warning notifications for absences nearing the sanction limit';

    public function handle(SanctionCalculeeService $service)
    {
        $this->info("Starting warning notification check...");
        $service->calculateWarnings();
        $this->info("Warning notifications sent.");
    }
}
