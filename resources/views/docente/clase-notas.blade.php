<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Notas — CUP FICCT</title>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Figtree', sans-serif; background: #f1f5f9; color: #1e293b; }

        .topbar { background: #0f172a; padding: 0 24px; height: 56px; display: flex; align-items: center; justify-content: space-between; position: fixed; top: 0; left: 0; right: 0; z-index: 200; }
        .topbar-brand { color: #fff; font-size: 16px; font-weight: 600; display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .topbar-right { display: flex; align-items: center; gap: 16px; }
        .topbar-user { color: #cbd5e1; font-size: 13px; display: flex; align-items: center; gap: 6px; }
        .btn-logout { background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.22); color: #fff; padding: 6px 14px; border-radius: 8px; font-size: 12px; cursor: pointer; text-decoration: none; display: flex; align-items: center; gap: 6px; }
        .btn-logout:hover { background: rgba(255,255,255,0.22); }

        .main { margin-top: 56px; padding: 40px 24px; min-height: calc(100vh - 56px); display: flex; justify-content: center; }
        .page { width: 100%; max-width: 1100px; }
        
        .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; gap: 16px; }
        .page-title { font-size: 20px; font-weight: 600; color: #0f172a; display: flex; align-items: center; gap: 8px; }
        .page-sub { font-size: 13px; color: #64748b; margin-top: 3px; }

        .btn-back { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; background: #fff; border: 1px solid #cbd5e1; border-radius: 8px; color: #334155; font-size: 13px; font-weight: 500; text-decoration: none; transition: background .15s; }
        .btn-back:hover { background: #f8fafc; }

        .alert { padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; font-size: 13px; display: flex; align-items: center; gap: 8px; }
        .alert-ok  { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }
        .alert-err { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }

        .card { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; margin-bottom: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .card-header { padding: 16px 20px; border-bottom: 1px solid #f1f5f9; font-weight: 600; font-size: 14px; color: #0f172a; display: flex; align-items: center; justify-content: space-between; }
        
        .class-meta { background: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 16px 20px; display: flex; flex-wrap: wrap; gap: 24px; }
        .meta-item { display: flex; flex-direction: column; gap: 4px; }
        .meta-label { font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; }
        .meta-value { font-size: 14px; font-weight: 600; color: #334155; }

        /* Planilla de Notas Table */
        .table-container { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th { background: #f8fafc; padding: 12px 16px; font-size: 12px; font-weight: 600; color: #475569; border-bottom: 1px solid #e2e8f0; white-space: nowrap; }
        td { padding: 12px 16px; font-size: 13px; border-bottom: 1px solid #f1f5f9; color: #334155; vertical-align: middle; }
        tr:hover td { background: #f8fafc; }

        .student-code { font-family: monospace; color: #64748b; font-weight: 500; font-size: 12px; }

        .input-grade { width: 80px; padding: 6px 10px; border: 1px solid #cbd5e1; border-radius: 6px; font-family: 'Figtree', sans-serif; font-size: 13px; font-weight: 600; color: #1e293b; text-align: center; outline: none; transition: border-color .15s; }
        .input-grade:focus { border-color: #0f172a; }
        .input-grade:disabled { background: #f1f5f9; color: #94a3b8; border-color: #e2e8f0; cursor: not-allowed; }

        /* Save Button */
        .card-footer { padding: 16px 20px; background: #f8fafc; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end; }
        .btn-save { padding: 10px 24px; background: #0f172a; color: #fff; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; font-family: 'Figtree', sans-serif; display: flex; align-items: center; gap: 6px; transition: background .15s; }
        .btn-save:hover { background: #1e293b; }

        .badge-nota { font-weight: 700; font-size: 12px; display: inline-flex; align-items: center; gap: 4px; }
        .text-pass { color: #059669; }
        .text-fail { color: #dc2626; }

        .empty { text-align: center; padding: 48px; color: #94a3b8; }
    
                /* =========================================================
           RESPONSIVE FIXES INJECTED BY AUTOMATION SCRIPT
           ========================================================= */
        .table-responsive { overflow-x: auto; width: 100%; -webkit-overflow-scrolling: touch; margin-bottom: 1rem; }
        .btn-menu-mobile { display: none; background: transparent; border: none; color: #fff; font-size: 24px; cursor: pointer; padding: 0 10px; }
        .overlay-mobile { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 250; }
        .overlay-mobile.show { display: block; }
        @media (max-width: 1024px) {
            .sidebar { transform: translateX(-100%); z-index: 300; transition: transform 0.3s ease; height: 100vh; top: 0; padding-top: 56px; }
            .sidebar.open { transform: translateX(0); }
            .main, .layout, .main-content { margin-left: 0 !important; width: 100% !important; padding-left: 0 !important; padding-right: 0 !important; }
            .topbar-brand { display: none; }
            .btn-menu-mobile { display: block; }
            .conteos { grid-template-columns: 1fr 1fr !important; }
            .filtros { flex-direction: column; align-items: stretch !important; }
            .filtros > div { width: 100%; }
            .filtros input, .filtros select { width: 100% !important; }
            .page { padding: 16px !important; }
            .topbar-user { display: none; }
        }
        @media (max-width: 480px) {
            .conteos { grid-template-columns: 1fr !important; }
        }
    </style>
</head>
<body>
<!-- Mobile Overlay -->
<div id="sidebar-overlay-mobile" class="overlay-mobile" onclick="document.querySelector('.sidebar').classList.remove('open'); this.classList.remove('show');"></div>

<div class="topbar">
    <button type="button" class="btn-menu-mobile" onclick="document.querySelector('.sidebar').classList.toggle('open'); document.getElementById('sidebar-overlay-mobile').classList.toggle('show');">&#9776;</button>
    <a href="{{ route('docente.dashboard') }}" class="topbar-brand">
        <i class="ti ti-school" style="font-size:20px"></i> Portal Docente — CUP FICCT
    </a>
    <div class="topbar-right">
        <span class="topbar-user">
            <i class="ti ti-user-circle" style="font-size:16px"></i>
            {{ Auth::user()->nombre }} {{ Auth::user()->apellido }}
        </span>
        <form method="POST" action="{{ route('logout') }}" style="display:inline">
            @csrf
            <button type="submit" class="btn-logout"><i class="ti ti-logout"></i> Salir</button>
        </form>
    </div>
</div>

<main class="main">
<div class="page">

    <div class="page-header">
        <div>
            <a href="{{ route('docente.dashboard') }}" class="btn-back">
                <i class="ti ti-arrow-left"></i> Volver al Panel
            </a>
        </div>
        <div style="text-align: right">
            <div class="page-title"><i class="ti ti-edit"></i> Planilla de Calificaciones</div>
            <div class="page-sub">Ingresa y actualiza los puntajes de las evaluaciones</div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-ok"><i class="ti ti-circle-check"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-err"><i class="ti ti-alert-circle"></i> {{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <span style="font-size: 15px; font-weight: 700; color: #0f172a;">Planilla de Notas</span>
            <span style="font-size: 11px; background: #e2e8f0; color: #334155; padding: 2px 8px; border-radius: 12px; font-weight: 700;">Gestión Académica</span>
        </div>

        {{-- Metadatos del grupo --}}
        <div class="class-meta">
            <div class="meta-item">
                <div class="meta-label">Materia</div>
                <div class="meta-value">{{ $clase->materia_nombre }} ({{ $clase->materia_codigo }})</div>
            </div>
            <div class="meta-item">
                <div class="meta-label">Grupo</div>
                <div class="meta-value">{{ $clase->codigo_grupo }}</div>
            </div>
            <div class="meta-item">
                <div class="meta-label">Turno</div>
                <div class="meta-value">{{ $clase->turno }}</div>
            </div>
            <div class="meta-item">
                <div class="meta-label">Total Estudiantes</div>
                <div class="meta-value">{{ count($planilla) }}</div>
            </div>
        </div>

        @if(count($planilla) === 0)
            <div class="empty">
                <i class="ti ti-users" style="font-size:36px;display:block;margin-bottom:8px"></i>
                No hay estudiantes asignados en este grupo.
            </div>
        @elseif(count($examenes) === 0)
            <div class="empty">
                <i class="ti ti-article" style="font-size:36px;display:block;margin-bottom:8px"></i>
                No se han programado exámenes para esta materia en la convocatoria activa.
            </div>
        @else
            <form action="{{ route('docente.clase.guardar-notas', $clase->horario_grupo_id) }}" method="POST">
                @csrf
                <div class="table-container">
                    <div class="table-responsive"><table>
                        <thead>
                            <tr>
                                <th style="width: 80px;">Reg. Universitario</th>
                                <th>Postulante</th>
                                @foreach($examenes as $ex)
                                    <th style="text-align: center; width: 140px;">
                                        Evaluación {{ $ex->nro_examen }}
                                        <div style="font-size: 10px; color: #64748b; font-weight: normal; margin-top: 2px;">
                                            Peso: {{ $ex->porcentaje_peso }}%
                                        </div>
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($planilla as $p)
                                <tr>
                                    <td class="student-code">{{ $p['codigo_estudiante'] }}</td>
                                    <td>
                                        <span style="font-weight: 600; color: #0f172a;">{{ $p['apellido'] }}</span>, {{ $p['nombre'] }}
                                    </td>
                                    @foreach($examenes as $ex)
                                        <td style="text-align: center;">
                                            <input type="number" 
                                                   name="notas[{{ $p['id'] }}][{{ $ex->id }}]" 
                                                   value="{{ $p['notas'][$ex->id] }}"
                                                   class="input-grade"
                                                   min="0"
                                                   max="100"
                                                   step="0.01"
                                                   placeholder="-"
                                            >
                                            <div style="margin-top: 4px;">
                                                @if($p['notas'][$ex->id] !== null && $p['notas'][$ex->id] !== '')
                                                    @if((float)$p['notas'][$ex->id] >= 60)
                                                        <span class="badge-nota text-pass">Aprobado (>=60)</span>
                                                    @else
                                                        <span class="badge-nota text-fail">Reprobado (<60)</span>
                                                    @endif
                                                @endif
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table></div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn-save">
                        <i class="ti ti-device-floppy"></i> Guardar Calificaciones
                    </button>
                </div>
            </form>
        @endif
    </div>

</div>
</main>

</body>
</html>
