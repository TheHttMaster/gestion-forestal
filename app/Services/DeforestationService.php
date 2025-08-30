<?php

namespace App\Services;

use App\Models\Polygon;
use Illuminate\Support\Facades\DB;
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
     * EN LA PRÁCTICA: Conectarías con APIs gratuitas o procesarías imágenes
     */
    private function analyzeYear(Polygon $polygon, int $year): ?array
    {
        try {
            // SIMULACIÓN: En un caso real, aquí conectarías con:
            // - Google Earth Engine (gratuito con límites)
            // - APIs de satélites abiertos (Landsat, Sentinel)
            // - Datos pre-procesados de Global Forest Watch
            
            $polygonArea = $polygon->area_ha;
            
            // Datos de ejemplo (simulados)
            $baseForest = 1000; // hectáreas base de bosque
            $annualLoss = rand(5, 15); // pérdida anual aleatoria entre 5-15%
            
            $forestArea = $baseForest * (1 - ($annualLoss / 100 * ($year - 2018)));
            $deforestedArea = $baseForest - $forestArea;
            $percentageLoss = ($deforestedArea / $baseForest) * 100;
            
            return [
                'forest_area_ha' => round($forestArea, 2),
                'deforested_area_ha' => round($deforestedArea, 2),
                'percentage_loss' => round($percentageLoss, 2),
                'year' => $year,
                'metadata' => [
                    'source' => 'simulated_data',
                    'notes' => 'Datos de ejemplo para demostración'
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
}