<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:50'],
            'background' => ['nullable', 'string', 'max:255'],
            'image_uri' => ['nullable', 'string', 'max:255'],
            'classrole' => ['required', 'integer', 'exists:classroles,id'],
            'race' => ['required', 'integer', 'exists:races,id'],
            'faction' => ['nullable', 'integer', 'exists:factions,id'],
            'hp' => ['required', 'integer', 'min:0'],
            'strength' => ['required', 'integer', 'min:0'],
            'defense' => ['required', 'integer', 'min:0'],
            'ki' => ['required', 'integer', 'min:0'],
            'level' => ['required', 'integer', 'min:0'],
            'experience' => ['required', 'integer', 'min:0']
        ];
    }
}
