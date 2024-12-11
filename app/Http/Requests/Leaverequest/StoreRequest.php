<?php

namespace App\Http\Requests\Leaverequest;

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
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'body' => 'nullable|string|max:1000',
            'applied_employee_id' => 'required',
            'status' => 'nullable|string|max:1000',
            'request_days' => 'nullable|max:1000',
        ];
    }

    public function messages()
    {
        return [
            'employee_id' => 'Report Manage is required',
            'leave_type_id' => 'Leave Type is required',
        ];
    }
}
