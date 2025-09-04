<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Http\Requests\AreaRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AreaController extends Controller
{
    public function index(): View
    {
        $areas = Area::with('padre')
            ->orderBy('tipo')
            ->orderBy('nombre')
            ->paginate(20);

        $tipos = ['pais', 'estado', 'ciudad', 'municipio', 'zona', 'barrio'];
        
        return view('areas.index', compact('areas', 'tipos'));
    }

    public function create(): View
    {
        $areasPadre = Area::where('activo', true)
            ->orderBy('nombre')
            ->get();
            
        $tipos = ['pais', 'estado', 'ciudad', 'municipio', 'zona', 'barrio'];
        
        return view('areas.create', compact('areasPadre', 'tipos'));
    }

    public function store(Request $request)
    {
        // 1. Validar los datos de entrada, asegurándose de que las coordenadas son requeridas y numéricas.
        $validator = Validator::make($request->all(), [
            'nombre'    => 'required|string|max:150',
            'codigo'    => 'required|string|max:50|unique:areas,codigo',
            'latitud'   => 'nullable|numeric|between:-90,90',
            'longitud'  => 'nullable|numeric|between:-180,180',
            'tipo'      => 'required|in:pais,estado,ciudad,municipio,zona,barrio',
            'area_padre_id' => 'nullable|exists:areas,id',
            'descripcion' => 'nullable|string',
        ]);
        
        // Si la validación falla, redirecciona de vuelta con los errores.
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // 2. Crear una nueva instancia del modelo Area con los datos validados.
            $area = Area::create($validator->validated());

            // 3. Registrar la actividad de creación del área.
            activity()
                ->causedBy(auth()->user())
                ->performedOn($area)
                ->log('Área creada');

            // 4. Redireccionar con un mensaje de éxito en formato Swal.
            return redirect()->route('areas.index')
                ->with('swal', [
                    'icon' => 'success',
                    'title' => 'Éxito',
                    'text' => 'Área geográfica creada con éxito.'
                ]);
        } catch (\Exception $e) {
            // Manejar errores si la creación falla.
            return redirect()->back()
                ->with('swal', [
                    'icon' => 'error',
                    'title' => 'Error',
                    'text' => 'Error al crear el área: ' . $e->getMessage()
                ])
                ->withInput();
        }
    }

    public function show(Area $area): View
    {
        $area->load(['padre', 'hijos' => function ($query) {
            $query->orderBy('nombre');
        }]);
        
        return view('areas.show', compact('area'));
    }

    public function edit(Area $area): View
    {
        $areasPadre = Area::where('activo', true)
            ->where('id', '!=', $area->id)
            ->orderBy('nombre')
            ->get();
            
        $tipos = ['pais', 'estado', 'ciudad', 'municipio', 'zona', 'barrio'];
        
        return view('areas.edit', compact('area', 'areasPadre', 'tipos'));
    }

    public function update(AreaRequest $request, Area $area): RedirectResponse
    {
        try {
            $area->update($request->validated());
            
            return redirect()->route('areas.index')
                ->with('success', 'Área actualizada exitosamente');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al actualizar el área: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Area $area): JsonResponse
    {
        try {
            if ($area->tieneHijos()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar el área porque tiene áreas hijas'
                ]);
            }

            $area->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Área eliminada exitosamente'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el área: ' . $e->getMessage()
            ], 500);
        }
    }

    public function toggleStatus(Area $area): JsonResponse
    {
        try {
            $area->update(['activo' => !$area->activo]);
            
            return response()->json([
                'success' => true,
                'message' => 'Estado actualizado exitosamente',
                'nuevo_estado' => $area->activo
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar el estado: ' . $e->getMessage()
            ], 500);
        }
    }

    public function search(string $search): JsonResponse
    {
        $areas = Area::buscar($search)
            ->activas()
            ->limit(10)
            ->get(['id', 'nombre', 'codigo', 'tipo']);
            
        return response()->json($areas);
    }
}