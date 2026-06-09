<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Nota extends Model
{
    protected $table = 'nota';

    public const CREATED_AT = 'registrado_en';
    public const UPDATED_AT = 'actualizado_en';

    protected $fillable = [
        'postulante_id',
        'examen_id',
        'puntaje',
        'aprobado',
        'registrado_por',
        'observaciones',
    ];

    protected $casts = [
        'puntaje'  => 'decimal:2',
        'aprobado' => 'boolean',
    ];

    // ──────────────────────────────────────────
    // Relaciones
    // ──────────────────────────────────────────

    /** Una nota pertenece a un postulante */
    public function postulante(): BelongsTo
    {
        return $this->belongsTo(Postulante::class);
    }

    /** Una nota pertenece a un examen */
    public function examen(): BelongsTo
    {
        return $this->belongsTo(Examen::class);
    }

    /** Una nota es registrada por un usuario administrador */
    public function registradoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }

    // ──────────────────────────────────────────
    // Scopes
    // ──────────────────────────────────────────

    /** Notas aprobadas (>= 60) */
    public function scopeAprobadas($query)
    {
        return $query->where('puntaje', '>=', 60);
    }

    /** Notas reprobadas (< 60) */
    public function scopeReprobadas($query)
    {
        return $query->where('puntaje', '<', 60);
    }

    // ──────────────────────────────────────────
    // Helpers
    // ──────────────────────────────────────────

    /** ¿Nota aprobada? */
    public function esAprobada(): bool
    {
        return $this->puntaje >= 60;
    }

    /** Estado descriptivo */
    public function getEstadoDescriptivo(): string
    {
        return $this->esAprobada() ? 'Aprobado' : 'Reprobado';
    }
}
