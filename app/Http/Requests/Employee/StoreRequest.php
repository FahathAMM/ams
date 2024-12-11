<?php

namespace App\Http\Requests\Employee;

use App\Traits\failedValidationWithName;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

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
            'first_name' => 'required',
            'last_name' => 'required',
            'emp_number' => 'required|numeric|unique:employees',
            'designation' => 'required',
            'phone_number' => 'required',
            // 'username' => 'required',
            'username' => 'required|unique:employees',
            'email' => 'required|email|unique:employees',
            'branch_id' => 'nullable',
            'department_id' => 'nullable',
            'gender' => 'nullable',
            'joining_date' => 'required',
            'country' => 'required',
            'description' => "nullable",
            'is_active' => "nullable",
            'report_manager_id' => "nullable",
            'leave_types' => "nullable",
            'password' => [
                'required',
                'string',
                'confirmed',
                'nullable',
                'min:6', // must be at least 10 characters in length
                'max:25', // must be maximum 25 characters in length
                'regex:/[a-z]/', // must contain at least one lowercase letter
                'regex:/[A-Z]/', // must contain at least one uppercase letter
                'regex:/[0-9]/', // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character
            ],
        ];
    }

    // protected function prepareForValidation()
    // {
    //     $this->merge([
    //         'leave_types' => '',
    //     ]);
    // }
}
