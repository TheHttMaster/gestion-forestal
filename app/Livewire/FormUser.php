<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class FormUser extends Component
{
    #[Validate('required|min:3', onUpdate: true)]
    public $name = '';

    #[Validate('required|email|unique:users,email', onUpdate: true)]
    public $email = '';

    #[Validate('required|min:8', onUpdate: true)]
    public $password = '';

    #[Validate('required|min:8', onUpdate: true)]
    public $password_confirmation = '';

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    // Este es el método que se ejecutará al enviar el formulario 
    public function store()
    {
        
        // Guardar el usuario en la base de datos
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => 'basico',
        ]);

        activity()
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->log('creó un nuevo usuario');

         // Limpia los campos del formulario
        $this->reset([
            'name', 
            'email', 
            'password', 
            'password_confirmation'
        ]);
        
        // 3. Redireccionar con un mensaje de éxito a la vista de usuarios
        return redirect()->route('admin.users.index')
            ->with('swal', [
                'icon' => 'success',
                'title' => 'Éxito',
                'text' => 'Usuario creado exitosamente.'
            ]);
    }

    public function render()
    {
        return view('livewire.form-user');
    }
}