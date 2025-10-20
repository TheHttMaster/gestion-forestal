<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create()
        User::create([
            'name' => 'Admin2',
            'email' => 'admin2@gmail.com',
            'password' => Hash::make('12345678'), // Hash con mayúscula
            'role' => 'administrador',
        ]);

         User::create([
            'name' => 'htt',
            'email' => 'diperishilla2468@gmail.com',
            'password' => Hash::make('12345679'), // Hash con mayúscula
            'role' => 'administrador',
        ]);
    }
}
