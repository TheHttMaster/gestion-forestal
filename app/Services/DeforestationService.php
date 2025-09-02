<?php

namespace App\Services;

use App\Models\Polygon;
use Illuminate\Support\Facades\DB;
use App\Models\DeforestationAnalysis; // ← AÑADE ESTA LÍNEA
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
    // DeforestationService.php - MODIFICAR el método analyzeYear
    private function analyzeYear(Polygon $polygon, int $year): ?array
    {
        try {
            // Obtener el área REAL del polígono
            $polygonArea = $polygon->area_ha;
            
            if ($polygonArea <= 0) {
                throw new \Exception("Área del polígono no válida: {$polygonArea} ha");
            }
            
            // EN UN SISTEMA REAL: Aquí conectarías con APIs de satélite
            // Para esta demo, usaremos datos más realistas basados en el área real
            
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
}