<?php

namespace App\Http\Requests\Room;

use Illuminate\Validation\Rule;
use App\Traits\failedValidationWithName;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

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
            'apartment_id' => 'required|exists:apartments,id',
            'room_number' => 'required|string|max:255|unique:rooms,room_number',
            'room_number' => 'required|string|max:255|unique:rooms,room_number',
            'floor' => 'required|integer',
            'type' => 'required|string|max:255',
            'is_occupied' => 'nullable|boolean',
            'description' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'apartment_id.required' => 'The apartment ID is required.',
            'apartment_id.exists' => 'The selected apartment does not exist.',
            'room_number.required' => 'The room number is required.',
            'room_number.unique' => 'The room number must be unique.',
            'floor.required' => 'The floor number is required.',
            'type.required' => 'The type of the room is required.',
        ];
    }
}
