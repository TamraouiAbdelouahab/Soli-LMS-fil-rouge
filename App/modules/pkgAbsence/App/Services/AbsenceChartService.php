<?php

namespace Modules\PkgAbsence\App\Services;

use Carbon\Carbon;
use Modules\PkgAbsence\App\Models\Absence;
use Illuminate\Support\Facades\DB;

class AbsenceChartService
{
    public function getWeeklyMonthlyRecap()
    {
        $weekly = Absence::whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->selectRaw('DATE(date) as day, count(*) as total')
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $monthly = Absence::whereMonth('date', Carbon::now()->month)
            ->selectRaw('WEEK(date) as week, count(*) as total')
            ->groupBy('week')
            ->orderBy('week')
            ->get();

        return [
            'weekly' => $weekly,
            'monthly' => $monthly
        ];
    }
}
