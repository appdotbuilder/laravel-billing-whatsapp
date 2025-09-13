<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBillingRateRequest extends FormRequest
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
            'price_per_cubic_meter' => 'required|numeric|min:0',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2020|max:2030',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'price_per_cubic_meter.required' => 'Price per cubic meter is required.',
            'price_per_cubic_meter.numeric' => 'Price must be a valid number.',
            'price_per_cubic_meter.min' => 'Price cannot be negative.',
            'month.required' => 'Month is required.',
            'month.integer' => 'Month must be a valid integer.',
            'month.min' => 'Month must be between 1 and 12.',
            'month.max' => 'Month must be between 1 and 12.',
            'year.required' => 'Year is required.',
            'year.integer' => 'Year must be a valid integer.',
        ];
    }
}