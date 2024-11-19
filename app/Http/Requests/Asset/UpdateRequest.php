<?php

namespace App\Http\Requests\Asset;

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
            'name' => 'required',
            'serial_number' => 'required',
            'category_id' => 'required',
            'img' => 'image|nullable',
            'tags' => 'array',
            'issue_date' => 'nullable|date',
            'return_date' => 'nullable',
            'is_active' => 'nullable',
            'condition' => 'required',
            'warranty_nfo' => 'nullable',
            'description' => 'nullable',
            'employee_id' => "nullable",
        ];
    }
}
