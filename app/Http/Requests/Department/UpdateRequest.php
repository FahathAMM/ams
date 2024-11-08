<?php

namespace App\Http\Requests\Department;

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
        return [
            'department_code' => [
                'required',
                'string',
                'max:10',
                Rule::unique('departments', 'department_code')->ignore($this->route('department')),
            ],
            'department_name' => 'required|string|max:255',

            'description'     => 'nullable|string',
            'branch_id'       => 'required|exists:branches,id',
            'email'           => 'nullable|email|max:255',
            'phone_number'    => 'nullable|string|max:20',
            'established_date' => 'nullable|date',
            'is_active'       => 'required|boolean',
            'notes'           => 'nullable|string',
        ];
    }
}
