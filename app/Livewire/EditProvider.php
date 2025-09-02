<?php

namespace App\Livewire;

use App\Models\Provider;
use Livewire\Component;
use Illuminate\Validation\Rule;

class EditProvider extends Component
{
    // Propiedad para el proveedor que se va a editar
    public Provider $provider;

    // Propiedades para los campos del formulario
    public $name = '';
    public $contact_name = '';
    public $email = '';
    public $address = '';
    public $city = '';
    public $country = '';
    public $notes = '';
    public $is_active = false;

    // Método de inicialización
    public function mount(Provider $provider)
    {
        $this->provider = $provider;
        $this->name = $provider->name;
        $this->contact_name = $provider->contact_name;
        $this->email = $provider->email;
        $this->address = $provider->address;
        $this->city = $provider->city;
        $this->country = $provider->country;
        $this->notes = $provider->notes;
        $this->is_active = $provider->is_active;
    }
    
    // Reglas de validación
    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'min:3', Rule::unique('providers', 'name')->ignore($this->provider->id)],
            'contact_name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', Rule::unique('providers', 'email')->ignore($this->provider->id)],
            'address' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
            'country' => ['nullable', 'string'],
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

    // Método para actualizar el proveedor
    public function update()
    {
        $validatedData = $this->validate();

        $this->provider->update($validatedData);

        // Redireccionar con un mensaje de éxito
        return redirect()->route('providers.index')->with('swal', [
            'icon' => 'success',
            'title' => 'Éxito',
            'text' => 'Proveedor actualizado exitosamente.'
        ]);
    }

    public function render()
    {
        return view('livewire.edit-provider');
    }
}