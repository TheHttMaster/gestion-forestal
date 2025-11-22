<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProducerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $producerId = $this->route('producer')->id ?? $this->route('producer');

        return [
            'name' => 'required|string|max:255|unique:producers,name,' . $producerId,
            'contact_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:producers,email,' . $producerId,
            
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
            'is_active' => 'boolean'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre del productor es obligatorio.',
            'name.unique' => 'Ya existe un productor con este nombre.',
            'email.email' => 'El email debe ser una dirección válida.',
            'email.unique' => 'Ya existe un productor con este email.',
        ];
    }
}


