<?php

namespace App\Http\Controllers\Postulante;

use App\Http\Controllers\Controller;
use App\Models\Postulante;
use App\Models\ResultadoFinal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $usuario    = Auth::user();
        $postulante = Postulante::where('usuario_id', $usuario->id)->first();

        if (!$postulante) {
            return view('postulante.sin-postulante');
        }

        $postulante->load([
            'convocatoria',
            'carreraPref1',
            'carreraPref2',
            'resultadoFinal.carreraAsignada',
            'grupoPostulante.grupo',
        ]);

        $resultado = $postulante->resultadoFinal;
        $estado = 'PROCESO';
        if ($resultado && $resultado->estado_admision !== 'PROCESO') {
            $estado = $resultado->estado_admision;
        }

        $notas      = $postulante->notas()->get();
        $promedio   = $postulante->calcularPromedio();

        // Si el estudiante reprueba al menos un examen tomado, se le considera REPROBADO
        $hasFailedExam = $notas->contains(function ($n) {
            return $n->puntaje < 60;
        });

        if ($hasFailedExam) {
            $estado = 'REPROBADO';
        }

        $estadisticas = [
            'grupo'            => $postulante->grupoPostulante?->grupo,
            'notas_registradas'=> $notas->count(),
            'promedio'         => $promedio,
            'estado'           => $estado,
            'carrera_asignada' => $resultado?->carreraAsignada,
            'posicion_ranking' => $resultado?->ranking,
            'reprobo_examen'   => $hasFailedExam,
        ];

        return view('postulante.dashboard', compact('postulante', 'resultado', 'estadisticas'));
    }

    public function verNotas()
    {
        $usuario    = Auth::user();
        $postulante = Postulante::where('usuario_id', $usuario->id)->firstOrFail();

        $notasRaw = DB::table('nota as n')
            ->join('examen as e', 'e.id', '=', 'n.examen_id')
            ->join('materia as m', 'm.id', '=', 'e.materia_id')
            ->leftJoin('usuario as u', 'u.id', '=', 'n.registrado_por')
            ->leftJoin('docente as d', 'd.usuario_id', '=', 'u.id')
            ->where('n.postulante_id', $postulante->id)
            ->select(
                'n.id',
                'n.puntaje as calificacion',
                'n.registrado_en as created_at',
                'e.nro_examen',
                'm.id as materia_id',
                'm.nombre as materia_nombre',
                'd.nombre as docente_nombre',
                'd.apellido as docente_apellido',
                'n.observaciones'
            )
            ->orderBy('m.id')
            ->orderBy('e.nro_examen')
            ->get();

        $notas = $notasRaw->map(function ($n) {
            $n->materia = (object) [
                'id' => $n->materia_id,
                'nombre' => $n->materia_nombre,
            ];
            $n->docente = $n->docente_nombre ? (object) [
                'nombre' => $n->docente_nombre,
                'apellido' => $n->docente_apellido,
            ] : null;
            $n->created_at = $n->created_at ? \Carbon\Carbon::parse($n->created_at) : null;
            return $n;
        })->groupBy('materia_id');

        return view('postulante.notas', compact('postulante', 'notas'));
    }

    public function verGrupo()
    {
        $usuario    = Auth::user();
        $postulante = Postulante::where('usuario_id', $usuario->id)->firstOrFail();

        $grupo = $postulante->grupoPostulante?->grupo;

        if (!$grupo) {
            return view('postulante.sin-grupo');
        }

        $grupo->load('docentes', 'materias');

        if ($grupo->materias->isEmpty()) {
            $grupo->setRelation('materias', \App\Models\Materia::orderBy('id')->get());
        }

        return view('postulante.grupo', compact('postulante', 'grupo'));
    }

    public function verHorario()
    {
        $usuario    = Auth::user();
        $postulante = Postulante::where('usuario_id', $usuario->id)->firstOrFail();

        $grupo = DB::table('grupo_postulante as gp')
            ->join('grupo as g', 'g.id', '=', 'gp.grupo_id')
            ->where('gp.postulante_id', $postulante->id)
            ->select('g.*')
            ->first();

        $horarios = collect();

        if ($grupo) {
            $horarios = DB::table('horario_grupo as hg')
                ->join('materia as m', 'm.id', '=', 'hg.materia_id')
                ->leftJoin('asignacion_docente as ad', 'ad.horario_grupo_id', '=', 'hg.id')
                ->leftJoin('docente as d', 'd.id', '=', 'ad.docente_id')
                ->where('hg.grupo_id', $grupo->id)
                ->select(
                    'hg.id', 'hg.dia_semana', 'hg.hora_inicio', 'hg.hora_fin', 'hg.aula',
                    'm.nombre as materia', 'm.codigo as materia_codigo',
                    DB::raw("COALESCE(d.nombre || ' ' || d.apellido, 'Sin asignar') as docente"),
                    'd.especialidad'
                )
                ->orderByRaw("CASE hg.dia_semana
                    WHEN 'LUNES'     THEN 1
                    WHEN 'MARTES'    THEN 2
                    WHEN 'MIERCOLES' THEN 3
                    WHEN 'JUEVES'    THEN 4
                    WHEN 'VIERNES'   THEN 5
                    WHEN 'SABADO'    THEN 6
                    END")
                ->orderBy('hg.hora_inicio')
                ->get()
                ->groupBy('dia_semana');
        }

        return view('postulante.horario', compact('postulante', 'grupo', 'horarios'));
    }
}