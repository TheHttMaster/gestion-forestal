<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProviderRequest;
use App\Http\Requests\UpdateProviderRequest;

class ProviderController extends Controller
{
    /**
     * Muestra la lista de productores con filtros.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status', 'all');

        $providers = Provider::query() // ← Cambia aquí: quita withTrashed()
            ->when($search, function ($query, $search) {
                return $query->search($search);
            })
            ->when($status !== 'all', function ($query) use ($status) {
                if ($status === 'active') {
                    return $query->where('is_active', true);
                } elseif ($status === 'inactive') {
                    return $query->where('is_active', false);
                } elseif ($status === 'deleted') {
                    return $query->onlyTrashed(); // ← Solo aquí se ven eliminados
                }
            }, function ($query) use ($status) {
                // Para el caso 'all', incluir todos (activos, inactivos y eliminados)
                return $query->withTrashed();
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('providers.index', compact('providers', 'search', 'status'));
    }

    /**
     * Muestra el formulario para crear un nuevo productor.
     */
    public function create()
    {
        return view('providers.create');
    }

    /**
     * Guarda un nuevo productor en la base de datos.
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
                    'text' => 'productor creado exitosamente.'
                ]);
        } catch (\Exception $e) {
            // Alerta de error con SweetAlert2
            return redirect()->back()
                ->withInput()
                ->with('swal', [
                    'icon' => 'error',
                    'title' => 'Error',
                    'text' => 'Error al crear el productor: ' . $e->getMessage()
                ]);
        }
    }

    /**
     * Muestra los detalles de un productor.
     */
    public function show(Provider $provider)
    {
        return view('providers.show', compact('provider'));
    }

    /**
     * Muestra el formulario para editar un productor.
     */
    public function edit(Provider $provider)
    {
        return view('providers.edit', compact('provider'));
    }

    /**
     * Actualiza un productor existente.
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
                    'text' => 'productor actualizado exitosamente.'
                ]);
        } catch (\Exception $e) {
            // Alerta de error con SweetAlert2
            return redirect()->back()
                ->withInput()
                ->with('swal', [
                    'icon' => 'error',
                    'title' => 'Error',
                    'text' => 'Error al actualizar el productor: ' . $e->getMessage()
                ]);
        }
    }

    /**
     * Elimina (soft delete) un productor.
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
                    'text' => 'productor eliminado exitosamente.'
                ]);
        } catch (\Exception $e) {
            // Alerta de error con SweetAlert2
            return redirect()->back()
                ->with('swal', [
                    'icon' => 'error',
                    'title' => 'Error',
                    'text' => 'Error al eliminar el productor: ' . $e->getMessage()
                ]);
        }
    }

    /**
     * Restaura un productor eliminado.
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
                    'text' => 'productor restaurado exitosamente.'
                ]);
        } catch (\Exception $e) {
            // Alerta de error con SweetAlert2
            return redirect()->back()
                ->with('swal', [
                    'icon' => 'error',
                    'title' => 'Error',
                    'text' => 'Error al restaurar el productor: ' . $e->getMessage()
                ]);
        }
    }

    /**
     * Elimina permanentemente un productor.
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
                    'text' => 'productor eliminado permanentemente.'
                ]);
        } catch (\Exception $e) {
            // Alerta de error con SweetAlert2
            return redirect()->back()
                ->with('swal', [
                    'icon' => 'error',
                    'title' => 'Error',
                    'text' => 'Error al eliminar permanentemente el productor: ' . $e->getMessage()
                ]);
        }
    }

    /**
     * Cambia el estado (activo/inactivo) de un productor.
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
                    'text' => "productor {$status} exitosamente."
                ]);
        } catch (\Exception $e) {
            // Alerta de error con SweetAlert2
            return redirect()->back()
                ->with('swal', [
                    'icon' => 'error',
                    'title' => 'Error',
                    'text' => 'Error al cambiar el estado del productor: ' . $e->getMessage()
                ]);
        }
    }
}
