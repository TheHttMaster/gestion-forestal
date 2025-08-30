<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    public function getAreaHaAttribute(): float
    {
        // Calcula el área usando PostGIS (en metros cuadrados) y convierte a hectáreas
        $areaSqM = \DB::table('polygons')
            ->where('id', $this->id)
            ->selectRaw('ST_Area(geometry) as area')
            ->first()
            ->area;
            
        return round($areaSqM / 10000, 2); // 1 hectárea = 10,000 m²
    }
}