<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AcademicoController extends Controller
{
    // === EXÁMENES Y NOTAS ===

    public function indexExamenes()
    {
        $activeConv = DB::table('convocatoria')->where('estado', 'ACTIVA')->first();
        $convId = $activeConv ? $activeConv->id : null;

        $examenes = [];
        $materias = [];

        if ($convId) {
            $examenes = DB::table('examen')
                ->join('materia', 'examen.materia_id', '=', 'materia.id')
                ->where('examen.convocatoria_id', $convId)
                ->select('examen.*', 'materia.nombre as materia_nombre', 'materia.codigo as materia_codigo')
                ->orderBy('materia.id')
                ->orderBy('examen.nro_examen')
                ->get();

            $materias = DB::table('materia')->get();
        }

        return view('admin.examenes.index', compact('activeConv', 'examenes', 'materias'));
    }

    public function storeExamen(Request $request)
    {
        $request->validate([
            'materia_id'      => 'required|exists:materia,id',
            'nro_examen'      => 'required|integer|min:1|max:5',
            'fecha'           => 'required|date',
            'porcentaje_peso' => 'required|integer|min:5|max:100',
        ]);

        $activeConv = DB::table('convocatoria')->where('estado', 'ACTIVA')->first();
        if (!$activeConv) {
            return back()->with('error', 'No existe una convocatoria ACTIVA.');
        }

        // Verificar peso total para esta materia no exceda el 100%
        $pesoActual = DB::table('examen')
            ->where('convocatoria_id', $activeConv->id)
            ->where('materia_id', $request->materia_id)
            ->sum('porcentaje_peso');

        if ($pesoActual + $request->porcentaje_peso > 100) {
            $materiaNombre = DB::table('materia')->where('id', $request->materia_id)->value('nombre');
            return back()->with('error', "El peso acumulado para {$materiaNombre} no puede superar el 100%. (Peso actual: {$pesoActual}%)");
        }

        DB::table('examen')->insert([
            'materia_id'      => $request->materia_id,
            'convocatoria_id' => $activeConv->id,
            'nro_examen'      => $request->nro_examen,
            'fecha'           => $request->fecha,
            'porcentaje_peso' => $request->porcentaje_peso
        ]);

        $materiaNombre = DB::table('materia')->where('id', $request->materia_id)->value('nombre');

        DB::table('log_actividad')->insert([
            'usuario_id'     => Auth::id(),
            'usuario_nombre' => Auth::user()->nombre . ' ' . Auth::user()->apellido,
            'usuario_email'  => Auth::user()->email,
            'accion'         => 'registro_creado',
            'descripcion'    => "Examen Nro {$request->nro_examen} de {$materiaNombre} creado. Peso: {$request->porcentaje_peso}%.",
            'ip'             => $request->ip(),
            'modulo'         => 'academico',
            'resultado'      => 'ok',
            'fecha_hora'     => now()
        ]);

        return back()->with('success', '✅ Examen registrado correctamente.');
    }

    public function cargarNotasView(Request $request, $examenId)
    {
        $examen = DB::table('examen')
            ->join('materia', 'examen.materia_id', '=', 'materia.id')
            ->where('examen.id', $examenId)
            ->select('examen.*', 'materia.nombre as materia_nombre', 'materia.codigo as materia_codigo')
            ->first();

        if (!$examen) {
            return redirect()->route('admin.examenes.index')->with('error', 'Examen no encontrado.');
        }

        $activeConv = DB::table('convocatoria')->where('estado', 'ACTIVA')->first();
        
        // Obtener grupos de esta convocatoria para el filtro
        $grupos = DB::table('grupo')
            ->where('convocatoria_id', $activeConv->id)
            ->get();

        $grupoId = $request->query('grupo_id');
        $postulantes = [];

        if ($grupoId) {
            // Obtener postulantes de ese grupo
            $postulantesRaw = DB::table('postulante')
                ->join('grupo_postulante', 'postulante.id', '=', 'grupo_postulante.postulante_id')
                ->where('grupo_postulante.grupo_id', $grupoId)
                ->select('postulante.id', 'postulante.nombre', 'postulante.apellido', 'postulante.codigo_estudiante')
                ->orderBy('postulante.apellido')
                ->get();

            foreach ($postulantesRaw as $p) {
                // Obtener nota si ya existe
                $nota = DB::table('nota')
                    ->where('postulante_id', $p->id)
                    ->where('examen_id', $examenId)
                    ->first();

                $postulantes[] = [
                    'id'                => $p->id,
                    'nombre'            => $p->nombre,
                    'apellido'          => $p->apellido,
                    'codigo_estudiante' => $p->codigo_estudiante,
                    'nota'              => $nota ? $nota->puntaje : ''
                ];
            }
        }

        return view('admin.examenes.cargar-notes', compact('examen', 'grupos', 'grupoId', 'postulantes'));
    }

    public function guardarNotas(Request $request, $examenId)
    {
        $request->validate([
            'grupo_id' => 'required|exists:grupo,id',
            'notas'    => 'required|array',
        ]);

        $examen = DB::table('examen')->where('id', $examenId)->first();
        if (!$examen) {
            return back()->with('error', 'Examen no encontrado.');
        }

        DB::beginTransaction();
        try {
            foreach ($request->notas as $postulanteId => $puntaje) {
                if ($puntaje === null || $puntaje === '') {
                    // Si está vacío, eliminamos la nota registrada anterior
                    DB::table('nota')
                        ->where('postulante_id', $postulanteId)
                        ->where('examen_id', $examenId)
                        ->delete();
                    continue;
                }

                $score = (float) $puntaje;
                if ($score < 0 || $score > 100) {
                    throw new \Exception("La nota debe estar entre 0 y 100.");
                }

                // Aprobado en examen si es mayor o igual a 60
                $aprobado = $score >= 60;

                // Actualizar o Insertar
                $existe = DB::table('nota')
                    ->where('postulante_id', $postulanteId)
                    ->where('examen_id', $examenId)
                    ->exists();

                if ($existe) {
                    DB::table('nota')
                        ->where('postulante_id', $postulanteId)
                        ->where('examen_id', $examenId)
                        ->update([
                            'puntaje'        => $score,
                            'registrado_por' => Auth::id(),
                            'actualizado_en' => now()
                        ]);
                } else {
                    DB::table('nota')->insert([
                        'postulante_id'  => $postulanteId,
                        'examen_id'      => $examenId,
                        'puntaje'        => $score,
                        'registrado_por' => Auth::id(),
                        'registrado_en'  => now()
                    ]);
                }
            }

            $grupoCodigo = DB::table('grupo')->where('id', $request->grupo_id)->value('codigo_grupo');

            DB::table('log_actividad')->insert([
                'usuario_id'     => Auth::id(),
                'usuario_nombre' => Auth::user()->nombre . ' ' . Auth::user()->apellido,
                'usuario_email'  => Auth::user()->email,
                'accion'         => 'registro_actualizado',
                'descripcion'    => "Registro de notas del Grupo {$grupoCodigo} para el examen ID {$examenId}.",
                'ip'             => $request->ip(),
                'modulo'         => 'academico',
                'resultado'      => 'ok',
                'fecha_hora'     => now()
            ]);

            DB::commit();
            return redirect()->route('admin.examenes.cargar-notas', ['id' => $examenId, 'grupo_id' => $request->grupo_id])
                ->with('success', '✅ Notas guardadas correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al guardar notas: ' . $e->getMessage());
        }
    }


    // === PROCESO DE ADMISIÓN (CU15 - CU19) ===

    public function admisionView()
    {
        $activeConv = DB::table('convocatoria')->where('estado', 'ACTIVA')->first();
        $convId = $activeConv ? $activeConv->id : null;

        $resultados = [];
        $stats = [
            'total_postulantes' => 0,
            'admitidos'         => 0,
            'aprobados_sin_cupo'=> 0,
            'reprobados'        => 0
        ];

        if ($convId) {
            $resultados = DB::table('resultado_final')
                ->join('postulante', 'resultado_final.postulante_id', '=', 'postulante.id')
                ->leftJoin('carrera', 'resultado_final.carrera_asignada_id', '=', 'carrera.id')
                ->where('resultado_final.convocatoria_id', $convId)
                ->select(
                    'resultado_final.*',
                    'postulante.nombre as postulante_nombre',
                    'postulante.apellido as postulante_apellido',
                    'postulante.codigo_estudiante',
                    'carrera.nombre as carrera_nombre'
                )
                ->orderBy('resultado_final.ranking')
                ->get();

            $stats['total_postulantes'] = DB::table('postulante')->where('convocatoria_id', $convId)->count();
            $stats['admitidos']          = DB::table('resultado_final')->where('convocatoria_id', $convId)->where('estado_admision', 'ADMITIDO')->count();
            $stats['aprobados_sin_cupo'] = DB::table('resultado_final')->where('convocatoria_id', $convId)->where('estado_admision', 'APROBADO_SIN_CUPO')->count();
            $stats['reprobados']         = DB::table('resultado_final')->where('convocatoria_id', $convId)->where('estado_admision', 'REPROBADO')->count();
        }

        return view('admin.resultados.admision', compact('activeConv', 'resultados', 'stats'));
    }

    public function ejecutarCalculosAdmision(Request $request)
    {
        $activeConv = DB::table('convocatoria')->where('estado', 'ACTIVA')->first();
        if (!$activeConv) {
            return back()->with('error', 'No existe una convocatoria ACTIVA.');
        }

        $convId = $activeConv->id;

        DB::beginTransaction();
        try {
            // 1. Limpiar resultados anteriores de esta convocatoria
            DB::table('resultado_final')->where('convocatoria_id', $convId)->delete();

            // 2. Obtener materias y postulantes
            $materias = DB::table('materia')->get()->keyBy('codigo'); // MAT, FIS, COM, ING
            $postulantes = DB::table('postulante')->where('convocatoria_id', $convId)->get();

            if ($postulantes->isEmpty()) {
                throw new \Exception("No hay postulantes registrados en esta convocatoria.");
            }

            // Exámenes por materia de esta convocatoria
            $examenesPorMateria = [];
            foreach ($materias as $codigo => $m) {
                $examenesPorMateria[$codigo] = DB::table('examen')
                    ->where('convocatoria_id', $convId)
                    ->where('materia_id', $m->id)
                    ->get();
            }

            // Calcular promedios por estudiante (CU15 y CU17)
            foreach ($postulantes as $p) {
                $promedios = ['MAT' => 0.0, 'FIS' => 0.0, 'COM' => 0.0, 'ING' => 0.0];

                foreach ($materias as $codigo => $m) {
                    $exams = $examenesPorMateria[$codigo];
                    if ($exams->isEmpty()) {
                        continue;
                    }

                    $totalWeight = 0;
                    $weightedSum = 0;

                    foreach ($exams as $ex) {
                        $nota = DB::table('nota')
                            ->where('postulante_id', $p->id)
                            ->where('examen_id', $ex->id)
                            ->first();

                        $puntaje = $nota ? (float) $nota->puntaje : 0.0;
                        $weightedSum += ($puntaje * $ex->porcentaje_peso);
                        $totalWeight += $ex->porcentaje_peso;
                    }

                    // Promediar sobre el peso total configurado
                    if ($totalWeight > 0) {
                        $promedios[$codigo] = round($weightedSum / 100, 2);
                    }
                }

                // Promedio total general
                $promedioTotal = round(array_sum($promedios) / 4, 2);
                
                // Nota mínima de aprobación es 60 y no haber reprobado ningún examen tomado
                $hasFailedExam = DB::table('nota')
                    ->where('postulante_id', $p->id)
                    ->where('puntaje', '<', 60)
                    ->exists();

                $aprobadoGeneral = ($promedioTotal >= 60) && !$hasFailedExam;

                // Registrar el resultado final parcial
                DB::table('resultado_final')->insert([
                    'postulante_id'     => $p->id,
                    'convocatoria_id'   => $convId,
                    'promedio_mat'      => $promedios['MAT'],
                    'promedio_fis'      => $promedios['FIS'],
                    'promedio_com'      => $promedios['COM'],
                    'promedio_ing'      => $promedios['ING'],
                    'promedio_total'    => $promedioTotal,
                    'aprobado_general'  => $aprobadoGeneral,
                    'estado_admision'   => 'PROCESO',
                    'calculado_en'      => now()
                ]);
            }

            // 3. Algoritmo de Admisión y Asignación de Carreras por Cupos (CU18)
            $carreras = DB::table('carrera')->where('activa', true)->get()->keyBy('id');
            
            // Inicializar cupos disponibles por carrera
            $cuposDisponibles = [];
            foreach ($carreras as $cId => $c) {
                $cuposDisponibles[$cId] = (int) $c->cupo_max;
            }

            // Obtener resultados aprobados ordenados por promedio total DESC (Ranking)
            $aprobados = DB::table('resultado_final')
                ->where('convocatoria_id', $convId)
                ->where('aprobado_general', true)
                ->orderBy('promedio_total', 'desc')
                ->orderBy('postulante_id') // Desempate determinista
                ->get();

            foreach ($aprobados as $ap) {
                $postulante = DB::table('postulante')->where('id', $ap->postulante_id)->first();
                $carreraAsignadaId = null;
                $estadoAdmision = 'APROBADO_SIN_CUPO';

                // Intentar asignar Opción 1
                $op1 = $postulante->carrera_pref_1_id;
                if ($op1 && isset($cuposDisponibles[$op1]) && $cuposDisponibles[$op1] > 0) {
                    $carreraAsignadaId = $op1;
                    $cuposDisponibles[$op1]--;
                    $estadoAdmision = 'ADMITIDO';
                } else {
                    // Si la opción 1 está llena, intentar Opción 2
                    $op2 = $postulante->carrera_pref_2_id;
                    if ($op2 && isset($cuposDisponibles[$op2]) && $cuposDisponibles[$op2] > 0) {
                        $carreraAsignadaId = $op2;
                        $cuposDisponibles[$op2]--;
                        $estadoAdmision = 'ADMITIDO';
                    }
                }

                // Actualizar admisión del aprobado
                DB::table('resultado_final')
                    ->where('id', $ap->id)
                    ->update([
                        'carrera_asignada_id' => $carreraAsignadaId,
                        'estado_admision'     => $estadoAdmision
                    ]);
            }

            // Marcar reprobados
            DB::table('resultado_final')
                ->where('convocatoria_id', $convId)
                ->where('aprobado_general', false)
                ->update([
                    'carrera_asignada_id' => null,
                    'estado_admision'     => 'REPROBADO'
                ]);

            // 4. Asignar Ranking General de todos (CU19)
            $todosOrdenados = DB::table('resultado_final')
                ->where('convocatoria_id', $convId)
                ->orderBy('promedio_total', 'desc')
                ->orderBy('postulante_id')
                ->get();

            $rank = 1;
            foreach ($todosOrdenados as $item) {
                DB::table('resultado_final')
                    ->where('id', $item->id)
                    ->update(['ranking' => $rank++]);
            }

            // 5. Actualizar el estado de los postulantes en la tabla postulante
            $admitidosIds = DB::table('resultado_final')
                ->where('convocatoria_id', $convId)
                ->where('estado_admision', 'ADMITIDO')
                ->pluck('postulante_id')
                ->toArray();

            $noAdmitidosIds = DB::table('resultado_final')
                ->where('convocatoria_id', $convId)
                ->whereIn('estado_admision', ['APROBADO_SIN_CUPO', 'REPROBADO'])
                ->pluck('postulante_id')
                ->toArray();

            if (!empty($admitidosIds)) {
                DB::table('postulante')->whereIn('id', $admitidosIds)->update(['estado' => 'ADMITIDO']);
            }
            if (!empty($noAdmitidosIds)) {
                DB::table('postulante')->whereIn('id', $noAdmitidosIds)->update(['estado' => 'NO_ADMITIDO']);
            }

            DB::table('log_actividad')->insert([
                'usuario_id'     => Auth::id(),
                'usuario_nombre' => Auth::user()->nombre . ' ' . Auth::user()->apellido,
                'usuario_email'  => Auth::user()->email,
                'accion'         => 'registro_actualizado',
                'descripcion'    => "Cálculo de resultados de admisión y asignación de carreras completado para la convocatoria {$activeConv->nombre}.",
                'ip'             => $request->ip(),
                'modulo'         => 'academico',
                'resultado'      => 'ok',
                'fecha_hora'     => now()
            ]);

            DB::commit();
            return redirect()->route('admin.resultados.admision')
                ->with('success', '✅ Proceso de admisión ejecutado correctamente. Se calcularon promedios, rankings y asignaciones de carreras por cupos.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al ejecutar admisión: ' . $e->getMessage());
        }
    }
}
