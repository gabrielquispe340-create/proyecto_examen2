<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $modulo = $request->query('modulo');
        $accion = $request->query('accion');

        $query = DB::table('log_actividad')
            ->orderBy('fecha_hora', 'desc');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('usuario_nombre', 'like', "%{$search}%")
                  ->orWhere('usuario_email', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }

        if ($modulo) {
            $query->where('modulo', $modulo);
        }

        if ($accion) {
            $query->where('accion', $accion);
        }

        $logs = $query->paginate(20)->withQueryString();

        // Obtener listas únicas de modulos y acciones para los filtros
        $modulos = DB::table('log_actividad')->distinct()->pluck('modulo')->filter()->toArray();
        $acciones = DB::table('log_actividad')->distinct()->pluck('accion')->filter()->toArray();

        $stats = [
            'total'     => DB::table('log_actividad')->count(),
            'hoy'       => DB::table('log_actividad')->whereDate('fecha_hora', today())->count(),
            'errores'   => DB::table('log_actividad')->where('resultado', '!=', 'ok')->count(),
        ];

        return view('admin.logs.index', compact('logs', 'stats', 'modulos', 'acciones', 'search', 'modulo', 'accion'));
    }
}
