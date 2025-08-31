<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB; // ← AÑADE ESTA LÍNEA

class Polygon extends Model
{
    protected $fillable = ['name', 'description', 'geometry'];
    
    /**
     * Relación: Un polígono tiene muchos análisis de deforestación
     */
    public function analyses(): HasMany
    {
        return $this->hasMany(DeforestationAnalysis::class);
    }
    
    /**
     * Accesor para obtener el área total en hectáreas
     */
    // Polygon.php - REEMPLAZAR el método getAreaHaAttribute
    public function getAreaHaAttribute(): float
    {
        // Usar una consulta más confiable con PostGIS
        $area = DB::table('polygons')
            ->where('id', $this->id)
            ->selectRaw('ST_Area(ST_Transform(geometry, 4326)::geography) / 10000 as area_ha')
            ->first()
            ->area_ha;
        
        return round($area, 2);
    }
}