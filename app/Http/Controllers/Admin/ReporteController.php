<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    // ── INDEX ──────────────────────────────────────────────────
    public function index(Request $request)
    {
        $stats = [
            'postulantes' => DB::table('postulante')->count(),
            'admitidos'   => DB::table('resultado_final')->where('estado_admision', 'ADMITIDO')->count(),
            'docentes'    => DB::table('docente')->where('activo', true)->count(),
            'grupos'      => DB::table('grupo')->where('activo', true)->count(),
            'examenes'    => DB::table('examen')->count(),
        ];

        $convocatorias = DB::table('convocatoria')->orderByDesc('id')->get();

        $logsQuery = DB::table('log_actividad')->orderByDesc('fecha_hora');
        if ($request->filled('modulo'))    $logsQuery->where('modulo', $request->modulo);
        if ($request->filled('resultado')) $logsQuery->where('resultado', $request->resultado);

        $logs = $logsQuery->paginate(20)->withQueryString();

        return view('admin.reportes.index', compact('stats', 'convocatorias', 'logs'));
    }

    // ── DESCARGAR ───────────────────────────────────────────────
    public function descargar(Request $request)
    {
        $tipo    = $request->tipo;
        $formato = $request->formato ?? 'csv';
        $convId  = $request->conv;

        $datos   = $this->obtenerDatos($tipo, $convId);
        $nombre  = $this->nombreArchivo($tipo);

        return match($formato) {
            'pdf'   => $this->generarPDF($datos, $nombre, $tipo),
            'excel' => $this->generarExcel($datos, $nombre),
            default => $this->generarCSV($datos, $nombre),
        };
    }

    // ── OBTENER DATOS ────────────────────────────────────────────
    private function obtenerDatos(string $tipo, ?string $convId): array
    {
        return match($tipo) {
            'postulantes'         => $this->datosPostulantes($convId),
            'aprobados'           => $this->datosAprobados($convId, true),
            'reprobados'          => $this->datosAprobados($convId, false),
            'promedios'           => $this->datosPromedios($convId),
            'estadisticas_materia'=> $this->datosEstadisticasMateria($convId),
            'ranking'             => $this->datosRanking($convId),
            'grupos'              => $this->datosGrupos($convId),
            'docentes_grupo'      => $this->datosDocentesGrupo($convId),
            'grupo_top'           => $this->datosGrupoTop($convId),
            'log_actividad'       => $this->datosLog(),
            default               => ['headers' => ['Sin datos'], 'rows' => []],
        };
    }

    private function datosPostulantes(?string $convId): array
    {
        $q = DB::table('postulante as p')
            ->leftJoin('convocatoria as c',  'c.id', '=', 'p.convocatoria_id')
            ->leftJoin('carrera as c1',      'c1.id','=', 'p.carrera_pref_1_id')
            ->leftJoin('carrera as c2',      'c2.id','=', 'p.carrera_pref_2_id')
            ->leftJoin('grupo_postulante as gp','gp.postulante_id','=','p.id')
            ->leftJoin('grupo as g',         'g.id', '=', 'gp.grupo_id')
            ->select('p.codigo_estudiante', DB::raw("p.nombre||' '||p.apellido as nombre"),
                'p.ci','p.sexo','p.email','p.telefono','p.ciudad','p.colegio_nombre',
                'c1.nombre as carrera_1','c2.nombre as carrera_2',
                'p.turno_asignado','g.codigo_grupo','p.estado','c.nombre as convocatoria')
            ->orderBy('p.apellido');
        if ($convId) $q->where('p.convocatoria_id', $convId);
        $rows = $q->get()->map(fn($r) => (array)$r)->toArray();
        return [
            'headers' => ['Código','Nombre Completo','CI','Sexo','Email','Teléfono','Ciudad',
                          'Colegio','Carrera 1','Carrera 2','Turno','Grupo','Estado','Convocatoria'],
            'rows' => $rows,
        ];
    }

    private function datosAprobados(?string $convId, bool $aprobado): array
    {
        $q = DB::table('resultado_final as rf')
            ->join('postulante as p',   'p.id',  '=', 'rf.postulante_id')
            ->leftJoin('carrera as ca', 'ca.id', '=', 'rf.carrera_asignada_id')
            ->leftJoin('convocatoria as c','c.id','=', 'rf.convocatoria_id')
            ->select(DB::raw("p.nombre||' '||p.apellido as nombre"), 'p.ci',
                'rf.promedio_mat','rf.promedio_fis','rf.promedio_com','rf.promedio_ing',
                'rf.promedio_total','rf.ranking','ca.nombre as carrera','rf.estado_admision','c.nombre as convocatoria')
            ->where('rf.aprobado_general', $aprobado)
            ->orderByDesc('rf.promedio_total');
        if ($convId) $q->where('rf.convocatoria_id', $convId);
        return [
            'headers' => ['Nombre','CI','MAT','FIS','COM','ING','Promedio Total','Ranking','Carrera','Estado','Convocatoria'],
            'rows' => $q->get()->map(fn($r) => (array)$r)->toArray(),
        ];
    }

    private function datosPromedios(?string $convId): array
    {
        $q = DB::table('resultado_final as rf')
            ->join('postulante as p', 'p.id', '=', 'rf.postulante_id')
            ->leftJoin('convocatoria as c','c.id','=','rf.convocatoria_id')
            ->select(DB::raw("p.nombre||' '||p.apellido as nombre"),'p.ci',
                'rf.promedio_mat','rf.promedio_fis','rf.promedio_com','rf.promedio_ing','rf.promedio_total',
                DB::raw("CASE WHEN rf.aprobado_general THEN 'APROBADO' ELSE 'REPROBADO' END as estado"),
                'c.nombre as convocatoria')
            ->orderByDesc('rf.promedio_total');
        if ($convId) $q->where('rf.convocatoria_id', $convId);
        return [
            'headers' => ['Nombre','CI','MAT','FIS','COM','ING','Promedio Total','Estado','Convocatoria'],
            'rows' => $q->get()->map(fn($r) => (array)$r)->toArray(),
        ];
    }

    private function datosEstadisticasMateria(?string $convId): array
    {
        $q = DB::table('nota as n')
            ->join('examen as e',       'e.id', '=', 'n.examen_id')
            ->join('materia as m',      'm.id', '=', 'e.materia_id')
            ->join('convocatoria as c', 'c.id', '=', 'e.convocatoria_id')
            ->select('m.nombre as materia','c.nombre as convocatoria',
                DB::raw('COUNT(DISTINCT n.postulante_id) as total'),
                DB::raw('COUNT(DISTINCT n.postulante_id) FILTER (WHERE n.aprobado=true) as aprobados'),
                DB::raw('COUNT(DISTINCT n.postulante_id) FILTER (WHERE n.aprobado=false) as reprobados'),
                DB::raw('ROUND(AVG(n.puntaje),2) as promedio'),
                DB::raw('MAX(n.puntaje) as maxima'),
                DB::raw('MIN(n.puntaje) as minima'))
            ->groupBy('m.id','m.nombre','c.id','c.nombre');
        if ($convId) $q->where('e.convocatoria_id', $convId);
        return [
            'headers' => ['Materia','Convocatoria','Total','Aprobados','Reprobados','Promedio','Máxima','Mínima'],
            'rows' => $q->get()->map(fn($r) => (array)$r)->toArray(),
        ];
    }

    private function datosRanking(?string $convId): array
    {
        $q = DB::table('resultado_final as rf')
            ->join('postulante as p',   'p.id',  '=', 'rf.postulante_id')
            ->leftJoin('carrera as ca', 'ca.id', '=', 'rf.carrera_asignada_id')
            ->leftJoin('convocatoria as c','c.id','=','rf.convocatoria_id')
            ->select('rf.ranking', DB::raw("p.nombre||' '||p.apellido as nombre"), 'p.ci',
                'rf.promedio_total','rf.aprobado_general','ca.nombre as carrera',
                'rf.estado_admision','c.nombre as convocatoria')
            ->orderBy('rf.ranking');
        if ($convId) $q->where('rf.convocatoria_id', $convId);
        return [
            'headers' => ['Ranking','Nombre','CI','Promedio Total','Aprobado','Carrera','Estado Admisión','Convocatoria'],
            'rows' => $q->get()->map(fn($r) => (array)$r)->toArray(),
        ];
    }

    private function datosGrupos(?string $convId): array
    {
        $q = DB::table('grupo as g')
            ->join('convocatoria as c', 'c.id', '=', 'g.convocatoria_id')
            ->leftJoin('grupo_postulante as gp', 'gp.grupo_id', '=', 'g.id')
            ->select('g.codigo_grupo','g.turno','g.capacidad','c.nombre as convocatoria',
                DB::raw('COUNT(gp.id) as inscritos'),
                DB::raw('g.capacidad - COUNT(gp.id) as cupos_disponibles'))
            ->groupBy('g.id','g.codigo_grupo','g.turno','g.capacidad','c.nombre')
            ->orderBy('g.turno')->orderBy('g.codigo_grupo');
        if ($convId) $q->where('g.convocatoria_id', $convId);
        return [
            'headers' => ['Grupo','Turno','Capacidad','Inscritos','Cupos Disponibles','Convocatoria'],
            'rows' => $q->get()->map(fn($r) => (array)$r)->toArray(),
        ];
    }

    private function datosDocentesGrupo(?string $convId): array
    {
        $q = DB::table('asignacion_docente as ad')
            ->join('horario_grupo as hg',  'hg.id', '=', 'ad.horario_grupo_id')
            ->join('grupo as g',           'g.id',  '=', 'hg.grupo_id')
            ->join('materia as m',         'm.id',  '=', 'hg.materia_id')
            ->join('docente as d',         'd.id',  '=', 'ad.docente_id')
            ->join('convocatoria as c',    'c.id',  '=', 'g.convocatoria_id')
            ->select('g.codigo_grupo','g.turno','m.nombre as materia',
                DB::raw("d.nombre||' '||d.apellido as docente"),
                'd.grado_academico','hg.dia_semana','hg.hora_inicio','hg.hora_fin','hg.aula','c.nombre as convocatoria')
            ->orderBy('g.codigo_grupo')->orderBy('hg.dia_semana')->orderBy('hg.hora_inicio');
        if ($convId) $q->where('g.convocatoria_id', $convId);
        return [
            'headers' => ['Grupo','Turno','Materia','Docente','Grado Académico','Día','Hora Inicio','Hora Fin','Aula','Convocatoria'],
            'rows' => $q->get()->map(fn($r) => (array)$r)->toArray(),
        ];
    }

    private function datosGrupoTop(?string $convId): array
    {
        $q = DB::table('grupo as g')
            ->join('grupo_postulante as gp', 'gp.grupo_id', '=', 'g.id')
            ->join('postulante as p',        'p.id',         '=', 'gp.postulante_id')
            ->join('resultado_final as rf',  'rf.postulante_id','=','p.id')
            ->join('convocatoria as c',      'c.id',          '=', 'g.convocatoria_id')
            ->select('g.codigo_grupo','g.turno','c.nombre as convocatoria',
                DB::raw('COUNT(*) FILTER (WHERE rf.aprobado_general=true) as aprobados'),
                DB::raw('COUNT(*) as total'),
                DB::raw("ROUND(COUNT(*) FILTER (WHERE rf.aprobado_general=true)::DECIMAL/NULLIF(COUNT(*),0)*100,1)||'%' as pct"))
            ->groupBy('g.id','g.codigo_grupo','g.turno','c.nombre')
            ->orderByDesc('aprobados');
        if ($convId) $q->where('g.convocatoria_id', $convId);
        return [
            'headers' => ['Grupo','Turno','Convocatoria','Aprobados','Total','% Aprobación'],
            'rows' => $q->get()->map(fn($r) => (array)$r)->toArray(),
        ];
    }

    private function datosLog(): array
    {
        $rows = DB::table('log_actividad')->orderByDesc('fecha_hora')->limit(5000)->get()
            ->map(fn($r) => (array)$r)->toArray();
        return [
            'headers' => ['ID','Fecha/Hora','Usuario','Email','Rol','Acción','Descripción','IP','Módulo','Resultado'],
            'rows' => $rows,
        ];
    }

    // ── GENERADORES ──────────────────────────────────────────────
