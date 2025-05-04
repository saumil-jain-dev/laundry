<?php

namespace App\Http\Requests\Api\Vendor;

use Carbon\Carbon;
use Carbon\Traits\Timestamp;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;
use App\Models\User;

class UpdateTimingRequest extends FormRequest
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
            //
            'store_timings' => ['required', 'array'], // Ensure exactly 7 days exist
            'store_timings.*' => ['array'],
            'store_timings.*.start_time' => ['required_with:store_timings.*.close_time', 'date_format:H:i'],
            'store_timings.*.close_time' => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) {
                    $day = explode('.', $attribute)[1]; // Extract day name (e.g., "sun", "mon")
                    $startTime = $this->input("store_timings.$day.start_time");

                    if ($startTime && strtotime($value) <= strtotime($startTime)) {
                        $fail("The close time for $day must be greater than the start time.");
                    }
                }
            ],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            fail([], error_parse($validator->errors()), config('code.VALIDATION_ERROR_CODE'))
        );
    }
}
