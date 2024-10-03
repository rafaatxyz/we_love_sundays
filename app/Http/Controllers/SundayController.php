<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use App\Http\Requests\CountSundaysRequest;
use App\Services\SundayCounterService;

class SundayController extends Controller
{

    protected $sundayCounter;

    public function __construct(SundayCounterService $sundayCounter)
    {
        $this->sundayCounter = $sundayCounter;
    }

    public function countSundays(CountSundaysRequest $request)
    {

        $startDate = Carbon::parse(time: $request->input(key: 'start_date'));
        $endDate = Carbon::parse(time: $request->input(key: 'end_date'));

        $sundaysCount = $this->sundayCounter->countSundays(startDate: $startDate, endDate: $endDate);

        return response()->json(data: ['sundays_count' => $sundaysCount]);
    }
}
