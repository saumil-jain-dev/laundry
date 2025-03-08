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

class RegisterRequest extends FormRequest
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
            'first_name' => 'required|string|min:2|max:50',
            'last_name'  => 'required|string|min:2|max:50',
            'email'      => [
                'required',
                'email',
                Rule::unique('users', 'email')
                    ->where('role_id', $this->input('role_id'))
                    ->whereNull('deleted_at') // Ignore soft-deleted users
            ],
            'phone'      => [
                'required',
                'numeric',
                'digits:10',
                Rule::unique('users', 'phone')
                    ->where('role_id', $this->input('role_id'))
                    ->whereNull('deleted_at') // Ignore soft-deleted users
            ],
            'password'   => ['required', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
            'password_confirmation' => 'required|same:password',
            'role_id' => 'required|numeric|in:3',
            'media' => 'required|array|min:1',
            'media.*' => 'file|max:20480',
            'business_name' => 'required|min:2|max:255',
            'business_type_id' => 'required|numeric|exists:business_types,id',
            'address_line_1' => 'required',
            'address_line_2' => 'nullable',
            'city' => 'required|min:2|max:255',
            'state' => 'required|min:2|max:255',
            'country' => 'required|min:2|max:255',
            'zipcode' => 'required|numeric|digits:6',
            'lattitude' => 'required',
            'longitude' => 'required',
            'about' => 'required',
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
            'pricing' => ['nullable', 'array'],
            'pricing.*' => ['array'],
            'pricing.*.*' => ['array'],
            'pricing.*.*.*' => ['required', 'numeric'],

        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $media = $this->file('media');

            if (!$media) {
                $validator->errors()->add('media', 'At least one image or video is required.');
                return;
            }

            $hasValidMedia = false;

            foreach ($media as $file) {
                $mime = $file->getMimeType();
                $extension = strtolower($file->getClientOriginalExtension());
                $size = $file->getSize();

                // ✅ Image Validation
                if (str_starts_with($mime, 'image/')) {
                    if (!in_array($extension, ['jpg', 'jpeg', 'png', 'svg', 'gif'])) {
                        $validator->errors()->add('media', 'Only JPG, JPEG, PNG, SVG, and GIF images are allowed.');
                    }
                    if ($size > 5 * 1024 * 1024) { // 5MB
                        $validator->errors()->add('media', 'Each image must be less than or equal to 5MB.');
                    }
                    $hasValidMedia = true;
                }

                // ✅ Video Validation
                elseif (str_starts_with($mime, 'video/')) {
                    if (!in_array($extension, ['mp4', 'avi', 'mpeg', 'mov'])) {
                        $validator->errors()->add('media', 'Only MP4, AVI, MPEG, and MOV videos are allowed.');
                    }
                    if ($size > 20 * 1024 * 1024) { // 20MB
                        $validator->errors()->add('media', 'Each video must be less than or equal to 20MB.');
                    }
                    $hasValidMedia = true;
                }

                // ❌ Invalid File Type
                else {
                    $validator->errors()->add('media', 'Only image and video files are allowed.');
                }
            }

            // ✅ Ensure at least one valid media file is uploaded
            if (!$hasValidMedia) {
                $validator->errors()->add('media', 'At least one valid image or video is required.');
            }
        });
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            fail([], error_parse($validator->errors()), config('code.VALIDATION_ERROR_CODE'))
        );
    }
}
