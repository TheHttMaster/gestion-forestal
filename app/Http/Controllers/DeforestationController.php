// app/Http/Controllers/DeforestationController.php
<?php

namespace App\Http\Controllers;

use App\Models\Polygon;
use App\Services\DeforestationService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class DeforestationController extends Controller
{
    protected $deforestationService;
    
    public function __construct(DeforestationService $deforestationService)
    {
        $this->deforestationService = $deforestationService;
    }
    
    /**
     * Muestra el formulario para crear nuevo análisis
     */
    public function create(): View
    {
        return view('deforestation.create');
    }
    
    /**
     * Procesa el análisis de deforestación
     */
    public function analyze(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'geometry' => 'required|json', // GeoJSON del polígono
            'start_year' => 'required|integer|min:2000|max:2023',
            'end_year' => 'required|integer|min:2000|max:2023|gte:start_year'
        ]);
        
        try {
            // Crear el polígono
            $polygon = Polygon::create([
                'name' => $request->name,
                'description' => $request->description,
                'geometry' => DB::raw("ST_GeomFromGeoJSON('{$request->geometry}')")
            ]);
            
            // Ejecutar análisis
            $results = $this->deforestationService->analyzeDeforestation(
                $polygon, 
                $request->start_year, 
                $request->end_year
            );
            
            return response()->json([
                'success' => true,
                'polygon_id' => $polygon->id,
                'results' => $results
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar el análisis: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Muestra los resultados del análisis
     */
    public function results($polygonId): View
    {
        $polygon = Polygon::with('analyses')->findOrFail($polygonId);
        $analyses = $polygon->analyses->sortBy('year');
        
        return view('deforestation.results', compact('polygon', 'analyses'));
    }
    
    /**
     * Obtiene el historial de análisis en formato JSON para gráficos
     */
    public function getAnalysisData($polygonId): JsonResponse
    {
        $polygon = Polygon::findOrFail($polygonId);
        $history = $this->deforestationService->getAnalysisHistory($polygon);
        
        return response()->json($history);
    }
}