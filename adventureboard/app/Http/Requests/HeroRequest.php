<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HeroRequest extends FormRequest
{
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
            'name' => 'required|string|max:255',
            'background' => 'nullable|string|max:1000',
            'image_uri' => 'nullable|file|image|max:2048',
            'race_id' => 'required|exists:races,id',
            'classrole_id' => 'required|exists:classroles,id',
            'faction_id' => 'nullable|exists:factions,id',
            'hp' => 'required|integer|min:1|max:1000',
            'defense' => 'required|integer|min:0|max:1000',
            'ki' => 'required|integer|min:0|max:1000',
            'strength' => 'required|integer|min:0|max:1000',
        ];
    }
}
