<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Examen extends Model
{
    protected $table = 'examen';

    public $timestamps = false;

    protected $fillable = [
        'materia_id',
        'convocatoria_id',
        'nro_examen',
        'fecha',
        'porcentaje_peso',
        'estado',
        'tipo',
        'hora',
    ];

    /** Un examen pertenece a una materia */
    public function materia(): BelongsTo
    {
        return $this->belongsTo(Materia::class);
    }

    /** Un examen pertenece a una convocatoria */
    public function convocatoria(): BelongsTo
    {
        return $this->belongsTo(Convocatoria::class);
    }

    /** Un examen tiene muchas notas */
    public function notas(): HasMany
    {
        return $this->hasMany(Nota::class);
    }
}
