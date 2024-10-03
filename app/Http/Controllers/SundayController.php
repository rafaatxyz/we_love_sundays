<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use App\Http\Requests\CountSundaysRequest;

class SundayController extends Controller
{
    public function countSundays(CountSundaysRequest $request) {

        $startDate = Carbon::parse(time: $request->input(key: 'start_date'));
        $endDate = Carbon::parse(time: $request->input(key: 'end_date'));

        $sundaysCount = 0;

        while ($startDate <= $endDate) {
            if ($startDate->format(format: 'w') == 0 && $startDate->day < 28) {
                $sundaysCount++;
            }
            $startDate->modify(modify: '+1 day');
        }

        return response()->json(data: ['sundays_count' => $sundaysCount]);
    }
}
