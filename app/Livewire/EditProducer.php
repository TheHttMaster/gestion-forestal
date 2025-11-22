<?php

namespace App\Livewire;

use App\Models\Producer;
use Livewire\Component;
use Illuminate\Validation\Rule;

class EditProducer extends Component
{
    // Propiedad para el productor que se va a editar
    public Producer $producer;

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
    public function mount(Producer $producer)
    {
        $this->producer = $producer;
        $this->name = $producer->name;
        $this->contact_name = $producer->contact_name;
        $this->email = $producer->email;
        $this->address = $producer->address;
        $this->city = $producer->city;
        $this->country = $producer->country;
        $this->notes = $producer->notes;
        $this->is_active = $producer->is_active;
    }
    
    // Reglas de validación
    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'min:3', Rule::unique('producers', 'name')->ignore($this->producer->id)],
            'contact_name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', Rule::unique('producers', 'email')->ignore($this->producer->id)],
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
            'is_active' => 'productor activo'
        ];
    }

    // Validar el campo cuando se actualiza
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    // Método para actualizar el productor
    public function update()
    {
        $validatedData = $this->validate();

        $this->producer->update($validatedData);

        // Redireccionar con un mensaje de éxito
        return redirect()->route('producers.index')->with('swal', [
            'icon' => 'success',
            'title' => 'Éxito',
            'text' => 'productor actualizado exitosamente.'
        ]);
    }

    public function render()
    {
        return view('livewire.edit-producer');
    }
}