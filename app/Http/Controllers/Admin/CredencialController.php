<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\CredencialMail;

class CredencialController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $query = DB::table('credencial_temporal')
            ->orderBy('created_at', 'desc');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('email', 'like', "%{$search}%")
                  ->orWhere('codigo_registro', 'like', "%{$search}%");
            });
        }

        $credenciales = $query->paginate(15)->withQueryString();

        $stats = [
            'total'   => DB::table('credencial_temporal')->count(),
            'enviado' => DB::table('credencial_temporal')->where('correo_enviado', true)->count(),
            'pendiente' => DB::table('credencial_temporal')->where('correo_enviado', false)->count(),
        ];

        return view('admin.credenciales.index', compact('credenciales', 'stats', 'search'));
    }

    public function generar(Request $request)
    {
        $activeConv = DB::table('convocatoria')->where('estado', 'ACTIVA')->first();
        if (!$activeConv) {
            return back()->with('error', 'No existe una convocatoria ACTIVA para generar credenciales.');
        }

        DB::beginTransaction();
        try {
            // 1. Obtener postulantes activos de esta convocatoria
            $postulantes = DB::table('postulante')
                ->where('convocatoria_id', $activeConv->id)
                ->get();

            $generadas = 0;

            foreach ($postulantes as $p) {
                // Verificar si ya existe credencial temporal
                $existe = DB::table('credencial_temporal')
                    ->where('email', $p->email)
                    ->exists();

                if (!$existe) {
                    DB::table('credencial_temporal')->insert([
                        'email'             => $p->email,
                        'codigo_registro'   => $p->codigo_estudiante,
                        'contrasena_correo' => '12345678', // contraseña genérica inicial
                        'correo_enviado'    => false,
                        'created_at'        => now()
                    ]);
                    $generadas++;
                }
            }

            // 2. Obtener docentes activos
            $docentes = DB::table('docente')
                ->where('activo', true)
                ->get();

            foreach ($docentes as $d) {
                $existe = DB::table('credencial_temporal')
                    ->where('email', $d->email)
                    ->exists();

                if (!$existe) {
                    DB::table('credencial_temporal')->insert([
                        'email'             => $d->email,
                        'codigo_registro'   => $d->codigo_docente ?? $d->email,
                        'contrasena_correo' => $d->ci,
                        'correo_enviado'    => false,
                        'created_at'        => now()
                    ]);
                    $generadas++;
                }
            }

            if ($generadas > 0) {
                DB::table('log_actividad')->insert([
                    'usuario_id'     => Auth::id(),
                    'usuario_nombre' => Auth::user()->nombre . ' ' . Auth::user()->apellido,
                    'usuario_email'  => Auth::user()->email,
                    'accion'         => 'registro_creado',
                    'descripcion'    => "Se generaron {$generadas} registros de credenciales temporales faltantes.",
                    'ip'             => $request->ip(),
                    'modulo'         => 'credenciales',
                    'resultado'      => 'ok',
                    'fecha_hora'     => now()
                ]);
            }

            DB::commit();
            return back()->with('success', "✅ Se generaron {$generadas} credenciales temporales nuevas con éxito.");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al generar credenciales: ' . $e->getMessage());
        }
    }

    public function enviar(Request $request, $id)
    {
        $credencial = DB::table('credencial_temporal')->where('id', $id)->first();
        if (!$credencial) {
            return back()->with('error', 'Registro de credencial no encontrado.');
        }

        try {
            Mail::to($credencial->email)->send(new CredencialMail($credencial->codigo_registro, $credencial->contrasena_correo));

            DB::table('credencial_temporal')
                ->where('id', $id)
                ->update([
                    'correo_enviado' => true,
                    'enviado_en'     => now()
                ]);

            DB::table('log_actividad')->insert([
                'usuario_id'     => Auth::id(),
                'usuario_nombre' => Auth::user()->nombre . ' ' . Auth::user()->apellido,
                'usuario_email'  => Auth::user()->email,
                'accion'         => 'credencial_enviada',
                'descripcion'    => "Envío de credenciales temporales a {$credencial->email}.",
                'ip'             => $request->ip(),
                'modulo'         => 'credenciales',
                'resultado'      => 'ok',
                'fecha_hora'     => now()
            ]);

            return back()->with('success', "✅ Credenciales enviadas a {$credencial->email} con éxito.");
        } catch (\Exception $e) {
            return back()->with('error', 'Error al enviar correo: ' . $e->getMessage());
        }
    }

    public function enviarMasivo(Request $request)
    {
        $pendientes = DB::table('credencial_temporal')
            ->where('correo_enviado', false)
            ->get();

        if ($pendientes->isEmpty()) {
            return back()->with('info', 'No hay credenciales pendientes por enviar.');
        }

        DB::beginTransaction();
        try {
            $totalEnviadas = 0;
            $errores = 0;
            foreach ($pendientes as $p) {
                try {
                    Mail::to($p->email)->send(new CredencialMail($p->codigo_registro, $p->contrasena_correo));

                    DB::table('credencial_temporal')
                        ->where('id', $p->id)
                        ->update([
                            'correo_enviado' => true,
                            'enviado_en'     => now()
                        ]);
                    $totalEnviadas++;
                } catch (\Exception $e) {
                    $errores++;
                }
            }

            $mensajeResultado = "Envío masivo de credenciales completado: {$totalEnviadas} correos enviados.";
            if ($errores > 0) {
                $mensajeResultado .= " Errores: {$errores}.";
            }

            DB::table('log_actividad')->insert([
                'usuario_id'     => Auth::id(),
                'usuario_nombre' => Auth::user()->nombre . ' ' . Auth::user()->apellido,
                'usuario_email'  => Auth::user()->email,
                'accion'         => 'credencial_enviada',
                'descripcion'    => $mensajeResultado,
                'ip'             => $request->ip(),
                'modulo'         => 'credenciales',
                'resultado'      => 'ok',
                'fecha_hora'     => now()
            ]);

            DB::commit();

            if ($errores > 0) {
                return back()->with('success', "✅ Envío masivo completado. Enviados: {$totalEnviadas}. Errores: {$errores}. Verifica tu configuración de correo.");
            }
            return back()->with('success', "✅ Envío masivo completado con éxito. Se enviaron {$totalEnviadas} credenciales.");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al ejecutar envío masivo: ' . $e->getMessage());
        }
    }
}
