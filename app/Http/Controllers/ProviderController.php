<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProviderRequest;
use App\Http\Requests\UpdateProviderRequest;

class ProviderController extends Controller
{
    /**
     * Muestra la lista de proveedores con filtros.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status', 'all');

        $providers = Provider::withTrashed()
            ->when($search, function ($query, $search) {
                return $query->search($search);
            })
            ->when($status !== 'all', function ($query) use ($status) {
                if ($status === 'active') {
                    return $query->where('is_active', true);
                } elseif ($status === 'inactive') {
                    return $query->where('is_active', false);
                } elseif ($status === 'deleted') {
                    return $query->onlyTrashed();
                }
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('providers.index', compact('providers', 'search', 'status'));
    }

    /**
     * Muestra el formulario para crear un nuevo proveedor.
     */
    public function create()
    {
        return view('providers.create');
    }

    /**
     * Guarda un nuevo proveedor en la base de datos.
     */
    public function store(StoreProviderRequest $request)
    {
        try {
            Provider::create($request->validated());

            // Alerta de éxito con SweetAlert2
            return redirect()->route('providers.index')
                ->with('swal', [
                    'icon' => 'success',
                    'title' => 'Éxito',
                    'text' => 'Proveedor creado exitosamente.'
                ]);
        } catch (\Exception $e) {
            // Alerta de error con SweetAlert2
            return redirect()->back()
                ->withInput()
                ->with('swal', [
                    'icon' => 'error',
                    'title' => 'Error',
                    'text' => 'Error al crear el proveedor: ' . $e->getMessage()
                ]);
        }
    }

    /**
     * Muestra los detalles de un proveedor.
     */
    public function show(Provider $provider)
    {
        return view('providers.show', compact('provider'));
    }

    /**
     * Muestra el formulario para editar un proveedor.
     */
    public function edit(Provider $provider)
    {
        return view('providers.edit', compact('provider'));
    }

    /**
     * Actualiza un proveedor existente.
     */
    public function update(UpdateProviderRequest $request, Provider $provider)
    {
        try {
            $provider->update($request->validated());

            // Alerta de éxito con SweetAlert2
            return redirect()->route('providers.index')
                ->with('swal', [
                    'icon' => 'success',
                    'title' => 'Éxito',
                    'text' => 'Proveedor actualizado exitosamente.'
                ]);
        } catch (\Exception $e) {
            // Alerta de error con SweetAlert2
            return redirect()->back()
                ->withInput()
                ->with('swal', [
                    'icon' => 'error',
                    'title' => 'Error',
                    'text' => 'Error al actualizar el proveedor: ' . $e->getMessage()
                ]);
        }
    }

    /**
     * Elimina (soft delete) un proveedor.
     */
    public function destroy(Provider $provider)
    {
        try {
            $provider->delete();

            // Alerta de éxito con SweetAlert2
            return redirect()->route('providers.index')
                ->with('swal', [
                    'icon' => 'success',
                    'title' => 'Éxito',
                    'text' => 'Proveedor eliminado exitosamente.'
                ]);
        } catch (\Exception $e) {
            // Alerta de error con SweetAlert2
            return redirect()->back()
                ->with('swal', [
                    'icon' => 'error',
                    'title' => 'Error',
                    'text' => 'Error al eliminar el proveedor: ' . $e->getMessage()
                ]);
        }
    }

    /**
     * Restaura un proveedor eliminado.
     */
    public function restore($id)
    {
        try {
            $provider = Provider::withTrashed()->findOrFail($id);
            $provider->restore();

            // Alerta de éxito con SweetAlert2
            return redirect()->route('providers.index')
                ->with('swal', [
                    'icon' => 'success',
                    'title' => 'Éxito',
                    'text' => 'Proveedor restaurado exitosamente.'
                ]);
        } catch (\Exception $e) {
            // Alerta de error con SweetAlert2
            return redirect()->back()
                ->with('swal', [
                    'icon' => 'error',
                    'title' => 'Error',
                    'text' => 'Error al restaurar el proveedor: ' . $e->getMessage()
                ]);
        }
    }

    /**
     * Elimina permanentemente un proveedor.
     */
    public function forceDelete($id)
    {
        try {
            $provider = Provider::withTrashed()->findOrFail($id);
            $provider->forceDelete();

            // Alerta de éxito con SweetAlert2
            return redirect()->route('providers.index')
                ->with('swal', [
                    'icon' => 'success',
                    'title' => 'Éxito',
                    'text' => 'Proveedor eliminado permanentemente.'
                ]);
        } catch (\Exception $e) {
            // Alerta de error con SweetAlert2
            return redirect()->back()
                ->with('swal', [
                    'icon' => 'error',
                    'title' => 'Error',
                    'text' => 'Error al eliminar permanentemente el proveedor: ' . $e->getMessage()
                ]);
        }
    }

    /**
     * Cambia el estado (activo/inactivo) de un proveedor.
     */
    public function toggleStatus(Provider $provider)
    {
        try {
            $provider->update(['is_active' => !$provider->is_active]);

            $status = $provider->is_active ? 'activado' : 'desactivado';

            // Alerta de éxito con SweetAlert2
            return redirect()->back()
                ->with('swal', [
                    'icon' => 'success',
                    'title' => 'Éxito',
                    'text' => "Proveedor {$status} exitosamente."
                ]);
        } catch (\Exception $e) {
            // Alerta de error con SweetAlert2
            return redirect()->back()
                ->with('swal', [
                    'icon' => 'error',
                    'title' => 'Error',
                    'text' => 'Error al cambiar el estado del proveedor: ' . $e->getMessage()
                ]);
        }
    }
}
