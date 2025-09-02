<?php

namespace App\Services;

use App\Models\Polygon;
use Illuminate\Support\Facades\DB;
use App\Models\DeforestationAnalysis;
use Illuminate\Support\Facades\Log;

class DeforestationService
{
    /**
     * Analiza la deforestación para un polígono en un período de años
     */
    public function analyzeDeforestation(Polygon $polygon, int $startYear, int $endYear): array
    {
        $results = [];
        
        for ($year = $startYear; $year <= $endYear; $year++) {
            $analysis = $this->analyzeYear($polygon, $year);
            
            if ($analysis) {
                $results[$year] = $analysis;
                
                // Guardar en base de datos
                $this->saveAnalysis($polygon, $year, $analysis);
            }
        }
        
        return $results;
    }
    
    /**
     * Analiza un año específico usando datos de ejemplo (simulado)
     */
    private function analyzeYear(Polygon $polygon, int $year): ?array
    {
        try {
            // Obtener el área REAL del polígono
            $polygonArea = $polygon->area_ha;
            
            if ($polygonArea <= 0) {
                throw new \Exception("Área del polígono no válida: {$polygonArea} ha");
            }
            
            // Simular pérdida forestal (5-15% del área total acumulada por año)
            $yearsFromStart = $year - 2018;
            $annualLossPercentage = rand(5, 15) / 100; // 5-15% de pérdida anual
            
            // Calcular áreas basadas en el tamaño REAL del polígono
            $remainingPercentage = max(0, 1 - ($annualLossPercentage * $yearsFromStart));
            $forestArea = $polygonArea * $remainingPercentage;
            $deforestedArea = $polygonArea - $forestArea;
            $percentageLoss = ($deforestedArea / $polygonArea) * 100;
            
            return [
                'forest_area_ha' => round($forestArea, 2),
                'deforested_area_ha' => round($deforestedArea, 2),
                'percentage_loss' => round($percentageLoss, 2),
                'year' => $year,
                'metadata' => [
                    'source' => 'simulated_based_on_real_area',
                    'polygon_area_ha' => $polygonArea,
                    'annual_loss_percentage' => $annualLossPercentage * 100,
                    'notes' => 'Datos simulados basados en el área real del polígono'
                ]
            ];
            
        } catch (\Exception $e) {
            Log::error("Error analyzing year {$year}: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Guarda el análisis en la base de datos
     */
    private function saveAnalysis(Polygon $polygon, int $year, array $analysis): void
    {
        DeforestationAnalysis::updateOrCreate(
            [
                'polygon_id' => $polygon->id,
                'year' => $year
            ],
            [
                'forest_area_ha' => $analysis['forest_area_ha'],
                'deforested_area_ha' => $analysis['deforested_area_ha'],
                'percentage_loss' => $analysis['percentage_loss'],
                'metadata' => $analysis['metadata']
            ]
        );
    }
    
    /**
     * Obtiene el historial de análisis para un polígono
     */
    public function getAnalysisHistory(Polygon $polygon): array
    {
        return $polygon->analyses()
            ->orderBy('year')
            ->get()
            ->keyBy('year')
            ->toArray();
    }
    
    /**
     * Procesa un GeoJSON con múltiples polígonos y devuelve información de cada uno
     */
    public function processMultiPolygonGeoJSON($geojson): array
    {
        $data = json_decode($geojson, true);
        $results = [];
        
        if (isset($data['type']) && $data['type'] === 'FeatureCollection') {
            foreach ($data['features'] as $feature) {
                if (!isset($feature['geometry']) || $feature['geometry']['type'] !== 'Polygon') {
                    continue;
                }
                
                // Extraer propiedades
                $properties = $feature['properties'] ?? [];
                $productor = $properties['Productor'] ?? $properties['productor'] ?? 'Desconocido';
                $localidad = $properties['Localidad'] ?? $properties['localidad'] ?? 'No especificada';
                
                // Calcular área (simulación - en producción usarías PostGIS)
                $area = $this->calculateAreaFromGeoJSON($feature['geometry']);
                
                $results[] = [
                    'productor' => $productor,
                    'localidad' => $localidad,
                    'area_ha' => round($area, 2),
                    'geometry' => $feature['geometry']
                ];
            }
        }
        
        return $results;
    }
    
    /**
     * Calcula el área aproximada desde GeoJSON (simulación)
     * EN PRODUCCIÓN: Usarías funciones PostGIS como ST_Area
     */
    private function calculateAreaFromGeoJSON($geometry): float
    {
        // Esta es una simulación simple - en producción usarías PostGIS
        // Para polígonos simples, podemos hacer un cálculo aproximado
        if ($geometry['type'] === 'Polygon' && isset($geometry['coordinates'][0])) {
            $coordinates = $geometry['coordinates'][0];
            if (count($coordinates) > 2) {
                // Algoritmo simple para cálculo de área (fórmula del shoelace)
                $area = 0;
                $n = count($coordinates);
                
                for ($i = 0; $i < $n; $i++) {
                    $j = ($i + 1) % $n;
                    $area += $coordinates[$i][0] * $coordinates[$j][1];
                    $area -= $coordinates[$j][0] * $coordinates[$i][1];
                }
                
                $area = abs($area) / 2;
                
                // Convertir grados² a hectáreas (aproximación muy básica)
                // EN PRODUCCIÓN: Usar funciones PostGIS para conversión precisa
                return $area * 10000; // Aproximación
            }
        }
        
        return 0;
    }
}