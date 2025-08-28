<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Area extends Model
{
    use SoftDeletes;

    protected $table = 'areas';

    protected $fillable = [
        'nombre',
        'codigo',
        'descripcion',
        'latitud',
        'longitud',
        'area_padre_id',
        'tipo',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'latitud' => 'float',
        'longitud' => 'float',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    // Relación con área padre
    public function padre(): BelongsTo
    {
        return $this->belongsTo(Area::class, 'area_padre_id');
    }

    // Relación con áreas hijas
    public function hijos(): HasMany
    {
        return $this->hasMany(Area::class, 'area_padre_id');
    }

    // Scope para áreas activas
    public function scopeActivas(Builder $query): Builder
    {
        return $query->where('activo', true);
    }

    // Scope para búsqueda (optimizado para PostgreSQL)
    public function scopeBuscar(Builder $query, string $search): Builder
    {
        return $query->where(function ($q) use ($search) {
            $q->where('nombre', 'ilike', "%{$search}%")
              ->orWhere('codigo', 'ilike', "%{$search}%")
              ->orWhere('descripcion', 'ilike', "%{$search}%");
        });
    }

    // Scope por tipo
    public function scopePorTipo(Builder $query, string $tipo): Builder
    {
        return $query->where('tipo', $tipo);
    }

    // Scope para áreas con coordenadas
    public function scopeConCoordenadas(Builder $query): Builder
    {
        return $query->whereNotNull('latitud')->whereNotNull('longitud');
    }

    // Verificar si tiene áreas hijas
    public function tieneHijos(): bool
    {
        return $this->hijos()->count() > 0;
    }

    // Obtener árbol completo (recursivo)
    public function getArbolAttribute()
    {
        return $this->load('hijos.arbol');
    }

    // Calcular distancia usando PostgreSQL earthdistance extension (opcional)
    public function distanciaA($latitud, $longitud)
    {
        // Requiere la extensión earthdistance de PostgreSQL
        return DB::selectOne("
            SELECT ST_Distance(
                ST_MakePoint(?, ?)::geography,
                ST_MakePoint(?, ?)::geography
            ) as distancia
        ", [$this->longitud, $this->latitud, $longitud, $latitud])->distancia;
    }
}