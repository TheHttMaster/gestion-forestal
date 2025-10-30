<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProviderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $providerId = $this->route('provider')->id;

        return [
            'name' => 'required|string|max:255|unique:providers,name,' . $providerId,
            'contact_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:providers,email,' . $providerId,
            'phone' => 'nullable|string|max:20',
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