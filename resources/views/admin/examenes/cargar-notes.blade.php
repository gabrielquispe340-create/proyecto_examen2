<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cargar Notas — CUP FICCT</title>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Figtree', sans-serif; background: #f1f5f9; color: #1e293b; }

        .topbar { background: #1e3a6e; padding: 0 24px; height: 56px; display: flex; align-items: center; justify-content: space-between; position: fixed; top: 0; left: 0; right: 0; z-index: 200; }
        .topbar-brand { color: #fff; font-size: 16px; font-weight: 600; display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .topbar-right { display: flex; align-items: center; gap: 16px; }
        .topbar-user { color: #a8c8f0; font-size: 13px; display: flex; align-items: center; gap: 6px; }
        .btn-logout { background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.22); color: #fff; padding: 6px 14px; border-radius: 8px; font-size: 12px; cursor: pointer; text-decoration: none; display: flex; align-items: center; gap: 6px; }
        .btn-logout:hover { background: rgba(255,255,255,0.22); }

        .sidebar { width: 224px; height: calc(100vh - 56px); background: #1e3a6e; position: fixed; top: 56px; left: 0; overflow-y: auto; padding: 20px 12px 24px; display: flex; flex-direction: column; gap: 2px; }
        .nav-label { font-size: 10px; font-weight: 700; color: rgba(168,200,240,0.55); text-transform: uppercase; letter-spacing: .1em; padding: 16px 10px 6px; }
        .nav-label:first-child { padding-top: 4px; }
        .nav-item { padding: 9px 12px; font-size: 13px; color: rgba(168,200,240,0.85); text-decoration: none; border-radius: 8px; display: flex; align-items: center; gap: 10px; transition: background .15s; font-weight: 400; }
        .nav-item i { font-size: 16px; flex-shrink: 0; }
        .nav-item:hover { background: rgba(255,255,255,0.1); color: #fff; }
        .nav-item.active { background: rgba(255,255,255,0.15); color: #fff; font-weight: 500; }
        .nav-item.c-blue   i { color: #93c5fd; }
        .nav-item.c-amber  i { color: #fcd34d; }
        .nav-item.c-teal   i { color: #6ee7b7; }
        .nav-item.c-purple i { color: #c4b5fd; }
        .nav-item.c-rose   i { color: #fda4af; }
        .nav-item.c-sky    i { color: #7dd3fc; }
        .sidebar-footer { margin-top: auto; padding: 16px 10px 0; font-size: 11px; color: rgba(168,200,240,0.4); }

        .main { margin-left: 224px; padding-top: 56px; min-height: 100vh; }
        .page { padding: 28px; max-width: 900px; }
        
        /* Breadcrumb */
        .breadcrumb { display: flex; align-items: center; gap: 6px; font-size: 13px; color: #94a3b8; margin-bottom: 20px; }
        .breadcrumb a { color: #94a3b8; text-decoration: none; }
        .breadcrumb a:hover { color: #1e3a6e; }
        .breadcrumb span { color: #1e293b; font-weight: 500; }

        .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; }
        .page-title { font-size: 20px; font-weight: 600; }
        .page-sub { font-size: 13px; color: #94a3b8; margin-top: 3px; }

        .alert { padding: 12px 16px; border-radius: 10px; margin-bottom: 16px; font-size: 13px; display: flex; align-items: center; gap: 8px; }
        .alert-ok  { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }
        .alert-err { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }

        /* Filtro de grupo */
        .filter-card { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; padding: 18px 20px; margin-bottom: 24px; display: flex; gap: 16px; align-items: flex-end; }
        .filter-card label { font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: .04em; display: block; margin-bottom: 6px; }
        .filter-card select { padding: 8px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; color: #374151; background: #f8fafc; font-family: 'Figtree', sans-serif; min-width: 200px; outline: none; }
        .filter-card select:focus { border-color: #1e3a6e; background: #fff; }
        .btn-filter { padding: 9px 18px; background: #1e3a6e; color: #fff; border: none; border-radius: 8px; font-size: 13px; font-weight: 500; cursor: pointer; font-family: 'Figtree', sans-serif; display: flex; align-items: center; gap: 6px; transition: background .15s; }
        .btn-filter:hover { background: #0f2147; }

        /* Planilla de notas */
        .card { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; margin-bottom: 24px; }
        .card-header { padding: 16px 20px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; }
        .card-header h3 { font-size: 14px; font-weight: 600; color: #1e293b; }
        .badge-info { background: #ede9fe; color: #5b21b6; border: 1px solid #c4b5fd; font-size: 12px; }
        
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th { text-align: left; padding: 12px 16px; font-size: 11px; font-weight: 600; color: #94a3b8; background: #f8fafc; border-bottom: 1px solid #f1f5f9; text-transform: uppercase; letter-spacing: .04em; }
        td { padding: 14px 16px; border-bottom: 1px solid #f8fafc; color: #374151; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        
        .avatar { width: 30px; height: 30px; border-radius: 50%; background: #dbeafe; color: #1e40af; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 600; }
        
        /* Input de nota */
        .grade-input { width: 80px; padding: 6px 10px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px; text-align: center; font-weight: 600; color: #0f172a; outline: none; transition: border-color .15s; }
        .grade-input:focus { border-color: #1e3a6e; box-shadow: 0 0 0 3px rgba(30,58,110,0.08); }
        .grade-input:disabled { background: #f1f5f9; color: #94a3b8; cursor: not-allowed; }

        .btn-save { padding: 10px 24px; background: #10b981; color: #fff; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; font-family: 'Figtree', sans-serif; display: inline-flex; align-items: center; gap: 8px; transition: background .15s; }
        .btn-save:hover { background: #059669; }

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
    <a href="{{ route('admin.dashboard') }}" class="topbar-brand">
        <i class="ti ti-school" style="font-size:20px"></i> CUP — FICCT
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

@include('admin.partials.sidebar')

<main class="main">
<div class="page">

    {{-- BREADCRUMB --}}
    <div class="breadcrumb">
        <a href="{{ route('admin.examenes.index') }}"><i class="ti ti-arrow-left" style="font-size:14px"></i> Exámenes</a>
        <span style="color:#cbd5e1">/</span>
        <span>Cargar Notas</span>
    </div>

    <div class="page-header">
        <div>
            <div class="page-title">Planilla de Registro de Notas</div>
            <div class="page-sub">{{ $examen->materia_nombre }} ({{ $examen->materia_codigo }}) — {{ $examen->nro_examen }}º Examen Parcial (Peso: {{ $examen->porcentaje_peso }}%)</div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-ok"><i class="ti ti-circle-check"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-err"><i class="ti ti-alert-circle"></i> {{ session('error') }}</div>
    @endif

    {{-- FILTRO DE GRUPO --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('admin.examenes.cargar-notas', $examen->id) }}" style="display:flex;align-items:flex-end;gap:12px">
            <div>
                <label>Seleccionar Grupo Académico *</label>
                <select name="grupo_id" required>
                    <option value="">-- Seleccionar grupo --</option>
                    @foreach($grupos as $g)
                        <option value="{{ $g->id }}" {{ $grupoId == $g->id ? 'selected' : '' }}>
                            {{ $g->codigo_grupo }} ({{ $g->turno }})
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn-filter">
                <i class="ti ti-check"></i> Cargar Planilla
            </button>
        </form>
    </div>

    {{-- PLANILLA DE ESTUDIANTES --}}
    @if($grupoId)
        <div class="card">
            <div class="card-header">
                <h3>Postulantes del Grupo</h3>
                <span class="badge badge-purple"><i class="ti ti-school"></i> Notas sobre 100 puntos</span>
            </div>

            @if(empty($postulantes))
                <div class="empty">
                    <i class="ti ti-users" style="font-size:36px;display:block;margin-bottom:10px"></i>
                    No hay postulantes registrados en este grupo.
                </div>
            @else
                <form method="POST" action="{{ route('admin.examenes.guardar-notas', $examen->id) }}">
                    @csrf
                    <input type="hidden" name="grupo_id" value="{{ $grupoId }}">

                    <div class="table-responsive"><table>
                        <thead>
                            <tr>
                                <th style="width: 140px">Registro</th>
                                <th>Nombre Completo</th>
                                <th style="width: 160px; text-align: center">Nota Obtenida</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $index = 0; @endphp
                            @foreach($postulantes as $p)
                            <tr>
                                <td style="font-weight:600;color:#1e3a6e">{{ $p['codigo_estudiante'] }}</td>
                                <td>
                                    <div style="display:flex;align-items:center;gap:10px">
                                        <div class="avatar">
                                            {{ strtoupper(substr($p['nombre'], 0, 1)) }}{{ strtoupper(substr($p['apellido'], 0, 1)) }}
                                        </div>
                                        <div>
                                            <div style="font-weight:500">{{ $p['nombre'] }} {{ $p['apellido'] }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="text-align: center">
                                    <input type="number" 
                                           name="notas[{{ $p['id'] }}]" 
                                           value="{{ $p['nota'] }}" 
                                           min="0" 
                                           max="100" 
                                           step="0.01" 
                                           placeholder="—"
                                           class="grade-input">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table></div>

                    <div style="padding: 20px; text-align: right; background: #f8fafc; border-top: 1px solid #f1f5f9;">
                        <button type="submit" class="btn-save">
                            <i class="ti ti-device-floppy"></i> Guardar Calificaciones
                        </button>
                    </div>
                </form>
            @endif
        </div>
    @else
        <div class="card" style="border-style:dashed;background:rgba(255,255,255,0.4)">
            <div class="empty">
                <i class="ti ti-filter" style="font-size:36px;display:block;margin-bottom:10px;color:#94a3b8"></i>
                Selecciona un grupo y haz clic en "Cargar Planilla" para registrar calificaciones.
            </div>
        </div>
    @endif

</div>
</main>

</body>
</html>
