<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; // <-- Asegúrate de tener esta importación

class UserController extends Controller
{
    /**
     * Display a listing of the resource, priorizando el usuario actual.
     */
    public function index()
    {
        // 1. Obtener el ID del usuario autenticado
        $currentUserId = Auth::id();
        
        // 2. Obtener los demás usuarios (excluyendo el actual) y paginarlos
        $otherUsersPaginator = User::where('id', '!=', $currentUserId)
                                   ->paginate(15);

        // 3. Obtener el objeto del usuario actual
        $currentUser = User::find($currentUserId);
        
        // 4. Insertar el usuario actual al comienzo de la colección de la página actual
        // Solo lo hacemos si estamos en la primera página para evitar duplicados en otras páginas.
        if ($otherUsersPaginator->currentPage() === 1 && $currentUser) {
            $otherUsersPaginator->getCollection()->prepend($currentUser);
        }

        // 5. La variable $users ahora contiene el paginador con el usuario actual primero (en la pág. 1)
        $users = $otherUsersPaginator;

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
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
    
        /* // Agregar validación condicional para password
        if ($request->filled('password')) {
            $rules['password'] = ['confirmed', Rules\Password::defaults()];
        }
 */
        $request->validate($rules);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        /* // Actualizar password solo si se proporciona
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } */

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
        // USAR withTrashed() para buscar usuarios deshabilitados
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
