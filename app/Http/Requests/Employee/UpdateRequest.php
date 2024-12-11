<?php

namespace App\Http\Requests\Employee;

use Illuminate\Validation\Rule;
use App\Traits\failedValidationWithName;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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

        $userId = $this->route('employee')->id;
        //     'email' => ['required', 'string', Rule::unique('users')->ignore($userId)],


        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'emp_number' => ['required', 'string', Rule::unique('employees')->ignore($userId)],
            'designation' => 'required',
            'phone_number' => 'required',
            'username' => ['required', 'string', Rule::unique('employees')->ignore($userId)],
            'email' => ['required', 'string', Rule::unique('employees')->ignore($userId)],
            'branch_id' => 'nullable',
            'department_id' => 'nullable',
            'gender' => 'nullable',
            'joining_date' => 'required',
            'country' => 'required',
            'description' => "nullable",
            'leave_types' => "nullable",
            'is_active' => "nullable",
            'report_manager_id' => "nullable",
            'password' => [
                'nullable',
                'string',
                'confirmed',
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
