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

class UpdateBusinessDetailsRequest extends FormRequest
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
            'business_image' => 'nullable|image|max:5120|mimes:png,jpg,jpeg,svg,gif',
            'media' => 'nullable|array|min:1',
            'media.*' => 'file|max:20480',
            'business_name' => 'required|min:2|max:255',
            'business_type_id' => 'required|numeric|exists:business_types,id',
            'services' => [
                'required',
                'array',
                'min:1',
                Rule::exists('services', 'id'),
            ],
            'address_line_1' => 'required',
            'address_line_2' => 'nullable',
            'city' => 'required|min:2|max:255',
            'state' => 'required|min:2|max:255',
            'country' => 'required|min:2|max:255',
            'zipcode' => 'required|numeric|digits:6',
            'lattitude' => 'required',
            'longitude' => 'required',
            'about' => 'required',
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $media = $this->file('media');

            if ($media) {
                //$validator->errors()->add('media', 'At least one image or video is required.');
                // return;
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
