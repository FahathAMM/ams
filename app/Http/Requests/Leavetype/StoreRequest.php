<?php

namespace App\Http\Requests\Leavetype;

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
            // 'user_id' => 'required|exists:users,id',
            // 'leave_type_id' => 'required|exists:leave_types,id',
            // 'start_date' => 'required|date|after_or_equal:today',
            // 'end_date' => 'required|date|after_or_equal:start_date',
            // 'reason' => 'nullable|string|max:1000',

            'name' => 'required|string|max:255',
            'number_of_days' => 'required|integer',
            'description' => 'nullable|string|max:1000',
        ];
    }
}
