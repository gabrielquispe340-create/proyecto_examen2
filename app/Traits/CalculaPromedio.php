<?php

namespace App\Traits;

use App\Models\ResultadoFinal;
use Illuminate\Support\Facades\DB;

trait CalculaPromedio
{
    /**
     * CU15 - Calcula el promedio de un postulante agrupado por materias y el total.
     * @return array
     */
    public function obtenerDetallePromedios(): array
    {
        $notas = $this->notas()->get();
        $convId = $this->convocatoria_id;
        $materias = DB::table('materia')->get();

        $promediosMaterias = [
            'MAT' => 0.0,
            'FIS' => 0.0,
            'COM' => 0.0,
            'ING' => 0.0,
        ];

        foreach ($materias as $m) {
            $codigo = strtoupper($m->codigo); // MAT, FIS, COM, ING
            if (!array_key_exists($codigo, $promediosMaterias)) {
                continue;
            }

            // Exámenes de esta materia y convocatoria
            $exams = DB::table('examen')
                ->where('convocatoria_id', $convId)
                ->where('materia_id', $m->id)
                ->get();

            if ($exams->isEmpty()) {
                $promediosMaterias[$codigo] = 0.0;
                continue;
            }

            $weightedSum = 0;
            $totalWeight = 0;

            foreach ($exams as $ex) {
                // Nota del postulante para el examen
                $nota = $notas->where('examen_id', $ex->id)->first();
                $puntaje = $nota ? (float) $nota->puntaje : 0.0;

                $weightedSum += ($puntaje * $ex->porcentaje_peso);
                $totalWeight += $ex->porcentaje_peso;
            }

            if ($totalWeight > 0) {
                // El promedio ponderado es la suma ponderada dividida entre 100
                $promediosMaterias[$codigo] = round($weightedSum / 100, 2);
            }
        }

        $promedioTotal = round(array_sum($promediosMaterias) / 4, 2);

        return [
            'total' => $promedioTotal,
            'materias' => $promediosMaterias,
        ];
    }

    /**
     * CU15 - Calcula el promedio total de un postulante
     * @return float|null
     */
    public function calcularPromedio(): ?float
    {
        $detalle = $this->obtenerDetallePromedios();
        return $detalle['total'];
    }

    /**
     * Calcula el estado del postulante basado en el promedio
     * @return string
     */
    public function calcularEstado(): string
    {
        $notas = $this->notas()->get();
        $hasFailedExam = $notas->contains(function ($n) {
            return $n->puntaje < 60;
        });

        if ($hasFailedExam) {
            return 'REPROBADO_CUP';
        }

        $promedio = $this->calcularPromedio();
        return $promedio >= 60 ? 'ADMITIDO' : 'REPROBADO_CUP';
    }

    /**
     * Obtiene o crea el resultado final
     */
    public function obtenerResultadoFinal()
    {
        return ResultadoFinal::firstOrCreate(
            [
                'postulante_id' => $this->id,
                'convocatoria_id' => $this->convocatoria_id,
            ],
            [
                'estado_admision' => 'PROCESO',
            ]
        );
    }

    /**
     * Actualiza el resultado final del postulante
     */
    public function actualizarResultadoFinal(): ResultadoFinal
    {
        $resultado = $this->obtenerResultadoFinal();
        $detalle = $this->obtenerDetallePromedios();
        $promedioTotal = $detalle['total'];
        $promedios = $detalle['materias'];

        $notas = $this->notas()->get();
        $hasFailedExam = $notas->contains(function ($n) {
            return $n->puntaje < 60;
        });

        $aprobadoGeneral = ($promedioTotal >= 60) && !$hasFailedExam;

        $resultado->update([
            'promedio_mat'     => $promedios['MAT'],
            'promedio_fis'     => $promedios['FIS'],
            'promedio_com'     => $promedios['COM'],
            'promedio_ing'     => $promedios['ING'],
            'promedio_total'   => $promedioTotal,
            'aprobado_general' => $aprobadoGeneral,
            'estado_admision'  => $aprobadoGeneral ? 'ADMITIDO' : 'REPROBADO_CUP',
            'calculado_en'     => now(),
        ]);

        return $resultado;
    }
}
