<?php

namespace App\Http\Requests;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;


class CountSundaysRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'start_date' => [
                'required',
                'date',
                function ($attribute, $value, $fail): void {
                    $date = Carbon::parse(time: $value);
                    if ($date->isSunday()) {
                        $fail('The start date cannot be a Sunday.');
                    }
                }
            ],
            'end_date' => [
                'required',
                'date',
                'after_or_equal:start_date',
                function ($attribute, $value, $fail): void {
                    $startDate = Carbon::parse(time: $this->start_date);
                    $endDate = Carbon::parse(time: $value);

                    $yearsDifference = $startDate->diffInYears(date: $endDate);

                    if ($yearsDifference < 2) {
                        $fail('Two dates must be at least 2 years apart.');
                    } elseif ($yearsDifference > 5) {
                        $fail('Two dates can be a maximum of 5 years apart.');
                    }
                }
            ],
        ];

    }

    public function failedValidation(Validator $validator): never
    {

        throw new HttpResponseException(response: response()->json(data: [
            'success' => false,
            'message' => 'Validation errors',
            'data' => $validator->errors()
        ],status:422));

    }



    public function messages()
    {

        return [
            'start_date.required' => 'The start date is required.',
            'start_date.date' => 'The start date must be a valid date.',
            'end_date.required' => 'The end date is required.',
            'end_date.date' => 'The end date must be a valid date.',
            'end_date.after_or_equal' => 'The start date cannot be larger than the end date.'
        ];

    }

}
