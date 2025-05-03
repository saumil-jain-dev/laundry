<?php

namespace App\Http\Requests\Api\Vendor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
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
        $user = Auth::user();
        return [
            'first_name' => 'required|string|min:2|max:50',
            'last_name'  => 'required|string|min:2|max:50',
            'email'      => [
                'required',
                'email',
                Rule::unique('users','email')->where(function ($query) use ($user){
                    $query->where('role_id', $user->role_id) ->where('id', '!=', $user->id) ->whereNull('deleted_at'); // Ignore soft-deleted users
                }),
            ],
            'phone'      => [
                'required',
                'numeric',
                'digits:10',
                Rule::unique('users','phone')->where(function ($query) use ($user){
                    $query->where('role_id', $user->role_id) ->where('id', '!=', $user->id) ->whereNull('deleted_at'); // Ignore soft-deleted users
                }),
            ],
            'profile_picture' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,svg,gif',
                'max:5120'
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
