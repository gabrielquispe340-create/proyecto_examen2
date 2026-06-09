<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo HorarioGrupo
 *
 * Representa el horario semanal de un grupo académico para una materia concreta.
 * Almacena el día, la hora de inicio, la hora de fin, el aula y el docente asignado.
 *
 * Tabla en BD: "horario_grupo"
 */
class HorarioGrupo extends Model
{
    protected $table = 'horario_grupo';

    protected $fillable = [
        'grupo_id',
        'materia_id',
        'docente_id',
        'dia_semana',
        'hora_inicio',
        'hora_fin',
        'aula',
    ];

    // =========================================================================
    // RELACIONES
    // =========================================================================

    /**
     * El horario pertenece a un grupo académico.
     */
    public function grupo(): BelongsTo
    {
        return $this->belongsTo(Grupo::class);
    }

    /**
     * El horario corresponde a una materia.
     */
    public function materia(): BelongsTo
    {
        return $this->belongsTo(Materia::class);
    }

    /**
     * El horario puede tener un docente asignado.
     */
    public function docente(): BelongsTo
    {
        return $this->belongsTo(Docente::class);
    }

    // =========================================================================
    // ACCESSORS
    // =========================================================================

    /**
     * Retorna el rango de horas formateado: "08:00 – 10:00"
     */
    public function getRangoHoraAttribute(): string
    {
        return substr($this->hora_inicio, 0, 5) . ' – ' . substr($this->hora_fin, 0, 5);
    }
}
