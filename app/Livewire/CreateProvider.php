<?php

namespace App\Livewire;

use App\Models\Provider;
use Livewire\Component;
use Illuminate\Validation\Rule;

class CreateProvider extends Component
{
    // Propiedades para los campos del formulario
    public $name = '';
    public $contact_name = '';
    public $email = '';
    public $address = '';
    public $city = '';
    public $country = '';
    public $notes = '';
    public $is_active = true;

    // Reglas de validación
    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s\']+$/', 'min:3', Rule::unique('providers', 'name')],
            'contact_name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email'],

            'address' => ['nullable', 'string', 'max:500', 'regex:/^[a-zA-Z0-9\s.,-]+$/'],
            'city' => ['nullable', 'string', 'max:100', 'regex:/^[a-zA-Z\s]+$/'],
            'country' => ['nullable', 'string', 'max:100', 'regex:/^[a-zA-Z\s]+$/'],
            
            'notes' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ];
    }
    
    // Atributos para los mensajes de error personalizados
    protected function validationAttributes()
    {
        return [
            'name' => 'nombre',
            'contact_name' => 'persona de contacto',
            'email' => 'correo electrónico',
            'address' => 'dirección',
            'city' => 'ciudad',
            'country' => 'país',
            'notes' => 'notas',
            'is_active' => 'proveedor activo'
        ];
    }

    // Validar el campo cuando se actualiza
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    // Método para guardar el nuevo proveedor
    public function store()
    {
        $validatedData = $this->validate();

        Provider::create($validatedData);
        
        // Redireccionar con un mensaje de éxito
        return redirect()->route('providers.index')->with('swal', [
            'icon' => 'success',
            'title' => 'Éxito',
            'text' => 'Proveedor creado exitosamente.'
        ]);
    }

    public function render()
    {
        return view('livewire.create-provider');
    }
}