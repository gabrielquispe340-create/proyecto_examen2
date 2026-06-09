<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Grupo;
use App\Models\Convocatoria;
use App\Models\Postulante;
use App\Models\Docente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * GrupoController
 *
 * Controlador responsable de gestionar los grupos académicos del CUP.
 * Cubre los casos de uso:
 *   - CU12: Listar grupos, asignar/desasignar postulantes APROBADOS y docentes ACTIVOS.
 *   - CU13: Consultar docentes por grupo (endpoint API).
 *   - Generar grupos automáticamente para una convocatoria.
 *   - Limpiar (eliminar) todos los grupos de una convocatoria.
 *   - Distribución automática de postulantes en grupos disponibles.
 *
 * Reglas de negocio clave:
 *   - Solo pueden asignarse postulantes con estado "APROBADO".
 *   - Solo pueden asignarse docentes con estado "ACTIVO".
 *   - La capacidad máxima por grupo es de 70 estudiantes (reglamento CUP).
 *   - Un postulante solo puede pertenecer a un grupo por convocatoria.
 */
class GrupoController extends Controller
{
    // =========================================================================
    // LISTADO Y DETALLE
    // =========================================================================

    /**
     * CU12 — Listar los grupos de una convocatoria.
     *
     * Muestra la pantalla principal de gestión de grupos. Si se pasa
     * el parámetro "convocatoria_id" en la URL, carga esa convocatoria;
     * de lo contrario, busca automáticamente la convocatoria con estado
     * "ACTIVA". Junto con los grupos, carga sus postulantes y docentes
     * relacionados para mostrar estadísticas en la vista.
     *
     * @param  Request $request  Objeto HTTP con posible query param "convocatoria_id".
     * @return \Illuminate\View\View  Vista "admin.grupos.index" con los grupos y convocatorias.
     */
    public function index(Request $request)
    {
        // Leer el filtro de convocatoria desde la URL (?convocatoria_id=X)
        $convocatoriaId = $request->query('convocatoria_id');

        if ($convocatoriaId) {
            // Si se especificó una convocatoria concreta, cargarla junto con sus grupos
            $convocatoria = Convocatoria::findOrFail($convocatoriaId);
            $grupos = $convocatoria->grupos()->with(['postulantes', 'docentes'])->get();
        } else {
            // Si no se filtró, mostrar la convocatoria que esté en estado ACTIVA
            $convocatoria = Convocatoria::where('estado', 'ACTIVA')->first();
            $grupos = $convocatoria ? $convocatoria->grupos()->with(['postulantes', 'docentes'])->get() : collect([]);
        }

        // Obtener todas las convocatorias ACTIVAS o PLANIFICADAS para el selector del header
        $convocatorias = Convocatoria::whereIn('estado', ['ACTIVA', 'PLANIFICADA'])->get();

        return view('admin.grupos.index', compact('grupos', 'convocatoria', 'convocatorias', 'convocatoriaId'));
    }

