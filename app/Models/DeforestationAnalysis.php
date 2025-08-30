<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeforestationAnalysis extends Model
{
    protected $fillable = [
        'polygon_id', 'year', 'forest_area_ha', 
        'deforested_area_ha', 'percentage_loss', 'metadata'
    ];
    
    protected $casts = [
        'metadata' => 'array', // Convierte el JSON a array automáticamente
    ];
    
    /**
     * Relación: Un análisis pertenece a un polígono
     */
    public function polygon(): BelongsTo
    {
        return $this->belongsTo(Polygon::class);
    }
}