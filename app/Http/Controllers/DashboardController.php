<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Spatie\Activitylog\Models\Activity;

class DashboardController extends Controller{
    
    public function index(){
        $totalUsers = User::count();
        // Por ahora, el total de acciones es 0. Lo implementaremos más adelante.
        $totalActions = 0;

        return view('dashboard', compact('totalUsers', 'totalActions'));
    }

    public function listUsers(){
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

public function createUser(){
        return view('admin.users.create');
    }

    public function storeUser(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'basico', // Por defecto, creamos usuarios con el rol 'basico'
        ]);

        activity()
            ->causedBy(auth()->user()) // Quién causó la acción (el administrador)
            ->performedOn($user) // Sobre qué modelo se realizó la acción
            ->log('creó un nuevo usuario'); // Descripción de la acción

        return redirect()->route('admin.users.index')->with('status', 'Usuario creado exitosamente.');
    }
}
