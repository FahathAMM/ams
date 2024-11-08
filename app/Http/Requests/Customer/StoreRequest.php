<?php

namespace App\Http\Requests\Customer;

use App\Traits\failedValidationWithName;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    use failedValidationWithName;

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
            'customer_code' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'nullable|string',
            'company_name' => 'required|string',
            'email' => 'required|string|email|unique:customers,email',
            'phone_number' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'nullable|string',
            'postal_code' => 'nullable|string',
            'country' => 'required|string',
            'website' => 'nullable|string',
            'business_type' => 'nullable|string',
            'industry' => 'nullable|string',
            'contact_person_name' => 'nullable|string',
            'contact_email' => 'nullable|string|email',
            'contact_phone' => 'nullable|string',
            'customer_since' => 'required|date',
            'is_active' => 'nullable',
            'description' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'An email address is required.',
            'email.unique' => 'This email is already registered.',
        ];
    }
}
