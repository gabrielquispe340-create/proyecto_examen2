<?php

namespace App\Http\Controllers\Docente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DocenteGestionController extends Controller
{
    public function dashboard()
    {
        $usuario = Auth::user();
        $docente = DB::table('docente')->where('usuario_id', $usuario->id)->first();

        $clases = [];
        $totalEstudiantes = 0;

        if ($docente) {
            $docente->estado = $docente->activo ? 'ACTIVO' : 'INACTIVO';
            $clases = DB::table('asignacion_docente')
                ->join('horario_grupo', 'asignacion_docente.horario_grupo_id', '=', 'horario_grupo.id')
                ->join('grupo', 'horario_grupo.grupo_id', '=', 'grupo.id')
                ->join('materia', 'horario_grupo.materia_id', '=', 'materia.id')
                ->where('asignacion_docente.docente_id', $docente->id)
                ->select(
                    'horario_grupo.id as horario_grupo_id',
                    'grupo.id as grupo_id',
                    'grupo.codigo_grupo',
                    'grupo.turno',
                    'materia.nombre as materia_nombre',
                    'materia.codigo as materia_codigo',
                    'horario_grupo.dia_semana',
                    'horario_grupo.hora_inicio',
                    'horario_grupo.hora_fin',
                    'horario_grupo.aula'
                )
                ->get();

            foreach ($clases as $c) {
                $cCount = DB::table('grupo_postulante')
                    ->where('grupo_id', $c->grupo_id)
                    ->count();
                $c->estudiantes_count = $cCount;
                $totalEstudiantes += $cCount;
            }
        }

        return view('docente.dashboard', compact('docente', 'clases', 'totalEstudiantes'));
    }

    public function claseNotas(Request $request, $horarioGrupoId)
    {
        $usuario = Auth::user();
        $docente = DB::table('docente')->where('usuario_id', $usuario->id)->first();
        if (!$docente) {
            return redirect()->route('docente.dashboard')->with('error', 'Perfil docente no encontrado.');
        }

        // Validar asignación del docente
        $asignacion = DB::table('asignacion_docente')
            ->where('docente_id', $docente->id)
            ->where('horario_grupo_id', $horarioGrupoId)
            ->first();

        if (!$asignacion) {
            return redirect()->route('docente.dashboard')->with('error', 'No estás asignado a esta clase.');
        }

        $clase = DB::table('horario_grupo')
            ->join('grupo', 'horario_grupo.grupo_id', '=', 'grupo.id')
            ->join('materia', 'horario_grupo.materia_id', '=', 'materia.id')
            ->where('horario_grupo.id', $horarioGrupoId)
            ->select(
                'horario_grupo.id as horario_grupo_id',
                'horario_grupo.materia_id',
                'horario_grupo.grupo_id',
                'grupo.codigo_grupo',
                'grupo.turno',
                'grupo.convocatoria_id',
                'materia.nombre as materia_nombre',
                'materia.codigo as materia_codigo'
            )
            ->first();

        // 1. Obtener exámenes de la materia en esta convocatoria
        $examenes = DB::table('examen')
            ->where('materia_id', $clase->materia_id)
            ->where('convocatoria_id', $clase->convocatoria_id)
            ->orderBy('nro_examen')
            ->get();

        // 2. Obtener estudiantes del grupo
        $postulantesRaw = DB::table('postulante')
            ->join('grupo_postulante', 'postulante.id', '=', 'grupo_postulante.postulante_id')
            ->where('grupo_postulante.grupo_id', $clase->grupo_id)
            ->select('postulante.id', 'postulante.nombre', 'postulante.apellido', 'postulante.codigo_estudiante')
            ->orderBy('postulante.apellido')
            ->get();

        $planilla = [];
        foreach ($postulantesRaw as $p) {
            $notasExamenes = [];
            foreach ($examenes as $ex) {
                $nota = DB::table('nota')
                    ->where('postulante_id', $p->id)
                    ->where('examen_id', $ex->id)
                    ->first();
                $notasExamenes[$ex->id] = $nota ? $nota->puntaje : '';
            }

            $planilla[] = [
                'id'                => $p->id,
                'nombre'            => $p->nombre,
                'apellido'          => $p->apellido,
                'codigo_estudiante' => $p->codigo_estudiante,
                'notas'             => $notasExamenes
            ];
        }

        return view('docente.clase-notas', compact('docente', 'clase', 'examenes', 'planilla'));
    }

    public function guardarNotas(Request $request, $horarioGrupoId)
    {
        $usuario = Auth::user();
        $docente = DB::table('docente')->where('usuario_id', $usuario->id)->first();
        if (!$docente) {
            return back()->with('error', 'Perfil docente no encontrado.');
        }

        // Validar asignación
        $asignacion = DB::table('asignacion_docente')
            ->where('docente_id', $docente->id)
            ->where('horario_grupo_id', $horarioGrupoId)
            ->first();

        if (!$asignacion) {
            return back()->with('error', 'No estás autorizado para modificar calificaciones en esta clase.');
        }

        $request->validate([
            'notas' => 'required|array'
        ]);

        DB::beginTransaction();
        try {
            // Estructura: notas[postulante_id][examen_id] = score
            foreach ($request->notas as $postulanteId => $examenes) {
                foreach ($examenes as $examenId => $puntaje) {
                    if ($puntaje === null || $puntaje === '') {
                        DB::table('nota')
                            ->where('postulante_id', $postulanteId)
                            ->where('examen_id', $examenId)
                            ->delete();
                        continue;
                    }

                    $score = (float) $puntaje;
                    if ($score < 0 || $score > 100) {
                        throw new \Exception("La nota debe estar entre 0 y 100 puntos.");
                    }

                    $aprobado = $score >= 60;

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
                                'registrado_por' => $usuario->id,
                                'actualizado_en' => now()
                            ]);
                    } else {
                        DB::table('nota')->insert([
                            'postulante_id'  => $postulanteId,
                            'examen_id'      => $examenId,
                            'puntaje'        => $score,
                            'registrado_por' => $usuario->id,
                            'registrado_en'  => now()
                        ]);
                    }
                }
            }

            $claseInfo = DB::table('horario_grupo')
                ->join('grupo', 'horario_grupo.grupo_id', '=', 'grupo.id')
                ->join('materia', 'horario_grupo.materia_id', '=', 'materia.id')
                ->where('horario_grupo.id', $horarioGrupoId)
                ->select('materia.nombre as materia_nombre', 'grupo.codigo_grupo')
                ->first();

            DB::table('log_actividad')->insert([
                'usuario_id'     => $usuario->id,
                'usuario_nombre' => $usuario->nombre . ' ' . $usuario->apellido,
                'usuario_email'  => $usuario->email,
                'accion'         => 'registro_actualizado',
                'descripcion'    => "Docente registró calificaciones de {$claseInfo->materia_nombre} en Grupo {$claseInfo->codigo_grupo}.",
                'ip'             => $request->ip(),
                'modulo'         => 'docente-portal',
                'resultado'      => 'ok',
                'fecha_hora'     => now()
            ]);

            DB::commit();
            return back()->with('success', '✅ Calificaciones registradas y promedios actualizados correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al guardar calificaciones: ' . $e->getMessage());
        }
    }
}
