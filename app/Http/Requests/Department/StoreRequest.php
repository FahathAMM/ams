<?php

namespace App\Http\Requests\Department;

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
            'department_name' => 'required|string|max:255',
            'department_code' => 'required|string|max:10|unique:departments,department_code',

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
