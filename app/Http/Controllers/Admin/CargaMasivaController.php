<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Convocatoria;

class CargaMasivaController extends Controller
{
    // Mostrar la vista para subir el archivo
    public function index()
    {
        $convocatorias = Convocatoria::whereIn('estado', ['ACTIVA', 'PLANIFICADA'])->get();
        // Obtener el historial de cargas masivas
        $cargas = DB::table('carga_masiva')->orderBy('created_at', 'desc')->get();
        
        return view('admin.carga_masiva.index', compact('convocatorias', 'cargas'));
    }

    // Procesar el archivo CSV subido
    public function procesar(Request $request)
    {
        // 1. Validar el archivo y los campos
        $request->validate([
            'convocatoria_id' => 'required|exists:convocatoria,id',
            'tipo_usuario'    => 'required|in:POSTULANTE,DOCENTE',
            'archivo_csv'     => 'required|file|mimes:csv,txt|max:2048', // Máximo 2MB
        ]);

        $convocatoriaId = $request->convocatoria_id;
        $tipoUsuario = $request->tipo_usuario;
        $archivo = $request->file('archivo_csv');

        // 2. Guardar el archivo físicamente en el servidor
        $rutaArchivo = $archivo->storeAs('cargas_masivas', time() . '_' . $archivo->getClientOriginalName(), 'public');

        // 3. Registrar el inicio de la carga en la BD
        $cargaId = DB::table('carga_masiva')->insertGetId([
            'convocatoria_id' => $convocatoriaId,
            'archivo_nombre'  => $archivo->getClientOriginalName(),
            'ruta_archivo'    => $rutaArchivo,
            'tipo_usuario'    => $tipoUsuario,
            'estado'          => 'PROCESANDO',
            'procesado_por'   => Auth::id(),
            'created_at'      => now(),
        ]);

        // 4. Leer el CSV y procesar fila por fila
        $exitosos = 0;
        $fallidos = 0;
        $errores = [];
        
        $rutaCompleta = storage_path('app/public/' . $rutaArchivo);
        $fileHandle = fopen($rutaCompleta, 'r');

        // Auto-detectar separador: coma (,) o punto y coma (;)
        // Excel en español usa punto y coma por defecto
        $primeraLinea = fgets($fileHandle);
        $separador = (substr_count($primeraLinea, ';') >= substr_count($primeraLinea, ',')) ? ';' : ',';
        rewind($fileHandle); // Volver al inicio

        $header = fgetcsv($fileHandle, 1000, $separador); // Leer la primera fila (Cabeceras)

        // Obtener los IDs de los roles
        $rolPostulante = DB::table('rol')->where('nombre_rol', 'POSTULANTE')->value('id');
        $rolDocente = DB::table('rol')->where('nombre_rol', 'DOCENTE')->value('id');

        DB::beginTransaction();
        try {
            while (($fila = fgetcsv($fileHandle, 1000, $separador)) !== FALSE) {
                // CSV acepta: [0]CI, [1]Nombre, [2]Apellido, [3]Email, [4]Turno(opcional), [5]CarreraId(opcional)
                $ci        = trim($fila[0] ?? '');
                $nombre    = trim($fila[1] ?? '');
                $apellido  = trim($fila[2] ?? '');
                $email     = trim($fila[3] ?? '');
                $turno     = strtoupper(trim($fila[4] ?? 'MAÑANA'));
                $carrera1Id = intval($fila[5] ?? 0) ?: null;
                $carrera2Id = intval($fila[6] ?? 0) ?: null;

                // Validar turno
                if (!in_array($turno, ['MAÑANA','TARDE','NOCHE'])) {
                    $turno = 'MAÑANA';
                }

                // Si la fila está vacía, saltar
                if (empty($ci) || empty($email)) {
                    $fallidos++;
                    $errores[] = "Fila incompleta: CI o Email faltante.";
                    continue;
                }

                // Verificar si el email ya existe en usuarios
                if (DB::table('usuario')->where('email', $email)->exists()) {
                    $fallidos++;
                    $errores[] = "El correo $email ya está registrado.";
                    continue;
                }

                // 5. Crear el Usuario base (Contraseña en texto plano = CI)
                $usuarioId = DB::table('usuario')->insertGetId([
                    'nombre'     => $nombre,
                    'apellido'   => $apellido,
                    'email'      => $email,
                    'password'   => $ci,
                    'rol_id'     => ($tipoUsuario === 'POSTULANTE') ? $rolPostulante : $rolDocente,
                    'activo'     => true,
                    'created_at' => now(),
                ]);

                // 6. Crear el registro específico (Postulante o Docente)
                if ($tipoUsuario === 'POSTULANTE') {
                    // Generar un código de estudiante único
                    $correlativo = DB::table('postulante')->count() + 1;
                    $codigoEst = date('y') . str_pad($correlativo, 6, '0', STR_PAD_LEFT);

                    DB::table('postulante')->insert([
                        'usuario_id'        => $usuarioId,
                        'convocatoria_id'   => $convocatoriaId,
                        'codigo_estudiante' => $codigoEst,
                        'ci'                => $ci,
                        'nombre'            => $nombre,
                        'apellido'          => $apellido,
                        'email'             => $email,
                        'turno_asignado'    => $turno,
                        'carrera_pref_1_id' => $carrera1Id,
                        'carrera_pref_2_id' => $carrera2Id,
                        'estado'            => 'APROBADO',
                        'created_at'        => now(),
                    ]);
                } else {
                    // Generar un código de docente único (ej: D26000001)
                    $correlativoDoc = DB::table('docente')->count() + 1;
                    $codigoDoc = 'D' . date('y') . str_pad($correlativoDoc, 6, '0', STR_PAD_LEFT);

                    DB::table('docente')->insert([
                        'usuario_id'      => $usuarioId,
                        'codigo_docente'  => $codigoDoc,
                        'ci'              => $ci,
                        'nombre'          => $nombre,
                        'apellido'        => $apellido,
                        'email'           => $email,
                        'activo'          => true,
                        'created_at'      => now(),
                    ]);
                }

                $exitosos++;
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            fclose($fileHandle);
            
            DB::table('carga_masiva')->where('id', $cargaId)->update([
                'estado'   => 'CON_ERRORES',
                'errores'  => json_encode(["Error del sistema: " . $e->getMessage()]),
                'updated_at' => now(),
            ]);

            return back()->with('error', 'Ocurrió un error crítico procesando el archivo.');
        }

        fclose($fileHandle);

        // 7. Actualizar el registro de la carga masiva con los resultados
        $estadoFinal = ($fallidos > 0) ? 'CON_ERRORES' : 'COMPLETADO';
        DB::table('carga_masiva')->where('id', $cargaId)->update([
            'total_registros' => $exitosos + $fallidos,
            'exitosos'        => $exitosos,
            'fallidos'        => $fallidos,
            'estado'          => $estadoFinal,
            'errores'         => json_encode($errores),
            'updated_at'      => now(),
        ]);

        // 8. Log de actividad
        DB::table('log_actividad')->insert([
            'usuario_id'     => Auth::id(),
            'usuario_nombre' => Auth::user()->nombre,
            'accion'         => 'carga_masiva',
            'descripcion'    => "Se cargaron $exitosos $tipoUsuario(S) desde archivo CSV.",
            'ip'             => $request->ip(),
            'modulo'         => 'usuarios',
            'fecha_hora'     => now(),
        ]);

        return back()->with('success', "Carga masiva finalizada: $exitosos creados correctamente, $fallidos fallaron.");
    }
}