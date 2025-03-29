<?php

namespace App\Http\Requests\Api\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class OrderRequest extends FormRequest
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
            'user_id' => 'required|numeric|exists:users,id',
            'business_id' => 'required|numeric|exists:business_details,id',
            'total_amount' => 'required|numeric',
            // Discount-related fields
            'gross_amount' => 'nullable|numeric',
            'discount_amount' => 'nullable|numeric',
            'discount_id' => 'nullable|numeric',
            'coupon_code' => 'nullable|string',
            'pickup_date_time' => 'required|date_format:Y-m-d H:i:s',
            'drop_date_time' => 'required|date_format:Y-m-d H:i:s',
            'address' => 'required',
            'items' => 'required|array|min:1', // Must be an array and have at least 1 item
            'items.*.service_id' => 'required|numeric|exists:services,id',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.price_per_unit' => 'required|numeric|min:0',
            'items.*.total_price' => 'required|numeric|min:0',
             // Payment method validation
            'payment_method' => 'required|in:cod,online',
            'transaction_status' => 'required|in:pending,success,failed',

            // Transaction details (conditionally required)
            'transaction_id' => 'nullable',
            'transaction_response' => 'nullable',
        ];
    }

    /**
 * Define conditional validation logic.
 */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $data = $this->all();

            // If discount_id is present, then gross_amount, discount_amount, and coupon_code are required
            if (!empty($data['discount_id'])) {
                if (empty($data['gross_amount'])) {
                    $validator->errors()->add('gross_amount', 'The gross amount is required when discount is applied.');
                }
                if (empty($data['discount_amount'])) {
                    $validator->errors()->add('discount_amount', 'The discount amount is required when discount is applied.');
                }
                if (empty($data['coupon_code'])) {
                    $validator->errors()->add('coupon_code', 'The coupon code is required when discount is applied.');
                }
            }

            // If payment_method is "online", transaction_id and transaction_response are required
            if (!empty($data['payment_method']) && $data['payment_method'] === 'online') {
                if (empty($data['transaction_id'])) {
                    $validator->errors()->add('transaction_id', 'The transaction ID is required for online payment.');
                }
                if (empty($data['transaction_response'])) {
                    $validator->errors()->add('transaction_response', 'The transaction response is required for online payment.');
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
