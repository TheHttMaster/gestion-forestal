<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateAdminUser extends Command
{
    protected $signature = 'create:admin';
    protected $description = 'Create the first admin user for the application';

    public function handle()
    {
        $this->info('Creando el primer usuario administrador...');

        $name = $this->ask('Nombre del administrador');
        $email = $this->ask('Correo electrónico del administrador');
        $password = $this->secret('Contraseña del administrador');

        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ], [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            $this->error('Error de validación. Por favor, revisa la información proporcionada.');
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return Command::FAILURE;
        }

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'administrador', // <-- Aquí asignamos el rol
        ]);

        $this->info("¡Usuario administrador '$email' creado con éxito!");
        return Command::SUCCESS;
    }
}
