<?php

namespace App\Http\Controllers;

use App\Models\Polygon;
use App\Services\DeforestationService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Services\GFWService;
use Illuminate\Support\Facades\Log;


class DeforestationController extends Controller
{
    protected $deforestationService;
    protected $gfwService;
    
    public function __construct(DeforestationService $deforestationService, GFWService $gfwService)
    {
        $this->deforestationService = $deforestationService;
        $this->gfwService = $gfwService;
        
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
    /**
 * Procesa el análisis de deforestación
 */
public function analyze(Request $request)
{
    // 1. Obtener los datos del Request y asignarlos a variables
    $year = $request->input('end_year'); 
    $geometryString = $request->input('geometry');
    $areaHa = $request->input('area_ha'); // NUEVO: Área en hectáreas

    // 2. Decodificación y Estructuración del GeoJSON
    try {
        $geometryGeoJson = json_decode($geometryString, true); 
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            return back()->withErrors(['geometry' => 'Formato GeoJSON inválido']);
        }

    } catch (\Exception $e) {
        return back()->withErrors(['error' => 'Error procesando la geometría: ' . $e->getMessage()]);
    }

    $stats = $this->gfwService->getZonalStats($geometryGeoJson, $year);

    // Creamos un array que contiene todas las variables que queremos mostrar en la vista
    $dataToPass = [
        'analysis_year' => $year,
        'original_geojson' => $geometryString,
        'type' => $geometryGeoJson['type'],
        'geometry' => $geometryGeoJson['coordinates'][0],
        'area__ha' => $stats['data'][0]['area__ha'] ?? 0, // Área deforestada del servicio GFW
        'polygon_area_ha' => floatval($areaHa), // NUEVO: Área total del polígono
        'status' => $stats['status'],
        'polygon_name' => $request->input('name', 'Área de Estudio'), // Nombre del área
        'description' => $request->input('description', ''), // Descripción
    ];

    return view('deforestation.results', compact('dataToPass'));

} /*################## fin de la funcion analyze #################*/
        
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