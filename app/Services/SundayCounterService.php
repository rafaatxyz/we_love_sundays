<?php

namespace App\Services;

use Illuminate\Support\Carbon;

class SundayCounterService
{
    public function countSundays(Carbon $startDate, Carbon $endDate): int
    {
        $sundaysCount = 0;

        // Optimize by jumping to the next Sunday instead of iterating every day
        $startDate->modify(modify: 'next sunday');

        while ($startDate->lte(date: $endDate)) {
            if ($startDate->day < 28) {
                $sundaysCount++;
            }
            $startDate->addWeek();
        }

        return $sundaysCount;
    }
}
