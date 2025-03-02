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
            'role_id' => 'required|numeric|in:3'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            fail([], error_parse($validator->errors()), config('code.VALIDATION_ERROR_CODE'))
        );
    }
}
