<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class SundayController extends Controller
{
    public function countSundays(Request $request) {

        $validator = Validator::make($request->all(), [
            'start_date' => ['required','date'],
            'end_date' => [
                'required',
                'date',
                'after_or_equal:start_date',
                function ($attribute, $value, $fail) use ($request) {
                    $startDate = Carbon::parse($request->start_date);
                    $endDate = Carbon::parse($value);
        
                    if ($startDate->format('w')==0) {
                        $fail('The start date cannot be a Sunday.');
                    }
                    if ($startDate->diffInYears($endDate) < 2) {
                        $fail('Two dates must be at least 2 years apart.');
                    }
                    else if ($startDate->diffInYears($endDate) > 5) {
                        $fail('Two dates can be maxium of 5 years apart.');
                    }
                }
            ],
        ], [
            'start_date.required' => 'The start date is required.',
            'start_date.date' => 'The start date must be a valid date.',
            'end_date.required' => 'The end date is required.',
            'end_date.date' => 'The end date must be a valid date.',
            'end_date.after_or_equal' => 'The start date cannot be larger than the end date.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        
        }

        $startDate = Carbon::parse($request->input('start_date'));
        $endDate = Carbon::parse($request->input('end_date'));

        $sundaysCount = 0;

        while ($startDate <= $endDate) {
            if ($startDate->format('w') == 0) {
                $sundaysCount++;
            }
            $startDate->modify('+1 day');
        }

        return response()->json(['sundays_count' => $sundaysCount]);
    }
}
