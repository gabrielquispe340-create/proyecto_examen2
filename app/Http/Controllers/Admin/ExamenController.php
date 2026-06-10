<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamenController extends Controller
{
    // ────────────────────────────────────────────
    // INDEX
    // ────────────────────────────────────────────
    public function index(Request $request)
    {
        $totalExamenes  = DB::table('examen')->count();
        $totalInscritos = DB::table('postulante')->count();

        // Calcular conteos por estado basado en la columna estado de la BD
        $programados  = DB::table('examen')->where('estado', 'PROGRAMADO')->count();
        $finalizados  = DB::table('examen')->where('estado', 'FINALIZADO')->count();
        $enDesarrollo = DB::table('examen')->where('estado', 'EN_DESARROLLO')->count();
        $cancelados   = DB::table('examen')->where('estado', 'CANCELADO')->count();

        $convocatorias = DB::table('convocatoria')->orderByDesc('id')->get();
        $materias      = DB::table('materia')->orderBy('nombre')->get();

        $query = DB::table('examen as e')
            ->leftJoin('convocatoria as c', 'c.id', '=', 'e.convocatoria_id')
            ->leftJoin('materia as m', 'm.id', '=', 'e.materia_id')
            ->select(
                'e.id',
                DB::raw("m.nombre || ' — Examen ' || e.nro_examen AS nombre"),
                'e.fecha', 'e.hora', 'e.tipo', 'e.nro_examen', 'e.porcentaje_peso', 'e.convocatoria_id',
                'c.nombre AS convocatoria_nombre',
                'c.estado  AS conv_estado',
                'm.nombre  AS materia_nombre',
                'e.estado',
                DB::raw("(SELECT COUNT(DISTINCT gp.postulante_id) FROM grupo_postulante gp INNER JOIN grupo g ON g.id = gp.grupo_id WHERE g.convocatoria_id = e.convocatoria_id) AS inscritos"),
                DB::raw("(SELECT COUNT(*) FROM nota n WHERE n.examen_id = e.id) AS total_notas"),
                DB::raw("(SELECT COUNT(*) FROM nota n WHERE n.examen_id = e.id AND n.puntaje >= 60) AS aprobados"),
                DB::raw("(SELECT COUNT(*) FROM nota n WHERE n.examen_id = e.id AND n.puntaje < 60) AS reprobados"),
                DB::raw("(SELECT ROUND(AVG(n.puntaje), 2) FROM nota n WHERE n.examen_id = e.id) AS promedio")
            );

        if ($request->filled('buscar')) {
            $query->where(function ($q) use ($request) {
                $q->whereRaw("m.nombre ILIKE ?", ['%'.$request->buscar.'%'])
                  ->orWhereRaw("c.nombre ILIKE ?", ['%'.$request->buscar.'%']);
            });
        }
        if ($request->filled('convocatoria_id')) {
            $query->where('e.convocatoria_id', $request->convocatoria_id);
        }
        if ($request->filled('fecha_desde')) {
            $query->where('e.fecha', '>=', $request->fecha_desde);
        }
        if ($request->filled('fecha_hasta')) {
            $query->where('e.fecha', '<=', $request->fecha_hasta);
        }
        if ($request->filled('estado')) {
            $query->where('e.estado', $request->estado);
        }
        if ($request->filled('tab')) {
            $tabEstado = match ($request->tab) {
                'programados' => 'PROGRAMADO',
                'desarrollo'  => 'EN_DESARROLLO',
                'finalizados' => 'FINALIZADO',
                'cancelados'  => 'CANCELADO',
                default       => null,
            };
            if ($tabEstado) {
                $query->where('e.estado', $tabEstado);
            }
        }

        $examenes = $query->orderByDesc('e.fecha')->orderBy('e.nro_examen')
                          ->paginate(15)->withQueryString();

        $examenes->getCollection()->transform(function ($e) {
            $e->convocatoria = (object)[
                'nombre' => $e->convocatoria_nombre,
                'estado' => $e->conv_estado,
            ];
            return $e;
        });

        $proximos = DB::table('examen as e')
            ->leftJoin('convocatoria as c', 'c.id', '=', 'e.convocatoria_id')
            ->leftJoin('materia as m', 'm.id', '=', 'e.materia_id')
            ->select('e.id', 'e.fecha', 'e.hora',
                DB::raw("m.nombre || ' — Examen ' || e.nro_examen AS nombre"),
                DB::raw("(SELECT COUNT(DISTINCT gp.postulante_id) FROM grupo_postulante gp INNER JOIN grupo g ON g.id = gp.grupo_id WHERE g.convocatoria_id = e.convocatoria_id) AS inscritos"))
            ->whereNotNull('e.fecha')
            ->where('e.fecha', '>=', now()->toDateString())
            ->orderBy('e.fecha')
            ->limit(3)->get();

        return view('admin.examenes.index', compact(
            'examenes', 'convocatorias', 'materias', 'proximos',
            'totalExamenes', 'programados', 'enDesarrollo',
            'finalizados', 'cancelados', 'totalInscritos'
        ));
    }

    // ────────────────────────────────────────────
    // STORE — Crear nuevo examen
    // ────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'convocatoria_id' => 'required|exists:convocatoria,id',
            'materia_id'      => 'required|exists:materia,id',
            'nro_examen'      => 'required|in:1,2,3',
            'fecha'           => 'nullable|date',
        ], [
            'convocatoria_id.required' => 'Selecciona una convocatoria.',
            'materia_id.required'      => 'Selecciona una materia.',
            'nro_examen.required'      => 'Selecciona el número de examen.',
            'fecha.date'               => 'La fecha no tiene un formato válido.',
        ]);

        // Verificar duplicado (constraint UNIQUE de la BD)
        $existe = DB::table('examen')
            ->where('materia_id', $request->materia_id)
            ->where('convocatoria_id', $request->convocatoria_id)
            ->where('nro_examen', $request->nro_examen)
            ->exists();

        if ($existe) {
            return back()
                ->withErrors(['nro_examen' => 'Ya existe el Examen '.$request->nro_examen.' para esa materia y convocatoria.'])
                ->withInput();
        }

        $pesos = [1 => 30, 2 => 30, 3 => 40];

        DB::table('examen')->insert([
            'materia_id'      => $request->materia_id,
            'convocatoria_id' => $request->convocatoria_id,
            'nro_examen'      => (int) $request->nro_examen,
            'fecha'           => $request->filled('fecha') ? $request->fecha : null,
            'porcentaje_peso' => $pesos[$request->nro_examen],
        ]);

        return redirect()->route('admin.examenes.index')
                         ->with('success', '✓ Examen creado correctamente.');
    }

    // ────────────────────────────────────────────
    // IMPORTAR — CSV con resultados
    // ────────────────────────────────────────────
   public function importar(Request $request)
{
    set_time_limit(0);
    ini_set('max_execution_time', 0);

    $request->validate([
        'examen_id' => 'required|exists:examen,id',
        'archivo'   => 'required|file|mimes:csv,txt|max:5120',
    ], [
        'examen_id.required' => 'Selecciona el examen destino.',
        'archivo.required'   => 'Adjunta un archivo CSV.',
        'archivo.mimes'      => 'El archivo debe ser .csv',
    ]);

    $adminId  = auth()->id();
    $archivo  = $request->file('archivo');
    $exitosos = 0;
    $fallidos = 0;
    $errores  = [];

    // Cargar TODOS los postulantes de una sola vez
    $postulantes = DB::table('postulante')
        ->select('id', 'codigo_estudiante', 'ci')
        ->get()
        ->keyBy('codigo_estudiante');

    $porCi = DB::table('postulante')
        ->select('id', 'codigo_estudiante', 'ci')
        ->get()
        ->keyBy('ci');

    if (($handle = fopen($archivo->getRealPath(), 'r')) !== false) {
        $firstLine  = fgets($handle);
        $delimiter  = ',';
        $semicolons = substr_count($firstLine, ';');
        $commas     = substr_count($firstLine, ',');
        $tabs       = substr_count($firstLine, "\t");

        if ($semicolons > $commas && $semicolons > $tabs) $delimiter = ';';
        elseif ($tabs > $commas && $tabs > $semicolons)   $delimiter = "\t";

        rewind($handle);

        $insertar   = [];
        $ahora      = now();
        $fila       = 0;

        while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
            $fila++;
            if ($fila === 1) continue;

            $codigo  = trim($row[0] ?? '');
            if (str_starts_with($codigo, "\xef\xbb\xbf")) $codigo = substr($codigo, 3);
            $codigo  = trim($codigo);
            $puntaje = trim($row[1] ?? '');

            if ($codigo === '' && $puntaje === '') continue;

            if ($codigo === '' || !is_numeric($puntaje)) {
                $fallidos++;
                $errores[] = "Fila $fila: datos inválidos.";
                continue;
            }

            $postulante = $postulantes[$codigo] ?? $porCi[$codigo] ?? null;

            if (!$postulante) {
                $fallidos++;
                $errores[] = "Fila $fila: código '$codigo' no encontrado.";
                continue;
            }

            $insertar[] = [
                'postulante_id'  => $postulante->id,
                'examen_id'      => $request->examen_id,
                'puntaje'        => min(100, max(0, (float)$puntaje)),
                'registrado_por' => $adminId,
                'registrado_en'  => $ahora,
                'actualizado_en' => $ahora,
            ];
            $exitosos++;
        }
        fclose($handle);

        // Un solo INSERT para todos los registros
        if (!empty($insertar)) {
            foreach (array_chunk($insertar, 50) as $chunk) {
                DB::table('nota')->upsert(
                    $chunk,
                    ['postulante_id', 'examen_id'],
                    ['puntaje', 'registrado_por', 'actualizado_en']
                );
            }
        }
    }

    $msg = "Importación completada: $exitosos registros exitosos";
    if ($fallidos > 0) {
        $msg .= ", $fallidos fallidos.";
        if (!empty($errores)) {
            $msg .= " Errores: " . implode(' | ', array_slice($errores, 0, 3));
        }
    }

    return redirect()->route('admin.examenes.index')
                     ->with($fallidos > 0 ? 'error' : 'success', $msg);
}

    // ────────────────────────────────────────────
    // REPORTE — Genera CSV general de exámenes
    // ────────────────────────────────────────────
    public function reporte(Request $request)
    {
        $query = DB::table('examen as e')
            ->leftJoin('convocatoria as c', 'c.id', '=', 'e.convocatoria_id')
            ->leftJoin('materia as m', 'm.id', '=', 'e.materia_id')
            ->select(
                DB::raw("m.nombre || ' — Examen ' || e.nro_examen AS nombre_examen"),
                'c.nombre AS convocatoria',
                'm.nombre AS materia',
                'e.nro_examen',
                'e.porcentaje_peso',
                'e.fecha',
                DB::raw('(SELECT COUNT(*) FROM nota n WHERE n.examen_id = e.id) AS total_notas'),
                DB::raw('(SELECT ROUND(AVG(n.puntaje),2) FROM nota n WHERE n.examen_id = e.id) AS promedio'),
                DB::raw('(SELECT COUNT(*) FROM nota n WHERE n.examen_id = e.id AND n.aprobado = true) AS aprobados')
            );

        if ($request->filled('convocatoria_id')) {
            $query->where('e.convocatoria_id', $request->convocatoria_id);
        }

        $datos = $query->orderByDesc('e.fecha')->orderBy('e.nro_examen')->get();

        $filename = 'reporte_examenes_' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($datos) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM UTF-8
            fputcsv($handle, ['Examen','Convocatoria','Materia','N° Examen','Peso (%)','Fecha','Total Notas','Promedio','Aprobados']);
            foreach ($datos as $row) {
                fputcsv($handle, [
                    $row->nombre_examen,
                    $row->convocatoria ?? '—',
                    $row->materia      ?? '—',
                    $row->nro_examen,
                    $row->porcentaje_peso.'%',
                    $row->fecha        ?? '—',
                    $row->total_notas,
                    $row->promedio     ?? '0.00',
                    $row->aprobados,
                ]);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ────────────────────────────────────────────
    // UPDATE — Actualizar examen
    // ────────────────────────────────────────────
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'fecha'  => 'nullable|date_format:Y-m-d',
            'hora'   => 'nullable|date_format:H:i',
            'tipo'   => 'nullable|in:PRESENCIAL,VIRTUAL',
            'estado' => 'nullable|in:PROGRAMADO,EN_DESARROLLO,FINALIZADO,CANCELADO',
        ], [
            'fecha.date_format' => 'La fecha debe estar en formato YYYY-MM-DD',
            'hora.date_format'  => 'La hora debe estar en formato HH:MM',
            'tipo.in'           => 'El tipo debe ser PRESENCIAL o VIRTUAL',
            'estado.in'         => 'El estado debe ser PROGRAMADO, EN_DESARROLLO, FINALIZADO o CANCELADO',
        ]);

        $examen = DB::table('examen')->find($id);
        if (!$examen) {
            return back()->with('error', 'Examen no encontrado.');
        }

        $updateData = [];
        if ($request->filled('fecha')) {
            $updateData['fecha'] = $request->fecha;
        }
        if ($request->filled('hora')) {
            $updateData['hora'] = $request->hora;
        }
        if ($request->filled('tipo')) {
            $updateData['tipo'] = $request->tipo;
        }
        if ($request->has('estado')) {
            $updateData['estado'] = $request->estado;
        }

        if (!empty($updateData)) {
            DB::table('examen')->where('id', $id)->update($updateData);
            return back()->with('success', '✓ Examen actualizado correctamente.');
        }
        return back()->with('info', 'No hay cambios para guardar.');
    }

    // ────────────────────────────────────────────
    // DESTROY — Eliminar examen
    // ────────────────────────────────────────────
    public function destroy($id)
    {
        $examen = DB::table('examen')->find($id);

        if (!$examen) {
            return back()->with('error', 'Examen no encontrado.');
        }

        // Eliminar notas asociadas primero (integridad referencial)
        DB::table('nota')->where('examen_id', $id)->delete();

        // Eliminar el examen
        DB::table('examen')->where('id', $id)->delete();

        return redirect()->route('admin.examenes.index')
                         ->with('success', '✓ Examen eliminado correctamente.');
    }
}