    /**
     * CU12 — Mostrar el detalle de un grupo con sus postulantes y docentes asignados.
     *
     * Carga toda la información del grupo para la vista de gestión individual:
     *   - Lista de postulantes ya asignados al grupo.
     *   - Lista de postulantes APROBADOS de la convocatoria que AÚN no tienen grupo
     *     (disponibles para asignar).
     *   - Lista de docentes ACTIVOS que no están asignados todavía a este grupo.
     *   - Estadísticas globales de la convocatoria: total de aprobados y cuántos
     *     ya tienen grupo asignado.
     *
     * @param  Grupo $grupo  Instancia del grupo resuelto por Route Model Binding.
     * @return \Illuminate\View\View  Vista "admin.grupos.show" con todos los datos necesarios.
     */
    public function show(Grupo $grupo)
    {
        // Cargar relaciones del grupo para evitar N+1 queries en la vista
        $grupo->load(['postulantes', 'docentes', 'convocatoria']);

        // Obtener todos los IDs de postulantes que ya tienen algún grupo en toda la BD,
        // para excluirlos de la lista de disponibles (un postulante solo va a un grupo)
        $postulanteYaAsignados = DB::table('grupo_postulante')->pluck('postulante_id');

        // Postulantes disponibles: deben ser APROBADOS, pertenecer a esta convocatoria
        // y no tener grupo asignado aún. Se ordenan alfabéticamente.
        $postulantesSinGrupo = Postulante::where('convocatoria_id', $grupo->convocatoria_id)
            ->where('estado', 'APROBADO')
            ->whereNotIn('id', $postulanteYaAsignados)
            ->orderBy('apellido')
            ->orderBy('nombre')
            ->get();

        // Docentes disponibles: deben estar ACTIVOS, no estar ya en este grupo
        // y no haber alcanzado el límite máximo de 4 grupos en esta convocatoria.
        $MAX_GRUPOS_DOCENTE = 4;
        $gruposConvocatoriaIds = $convocatoriaGruposIds = DB::table('grupo')
            ->where('convocatoria_id', $grupo->convocatoria_id)
            ->pluck('id');

        // IDs de docentes que ya alcanzaron el límite de 4 grupos en esta convocatoria
        $docentesConLimiteAlcanzado = DB::table('grupo_docente')
            ->whereIn('grupo_id', $gruposConvocatoriaIds)
            ->select('docente_id', DB::raw('COUNT(*) as total_grupos'))
            ->groupBy('docente_id')
            ->havingRaw('COUNT(*) >= ?', [$MAX_GRUPOS_DOCENTE])
            ->pluck('docente_id');

        $docentesDisponibles = Docente::where('activo', true)
            ->whereNotIn('id', $grupo->docentes()->pluck('docente_id'))
            ->whereNotIn('id', $docentesConLimiteAlcanzado)
            ->orderBy('apellido')
            ->orderBy('nombre')
            ->get();

        // Estadística 1: total de postulantes APROBADOS en esta convocatoria
        $totalAprobados = Postulante::where('convocatoria_id', $grupo->convocatoria_id)
            ->where('estado', 'APROBADO')->count();

        // Estadística 2: cuántos de esos aprobados ya tienen grupo en esta convocatoria
        $totalAsignados = DB::table('grupo_postulante')
            ->join('grupo', 'grupo.id', '=', 'grupo_postulante.grupo_id')
            ->where('grupo.convocatoria_id', $grupo->convocatoria_id)
            ->count();

        return view('admin.grupos.show', compact(
            'grupo',
            'postulantesSinGrupo',
            'docentesDisponibles',
            'totalAprobados',
            'totalAsignados'
        ));
    }

    // =========================================================================
    // ASIGNACIÓN DE POSTULANTES
    // =========================================================================

