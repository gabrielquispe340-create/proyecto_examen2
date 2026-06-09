<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $convocatoriaActiva = DB::table('convocatoria')->where('estado', 'ACTIVA')->first();

        $stats = [
            'total_postulantes'  => DB::table('postulante')
                                       ->when($convocatoriaActiva, fn($q) => $q->where('convocatoria_id', $convocatoriaActiva->id))
                                       ->count(),
            'pre_reg_pendientes' => DB::table('pre_registro_estudiante')
                                      ->where('estado', 'PENDIENTE')->count(),
            'total_grupos'       => DB::table('grupo')
                                       ->when($convocatoriaActiva, fn($q) => $q->where('convocatoria_id', $convocatoriaActiva->id))
                                       ->count(),
            'total_docentes'     => DB::table('docente')->count(),
        ];

        $pendientes = DB::table('pre_registro_estudiante')
            ->where('estado', 'PENDIENTE')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $logs = DB::table('log_actividad')
            ->orderBy('fecha_hora', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'pendientes', 'logs', 'convocatoriaActiva'));
    }
}