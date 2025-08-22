<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Spatie\Activitylog\Models\Activity;

class DashboardController extends Controller{
    
    public function index()
    {
        $userCount = User::count();
        $activityCount = Activity::count();
        $activities = Activity::latest()->get();

        return view('dashboard', compact('userCount', 'activityCount', 'activities'));
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

    public function showAuditLog(){

        $activities = Activity::latest()->get(); // Obtiene todos los registros de actividad, ordenados por los más recientes.
        return view('admin.audit_log', compact('activities'));
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'string', 'in:basico,administrador'],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('status', 'Usuario actualizado exitosamente.');
    }

    public function destroyUser(User $user)
    {
        // No permitimos que un usuario se elimine a sí mismo
        if (auth()->user()->id === $user->id) {
            session()->flash('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'No puedes deshabilitar tu propia cuenta.'
            ]);
            return redirect()->route('admin.users.index');
        }

        $user->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Éxito',
            'text' => 'Usuario deshabilitado exitosamente.'
        ]);
        return redirect()->route('admin.users.index');
    }

    public function enableUser(User $user)
    {
        $user->restore();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Éxito',
            'text' => 'Usuario habilitado exitosamente.'
        ]);
        return redirect()->route('admin.users.disabled');
    }

    public function updateUserRole(Request $request, User $user)
    {
        $request->validate([
            'role' => ['required', 'string', 'in:basico,administrador'],
        ]);

        $user->update(['role' => $request->role]);

        return back()->with('status', 'Rol de usuario actualizado exitosamente.');
    }

    public function listDisabledUsers()
    {
        $users = User::onlyTrashed()->paginate(15); // Obtiene solo los usuarios deshabilitados
        return view('admin.users.disabled', compact('users'));
    }


}
