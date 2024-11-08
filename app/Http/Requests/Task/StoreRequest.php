<?php

namespace App\Http\Requests\Task;

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

            'repoting_manager_id' => 'required|integer',
            'subject' => 'required',
            'task_id' => 'nullable|array',
            'task_id.*' => 'required|string',  // If the task_id[] is an array of integers
            'customer_id' => 'nullable|array',
            'customer_id.*' => 'required',  // If the customer_id[] is an array of integers
            'task_description' => 'nullable|array',
            'task_status' => 'nullable|array',
            'task_duration' => 'nullable|array',
            'description' => 'nullable|string',
        ];
    }
}
