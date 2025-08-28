<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AreaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $areaId = $this->route('area')?->id;

        return [
            'nombre' => 'required|string|max:150',
            'codigo' => [
                'required',
                'string',
                'max:50',
                Rule::unique('areas')->ignore($areaId)
            ],
            'descripcion' => 'nullable|string|max:500',
            'latitud' => 'nullable|numeric|between:-90,90',
            'longitud' => 'nullable|numeric|between:-180,180',
            'area_padre_id' => 'nullable|exists:areas,id',
            'tipo' => 'required|in:pais,estado,ciudad,municipio,zona,barrio',
            'activo' => 'boolean'
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del área es obligatorio',
            'codigo.required' => 'El código del área es obligatorio',
            'codigo.unique' => 'El código ya existe',
            'tipo.required' => 'El tipo de área es obligatorio',
            'tipo.in' => 'El tipo de área no es válido',
            'latitud.between' => 'La latitud debe estar entre -90 y 90',
            'longitud.between' => 'La longitud debe estar entre -180 y 180',
            'area_padre_id.exists' => 'El área padre seleccionada no existe'
        ];
    }
}