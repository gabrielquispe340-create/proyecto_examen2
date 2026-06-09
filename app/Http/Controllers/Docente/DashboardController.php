<?php

namespace App\Http\Controllers\Docente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Dashboard principal del docente.
     * Carga grupos asignados, KPIs y estadísticas de notas/asistencia.
     */
    public function index()
    {
        $usuario = Auth::user();
        $docente = DB::table('docente')->where('usuario_id', $usuario->id)->first();

        if (!$docente) {
            abort(403, 'No tienes un perfil de docente registrado.');
        }

        $docente->estado = $docente->activo ? 'ACTIVO' : 'INACTIVO';

        // Grupos asignados al docente via tabla pivot grupo_docente
        // Mapeando las columnas reales de la tabla 'grupo': codigo_grupo as numero_grupo, capacidad as capacidad_maxima
        $grupos = DB::table('grupo_docente')
            ->join('grupo', 'grupo_docente.grupo_id', '=', 'grupo.id')
            ->join('convocatoria', 'grupo.convocatoria_id', '=', 'convocatoria.id')
            ->where('grupo_docente.docente_id', $docente->id)
            ->select(
                'grupo.id as grupo_id',
                'grupo.codigo_grupo as numero_grupo',
                'grupo.turno',
                DB::raw("CASE WHEN grupo.activo = true THEN 'ACTIVO' ELSE 'INACTIVO' END as estado"),
                'grupo.capacidad as capacidad_maxima',
                'convocatoria.nombre as convocatoria_nombre',
                'convocatoria.id as convocatoria_id'
            )
            ->get();

        // Para cada grupo: contar postulantes, notas registradas, promedio
        $grupos = $grupos->map(function ($g) use ($docente, $usuario) {
            $g->total_postulantes = DB::table('grupo_postulante')
                ->where('grupo_id', $g->grupo_id)->count();

            $postulanteIds = DB::table('grupo_postulante')
                ->where('grupo_id', $g->grupo_id)
                ->pluck('postulante_id');

            // Materias asignadas al docente en este grupo
            $grupoMateriasIds = DB::table('asignacion_docente')
                ->join('horario_grupo', 'asignacion_docente.horario_grupo_id', '=', 'horario_grupo.id')
                ->where('asignacion_docente.docente_id', $docente->id)
                ->where('horario_grupo.grupo_id', $g->grupo_id)
                ->distinct()
                ->pluck('horario_grupo.materia_id');

            $grupoExamenesIds = DB::table('examen')
                ->whereIn('materia_id', $grupoMateriasIds)
                ->where('convocatoria_id', $g->convocatoria_id)
                ->pluck('id');

            $g->notas_registradas = DB::table('nota')
                ->whereIn('postulante_id', $postulanteIds)
                ->whereIn('examen_id', $grupoExamenesIds)
                ->count();

            $promedioRow = DB::table('nota')
                ->whereIn('postulante_id', $postulanteIds)
                ->whereIn('examen_id', $grupoExamenesIds)
                ->avg('puntaje');
            $g->promedio = $promedioRow ? round($promedioRow, 1) : null;

            // Asistencia de hoy
            $g->asistencia_hoy = DB::table('asistencia')
                ->join('horario_grupo', 'asistencia.horario_id', '=', 'horario_grupo.id')
                ->where('horario_grupo.grupo_id', $g->grupo_id)
                ->whereDate('asistencia.fecha', today())
                ->count();

            // Materias del docente en este grupo
            $g->materias = DB::table('asignacion_docente')
                ->join('horario_grupo', 'asignacion_docente.horario_grupo_id', '=', 'horario_grupo.id')
                ->join('materia', 'horario_grupo.materia_id', '=', 'materia.id')
                ->where('asignacion_docente.docente_id', $docente->id)
                ->where('horario_grupo.grupo_id', $g->grupo_id)
                ->distinct()
                ->pluck('materia.nombre')
                ->implode(', ');

            return $g;
        });

        // KPIs globales
        $totalEstudiantes = $grupos->sum('total_postulantes');
        $totalGrupos      = $grupos->count();

        $allPostulanteIds = DB::table('grupo_postulante')
            ->whereIn('grupo_id', $grupos->pluck('grupo_id'))
            ->pluck('postulante_id');

        $allExamenesIds = DB::table('examen')
            ->whereIn('materia_id', function ($query) use ($docente, $grupos) {
                $query->select('horario_grupo.materia_id')
                    ->from('asignacion_docente')
                    ->join('horario_grupo', 'asignacion_docente.horario_grupo_id', '=', 'horario_grupo.id')
                    ->where('asignacion_docente.docente_id', $docente->id)
                    ->whereIn('horario_grupo.grupo_id', $grupos->pluck('grupo_id'));
            })
            ->whereIn('convocatoria_id', $grupos->pluck('convocatoria_id'))
            ->pluck('id');

        $totalNotas = DB::table('nota')
            ->whereIn('postulante_id', $allPostulanteIds)
            ->whereIn('examen_id', $allExamenesIds)
            ->count();

        $promedioGeneral = DB::table('nota')
            ->whereIn('postulante_id', $allPostulanteIds)
            ->whereIn('examen_id', $allExamenesIds)
            ->avg('puntaje');

        // Asistencia promedio de hoy en los grupos asignados
        $asistenciasHoy = DB::table('asistencia')
            ->join('horario_grupo', 'asistencia.horario_id', '=', 'horario_grupo.id')
            ->whereIn('horario_grupo.grupo_id', $grupos->pluck('grupo_id'))
            ->whereDate('asistencia.fecha', today())
            ->select('asistencia.presente')
            ->get();

        $presentesHoy = $asistenciasHoy->where('presente', true)->count();
        $totalRegistrosHoy = $asistenciasHoy->count();
        $pctAsistencia = $totalRegistrosHoy > 0
            ? round(($presentesHoy / $totalRegistrosHoy) * 100)
            : null;

        return view('docente.dashboard', compact(
            'docente', 'grupos',
            'totalEstudiantes', 'totalGrupos', 'totalNotas',
            'promedioGeneral', 'pctAsistencia'
        ));
    }

    /**
     * Detalle de un grupo: lista de postulantes, asistencia de hoy y notas.
     */
    public function grupoDetalle($grupoId)
    {
        $usuario = Auth::user();
        $docente = DB::table('docente')->where('usuario_id', $usuario->id)->firstOrFail();
        $docente->estado = $docente->activo ? 'ACTIVO' : 'INACTIVO';

        // Verificar que el docente esté asignado a este grupo
        $asignado = DB::table('grupo_docente')
            ->where('grupo_id', $grupoId)
            ->where('docente_id', $docente->id)
            ->exists();

        if (!$asignado) {
            abort(403, 'No tienes acceso a este grupo.');
        }

        $grupo = DB::table('grupo')
            ->join('convocatoria', 'grupo.convocatoria_id', '=', 'convocatoria.id')
            ->where('grupo.id', $grupoId)
            ->select(
                'grupo.id',
                'grupo.codigo_grupo as numero_grupo',
                'grupo.turno',
                'grupo.capacidad as capacidad_maxima',
                DB::raw("CASE WHEN grupo.activo = true THEN 'ACTIVO' ELSE 'INACTIVO' END as estado"),
                'convocatoria.nombre as convocatoria_nombre'
            )
            ->first();

        // Postulantes del grupo
        $postulantes = DB::table('postulante')
            ->join('grupo_postulante', 'postulante.id', '=', 'grupo_postulante.postulante_id')
            ->leftJoin('resultado_final as rf', 'postulante.id', '=', 'rf.postulante_id')
            ->where('grupo_postulante.grupo_id', $grupoId)
            ->select('postulante.id', 'postulante.nombre', 'postulante.apellido',
                     'postulante.ci', 'postulante.email', 'postulante.codigo_estudiante',
                     DB::raw("COALESCE(rf.estado_admision, 'PROCESO') as estado"))
            ->orderBy('postulante.apellido')
            ->get();

        // Asistencia de HOY por postulante
        $asistenciaHoy = DB::table('asistencia')
            ->join('horario_grupo', 'asistencia.horario_id', '=', 'horario_grupo.id')
            ->where('horario_grupo.grupo_id', $grupoId)
            ->whereDate('asistencia.fecha', today())
            ->select('asistencia.postulante_id', 'asistencia.presente', 'asistencia.observacion')
            ->get()
            ->keyBy('postulante_id')
            ->map(function ($asis) {
                if ($asis->presente) {
                    return 'PRESENTE';
                }
                return $asis->observacion === 'LICENCIA' ? 'JUSTIFICADO' : 'AUSENTE';
            });

        // Materias del docente para el selector de notas y tareas (definido antes de exámenes para usar como fallback)
        $materias = DB::table('competencia_docente')
            ->join('materia', 'competencia_docente.materia_id', '=', 'materia.id')
            ->where('competencia_docente.docente_id', $docente->id)
            ->select('materia.id', 'materia.nombre', 'materia.codigo')
            ->get();

        if ($materias->isEmpty()) {
            $materiaMatch = DB::table('materia')
                ->whereRaw('LOWER(nombre) = ?', [strtolower($docente->especialidad ?? '')])
                ->select('id', 'nombre', 'codigo')
                ->get();
            
            if ($materiaMatch->isNotEmpty()) {
                $materias = $materiaMatch;
            } else {
                // Si no hay coincidencia, cargar todas las materias como fallback seguro
                $materias = DB::table('materia')
                    ->select('id', 'nombre', 'codigo')
                    ->get();
            }
        }

        // Obtener materias que enseña este docente (competencias, especialidad o fallback de todas)
        $docenteMateriaIds = $materias->pluck('id')->toArray();

        // También incluir materias asignadas a este docente en el horario del grupo
        $materiasHorario = DB::table('horario_grupo')
            ->where('grupo_id', $grupoId)
            ->where('docente_id', $docente->id)
            ->pluck('materia_id')
            ->toArray();

        $materiasIds = array_unique(array_merge($docenteMateriaIds, $materiasHorario));

        $examenes = DB::table('examen')
            ->whereIn('materia_id', $materiasIds)
            ->where('convocatoria_id', $grupoId ? DB::table('grupo')->where('id', $grupoId)->value('convocatoria_id') : 0)
            ->orderBy('materia_id')
            ->orderBy('nro_examen')
            ->get();

        // Notas por postulante para los exámenes de las materias asignadas
        $notasRaw = DB::table('nota')
            ->whereIn('postulante_id', $postulantes->pluck('id'))
            ->whereIn('examen_id', $examenes->pluck('id'))
            ->get();

        // Mapear notas con examen y materia para simular el formato que espera la vista
        $notas = $notasRaw->map(function ($n) {
            $ex = DB::table('examen')->where('id', $n->examen_id)->first();
            $n->materia_id = $ex ? $ex->materia_id : null;
            $n->calificacion = $n->puntaje; // alias calificacion
            return $n;
        })->groupBy('postulante_id');

        return view('docente.grupo-detalle', compact(
            'docente', 'grupo', 'postulantes',
            'asistenciaHoy', 'notas', 'materias', 'examenes'
        ));
    }

    /**
     * Guardar asistencia masiva de un grupo para la fecha actual.
     */
    public function guardarAsistencia(Request $request, $grupoId)
    {
        $usuario = Auth::user();
        $docente = DB::table('docente')->where('usuario_id', $usuario->id)->firstOrFail();

        $asignado = DB::table('grupo_docente')
            ->where('grupo_id', $grupoId)
            ->where('docente_id', $docente->id)
            ->exists();

        if (!$asignado) abort(403);

        $asistencias = $request->input('asistencia', []); // [postulante_id => estado]

        // Buscar horario_id asignado a este grupo para este docente
        $horario = DB::table('asignacion_docente')
            ->join('horario_grupo', 'asignacion_docente.horario_grupo_id', '=', 'horario_grupo.id')
            ->where('asignacion_docente.docente_id', $docente->id)
            ->where('horario_grupo.grupo_id', $grupoId)
            ->first();

        // Fallback al primer horario del grupo si no hay asignación específica de horario
        $horarioId = $horario ? $horario->horario_grupo_id : DB::table('horario_grupo')->where('grupo_id', $grupoId)->value('id');

        if (!$horarioId) {
            return back()->with('error', 'No se puede guardar asistencia: no hay horarios definidos para este grupo.');
        }

        DB::beginTransaction();
        try {
            foreach ($asistencias as $postulanteId => $estado) {
                if (!in_array($estado, ['PRESENTE', 'AUSENTE', 'JUSTIFICADO'])) continue;

                $presente = ($estado === 'PRESENTE');
                $observacion = ($estado === 'JUSTIFICADO' ? 'LICENCIA' : ($estado === 'AUSENTE' ? 'FALTA' : null));

                $existe = DB::table('asistencia')
                    ->where('postulante_id', $postulanteId)
                    ->where('horario_id', $horarioId)
                    ->whereDate('fecha', today())
                    ->first();

                if ($existe) {
                    DB::table('asistencia')
                        ->where('id', $existe->id)
                        ->update([
                            'presente'       => $presente,
                            'observacion'    => $observacion,
                            'registrado_por' => $usuario->id,
                        ]);
                } else {
                    DB::table('asistencia')->insert([
                        'postulante_id'  => $postulanteId,
                        'horario_id'     => $horarioId,
                        'fecha'          => today(),
                        'presente'       => $presente,
                        'observacion'    => $observacion,
                        'registrado_por' => $usuario->id,
                        'created_at'     => now(),
                    ]);
                }
            }
            DB::commit();
            return back()->with('success', '✅ Asistencia guardada correctamente para hoy ' . now()->format('d/m/Y') . '.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al guardar asistencia: ' . $e->getMessage());
        }
    }

    /**
     * Guardar nota de un postulante en un grupo.
     */
    public function guardarNota(Request $request, $grupoId)
    {
        $usuario = Auth::user();
        $docente = DB::table('docente')->where('usuario_id', $usuario->id)->firstOrFail();

        $asignado = DB::table('grupo_docente')
            ->where('grupo_id', $grupoId)
            ->where('docente_id', $docente->id)
            ->exists();

        if (!$asignado) abort(403);

        $request->validate([
            'postulante_id'   => 'required|integer|exists:postulante,id',
            'materia_id'      => 'required|integer|exists:materia,id',
            'examen_id'       => 'required|integer|exists:examen,id',
            'calificacion'    => 'required|numeric|min:0|max:100',
            'observaciones'   => 'nullable|string|max:255',
        ]);

        $grupoDb = DB::table('grupo')->where('id', $grupoId)->first();
        if (!$grupoDb) abort(404);

        // Buscar el examen específico usando el examen_id del formulario
        $examen = DB::table('examen')
            ->where('id', $request->examen_id)
            ->where('materia_id', $request->materia_id)
            ->where('convocatoria_id', $grupoDb->convocatoria_id)
            ->first();

        if (!$examen) {
            return back()->with('error', 'No existe el examen configurado para esta materia en la convocatoria actual.');
        }

        DB::beginTransaction();
        try {
            $existe = DB::table('nota')
                ->where('postulante_id', $request->postulante_id)
                ->where('examen_id', $examen->id)
                ->first();

            $score = (float) $request->calificacion;
            $aprobado = $score >= 60;

            if ($existe) {
                DB::table('nota')->where('id', $existe->id)->update([
                    'puntaje'        => $score,
                    'observaciones'  => $request->observaciones,
                    'actualizado_en' => now(),
                ]);
            } else {
                DB::table('nota')->insert([
                    'postulante_id'  => $request->postulante_id,
                    'examen_id'      => $examen->id,
                    'puntaje'        => $score,
                    'observaciones'  => $request->observaciones,
                    'registrado_por' => $usuario->id,
                    'registrado_en'  => now(),
                ]);
            }

            DB::commit();
            return back()->with('success', '✅ Nota registrada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al guardar nota: ' . $e->getMessage());
        }
    }

    /**
     * Crear una nueva tarea para el grupo y materia.
     */
    public function crearTarea(Request $request, $grupoId)
    {
        $usuario = Auth::user();
        $docente = DB::table('docente')->where('usuario_id', $usuario->id)->firstOrFail();

        $request->validate([
            'materia_id'   => 'required|exists:materia,id',
            'titulo'       => 'required|string|max:255',
            'descripcion'  => 'required|string',
            'fecha_limite' => 'required|date',
            'archivo_guia' => 'nullable|file|mimes:pdf,doc,docx,zip,png,jpg,jpeg|max:10240',
        ]);

        $archivoGuiaPath = null;
        if ($request->hasFile('archivo_guia')) {
            $archivoGuiaPath = $request->file('archivo_guia')->store('tareas_guias', 'public');
        }

        DB::table('tarea')->insert([
            'grupo_id'     => $grupoId,
            'materia_id'   => $request->materia_id,
            'docente_id'   => $docente->id,
            'titulo'       => $request->titulo,
            'descripcion'  => $request->descripcion,
            'fecha_limite' => $request->fecha_limite,
            'archivo_guia' => $archivoGuiaPath,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        return back()->with('success', '✅ Tarea/Práctico creado exitosamente.');
    }

    /**
     * Registrar la calificación y retroalimentación de una entrega de tarea.
     */
    public function calificarTarea(Request $request, $grupoId)
    {
        $request->validate([
            'entrega_id'         => 'required|exists:tarea_entrega,id',
            'calificacion'       => 'required|numeric|min:0|max:100',
            'comentario_docente' => 'nullable|string|max:1000',
        ]);

        DB::table('tarea_entrega')
            ->where('id', $request->entrega_id)
            ->update([
                'calificacion'       => $request->calificacion,
                'comentario_docente' => $request->comentario_docente,
                'updated_at'         => now(),
            ]);

        return back()->with('success', '✅ Tarea calificada correctamente.');
    }

    /**
     * Publicar un aviso/anuncio para el grupo.
     */
    public function crearAnuncio(Request $request, $grupoId)
    {
        $usuario = Auth::user();
        $docente = DB::table('docente')->where('usuario_id', $usuario->id)->firstOrFail();

        $request->validate([
            'materia_id' => 'nullable|exists:materia,id',
            'titulo'     => 'required|string|max:255',
            'contenido'  => 'required|string',
        ]);

        DB::table('anuncio')->insert([
            'grupo_id'   => $grupoId,
            'materia_id' => $request->materia_id,
            'docente_id' => $docente->id,
            'titulo'     => $request->titulo,
            'contenido'  => $request->contenido,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', '✅ Anuncio publicado correctamente.');
    }

    /**
     * Enviar mensaje de chat directo a un postulante.
     */
    public function enviarMensaje(Request $request, $grupoId)
    {
        $usuario = Auth::user();

        $request->validate([
            'receptor_id' => 'required|exists:usuario,id',
            'contenido'   => 'required|string',
        ]);

        DB::table('mensaje')->insert([
            'grupo_id'    => $grupoId,
            'emisor_id'   => $usuario->id,
            'receptor_id' => $request->receptor_id,
            'contenido'   => $request->contenido,
            'leido'       => false,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Mensaje enviado.');
    }

    /**
     * Obtener el historial de chat con un postulante.
     */
    public function obtenerMensajes($grupoId, $postulanteId)
    {
        $usuario = Auth::user();
        
        $postulante = DB::table('postulante')->where('id', $postulanteId)->firstOrFail();
        
        // Marcar como leídos los mensajes que envió el estudiante al docente
        DB::table('mensaje')
            ->where('grupo_id', $grupoId)
            ->where('emisor_id', $postulante->usuario_id)
            ->where('receptor_id', $usuario->id)
            ->update(['leido' => true]);

        $mensajes = DB::table('mensaje')
            ->where('grupo_id', $grupoId)
            ->where(function($q) use ($usuario, $postulante) {
                $q->where(function($q1) use ($usuario, $postulante) {
                    $q1->where('emisor_id', $usuario->id)->where('receptor_id', $postulante->usuario_id);
                })->orWhere(function($q2) use ($usuario, $postulante) {
                    $q2->where('emisor_id', $postulante->usuario_id)->where('receptor_id', $usuario->id);
                });
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($mensajes);
    }

    /**
     * Exportar notas en formato CSV compatible con Excel.
     */
    public function exportarNotas($grupoId)
    {
        $grupo = DB::table('grupo')->where('id', $grupoId)->firstOrFail();
        
        $postulantes = DB::table('postulante')
            ->join('grupo_postulante', 'postulante.id', '=', 'grupo_postulante.postulante_id')
            ->where('grupo_postulante.grupo_id', $grupoId)
            ->select('postulante.*')
            ->orderBy('postulante.apellido')
            ->get();

        $usuario = Auth::user();
        $docente = DB::table('docente')->where('usuario_id', $usuario->id)->firstOrFail();

        // Obtener materias que enseña este docente
        $materias = DB::table('competencia_docente')
            ->join('materia', 'competencia_docente.materia_id', '=', 'materia.id')
            ->where('competencia_docente.docente_id', $docente->id)
            ->select('materia.id', 'materia.nombre', 'materia.codigo')
            ->get();

        if ($materias->isEmpty()) {
            $materiaMatch = DB::table('materia')
                ->whereRaw('LOWER(nombre) = ?', [strtolower($docente->especialidad ?? '')])
                ->select('id', 'nombre', 'codigo')
                ->get();
            
            if ($materiaMatch->isNotEmpty()) {
                $materias = $materiaMatch;
            } else {
                $materias = DB::table('materia')->select('id', 'nombre', 'codigo')->get();
            }
        }

        // Obtener materias que enseña este docente (competencias, especialidad o fallback de todas)
        $docenteMateriaIds = $materias->pluck('id')->toArray();

        // También incluir materias asignadas a este docente en el horario del grupo
        $materiasHorario = DB::table('horario_grupo')
            ->where('grupo_id', $grupoId)
            ->where('docente_id', $docente->id)
            ->pluck('materia_id')
            ->toArray();

        $materiasIds = array_unique(array_merge($docenteMateriaIds, $materiasHorario));

        $examenes = DB::table('examen')
            ->whereIn('materia_id', $materiasIds)
            ->where('convocatoria_id', $grupo->convocatoria_id)
            ->orderBy('materia_id')
            ->orderBy('nro_examen')
            ->get();

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=Notas_Grupo_{$grupo->codigo_grupo}.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($postulantes, $materias, $examenes) {
            $file = fopen('php://output', 'w');
            // Añadir el BOM para compatibilidad de caracteres con Excel
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Encabezados
            $headerColumns = ['Código', 'CI', 'Estudiante'];
            foreach ($materias as $m) {
                foreach ($examenes->where('materia_id', $m->id) as $ex) {
                    $headerColumns[] = "{$m->nombre} - Parcial {$ex->nro_examen} ({$ex->porcentaje_peso}%)";
                }
                $headerColumns[] = "Promedio {$m->nombre}";
            }
            $headerColumns[] = 'Promedio General';
            fputcsv($file, $headerColumns, ';');

            foreach ($postulantes as $p) {
                $row = [
                    $p->codigo_estudiante,
                    $p->ci,
                    "{$p->apellido}, {$p->nombre}"
                ];

                $sumGeneral = 0;
                $countGeneral = 0;

                foreach ($materias as $m) {
                    $sumMateria = 0;
                    $countMateria = 0;

                    foreach ($examenes->where('materia_id', $m->id) as $ex) {
                        $nota = DB::table('nota')
                            ->where('postulante_id', $p->id)
                            ->where('examen_id', $ex->id)
                            ->first();

                        $val = $nota ? (float)$nota->puntaje : 0;
                        $row[] = $nota ? $nota->puntaje : '—';
                        
                        $sumMateria += $val;
                        $countMateria++;
                    }

                    $promMateria = $countMateria > 0 ? round($sumMateria / $countMateria, 2) : 0;
                    $row[] = $countMateria > 0 ? $promMateria : '—';

                    $sumGeneral += $promMateria;
                    $countGeneral++;
                }

                $promGeneral = $countGeneral > 0 ? round($sumGeneral / $countGeneral, 2) : 0;
                $row[] = $countGeneral > 0 ? $promGeneral : '—';

                fputcsv($file, $row, ';');
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Exportar asistencia en formato CSV compatible con Excel.
     */
    public function exportarAsistencia($grupoId)
    {
        $grupo = DB::table('grupo')->where('id', $grupoId)->firstOrFail();
        
        $postulantes = DB::table('postulante')
            ->join('grupo_postulante', 'postulante.id', '=', 'grupo_postulante.postulante_id')
            ->where('grupo_postulante.grupo_id', $grupoId)
            ->select('postulante.*')
            ->orderBy('postulante.apellido')
            ->get();

        $horariosIds = DB::table('horario_grupo')
            ->where('grupo_id', $grupoId)
            ->pluck('id');

        // Obtener todas las fechas en las que se registró asistencia para este grupo
        $fechas = DB::table('asistencia')
            ->whereIn('horario_id', $horariosIds)
            ->distinct()
            ->orderBy('fecha', 'asc')
            ->pluck('fecha');

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=Asistencia_Grupo_{$grupo->codigo_grupo}.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($postulantes, $fechas, $horariosIds) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            $headerColumns = ['Código', 'CI', 'Estudiante'];
            foreach ($fechas as $f) {
                $headerColumns[] = \Carbon\Carbon::parse($f)->format('d/m/Y');
            }
            $headerColumns[] = '% Asistencia';
            fputcsv($file, $headerColumns, ';');

            foreach ($postulantes as $p) {
                $row = [
                    $p->codigo_estudiante,
                    $p->ci,
                    "{$p->apellido}, {$p->nombre}"
                ];

                $totalClases = 0;
                $presentes = 0;

                foreach ($fechas as $f) {
                    $asis = DB::table('asistencia')
                        ->where('postulante_id', $p->id)
                        ->whereIn('horario_id', $horariosIds)
                        ->whereDate('fecha', $f)
                        ->first();

                    if ($asis) {
                        $totalClases++;
                        if ($asis->presente) {
                            $presentes++;
                            $row[] = 'PRESENTE';
                        } else {
                            $row[] = $asis->observacion === 'LICENCIA' ? 'LICENCIA' : 'FALTA';
                        }
                    } else {
                        $row[] = '—';
                    }
                }

                $pct = $totalClases > 0 ? round(($presentes / $totalClases) * 100) : 0;
                $row[] = $totalClases > 0 ? "{$pct}%" : '0%';

                fputcsv($file, $row, ';');
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
