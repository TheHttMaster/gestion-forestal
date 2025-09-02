<?php

namespace App\Http\Controllers;

use App\Models\Polygon;
use App\Services\DeforestationService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

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
            'geometry' => 'required|json',
            'start_year' => 'required|integer|min:2000|max:2023',
            'end_year' => 'required|integer|min:2000|max:2023|gte:start_year'
        ]);
        
        try {
            $geometryData = json_decode($request->geometry, true);
            $results = [];
            
            // Si es una colección de features (múltiples polígonos)
            if (isset($geometryData['type']) && $geometryData['type'] === 'FeatureCollection') {
                foreach ($geometryData['features'] as $index => $feature) {
                    if (!isset($feature['geometry'])) continue;
                    
                    // Extraer propiedades del feature
                    $properties = $feature['properties'] ?? [];
                    $polygonName = $properties['name'] ?? $properties['Productor'] ?? $request->name . ' - Polígono ' . ($index + 1);
                    $polygonDescription = $properties['description'] ?? $request->description;
                    
                    // Crear el polígono individual
                    $polygon = Polygon::create([
                        'name' => $polygonName,
                        'description' => $polygonDescription,
                        'geometry' => DB::raw("ST_GeomFromGeoJSON('" . json_encode($feature['geometry']) . "')")
                    ]);
                    
                    // Ejecutar análisis para este polígono
                    $polygonResults = $this->deforestationService->analyzeDeforestation(
                        $polygon, 
                        $request->start_year, 
                        $request->end_year
                    );
                    
                    $results[] = [
                        'polygon_id' => $polygon->id,
                        'name' => $polygon->name,
                        'area_ha' => $polygon->area_ha,
                        'results' => $polygonResults
                    ];
                }
            } else {
                // Si es un solo polígono (compatibilidad con version anterior)
                $polygon = Polygon::create([
                    'name' => $request->name,
                    'description' => $request->description,
                    'geometry' => DB::raw("ST_GeomFromGeoJSON('{$request->geometry}')")
                ]);
                
                // Ejecutar análisis
                $polygonResults = $this->deforestationService->analyzeDeforestation(
                    $polygon, 
                    $request->start_year, 
                    $request->end_year
                );
                
                $results[] = [
                    'polygon_id' => $polygon->id,
                    'name' => $polygon->name,
                    'area_ha' => $polygon->area_ha,
                    'results' => $polygonResults
                ];
            }
            
            // Si hay múltiples polígonos, redirigir a una página de resumen
            if (count($results) > 1) {
                return response()->json([
                    'success' => true,
                    'multiple' => true,
                    'results' => $results
                ]);
            }
            
            // Si es un solo polígono, redirigir a la página de resultados normal
            return response()->json([
                'success' => true,
                'multiple' => false,
                'polygon_id' => $results[0]['polygon_id'],
                'results' => $results[0]['results']
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar el análisis: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Muestra los resultados del análisis para múltiples polígonos
     */
    public function multipleResults(Request $request): View
    {
        $polygonIds = explode(',', $request->input('polygon_ids', ''));
        $polygons = Polygon::with('analyses')->whereIn('id', $polygonIds)->get();
        
        return view('deforestation.multiple-results', compact('polygons'));
    }
    
    /**
     * Muestra los resultados del análisis para un solo polígono
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
    
    /**
     * Exporta los datos a GeoJSON (placeholder)
     */
    public function export($polygonId)
    {
        // Implementar lógica de exportación
        return response()->json(['message' => 'Export functionality to be implemented']);
    }
    
    /**
     * Genera reporte PDF (placeholder)
     */
    public function report($polygonId)
    {
        // Implementar lógica de reporte PDF
        return response()->json(['message' => 'PDF report functionality to be implemented']);
    }
}