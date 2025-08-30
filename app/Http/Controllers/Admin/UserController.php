<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(15);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request){
        
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
            /* ->log('creó un nuevo usuario') */; // Descripción de la acción

        return redirect()->route('admin.users.index')
            ->with('swal', [
                'icon' => 'success',
                'title' => 'Éxito',
                'text' => 'Usuario creado exitosamente.'
            ]);
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'string', 'in:basico,administrador'],
        ];
    
        // Agregar validación condicional para password
        if ($request->filled('password')) {
            $rules['password'] = ['confirmed', Rules\Password::defaults()];
        }

        $request->validate($rules);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        // Actualizar password solo si se proporciona
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

       /*  activity()
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->log('actualizó el usuario');
 */
        // Usar with() en lugar de session()->flash()
        return redirect()->route('admin.users.index')
            ->with('swal', [
                'icon' => 'success',
                'title' => 'Éxito',
                'text' => 'Usuario actualizado exitosamente.'
            ]);
    }

   public function destroy(Request $request, User $user)
    {
        // No permitimos que un usuario se elimine a sí mismo
        if (auth()->user()->id === $user->id) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No puedes deshabilitar tu propia cuenta.'
                ], 422);
            }
            
            session()->flash('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'No puedes deshabilitar tu propia cuenta.'
            ]);
            return redirect()->route('admin.users.index');
        }

        $user->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Usuario deshabilitado exitosamente.',
                'user_id' => $user->id
            ]);
        }

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Éxito',
            'text' => 'Usuario deshabilitado exitosamente.'
        ]);
        return redirect()->route('admin.users.index');
    }

   public function enableUser(Request $request, $userId)
    {
        // 🔥 USAR withTrashed() para buscar usuarios deshabilitados
        $user = User::withTrashed()->findOrFail($userId);
        
        $user->restore();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Usuario habilitado exitosamente.',
                'user_id' => $user->id
            ]);
        }

        return redirect()->route('admin.users.disabled')
            ->with('swal', [
                'icon' => 'success',
                'title' => 'Éxito',
                'text' => 'Usuario habilitado exitosamente.'
            ]);
    }

    public function updateUserRole(Request $request, $userId)
    {
        $request->validate([
            'role' => ['required', 'string', 'in:basico,administrador'],
        ]);

        // Buscar el usuario incluyendo deshabilitados
        $user = User::withTrashed()->findOrFail($userId);
        
        $user->update(['role' => $request->role]);

        return back()->with('swal', [
            'icon' => 'success',
            'title' => 'Éxito',
            'text' => 'Rol de usuario actualizado exitosamente.'
        ]);
    }

    public function listDisabledUsers()
    {
        $users = User::onlyTrashed()->paginate(15); // Obtiene solo los usuarios deshabilitados
        return view('admin.users.disabled', compact('users'));
    }
}