    /**
     * CU12 — Asignar un postulante APROBADO a un grupo.
     *
     * Realiza todas las validaciones del caso de uso antes de persistir la asignación:
     *   1. El campo postulante_id debe existir en la tabla "postulante".
     *   2. El postulante debe tener estado "APROBADO" (precondición del CU).
     *   3. El postulante debe pertenecer a la misma convocatoria que el grupo.
     *   4. El postulante NO debe estar ya asignado a ningún otro grupo.
     *   5. El grupo no debe haber superado la capacidad máxima permitida (mín entre
     *      capacidad_maxima del grupo y el límite reglamentario de 70 estudiantes).
     * Si todas las validaciones pasan, se crea la relación en "grupo_postulante"
     * y se registra la acción en el log de actividad.
     *
     * @param  Request $request  Contiene "postulante_id" (integer, requerido).
     * @param  Grupo   $grupo    Grupo destino resuelto por Route Model Binding.
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     *         Redirige con mensaje de éxito/error, o JSON si la petición lo pide.
     */
    public function asignarPostulante(Request $request, Grupo $grupo)
    {
        // Validar que se envió un ID de postulante existente en la BD
        $validated = $request->validate([
            'postulante_id' => 'required|exists:postulante,id',
        ]);

        // Cargar el postulante para acceder a sus atributos (estado, convocatoria_id, etc.)
        $postulante = Postulante::findOrFail($validated['postulante_id']);

        // Regla 1: El postulante debe estar activo para poder ingresar a un grupo
        if (!in_array($postulante->estado, ['REGISTRADO', 'CON_PAGO', 'APROBADO'])) {
            $msg = "El postulante {$postulante->nombre_completo} no está activo (estado actual: {$postulante->estado}). Solo se pueden asignar postulantes en estado REGISTRADO, CON_PAGO o APROBADO.";
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $msg], 422);
            }
            return back()->with('error', $msg);
        }

        // Regla 2: El postulante debe pertenecer a la convocatoria del grupo
        if ($postulante->convocatoria_id !== $grupo->convocatoria_id) {
            $msg = 'El postulante no pertenece a la convocatoria de este grupo.';
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $msg], 422);
            }
            return back()->with('error', $msg);
        }

        // Regla 3: Un postulante no puede estar en más de un grupo simultáneamente
        $yaEnGrupo = DB::table('grupo_postulante')->where('postulante_id', $postulante->id)->exists();
        if ($yaEnGrupo) {
            $msg = "El postulante {$postulante->nombre_completo} ya está asignado a un grupo.";
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $msg], 409);
            }
            return back()->with('error', $msg);
        }

        // Regla 4: La capacidad efectiva es el mínimo entre la capacidad del grupo
        // y el límite máximo reglamentario del CUP (70 estudiantes por grupo)
        $capacidadEfectiva = min($grupo->capacidad_maxima, 70);
        $ocupados = $grupo->postulantes()->count();
        if ($ocupados >= $capacidadEfectiva) {
            $msg = "El grupo {$grupo->numero_grupo} ha alcanzado su capacidad máxima de {$capacidadEfectiva} estudiantes. Libera cupos antes de continuar.";
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $msg], 409);
            }
            return back()->with('error', $msg);
        }

        // Todas las validaciones pasaron: crear la relación en la tabla pivot grupo_postulante
        $grupo->postulantes()->attach($postulante->id);

        // Registrar la acción en el log de auditoría del sistema
        DB::table('log_actividad')->insert([
            'usuario_id'     => Auth::id(),
            'usuario_nombre' => Auth::user()->nombre . ' ' . Auth::user()->apellido,
            'usuario_email'  => Auth::user()->email,
            'accion'         => 'registro_creado',
            'descripcion'    => "Postulante {$postulante->nombre_completo} (CI: {$postulante->ci}) asignado al grupo {$grupo->numero_grupo}",
            'ip'             => $request->ip(),
            'modulo'         => 'grupos',
            'resultado'      => 'ok',
            'fecha_hora'     => now(),
        ]);

        $msg = "Postulante {$postulante->nombre_completo} asignado al Grupo {$grupo->numero_grupo} exitosamente.";
        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => $msg]);
        }
        return back()->with('success', $msg);
    }

    /**
     * CU12 — Desasignar (remover) un postulante de un grupo.
     *
     * Elimina la relación entre el postulante y el grupo en la tabla pivot
     * "grupo_postulante". No modifica el estado del postulante, solo lo libera
     * del grupo para que pueda ser reasignado o dejado sin grupo. Registra la
     * acción en el log de actividad.
     *
     * @param  Request $request  Contiene "postulante_id" (integer, requerido).
     * @param  Grupo   $grupo    Grupo del que se desasignará el postulante.
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function desasignarPostulante(Request $request, Grupo $grupo)
    {
        // Validar que el postulante exista en la BD antes de intentar desasignarlo
        $validated = $request->validate([
            'postulante_id' => 'required|exists:postulante,id',
        ]);

        // Eliminar el registro de la tabla pivot grupo_postulante
        $grupo->postulantes()->detach($validated['postulante_id']);

        // Registrar la desasignación en el log de auditoría
        DB::table('log_actividad')->insert([
            'usuario_id'     => Auth::id(),
            'usuario_nombre' => Auth::user()->nombre . ' ' . Auth::user()->apellido,
            'usuario_email'  => Auth::user()->email,
            'accion'         => 'registro_eliminado',
            'descripcion'    => "Postulante desasignado del grupo {$grupo->numero_grupo}",
            'ip'             => request()->ip(),
            'modulo'         => 'grupos',
            'resultado'      => 'ok',
            'fecha_hora'     => now(),
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Postulante desasignado',
            ]);
        }
        return back()->with('success', 'Postulante desasignado exitosamente');
    }

    // =========================================================================
    // ASIGNACIÓN DE DOCENTES
    // =========================================================================

    /**
     * CU12 — Asignar un docente ACTIVO a un grupo.
     *
     * Verifica las precondiciones antes de crear la relación:
     *   1. El campo docente_id debe existir en la tabla "docente".
     *   2. El docente debe tener estado "ACTIVO" (contratado y disponible).
     *   3. El docente no debe estar ya asignado a este mismo grupo.
     * Si todo es correcto, se inserta el registro en la tabla pivot "grupo_docente"
     * y se deja constancia en el log de actividad.
     *
     * @param  Request $request  Contiene "docente_id" (integer, requerido).
     * @param  Grupo   $grupo    Grupo destino resuelto por Route Model Binding.
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function asignarDocente(Request $request, Grupo $grupo)
    {
        // Validar que el docente_id enviado exista en la base de datos
        $validated = $request->validate([
            'docente_id' => 'required|exists:docente,id',
        ]);

        // Cargar el docente para verificar su estado antes de asignarlo
        $docente = Docente::findOrFail($validated['docente_id']);

        // Regla 1: Solo docentes con estado ACTIVO pueden ser asignados a grupos.
        // Docentes en LICENCIA o INACTIVO no pueden impartir clases.
        if ($docente->estado !== 'ACTIVO') {
            $msg = "El docente {$docente->nombre_completo} no está disponible (estado: {$docente->estado}). Solo se pueden asignar docentes con estado ACTIVO.";
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $msg], 422);
            }
            return back()->with('error', $msg);
        }

        // Regla 2: El docente no puede estar asignado dos veces al mismo grupo
        if ($grupo->docentes()->where('docente_id', $docente->id)->exists()) {
            $msg = "El docente {$docente->nombre_completo} ya está asignado al Grupo {$grupo->numero_grupo}.";
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $msg], 409);
            }
            return back()->with('error', $msg);
        }

        // Regla 3: Un docente no puede estar asignado a más de 4 grupos en la misma convocatoria.
        $MAX_GRUPOS_DOCENTE = 4;
        $gruposConvocatoriaIds = DB::table('grupo')
            ->where('convocatoria_id', $grupo->convocatoria_id)
            ->pluck('id');
        $gruposActualesDocente = DB::table('grupo_docente')
            ->whereIn('grupo_id', $gruposConvocatoriaIds)
            ->where('docente_id', $docente->id)
            ->count();
        if ($gruposActualesDocente >= $MAX_GRUPOS_DOCENTE) {
            $msg = "El docente {$docente->nombre_completo} ya está asignado a {$gruposActualesDocente} grupo(s) en esta convocatoria. El máximo permitido es {$MAX_GRUPOS_DOCENTE} grupos por docente.";
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $msg], 422);
            }
            return back()->with('error', $msg);
        }

        // Crear la relación en la tabla pivot grupo_docente
        $grupo->docentes()->attach($docente->id);

        // Registrar la asignación en el log de auditoría
        DB::table('log_actividad')->insert([
            'usuario_id'     => Auth::id(),
            'usuario_nombre' => Auth::user()->nombre . ' ' . Auth::user()->apellido,
            'usuario_email'  => Auth::user()->email,
            'accion'         => 'registro_creado',
            'descripcion'    => "Docente {$docente->nombre_completo} asignado al grupo {$grupo->numero_grupo}",
            'ip'             => $request->ip(),
            'modulo'         => 'grupos',
            'resultado'      => 'ok',
            'fecha_hora'     => now(),
        ]);

        $msg = "Docente {$docente->nombre_completo} asignado al Grupo {$grupo->numero_grupo} exitosamente.";
        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => $msg]);
        }
        return back()->with('success', $msg);
    }

    /**
     * CU12 — Desasignar (remover) un docente de un grupo.
     *
     * Elimina la relación entre el docente y el grupo en la tabla pivot
     * "grupo_docente". El docente sigue existiendo en el sistema y puede
     * ser asignado nuevamente. Registra la operación en el log de actividad.
     *
     * @param  Request $request  Contiene "docente_id" (integer, requerido).
     * @param  Grupo   $grupo    Grupo del que se desasignará el docente.
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function desasignarDocente(Request $request, Grupo $grupo)
    {
        // Validar que el docente_id exista en la BD antes de desasignar
        $validated = $request->validate([
            'docente_id' => 'required|exists:docente,id',
        ]);

        // Eliminar el registro de la tabla pivot grupo_docente
        $grupo->docentes()->detach($validated['docente_id']);

        // Registrar la desasignación en el log de auditoría
        DB::table('log_actividad')->insert([
            'usuario_id'     => Auth::id(),
            'usuario_nombre' => Auth::user()->nombre . ' ' . Auth::user()->apellido,
            'usuario_email'  => Auth::user()->email,
            'accion'         => 'registro_eliminado',
            'descripcion'    => "Docente desasignado del grupo {$grupo->numero_grupo}",
            'ip'             => request()->ip(),
            'modulo'         => 'grupos',
            'resultado'      => 'ok',
            'fecha_hora'     => now(),
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Docente desasignado',
            ]);
        }
        return back()->with('success', 'Docente desasignado exitosamente');
    }

    // =========================================================================
    // API / CONSULTAS
    // =========================================================================

    /**
     * CU13 — Obtener la lista de docentes asignados a un grupo (endpoint API).
     *
     * Devuelve en formato JSON los docentes vinculados a un grupo específico.
     * Este endpoint es utilizado por scripts del frontend para consultar
     * dinámicamente los docentes de un grupo sin recargar la página.
     *
     * @param  Grupo $grupo  Grupo consultado resuelto por Route Model Binding.
     * @return \Illuminate\Http\JsonResponse  JSON con número de grupo y lista de docentes.
     */
    public function docentesPorGrupo(Grupo $grupo)
    {
        // Obtener los docentes relacionados con este grupo
        $docentes = $grupo->docentes()->get();

        // Retornar la información formateada en JSON
        return response()->json([
            'grupo'    => $grupo->numero_grupo,
            'docentes' => $docentes->map(fn($d) => [
                'id'          => $d->id,
                'nombre'      => $d->nombre . ' ' . $d->apellido,
                'email'       => $d->email,
                'especialidad'=> $d->especialidad,
            ]),
        ]);
    }

    // =========================================================================
    // GENERACIÓN Y LIMPIEZA DE GRUPOS
    // =========================================================================

    /**
     * Generar grupos académicos automáticamente para una convocatoria.
     *
     * La cantidad de grupos se calcula con la fórmula reglamentaria:
     *   grupos = CEIL(total_inscritos / 70)   (mínimo 1 grupo)
     *
     * Ejemplos:
     *   70 inscritos → CEIL(70/70) = 1 grupo
     *   71 inscritos → CEIL(71/70) = 2 grupos
     *  140 inscritos → CEIL(140/70) = 2 grupos
     *  141 inscritos → CEIL(141/70) = 3 grupos
     *  210 inscritos → CEIL(210/70) = 3 grupos
     *  211 inscritos → CEIL(211/70) = 4 grupos
     *
     * Si el admin marca "calcular automáticamente", se ignora el campo cantidad
     * y se usa la fórmula. Si no, se respeta la cantidad ingresada manualmente
     * (siempre que sea >= a la calculada).
     *
     * Parámetros del formulario (POST):
     *   - convocatoria_id  : ID de la convocatoria (requerido).
     *   - capacidad        : Capacidad máxima por grupo (entre 5 y 100).
     *   - turno            : Turno (MAÑANA, TARDE o NOCHE).
     *   - auto_calcular    : "1" para usar la fórmula, "0" para manual.
     *   - cantidad         : Requerido solo si auto_calcular = 0.
     *
     * @param  Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function generar(Request $request)
    {
        $validated = $request->validate([
            'convocatoria_id' => 'required|exists:convocatoria,id',
            'capacidad'       => 'required|integer|min:5|max:100',
        ]);

        $convocatoria = Convocatoria::findOrFail($validated['convocatoria_id']);
        $capacidad    = (int) $validated['capacidad'];

        // Turnos posibles
        $turnos = ['MAÑANA', 'TARDE', 'NOCHE'];

        // Grupos ya existentes por turno (para no duplicar)
        $gruposExistentes = $convocatoria->grupos()
            ->get()
            ->groupBy('turno');

        // Número correlativo global para codigo_grupo
        $ultimoCodigo = $convocatoria->grupos()->max('codigo_grupo') ?? 0;

        $gruposCreados  = 0;
        $detalle        = [];
        $turnosSaltados = [];

        foreach ($turnos as $turno) {
            // Contar postulantes activos de este turno
            $totalTurno = Postulante::where('convocatoria_id', $convocatoria->id)
                ->whereIn('estado', ['REGISTRADO', 'CON_PAGO', 'APROBADO'])
                ->where('turno_asignado', $turno)
                ->count();

            if ($totalTurno === 0) {
                continue; // Sin postulantes en este turno
            }

            // Cuántos grupos necesita este turno: CEIL(postulantes / capacidad)
            $gruposNecesarios = (int) ceil($totalTurno / $capacidad);

            // Cuántos grupos ya existen para este turno
            $gruposActuales = isset($gruposExistentes[$turno])
                ? $gruposExistentes[$turno]->count()
                : 0;

            // Cuántos grupos faltan por crear
            $gruposFaltantes = $gruposNecesarios - $gruposActuales;

            if ($gruposFaltantes <= 0) {
                $turnosSaltados[] = "{$turno} (ya tiene {$gruposActuales}/{$gruposNecesarios} grupos)";
                continue;
            }

            // Crear los grupos que faltan para este turno
            for ($i = 1; $i <= $gruposFaltantes; $i++) {
                $ultimoCodigo++;
                $subtotal = $gruposActuales + $i; // número de grupo dentro del turno

                Grupo::create([
                    'convocatoria_id' => $convocatoria->id,
                    'numero_grupo'    => $ultimoCodigo,
                    'turno'           => $turno,
                    'estado'          => 'ACTIVO',
                    'capacidad_maxima'=> $capacidad,
                ]);
                $gruposCreados++;
            }

            $detalle[] = "{$turno}: {$totalTurno} postulantes → {$gruposNecesarios} grupo(s) [cap. {$capacidad}]";
        }

        if ($gruposCreados === 0 && !empty($turnosSaltados)) {
            return back()->with('error',
                'Ya existen todos los grupos necesarios para cada turno. ' . implode(', ', $turnosSaltados) . '.');
        }

        if ($gruposCreados === 0) {
            return back()->with('error', 'No hay postulantes APROBADOS en ningún turno para crear grupos.');
        }

        // Registrar en log
        DB::table('log_actividad')->insert([
            'usuario_id'     => Auth::id(),
            'usuario_nombre' => Auth::user()->nombre . ' ' . Auth::user()->apellido,
            'usuario_email'  => Auth::user()->email,
            'accion'         => 'registro_creado',
            'descripcion'    => "Creados {$gruposCreados} grupos para {$convocatoria->nombre}: " . implode(' | ', $detalle),
            'ip'             => $request->ip(),
            'modulo'         => 'grupos',
            'resultado'      => 'ok',
            'fecha_hora'     => now(),
        ]);

        $mensaje = "¡Se crearon {$gruposCreados} grupo(s) correctamente! " . implode(', ', $detalle) . ".";
        if (!empty($turnosSaltados)) {
            $mensaje .= " Omitidos: " . implode(', ', $turnosSaltados) . ".";
        }

        return back()->with('success', $mensaje);
    }

    public function actualizarTurno(Request $request)
    {
        $validated = $request->validate([
            'grupo_id' => 'required|exists:grupo,id',
            'turno'    => 'required|in:MAÑANA,TARDE,NOCHE',
        ]);

        $grupo = Grupo::findOrFail($validated['grupo_id']);
        $grupo->update(['turno' => $validated['turno']]);

        return back()->with('success', "Turno del Grupo {$grupo->numero_grupo} actualizado a {$validated['turno']}.");
    }

    public function autoAsignarDocentes(Request $request)
    {
        $validated = $request->validate([
            'convocatoria_id' => 'required|exists:convocatoria,id',
        ]);

        $convocatoria = Convocatoria::findOrFail($validated['convocatoria_id']);
        $grupos = $convocatoria->grupos()->where('activo', true)->orderBy('id')->get();

        if ($grupos->isEmpty()) {
            return back()->with('error', 'Debes crear grupos activos primero.');
        }

        // Limpiar asignaciones previas de docentes en estos grupos
        DB::table('grupo_docente')
            ->whereIn('grupo_id', $grupos->pluck('id'))
            ->delete();

        // Obtener docentes activos agrupados por especialidad, ordenados alfabéticamente
        $docentesPorEspecialidad = \App\Models\Docente::where('activo', true)
            ->whereNotNull('especialidad')
            ->orderBy('apellido')
            ->orderBy('nombre')
            ->get()
            ->groupBy('especialidad');

        if ($docentesPorEspecialidad->isEmpty()) {
            return back()->with('error', 'No hay docentes con especialidad asignada. Edita los docentes primero.');
        }

        $asignados  = 0;
        $sinDocente = [];

        // Límite máximo de grupos por docente por convocatoria
        $MAX_GRUPOS_DOCENTE = 4;

        // Contador en memoria de cuántos grupos lleva cada docente en esta asignación
        // (el método limpia las asignaciones previas, por lo que el conteo parte de 0)
        $gruposPorDocente = [];

        // Índice rotativo por especialidad (round-robin):
        // Grupo 1 → docente[0], Grupo 2 → docente[1], Grupo 3 → docente[2], etc.
        $indiceEspecialidad = [];
        foreach ($docentesPorEspecialidad as $especialidad => $docentes) {
            $indiceEspecialidad[$especialidad] = 0;
        }

        foreach ($grupos as $grupo) {
            foreach ($docentesPorEspecialidad as $especialidad => $docentes) {
                $lista  = $docentes->values(); // reindexar
                $total  = $lista->count();
                $intentos = 0;
                $docente  = null;

                // Buscar el siguiente docente disponible que no haya alcanzado el límite
                while ($intentos < $total) {
                    $indice    = $indiceEspecialidad[$especialidad];
                    $candidato = $lista->get($indice);
                    // Avanzar índice circular
                    $indiceEspecialidad[$especialidad] = ($indice + 1) % $total;
                    $intentos++;

                    $gruposActuales = $gruposPorDocente[$candidato->id] ?? 0;
                    if ($gruposActuales < $MAX_GRUPOS_DOCENTE) {
                        $docente = $candidato;
                        break;
                    }
                }

                if ($docente) {
                    DB::table('grupo_docente')->insert([
                        'grupo_id'         => $grupo->id,
                        'docente_id'       => $docente->id,
                        'fecha_asignacion' => now(),
                        'created_at'       => now(),
                        'updated_at'       => now(),
                    ]);
                    $asignados++;
                    $gruposPorDocente[$docente->id] = ($gruposPorDocente[$docente->id] ?? 0) + 1;
                } else {
                    $sinDocente[] = "Grupo {$grupo->numero_grupo} ({$especialidad}): todos los docentes alcanzaron el límite de {$MAX_GRUPOS_DOCENTE} grupos";
                }
            }
        }

        $msg = "Se asignaron {$asignados} docente(s) correctamente ({$grupos->count()} grupos × " . $docentesPorEspecialidad->count() . " especialidades).";
        if (!empty($sinDocente)) {
            $msg .= " Sin docente disponible para: " . implode(', ', $sinDocente) . ".";
        }

        return back()->with('success', $msg);
    }

    /**
     * Endpoint AJAX: devuelve la cantidad de grupos calculada por la fórmula
     * para una convocatoria dada. Usado por el formulario para mostrar la
     * sugerencia en tiempo real antes de confirmar la generación.
     *
     * GET /admin/grupos/calcular?convocatoria_id=X
     *
     * @param  Request $request  Query param: convocatoria_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function calcularGrupos(Request $request)
    {
        $request->validate([
            'convocatoria_id' => 'required|exists:convocatoria,id',
            'capacidad'       => 'nullable|integer|min:5|max:100',
        ]);

        $capacidad = (int) $request->input('capacidad', 70);
        $turno = $request->turno; // opcional

        if ($turno) {
            // Calcular solo para el turno seleccionado
            $total  = Postulante::where('convocatoria_id', $request->convocatoria_id)
                ->whereIn('estado', ['REGISTRADO', 'CON_PAGO', 'APROBADO'])
                ->where('turno_asignado', $turno)
                ->count();
            $grupos = max(1, (int) ceil($total / $capacidad));

            return response()->json([
                'total_inscritos'   => $total,
                'grupos_calculados' => $grupos,
            ]);
        }

        // Sin turno: desglose completo por turno
        $turnos   = ['MAÑANA', 'TARDE', 'NOCHE'];
        $porTurno = [];
        $totalGeneral = 0;
        $gruposTotal  = 0;

        foreach ($turnos as $t) {
            $total = Postulante::where('convocatoria_id', $request->convocatoria_id)
                ->whereIn('estado', ['REGISTRADO', 'CON_PAGO', 'APROBADO'])
                ->where('turno_asignado', $t)
                ->count();
            if ($total > 0) {
                $g = max(1, (int) ceil($total / $capacidad));
                $porTurno[$t] = ['total' => $total, 'grupos' => $g];
                $totalGeneral += $total;
                $gruposTotal  += $g;
            }
        }

        return response()->json([
            'total_inscritos'   => $totalGeneral,
            'grupos_calculados' => $gruposTotal,
            'por_turno'         => $porTurno,
        ]);
    }

    /**
     * Eliminar todos los grupos de una convocatoria y sus asignaciones.
     *
     * Operación destructiva que borra en cascada:
     *   1. Los registros de "grupo_postulante" (postulantes asignados).
     *   2. Los registros de "grupo_docente" (docentes asignados).
     *   3. Las notas de los postulantes que estaban en esos grupos.
     *   4. Los propios registros de grupo.
     * Si no hay grupos, retorna error. Al finalizar, registra en el log.
     *
     * @param  Request $request  Contiene "convocatoria_id" (requerido).
     * @return \Illuminate\Http\RedirectResponse  Redirige con mensaje de resultado.
     */
    public function limpiar(Request $request)
    {
        $validated = $request->validate([
            'convocatoria_id' => 'required|exists:convocatoria,id',
            'grupo_id'        => 'required|exists:grupo,id',
        ]);

        $grupo = Grupo::findOrFail($validated['grupo_id']);

        // Eliminar asignaciones de postulantes
        $postulantesIds = DB::table('grupo_postulante')->where('grupo_id', $grupo->id)->pluck('postulante_id');
        DB::table('grupo_postulante')->where('grupo_id', $grupo->id)->delete();

        // Eliminar asignaciones de docentes
        DB::table('grupo_docente')->where('grupo_id', $grupo->id)->delete();

        // Eliminar notas asociadas
        if ($postulantesIds->isNotEmpty()) {
            DB::table('nota')->whereIn('postulante_id', $postulantesIds)->delete();
        }

        // Eliminar el grupo
        $grupo->delete();

        return back()->with('success', "Grupo {$grupo->numero_grupo} ({$grupo->turno}) eliminado correctamente.");
    }

    // =========================================================================
    // DISTRIBUCIÓN AUTOMÁTICA
    // =========================================================================

    /**
     * Distribución automática de postulantes APROBADOS en grupos disponibles.
     *
     * Recorre todos los postulantes con estado "APROBADO" que aún no tienen
     * grupo asignado en la convocatoria indicada, y los asigna uno a uno al
     * primer grupo activo que tenga cupo disponible (algoritmo greedy/secuencial).
     *
     * Reglas aplicadas:
     *   - Solo se distribuyen postulantes con estado "APROBADO".
     *   - Respeta la capacidad efectiva de cada grupo: min(capacidad_maxima, 70).
     *   - Si un grupo está lleno, pasa al siguiente.
     *   - Si ningún grupo tiene cupo, el postulante queda sin asignar.
     *   - Al finalizar informa cuántos se asignaron y cuántos no pudieron asignarse.
     *
     * @param  Request $request  Contiene "convocatoria_id" (requerido).
     * @return \Illuminate\Http\RedirectResponse  Redirige con resumen del proceso.
     */
    public function autoAsignar(Request $request)
    {
        // Validar que se envió un ID de convocatoria válido
        $validated = $request->validate([
            'convocatoria_id' => 'required|exists:convocatoria,id',
        ]);

        $convocatoria = Convocatoria::findOrFail($validated['convocatoria_id']);

        // Obtener todos los grupos ACTIVOS de la convocatoria
        $grupos = $convocatoria->grupos()->where('activo', true)->get();

        // Precondición: debe haber al menos un grupo activo donde asignar
        if ($grupos->isEmpty()) {
            return back()->with('error', 'Debes crear grupos activos primero para poder realizar la asignación automática.');
        }

        // Agrupar los grupos por turno para búsqueda rápida
        $gruposPorTurno = $grupos->groupBy('turno');

        // Obtener los IDs de postulantes que ya tienen grupo (para excluirlos)
        $postulantesAsignadosIds = DB::table('grupo_postulante')->pluck('postulante_id');

        // Filtrar: solo postulantes activos sin grupo, ordenados alfabéticamente
        $postulantesSinGrupo = Postulante::where('convocatoria_id', $convocatoria->id)
            ->whereIn('estado', ['REGISTRADO', 'CON_PAGO', 'APROBADO'])
            ->whereNotIn('id', $postulantesAsignadosIds)
            ->orderBy('apellido')
            ->orderBy('nombre')
            ->get();

        // Verificar que haya postulantes para distribuir
        if ($postulantesSinGrupo->isEmpty()) {
            return back()->with('error', 'No hay postulantes sin grupo para asignar.');
        }

        // Contadores para el informe final
        $asignadosCount  = 0;
        $noAsignadoCount = 0;
        $sinGrupoTurno   = 0;

        // Algoritmo: cada postulante va al grupo que tenga su mismo turno
        foreach ($postulantesSinGrupo as $postulante) {
            $turno = $postulante->turno_asignado; // MAÑANA, TARDE o NOCHE
            $asignado = false;

            // Buscar grupos del mismo turno que tengan cupo
            $gruposDelTurno = $gruposPorTurno[$turno] ?? collect();

            if ($gruposDelTurno->isEmpty()) {
                // No existe ningún grupo para ese turno
                $sinGrupoTurno++;
                $noAsignadoCount++;
                continue;
            }

            foreach ($gruposDelTurno as $grupo) {
                $capacidadEfectiva = min($grupo->capacidad_maxima, 70);
                $actual = $grupo->postulantes()->count();

                if ($actual < $capacidadEfectiva) {
                    $grupo->postulantes()->attach($postulante->id);
                    $asignadosCount++;
                    $asignado = true;
                    break;
                }
            }

            if (!$asignado) {
                $noAsignadoCount++;
            }
        }

        // Si al menos uno fue asignado, registrar en log y retornar éxito
        if ($asignadosCount > 0) {
            DB::table('log_actividad')->insert([
                'usuario_id'     => Auth::id(),
                'usuario_nombre' => Auth::user()->nombre . ' ' . Auth::user()->apellido,
                'usuario_email'  => Auth::user()->email,
                'accion'         => 'registro_creado',
                'descripcion'    => "Distribución automática: {$asignadosCount} postulantes APROBADOS distribuidos en grupos de la convocatoria {$convocatoria->nombre}",
                'ip'             => $request->ip(),
                'modulo'         => 'grupos',
                'resultado'      => 'ok',
                'fecha_hora'     => now(),
            ]);

            // Construir mensaje de resumen informativo
            $mensaje = "Se distribuyeron {$asignadosCount} postulantes exitosamente según su turno.";
            if ($noAsignadoCount > 0) {
                $mensaje .= " {$noAsignadoCount} postulante(s) no pudieron asignarse";
                if ($sinGrupoTurno > 0) {
                    $mensaje .= " (sin grupo creado para su turno o sin cupo disponible).";
                } else {
                    $mensaje .= " por falta de cupo.";
                }
            }
            return back()->with('success', $mensaje);
        }

        // Si ninguno pudo asignarse, informar el problema
        return back()->with('error', 'No se pudieron asignar postulantes. Verifique que los grupos tengan cupos disponibles (máximo 70 por grupo).');
    }
}