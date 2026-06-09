<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Docente;
use App\Models\Grupo;
use App\Models\HorarioGrupo;
use App\Models\Materia;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    // Días válidos de la semana
    private const DIAS = [
        'LUNES', 'MARTES', 'MIÉRCOLES', 'JUEVES', 'VIERNES', 'SÁBADO'
    ];

    // =========================================================================
    // INDEX — Lista todos los horarios agrupados por grupo
    // =========================================================================

    public function index(Request $request)
    {
        $grupos   = Grupo::orderBy('codigo_grupo')->get();
        $materias = Materia::orderBy('nombre')->get();
        $docentes = Docente::where('activo', true)->orderBy('apellido')->get();

        // Filtrado por grupo si se selecciona uno
        $grupoFiltro = $request->input('grupo_id');

        $query = HorarioGrupo::with(['grupo', 'materia', 'docente'])
            ->orderByRaw("
                CASE dia_semana
                    WHEN 'LUNES'      THEN 1
                    WHEN 'MARTES'     THEN 2
                    WHEN 'MIÉRCOLES'  THEN 3
                    WHEN 'JUEVES'     THEN 4
                    WHEN 'VIERNES'    THEN 5
                    WHEN 'SÁBADO'     THEN 6
                    ELSE 7
                END
            ")
            ->orderBy('hora_inicio');

        if ($grupoFiltro) {
            $query->where('grupo_id', $grupoFiltro);
        }

        $horarios = $query->get();

        return view('admin.horarios.index', compact(
            'grupos', 'materias', 'docentes', 'horarios', 'grupoFiltro'
        ));
    }

    // =========================================================================
    // STORE — Crear nuevo horario
    // =========================================================================

    public function store(Request $request)
    {
        $data = $request->validate([
            'grupo_id'    => 'required|exists:grupo,id',
            'materia_id'  => 'required|exists:materia,id',
            'docente_id'  => 'nullable|exists:docente,id',
            'dia_semana'  => 'required|in:LUNES,MARTES,MIÉRCOLES,JUEVES,VIERNES,SÁBADO',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin'    => 'required|date_format:H:i|after:hora_inicio',
            'aula'        => 'nullable|string|max:60',
        ], [
            'hora_fin.after'         => 'La hora de fin debe ser posterior a la hora de inicio.',
            'dia_semana.in'          => 'El día seleccionado no es válido.',
            'grupo_id.exists'        => 'El grupo seleccionado no existe.',
            'materia_id.exists'      => 'La materia seleccionada no existe.',
        ]);

        // Verificar conflictos
        $conflicto = $this->detectarConflicto(
            $data['grupo_id'],
            $data['docente_id'] ?? null,
            $data['aula'] ?? null,
            $data['dia_semana'],
            $data['hora_inicio'],
            $data['hora_fin']
        );

        if ($conflicto) {
            return back()->withInput()->with('error', $conflicto);
        }

        HorarioGrupo::create($data);

        return redirect()->route('admin.horarios.index', ['grupo_id' => $data['grupo_id']])
            ->with('success', 'Horario registrado correctamente.');
    }

    // =========================================================================
    // UPDATE — Editar un horario existente
    // =========================================================================

    public function update(Request $request, int $id)
    {
        $horario = HorarioGrupo::findOrFail($id);

        $data = $request->validate([
            'grupo_id'    => 'required|exists:grupo,id',
            'materia_id'  => 'required|exists:materia,id',
            'docente_id'  => 'nullable|exists:docente,id',
            'dia_semana'  => 'required|in:LUNES,MARTES,MIÉRCOLES,JUEVES,VIERNES,SÁBADO',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin'    => 'required|date_format:H:i|after:hora_inicio',
            'aula'        => 'nullable|string|max:60',
        ], [
            'hora_fin.after' => 'La hora de fin debe ser posterior a la hora de inicio.',
            'dia_semana.in'  => 'El día seleccionado no es válido.',
        ]);

        // Verificar conflictos excluyendo el registro actual
        $conflicto = $this->detectarConflicto(
            $data['grupo_id'],
            $data['docente_id'] ?? null,
            $data['aula'] ?? null,
            $data['dia_semana'],
            $data['hora_inicio'],
            $data['hora_fin'],
            $horario->id   // excluir el horario que se está editando
        );

        if ($conflicto) {
            return back()->withInput()->with('error', $conflicto);
        }

        $horario->update($data);

        return redirect()->route('admin.horarios.index', ['grupo_id' => $data['grupo_id']])
            ->with('success', 'Horario actualizado correctamente.');
    }

    // =========================================================================
    // DESTROY — Eliminar un horario
    // =========================================================================

    public function destroy(Request $request, int $id)
    {
        $horario = HorarioGrupo::findOrFail($id);
        $horario->delete();

        // Redirigir preservando el filtro de grupo que el usuario tenía activo.
        // Si venía sin filtro (viendo todos), vuelve a ver todos.
        $grupoFiltro = $request->input('_grupo_filtro');
        $params = $grupoFiltro ? ['grupo_id' => $grupoFiltro] : [];

        return redirect()->route('admin.horarios.index', $params)
            ->with('success', 'Horario eliminado correctamente.');
    }

    // =========================================================================
    // DETECCIÓN DE CONFLICTOS (privado)
    // =========================================================================

    /**
     * Verifica si existe un choque de horario con el nuevo bloque propuesto.
     *
     * Se verifican tres tipos de conflictos:
     *  1. Mismo GRUPO en el mismo día con un bloque que se traslapa.
     *  2. Mismo DOCENTE en el mismo día con un bloque que se traslapa.
     *  3. Misma AULA en el mismo día con un bloque que se traslapa.
     *
     * La condición de traslape es:   hora_inicio_existente < hora_fin_nueva
     *                           AND  hora_fin_existente    > hora_inicio_nueva
     *
     * @param  int         $grupoId
     * @param  int|null    $docenteId
     * @param  string|null $aula
     * @param  string      $dia
     * @param  string      $horaInicio  Formato H:i
     * @param  string      $horaFin     Formato H:i
     * @param  int|null    $excluirId   ID del horario a excluir (al editar)
     * @return string|null  Mensaje de error o null si no hay conflicto
     */
    private function detectarConflicto(
        int $grupoId,
        ?int $docenteId,
        ?string $aula,
        string $dia,
        string $horaInicio,
        string $horaFin,
        ?int $excluirId = null
    ): ?string {

        // Base query para traslape de tiempo
        $baseQuery = function () use ($dia, $horaInicio, $horaFin, $excluirId) {
            $q = HorarioGrupo::where('dia_semana', $dia)
                ->where('hora_inicio', '<', $horaFin)
                ->where('hora_fin', '>', $horaInicio);
            if ($excluirId) {
                $q->where('id', '!=', $excluirId);
            }
            return $q;
        };

        // 1. Conflicto de GRUPO
        $conflictoGrupo = (clone $baseQuery())->where('grupo_id', $grupoId)->first();
        if ($conflictoGrupo) {
            $mat = $conflictoGrupo->materia->nombre ?? 'otra materia';
            $rango = substr($conflictoGrupo->hora_inicio, 0, 5) . '–' . substr($conflictoGrupo->hora_fin, 0, 5);
            return "⚠️ Choque de Grupo: El grupo ya tiene clase de «{$mat}» el {$dia} de {$rango}.";
        }

        // 2. Conflicto de DOCENTE
        if ($docenteId) {
            $conflictoDocente = (clone $baseQuery())->where('docente_id', $docenteId)->first();
            if ($conflictoDocente) {
                $grp = $conflictoDocente->grupo->codigo_grupo ?? '?';
                $mat = $conflictoDocente->materia->nombre ?? 'otra materia';
                $rango = substr($conflictoDocente->hora_inicio, 0, 5) . '–' . substr($conflictoDocente->hora_fin, 0, 5);
                return "⚠️ Choque de Docente: El docente ya está asignado al grupo {$grp} en «{$mat}» el {$dia} de {$rango}.";
            }
        }

        // 3. Conflicto de AULA
        if (!empty($aula)) {
            $conflictoAula = (clone $baseQuery())->where('aula', $aula)->first();
            if ($conflictoAula) {
                $grp = $conflictoAula->grupo->codigo_grupo ?? '?';
                $mat = $conflictoAula->materia->nombre ?? 'otra materia';
                $rango = substr($conflictoAula->hora_inicio, 0, 5) . '–' . substr($conflictoAula->hora_fin, 0, 5);
                return "⚠️ Choque de Aula: El aula «{$aula}» ya está ocupada por el grupo {$grp} en «{$mat}» el {$dia} de {$rango}.";
            }
        }

        return null;
    }
}