private function generarCSV(array $datos, string $nombre): \Illuminate\Http\Response
{
    ob_start();
    $handle = fopen('php://output', 'w');
    fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

    // Cabecera
    fputcsv($handle, $datos['headers'], ';');

    // Filas
    foreach ($datos['rows'] as $fila) {
        $filaLimpia = array_map(fn($v) => is_null($v) ? '' : (string)$v, array_values((array)$fila));
        fputcsv($handle, $filaLimpia, ';');
    }

    fclose($handle);
    $contenido = ob_get_clean();

    return response($contenido, 200, [
        'Content-Type'        => 'text/csv; charset=UTF-8',
        'Content-Disposition' => 'attachment; filename="' . $nombre . '_' . date('Y-m-d_His') . '.csv"',
        'Cache-Control'       => 'no-store',
    ]);
}

private function generarExcel(array $datos, string $nombre): \Illuminate\Http\Response
{
    ob_start();
    echo '<html xmlns:o="urn:schemas-microsoft-com:office:office">';
    echo '<head><meta charset="UTF-8"></head><body>';
    echo '<table border="1" style="border-collapse:collapse">';

    // Cabecera
    echo '<tr style="background:#1e3a6e;color:#fff;font-weight:bold">';
    foreach ($datos['headers'] as $header) {
        echo '<th style="padding:6px 10px">' . htmlspecialchars((string)$header) . '</th>';
    }
    echo '</tr>';

    // Filas de datos
    foreach ($datos['rows'] as $i => $fila) {
        $bg = $i % 2 === 0 ? '#ffffff' : '#f1f5f9';
        echo '<tr style="background:' . $bg . '">';
        foreach (array_values((array)$fila) as $celda) {
            $valor = is_null($celda) ? '' : (string)$celda;
            echo '<td style="padding:5px 10px">' . htmlspecialchars($valor) . '</td>';
        }
        echo '</tr>';
    }

    echo '</table></body></html>';
    $contenido = ob_get_clean();

    return response($contenido, 200, [
        'Content-Type'        => 'application/vnd.ms-excel; charset=UTF-8',
        'Content-Disposition' => 'attachment; filename="' . $nombre . '_' . date('Y-m-d_His') . '.xls"',
        'Cache-Control'       => 'no-store',
    ]);
}

    private function generarPDF(array $datos, string $nombre, string $tipo): \Illuminate\Http\Response
    {
        $titulo = $this->titulos()[$tipo] ?? $nombre;
        $convocatoria = 'Todas las convocatorias';

        $html  = '<!DOCTYPE html><html><head><meta charset="UTF-8">';
        $html .= '<style>
            body { font-family: Arial, sans-serif; font-size: 11px; color: #1e293b; margin: 20px; }
            h1 { font-size: 16px; color: #1e3a6e; margin-bottom: 4px; }
            .meta { font-size: 11px; color: #64748b; margin-bottom: 16px; border-bottom: 2px solid #1e3a6e; padding-bottom: 8px; }
            table { width: 100%; border-collapse: collapse; margin-top: 10px; }
            th { background: #1e3a6e; color: #fff; padding: 7px 8px; text-align: left; font-size: 10px; }
            td { padding: 6px 8px; border-bottom: 1px solid #f1f5f9; font-size: 10px; }
            tr:nth-child(even) td { background: #f8fafc; }
            .footer { margin-top: 20px; font-size: 10px; color: #94a3b8; text-align: right; }
            .empty { text-align:center; padding: 40px; color: #94a3b8; }
        </style></head><body>';
        $html .= '<h1>'.$titulo.'</h1>';
        $html .= '<div class="meta">CUP — FICCT &nbsp;|&nbsp; '.$convocatoria.' &nbsp;|&nbsp; Generado: '.now()->format('d/m/Y H:i').'</div>';
        $html .= '<table><thead><tr>';
        foreach ($datos['headers'] as $h) $html .= '<th>'.htmlspecialchars($h).'</th>';
        $html .= '</tr></thead><tbody>';
        if (empty($datos['rows'])) {
            $html .= '<tr><td colspan="'.count($datos['headers']).'" class="empty">No hay datos disponibles</td></tr>';
        } else {
            foreach ($datos['rows'] as $row) {
                $html .= '<tr>';
                foreach (array_values($row) as $v) $html .= '<td>'.htmlspecialchars($v ?? '—').'</td>';
                $html .= '</tr>';
            }
        }
        $html .= '</tbody></table>';
        $html .= '<div class="footer">Total: '.count($datos['rows']).' registros</div>';
        $html .= '</body></html>';

        return response($html, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => "attachment; filename=\"{$nombre}.pdf\"",
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    private function nombreArchivo(string $tipo): string
    {
        return ($this->titulos()[$tipo] ?? $tipo).'_'.now()->format('Y-m-d_His');
    }

    private function titulos(): array
    {
        return [
            'postulantes'          => 'Lista_Postulantes',
            'aprobados'            => 'Postulantes_Aprobados',
            'reprobados'           => 'Postulantes_Reprobados',
            'promedios'            => 'Promedios_Generales',
            'estadisticas_materia' => 'Estadisticas_Por_Materia',
            'ranking'              => 'Ranking_Final_Admision',
            'grupos'               => 'Grupos_Habilitados',
            'docentes_grupo'       => 'Docentes_Por_Grupo',
            'grupo_top'            => 'Grupo_Con_Mas_Aprobados',
            'log_actividad'        => 'Log_Actividad',
        ];
    }
}