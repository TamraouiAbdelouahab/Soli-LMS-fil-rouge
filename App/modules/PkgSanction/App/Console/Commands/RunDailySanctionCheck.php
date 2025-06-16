<?php

namespace Modules\PkgSanction\App\Console\Commands;

use Illuminate\Console\Command;
use Modules\PkgSanction\App\Services\SanctionCalculeeService;

class RunDailySanctionCheck extends Command
{
    protected $signature = 'sanction:daily-check';
    protected $description = 'Run the daily sanction check using SanctionService';


    /**
     * Execute the console command.
     */
    public function handle(SanctionCalculeeService $sanctionService): int
    {
        $sanctionService->calculateSanctions();
        $this->info('Daily sanction check executed successfully.');
        return Command::SUCCESS;
    }
}
