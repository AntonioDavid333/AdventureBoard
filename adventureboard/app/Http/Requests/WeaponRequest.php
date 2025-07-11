<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WeaponRequest extends FormRequest
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
            'name'=> ['required', 'string', 'max:50', Rule::unique(table: 'weapons', column: 'name')->ignore(id: request('weapon'), idColumn: 'id')],
            'description'=> ['string', 'max:200'],
            'image_uri'=> ['nullable', 'image', 'max:2048'],
            'price'=> ['required', 'integer', 'min:0'],
            'damage'=> ['required', 'integer', 'min:0'],
            'defense'=> ['required', 'integer', 'min:0']
        ];
    }
    public function messages():array
    {
        return [
            'name.unique' => __('The weapon already exists.')
        ];

    }

    protected function prepareForValidation()
    {
        $this->merge([
            'damage' => ltrim($this->damage, '0') === '' ? 0 : ltrim($this->damage, '0'),
            'defense' => ltrim($this->defense, '0') === '' ? 0 : ltrim($this->defense, '0'),
            'price' => ltrim($this->price, '0') === '' ? 0 : ltrim($this->price, '0'),
        ]);
    }
    
}
