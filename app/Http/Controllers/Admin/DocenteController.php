<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Docente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class DocenteController extends Controller
{
    /**
     * Listado de docentes con filtros y paginación.
     */
    public function index(Request $request)
    {
        $query = Docente::with('grupos')
            ->orderBy('apellido')
            ->orderBy('nombre');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->whereRaw("LOWER(nombre || ' ' || apellido) LIKE ?", ['%'.strtolower($search).'%'])
                  ->orWhere('ci', 'like', '%'.$search.'%')
                  ->orWhere('email', 'like', '%'.$search.'%')
                  ->orWhere('codigo_docente', 'like', '%'.$search.'%')
                  ->orWhere('especialidad', 'like', '%'.$search.'%');
            });
        }

        if ($estado = $request->input('estado')) {
            if (Schema::hasColumn('docente', 'estado')) {
                $query->where('estado', $estado);
            } else {
                if ($estado === 'ACTIVO') {
                    $query->where('activo', true);
                } elseif ($estado === 'INACTIVO') {
                    $query->where('activo', false);
                }
            }
        }

        // Evitar consultas contra columnas inexistentes en bases de datos antiguas
        if (Schema::hasColumn('docente', 'estado')) {
            $stats = [
                'total'    => Docente::count(),
                'activos'  => Docente::where('estado', 'ACTIVO')->count(),
                'inactivos'=> Docente::where('estado', 'INACTIVO')->count(),
                'licencia' => Docente::where('estado', 'LICENCIA')->count(),
            ];
        } else {
            $stats = [
                'total'    => Docente::count(),
                'activos'  => Docente::where('activo', true)->count(),
                'inactivos'=> Docente::where('activo', false)->count(),
                'licencia' => 0,
            ];
        }

        $docentes = $query->paginate(15)->withQueryString();

        return view('admin.docentes.index', compact('docentes', 'stats'));
    }

    public function edit($id)
    {
        $docente  = \App\Models\Docente::findOrFail($id);
        $materias = \App\Models\Materia::orderBy('nombre')->get();
        return view('admin.docentes.edit', compact('docente', 'materias'));
    }

    public function update(\Illuminate\Http\Request $request, $id)
    {
        $docente = \App\Models\Docente::findOrFail($id);

        $validated = $request->validate([
            'especialidad' => 'nullable|string|max:150',
            'telefono'     => 'nullable|string|max:20',
            'estado'       => 'required|in:ACTIVO,INACTIVO,LICENCIA',
        ]);

        $docente->update($validated);

        return redirect()->route('admin.docentes.index')
            ->with('success', "Docente {$docente->nombre_completo} actualizado correctamente.");
    }
}