<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horarios — Panel Administrador | CUP FICCT</title>
    <meta name="description" content="Gestión de horarios de grupos académicos del CUP FICCT. Solo el administrador puede crear, editar y eliminar horarios con validación de conflictos.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <script>
        // Anti-flash: aplica tema antes del render
        if (localStorage.getItem('theme') === 'light' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: light)').matches)) {
            document.documentElement.classList.add('light-theme');
        } else {
            document.documentElement.classList.remove('light-theme');
        }
    </script>
    <style>
        /* ── TOKENS ── */
        :root {
            --bg:          #0f1117;
            --surface:     #1a1d27;
            --surface2:    #22263a;
            --border:      rgba(255,255,255,0.07);
            --text:        #e2e8f0;
            --muted:       #64748b;
            --table-hover: #1f2335;
            --accent:      #3b82f6;
            --accent-dim:  rgba(59,130,246,0.15);
        }
        .light-theme {
            --bg:          #f1f5f9;
            --surface:     #ffffff;
            --surface2:    #f8fafc;
            --border:      #e2e8f0;
            --text:        #1e293b;
            --muted:       #94a3b8;
            --table-hover: #f8fafc;
            --accent:      #1e3a6e;
            --accent-dim:  rgba(30,58,110,0.08);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Figtree', sans-serif; background: var(--bg); color: var(--text); }

        /* ── TOPBAR ── */
        .topbar {
            background: #1e3a6e;
            padding: 0 24px; height: 56px;
            display: flex; align-items: center; justify-content: space-between;
            position: fixed; top: 0; left: 0; right: 0; z-index: 200;
        }
        .topbar-brand { color: #fff; font-size: 16px; font-weight: 600; display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .topbar-right { display: flex; align-items: center; gap: 16px; }
        .topbar-user { color: #a8c8f0; font-size: 13px; display: flex; align-items: center; gap: 6px; }
        .btn-logout { background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.22); color: #fff; padding: 6px 14px; border-radius: 8px; font-size: 12px; cursor: pointer; text-decoration: none; display: flex; align-items: center; gap: 6px; transition: background .2s; font-family: 'Figtree', sans-serif; }
        .btn-logout:hover { background: rgba(255,255,255,0.22); }

        /* ── SIDEBAR ── */
        .sidebar { width: 224px; height: calc(100vh - 56px); background: #1e3a6e; position: fixed; top: 56px; left: 0; overflow-y: auto; padding: 20px 12px 24px; display: flex; flex-direction: column; gap: 2px; }
        .nav-label { font-size: 10px; font-weight: 700; color: rgba(168,200,240,0.55); text-transform: uppercase; letter-spacing: .1em; padding: 16px 10px 6px; }
        .nav-label:first-child { padding-top: 4px; }
        .nav-item { padding: 9px 12px; font-size: 13px; color: rgba(168,200,240,0.85); text-decoration: none; border-radius: 8px; display: flex; align-items: center; gap: 10px; transition: background .15s, color .15s; font-weight: 400; }
        .nav-item i { font-size: 16px; flex-shrink: 0; }
        .nav-item:hover { background: rgba(255,255,255,0.1); color: #fff; }
        .nav-item.active { background: rgba(255,255,255,0.15); color: #fff; font-weight: 500; }
        .nav-item.active i { color: #7dd3fc; }
        .nav-item.c-blue   i { color: #93c5fd; }
        .nav-item.c-amber  i { color: #fcd34d; }
        .nav-item.c-teal   i { color: #6ee7b7; }
        .nav-item.c-purple i { color: #c4b5fd; }
        .nav-item.c-rose   i { color: #fda4af; }
        .nav-item.c-sky    i { color: #7dd3fc; }
        .sidebar-footer { margin-top: auto; padding: 16px 10px 0; border-top: 1px solid rgba(255,255,255,0.08); font-size: 11px; color: rgba(168,200,240,0.4); text-align: center; }

        /* ── LAYOUT ── */
        .layout { margin-left: 224px; margin-top: 56px; padding: 28px; min-height: calc(100vh - 56px); }

        /* ── PAGE HEADER ── */
        .page-header { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 24px; flex-wrap: wrap; gap: 12px; }
        .page-title-group h1 { font-size: 22px; font-weight: 700; color: var(--text); display: flex; align-items: center; gap: 10px; }
        .page-title-group p { font-size: 13px; color: var(--muted); margin-top: 4px; }
        .page-title-group h1 i { color: #7dd3fc; }

        /* ── ALERTS ── */
        .alert { padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; font-size: 13px; display: flex; align-items: center; gap: 10px; animation: slideDown .3s ease; }
        .alert-ok  { background: rgba(16,185,129,0.15); color: #6ee7b7; border: 1px solid rgba(16,185,129,0.3); }
        .alert-err { background: rgba(244,63,94,0.15);  color: #fda4af; border: 1px solid rgba(244,63,94,0.3); }
        .light-theme .alert-ok  { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }
        .light-theme .alert-err { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
        @keyframes slideDown { from { opacity:0; transform: translateY(-8px); } to { opacity:1; transform: translateY(0); } }

        /* ── TOOLBAR ── */
        .toolbar { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 20px; flex-wrap: wrap; }
        .filter-group { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
        .filter-label { font-size: 12px; font-weight: 600; color: var(--muted); text-transform: uppercase; letter-spacing: .05em; }
        .filter-select {
            padding: 8px 12px; border-radius: 8px;
            border: 1px solid var(--border); background: var(--surface);
            color: var(--text); font-size: 13px; font-family: 'Figtree', sans-serif;
            cursor: pointer; min-width: 160px;
        }
        .filter-select:focus { outline: 2px solid var(--accent); outline-offset: 1px; }

        .btn-primary {
            padding: 9px 18px; border-radius: 8px; border: none;
            background: linear-gradient(135deg, #3b82f6, #1e40af);
            color: #fff; font-size: 13px; font-weight: 600;
            cursor: pointer; font-family: 'Figtree', sans-serif;
            display: inline-flex; align-items: center; gap: 6px;
            transition: opacity .15s, transform .1s;
            text-decoration: none;
        }
        .btn-primary:hover { opacity: .9; transform: translateY(-1px); }
        .light-theme .btn-primary { background: linear-gradient(135deg, #1e3a6e, #0f2147); }

        /* ── VISTA POR DÍA ── */
        .dia-section { margin-bottom: 20px; }
        .dia-header {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 16px; border-radius: 10px 10px 0 0;
            background: var(--surface2); border: 1px solid var(--border);
            border-bottom: none;
        }
        .dia-badge {
            font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em;
            padding: 2px 10px; border-radius: 99px;
        }
        .dia-badge.lunes     { background: rgba(59,130,246,0.2);  color: #93c5fd; }
        .dia-badge.martes    { background: rgba(139,92,246,0.2);  color: #c4b5fd; }
        .dia-badge.miercoles { background: rgba(16,185,129,0.2);  color: #6ee7b7; }
        .dia-badge.jueves    { background: rgba(245,158,11,0.2);  color: #fcd34d; }
        .dia-badge.viernes   { background: rgba(244,63,94,0.2);   color: #fda4af; }
        .dia-badge.sabado    { background: rgba(100,116,139,0.2); color: #94a3b8; }
        .light-theme .dia-badge.lunes     { background: #dbeafe; color: #1e40af; }
        .light-theme .dia-badge.martes    { background: #ede9fe; color: #5b21b6; }
        .light-theme .dia-badge.miercoles { background: #d1fae5; color: #065f46; }
        .light-theme .dia-badge.jueves    { background: #fef3c7; color: #92400e; }
        .light-theme .dia-badge.viernes   { background: #fee2e2; color: #991b1b; }
        .light-theme .dia-badge.sabado    { background: #f1f5f9; color: #475569; }

        .dia-count { font-size: 11px; color: var(--muted); }

        /* ── TABLA ── */
        .card { background: var(--surface); border: 1px solid var(--border); border-radius: 0 0 12px 12px; overflow: hidden; margin-bottom: 0; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th { padding: 10px 14px; font-size: 10px; font-weight: 700; color: var(--muted); text-align: left; background: var(--surface2); border-bottom: 1px solid var(--border); text-transform: uppercase; letter-spacing: .06em; }
        td { padding: 12px 14px; border-bottom: 1px solid var(--border); color: var(--text); vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: var(--table-hover); }

        /* ── HORARIO CHIP ── */
        .hora-chip { display: inline-flex; align-items: center; gap: 5px; padding: 3px 10px; border-radius: 6px; font-size: 12px; font-weight: 600; background: var(--accent-dim); color: var(--accent); font-variant-numeric: tabular-nums; }
        .hora-chip i { font-size: 13px; }

        /* ── DOCENTE CELL ── */
        .docente-cell { display: flex; align-items: center; gap: 8px; }
        .avatar { width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; flex-shrink: 0; background: rgba(139,92,246,0.15); color: #c4b5fd; }
        .light-theme .avatar { background: #ede9fe; color: #5b21b6; }
        .no-docente { color: var(--muted); font-style: italic; font-size: 12px; }

        /* ── AULA BADGE ── */
        .aula-badge { display: inline-flex; align-items: center; gap: 4px; padding: 2px 8px; border-radius: 5px; background: var(--surface2); color: var(--text); font-size: 12px; border: 1px solid var(--border); }
        .aula-badge i { font-size: 12px; color: var(--muted); }

        /* ── BOTONES DE ACCIÓN ── */
        .btn-edit {
            padding: 5px 11px; border-radius: 6px; font-size: 11px; font-weight: 600;
            border: 1px solid rgba(59,130,246,0.3); background: rgba(59,130,246,0.1); color: #93c5fd;
            cursor: pointer; font-family: 'Figtree', sans-serif;
            display: inline-flex; align-items: center; gap: 4px;
            transition: background .15s; text-decoration: none;
        }
        .btn-edit:hover { background: rgba(59,130,246,0.2); }
        .btn-del {
            padding: 5px 11px; border-radius: 6px; font-size: 11px; font-weight: 600;
            border: 1px solid rgba(244,63,94,0.3); background: rgba(244,63,94,0.1); color: #fda4af;
            cursor: pointer; font-family: 'Figtree', sans-serif;
            display: inline-flex; align-items: center; gap: 4px;
            transition: background .15s;
        }
        .btn-del:hover { background: rgba(244,63,94,0.2); }
        .light-theme .btn-edit { background: #dbeafe; color: #1e40af; border-color: #bfdbfe; }
        .light-theme .btn-edit:hover { background: #bfdbfe; }
        .light-theme .btn-del  { background: #fee2e2; color: #991b1b; border-color: #fca5a5; }
        .light-theme .btn-del:hover  { background: #fca5a5; }

        /* ── EMPTY STATE ── */
        .empty-state { text-align: center; padding: 48px 24px; color: var(--muted); }
        .empty-state i { font-size: 48px; margin-bottom: 12px; display: block; opacity: .4; }
        .empty-state p { font-size: 14px; margin-bottom: 4px; }
        .empty-state span { font-size: 12px; }

        /* ── RESUMEN GLOBAL si no hay filtro ── */
        .stats-bar { display: flex; gap: 12px; margin-bottom: 20px; flex-wrap: wrap; }
        .stat-pill { padding: 8px 16px; border-radius: 99px; font-size: 12px; font-weight: 600; border: 1px solid var(--border); background: var(--surface); display: flex; align-items: center; gap: 6px; }
        .stat-pill i { font-size: 14px; }
        .stat-pill.blue   { border-color: rgba(59,130,246,0.3); color: #93c5fd; }
        .stat-pill.teal   { border-color: rgba(16,185,129,0.3); color: #6ee7b7; }
        .stat-pill.purple { border-color: rgba(139,92,246,0.3); color: #c4b5fd; }
        .light-theme .stat-pill.blue   { border-color: #bfdbfe; color: #1e40af; background: #dbeafe; }
        .light-theme .stat-pill.teal   { border-color: #a7f3d0; color: #065f46; background: #d1fae5; }
        .light-theme .stat-pill.purple { border-color: #ddd6fe; color: #5b21b6; background: #ede9fe; }

        /* ── MODAL ── */
        .modal-overlay {
            position: fixed; inset: 0; z-index: 1000;
            background: rgba(0,0,0,0.6); backdrop-filter: blur(4px);
            display: flex; align-items: center; justify-content: center;
            opacity: 0; pointer-events: none; transition: opacity .25s;
        }
        .modal-overlay.open { opacity: 1; pointer-events: all; }
        .modal {
            background: var(--surface); border: 1px solid var(--border);
            border-radius: 16px; width: 520px; max-width: calc(100vw - 32px);
            max-height: 90vh; overflow-y: auto;
            transform: scale(0.95) translateY(16px);
            transition: transform .25s;
            box-shadow: 0 24px 64px rgba(0,0,0,0.5);
        }
        .modal-overlay.open .modal { transform: scale(1) translateY(0); }
        .modal-header { padding: 22px 24px 16px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
        .modal-title { font-size: 16px; font-weight: 700; display: flex; align-items: center; gap: 8px; }
        .modal-title i { color: #7dd3fc; }
        .btn-close { background: none; border: none; color: var(--muted); cursor: pointer; padding: 4px; border-radius: 6px; font-size: 20px; transition: color .15s; }
        .btn-close:hover { color: var(--text); }
        .modal-body { padding: 24px; display: flex; flex-direction: column; gap: 16px; }
        .modal-footer { padding: 16px 24px; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 10px; }

        /* ── FORM FIELDS ── */
        .form-row { display: grid; gap: 14px; }
        .form-row.cols-2 { grid-template-columns: 1fr 1fr; }
        .form-group { display: flex; flex-direction: column; gap: 5px; }
        .form-label { font-size: 11px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: .06em; }
        .form-control {
            padding: 9px 12px; border-radius: 8px;
            border: 1px solid var(--border); background: var(--surface2);
            color: var(--text); font-size: 13px; font-family: 'Figtree', sans-serif;
            width: 100%; transition: border-color .15s;
        }
        .form-control:focus { outline: none; border-color: var(--accent); }
        .form-control option { background: var(--surface2); }
        .form-hint { font-size: 11px; color: var(--muted); }

        .btn-cancel { padding: 9px 18px; border-radius: 8px; border: 1px solid var(--border); background: var(--surface2); color: var(--text); font-size: 13px; font-weight: 500; cursor: pointer; font-family: 'Figtree', sans-serif; transition: background .15s; }
        .btn-cancel:hover { background: var(--border); }

        /* ── CONFLICT WARNING ── */
        .conflict-hint { padding: 10px 14px; border-radius: 8px; background: rgba(245,158,11,0.12); border: 1px solid rgba(245,158,11,0.3); color: #fcd34d; font-size: 12px; line-height: 1.5; display: none; }
        .light-theme .conflict-hint { background: #fef3c7; color: #92400e; border-color: #fcd34d; }
    </style>
</head>
<body>
<script>
    window.addEventListener('pageshow', function(e) { if (e.persisted) window.location.reload(); });
</script>

{{-- ── TOPBAR ── --}}
<div class="topbar">
    <a href="{{ route('admin.dashboard') }}" class="topbar-brand">
        <i class="ti ti-school" style="font-size:20px"></i> CUP — FICCT
    </a>
    <div class="topbar-right">
        <button id="theme-toggle" class="btn-logout" style="border:none;background:none;padding:8px" title="Cambiar Tema">
            <i class="ti ti-moon" id="theme-icon" style="font-size:18px"></i>
        </button>
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

{{-- ── SIDEBAR ── --}}
@include('admin.partials.sidebar')

{{-- ── CONTENIDO ── --}}
<div class="layout">

    {{-- PAGE HEADER --}}
    <div class="page-header">
        <div class="page-title-group">
            <h1><i class="ti ti-calendar-time"></i> Gestión de Horarios</h1>
            <p>Solo el administrador puede crear, editar y eliminar horarios. El sistema valida que no existan choques de grupo, docente ni aula.</p>
        </div>
        <button class="btn-primary" id="btn-nuevo" onclick="abrirModalNuevo()">
            <i class="ti ti-plus"></i> Agregar Horario
        </button>
    </div>

    {{-- ALERTAS --}}
    @if(session('success'))
        <div class="alert alert-ok"><i class="ti ti-circle-check"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-err"><i class="ti ti-alert-circle"></i> {{ session('error') }}</div>
    @endif

    {{-- STATS BAR --}}
    <div class="stats-bar">
        <div class="stat-pill blue"><i class="ti ti-calendar"></i> {{ $horarios->count() }} horario{{ $horarios->count() !== 1 ? 's' : '' }}</div>
        <div class="stat-pill teal"><i class="ti ti-layout-grid"></i> {{ $grupos->count() }} grupos</div>
        <div class="stat-pill purple"><i class="ti ti-chalkboard"></i> {{ $docentes->count() }} docentes activos</div>
    </div>

    {{-- TOOLBAR: FILTRO POR GRUPO --}}
    <div class="toolbar">
        <form method="GET" action="{{ route('admin.horarios.index') }}" class="filter-group" id="filter-form">
            <span class="filter-label"><i class="ti ti-filter" style="font-size:12px"></i> Filtrar por grupo:</span>
            <select name="grupo_id" id="grupo_filter" class="filter-select" onchange="document.getElementById('filter-form').submit()">
                <option value="">— Todos los grupos —</option>
                @foreach($grupos as $g)
                    <option value="{{ $g->id }}" {{ $grupoFiltro == $g->id ? 'selected' : '' }}>
                        Grupo {{ $g->codigo_grupo }} ({{ $g->turno }})
                    </option>
                @endforeach
            </select>
            @if($grupoFiltro)
                <a href="{{ route('admin.horarios.index') }}" class="btn-cancel" style="padding:8px 12px;font-size:12px">
                    <i class="ti ti-x" style="font-size:11px"></i> Limpiar
                </a>
            @endif
        </form>
    </div>

    {{-- HORARIOS AGRUPADOS POR DÍA --}}
    @php
        $dias = ['LUNES','MARTES','MIÉRCOLES','JUEVES','VIERNES','SÁBADO'];
        $diaClass = [
            'LUNES' => 'lunes', 'MARTES' => 'martes', 'MIÉRCOLES' => 'miercoles',
            'JUEVES' => 'jueves', 'VIERNES' => 'viernes', 'SÁBADO' => 'sabado'
        ];
    @endphp

    @if($horarios->isEmpty())
        <div class="card" style="border-radius:12px">
            <div class="empty-state">
                <i class="ti ti-calendar-off"></i>
                <p>No hay horarios registrados{{ $grupoFiltro ? ' para este grupo' : '' }}.</p>
                <span>Haz clic en <strong>Agregar Horario</strong> para crear el primero.</span>
            </div>
        </div>
    @else
        @foreach($dias as $dia)
            @php $horariosDia = $horarios->where('dia_semana', $dia); @endphp
            @if($horariosDia->count() > 0)
            <div class="dia-section">
                <div class="dia-header">
                    <span class="dia-badge {{ $diaClass[$dia] }}">{{ $dia }}</span>
                    <span class="dia-count">{{ $horariosDia->count() }} clase{{ $horariosDia->count() !== 1 ? 's' : '' }}</span>
                </div>
                <div class="card">
                    <table>
                        <thead>
                            <tr>
                                <th>Hora</th>
                                <th>Materia</th>
                                @if(!$grupoFiltro)<th>Grupo</th>@endif
                                <th>Docente</th>
                                <th>Aula</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($horariosDia->sortBy('hora_inicio') as $h)
                            <tr>
                                <td>
                                    <span class="hora-chip">
                                        <i class="ti ti-clock"></i>
                                        {{ substr($h->hora_inicio,0,5) }} – {{ substr($h->hora_fin,0,5) }}
                                    </span>
                                </td>
                                <td style="font-weight:600">{{ $h->materia->nombre ?? '—' }}</td>
                                @if(!$grupoFiltro)
                                <td style="color:var(--muted);font-size:12px">
                                    Grupo {{ $h->grupo->codigo_grupo ?? '?' }} · {{ $h->grupo->turno ?? '' }}
                                </td>
                                @endif
                                <td>
                                    @if($h->docente)
                                        <div class="docente-cell">
                                            <div class="avatar">{{ substr($h->docente->nombre,0,1) }}{{ substr($h->docente->apellido,0,1) }}</div>
                                            <span>{{ $h->docente->nombre }} {{ $h->docente->apellido }}</span>
                                        </div>
                                    @else
                                        <span class="no-docente"><i class="ti ti-user-off"></i> Sin asignar</span>
                                    @endif
                                </td>
                                <td>
                                    @if($h->aula)
                                        <span class="aula-badge"><i class="ti ti-door"></i> {{ $h->aula }}</span>
                                    @else
                                        <span style="color:var(--muted);font-size:12px">—</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="display:flex;gap:6px">
                                        <button class="btn-edit" onclick="abrirModalEditar({{ $h->id }}, {{ $h->grupo_id }}, {{ $h->materia_id }}, {{ $h->docente_id ?? 'null' }}, '{{ $h->dia_semana }}', '{{ substr($h->hora_inicio,0,5) }}', '{{ substr($h->hora_fin,0,5) }}', '{{ addslashes($h->aula ?? '') }}')">
                                            <i class="ti ti-pencil"></i> Editar
                                        </button>
                                        <button type="button" class="btn-del" onclick="confirmarEliminar({{ $h->id }})">
                                            <i class="ti ti-trash"></i> Eliminar
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        @endforeach
    @endif

</div>

{{-- FORM OCULTO ÚNICO PARA ELIMINAR (fuera de la tabla, evita HTML inválido) --}}
<form id="form-eliminar" method="POST" action="" style="display:none">
    @csrf
    @method('DELETE')
    <input type="hidden" id="eliminar-grupo-filtro" name="_grupo_filtro" value="{{ $grupoFiltro ?? '' }}">
</form>

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- MODAL: CREAR / EDITAR HORARIO                          --}}
{{-- ═══════════════════════════════════════════════════════ --}}
<div class="modal-overlay" id="modal-overlay">
    <div class="modal" role="dialog" aria-modal="true" aria-labelledby="modal-title-text">
        <div class="modal-header">
            <div class="modal-title" id="modal-title-text">
                <i class="ti ti-calendar-plus"></i>
                <span id="modal-title-label">Agregar Horario</span>
            </div>
            <button class="btn-close" onclick="cerrarModal()" aria-label="Cerrar">&times;</button>
        </div>

        <form id="horario-form" method="POST" action="{{ route('admin.horarios.store') }}">
            @csrf
            <span id="method-field"></span>

            <div class="modal-body">

                {{-- INFO ROL --}}
                <div style="padding:10px 14px;border-radius:8px;background:var(--accent-dim);border:1px solid rgba(59,130,246,0.2);font-size:12px;color:var(--accent);display:flex;align-items:center;gap:8px">
                    <i class="ti ti-shield-check" style="font-size:16px"></i>
                    <span>Solo el <strong>Administrador</strong> puede gestionar horarios. El sistema valida automáticamente choques de horarios.</span>
                </div>

                {{-- GRUPO + MATERIA --}}
                <div class="form-row cols-2">
                    <div class="form-group">
                        <label class="form-label" for="f-grupo">Grupo *</label>
                        <select id="f-grupo" name="grupo_id" class="form-control" required>
                            <option value="">— Seleccionar —</option>
                            @foreach($grupos as $g)
                                <option value="{{ $g->id }}">Grupo {{ $g->codigo_grupo }} — {{ $g->turno }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="f-materia">Materia *</label>
                        <select id="f-materia" name="materia_id" class="form-control" required>
                            <option value="">— Seleccionar —</option>
                            @foreach($materias as $m)
                                <option value="{{ $m->id }}">{{ $m->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- DOCENTE --}}
                <div class="form-group">
                    <label class="form-label" for="f-docente">Docente</label>
                    <select id="f-docente" name="docente_id" class="form-control">
                        <option value="">— Sin asignar —</option>
                        @foreach($docentes as $d)
                            <option value="{{ $d->id }}">{{ $d->nombre }} {{ $d->apellido }} · {{ $d->especialidad }}</option>
                        @endforeach
                    </select>
                    <span class="form-hint">Opcional. El sistema verificará que el docente no tenga otra clase en el mismo horario.</span>
                </div>

                {{-- DÍA --}}
                <div class="form-group">
                    <label class="form-label" for="f-dia">Día de la semana *</label>
                    <select id="f-dia" name="dia_semana" class="form-control" required>
                        <option value="">— Seleccionar —</option>
                        @foreach(['LUNES','MARTES','MIÉRCOLES','JUEVES','VIERNES','SÁBADO'] as $d)
                            <option value="{{ $d }}">{{ $d }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- HORAS --}}
                <div class="form-row cols-2">
                    <div class="form-group">
                        <label class="form-label" for="f-inicio">Hora inicio *</label>
                        <input type="time" id="f-inicio" name="hora_inicio" class="form-control" required step="900">
                        <span class="form-hint">Formato 24h, p.ej. 08:00</span>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="f-fin">Hora fin *</label>
                        <input type="time" id="f-fin" name="hora_fin" class="form-control" required step="900">
                        <span class="form-hint">Debe ser posterior a la hora de inicio</span>
                    </div>
                </div>

                {{-- AULA --}}
                <div class="form-group">
                    <label class="form-label" for="f-aula">Aula / Ambiente</label>
                    <input type="text" id="f-aula" name="aula" class="form-control" placeholder="Ej: Aula 201, Lab. Cómputo A" maxlength="60">
                    <span class="form-hint">Opcional. El sistema verificará que el aula no esté ocupada en ese horario.</span>
                </div>

                {{-- AVISO DE CONFLICTOS --}}
                <div class="conflict-hint" id="conflict-hint">
                    <i class="ti ti-alert-triangle"></i> El sistema verificará conflictos al guardar. Si ya existe un horario que se traslape (mismo grupo, docente o aula en ese día y hora), el registro será rechazado con un mensaje de error específico.
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="cerrarModal()">Cancelar</button>
                <button type="submit" class="btn-primary" id="btn-submit">
                    <i class="ti ti-device-floppy"></i> <span id="btn-submit-text">Guardar Horario</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// ── THEME TOGGLE ──
const themeToggleBtn = document.getElementById('theme-toggle');
const themeIcon      = document.getElementById('theme-icon');
function updateThemeIcon() {
    themeIcon.className = document.documentElement.classList.contains('light-theme')
        ? 'ti ti-sun' : 'ti ti-moon';
}
updateThemeIcon();
themeToggleBtn.addEventListener('click', () => {
    const isLight = document.documentElement.classList.toggle('light-theme');
    localStorage.setItem('theme', isLight ? 'light' : 'dark');
    updateThemeIcon();
});

// ── MODAL ──
const overlay  = document.getElementById('modal-overlay');
const form     = document.getElementById('horario-form');
const titleLbl = document.getElementById('modal-title-label');
const titleIco = document.querySelector('#modal-title-text i');
const methodFl = document.getElementById('method-field');
const btnTxt   = document.getElementById('btn-submit-text');
const baseUrl  = "{{ route('admin.horarios.store') }}";

function abrirModalNuevo() {
    form.reset();
    form.action = baseUrl;
    methodFl.innerHTML = '';
    titleLbl.textContent = 'Agregar Horario';
    titleIco.className = 'ti ti-calendar-plus';
    btnTxt.textContent = 'Guardar Horario';
    document.getElementById('conflict-hint').style.display = 'block';
    overlay.classList.add('open');
    document.getElementById('f-grupo').focus();
}

function abrirModalEditar(id, grupoId, materiaId, docenteId, dia, inicio, fin, aula) {
    form.reset();
    form.action = "{{ url('admin/horarios') }}/" + id;
    methodFl.innerHTML = '<input type="hidden" name="_method" value="PUT">';
    titleLbl.textContent = 'Editar Horario';
    titleIco.className = 'ti ti-edit';
    btnTxt.textContent = 'Actualizar Horario';

    document.getElementById('f-grupo').value   = grupoId;
    document.getElementById('f-materia').value = materiaId;
    document.getElementById('f-docente').value = docenteId || '';
    document.getElementById('f-dia').value     = dia;
    document.getElementById('f-inicio').value  = inicio;
    document.getElementById('f-fin').value     = fin;
    document.getElementById('f-aula').value    = aula;

    document.getElementById('conflict-hint').style.display = 'block';
    overlay.classList.add('open');
}

function cerrarModal() {
    overlay.classList.remove('open');
}

// ── ELIMINAR HORARIO (form oculto único reutilizable) ──
function confirmarEliminar(id) {
    if (!confirm('¿Eliminar este horario? Esta acción no se puede deshacer.')) return;
    const formEliminar = document.getElementById('form-eliminar');
    formEliminar.action = '{{ url("admin/horarios") }}/' + id;
    formEliminar.submit();
}

// Cerrar al hacer clic fuera del modal
overlay.addEventListener('click', (e) => {
    if (e.target === overlay) cerrarModal();
});

// Cerrar con Escape
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') cerrarModal();
});

// Validación cliente: hora fin > hora inicio
document.getElementById('f-inicio').addEventListener('change', validarHoras);
document.getElementById('f-fin').addEventListener('change', validarHoras);

function validarHoras() {
    const inicio = document.getElementById('f-inicio').value;
    const fin    = document.getElementById('f-fin').value;
    const btnSubmit = document.getElementById('btn-submit');
    if (inicio && fin && fin <= inicio) {
        document.getElementById('f-fin').style.borderColor = '#f43f5e';
        btnSubmit.disabled = true;
        btnSubmit.style.opacity = '.5';
    } else {
        document.getElementById('f-fin').style.borderColor = '';
        btnSubmit.disabled = false;
        btnSubmit.style.opacity = '';
    }
}
</script>
</body>
</html>
