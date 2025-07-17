<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:800',
            'strength_required' => 'nullable|integer|min:0',
            'defense_required' => 'nullable|integer|min:0',
            'ki_required' => 'nullable|integer|min:0',
            'reguard' => 'required|integer|min:0',
            'image_uri' => 'nullable|image|max:2048',
        ];
    }
}
