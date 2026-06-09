<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Docente — CUP FICCT</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <script>
        // Pre-detect and apply theme before rendering to avoid flash
        if (localStorage.getItem('theme') === 'light' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: light)').matches)) {
            document.documentElement.classList.add('light-theme');
        }
    </script>
    <style>
        :root {
            --bg: #0f1117;
            --surface: #1a1d27;
            --surface2: #22263a;
            --border: rgba(255,255,255,0.07);
            --text: #e2e8f0;
            --muted: #64748b;
            --accent: #6366f1;
            --accent2: #8b5cf6;
            --green: #10b981;
            --amber: #f59e0b;
            --rose: #f43f5e;
            --sky: #0ea5e9;
            --sidebar-w: 240px;
        }

        .light-theme {
            --bg: #f8fafc;
            --surface: #ffffff;
            --surface2: #f1f5f9;
            --border: rgba(0, 0, 0, 0.08);
            --text: #0f172a;
            --muted: #64748b;
            --accent: #4f46e5;
            --accent2: #7c3aed;
        }

        /* Light Theme Overrides */
        .light-theme .nav-item {
            color: #475569;
        }
        .light-theme .nav-item:hover {
            background: rgba(0, 0, 0, 0.04);
            color: #0f172a;
        }
        .light-theme .nav-item.active {
            background: rgba(79, 70, 229, 0.1);
            color: #4f46e5;
        }
        .light-theme .topbar {
            background: rgba(248, 250, 252, 0.85);
        }
        .light-theme .welcome-banner {
            background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
            border: none;
        }
        .light-theme .welcome-banner::before, .light-theme .welcome-banner::after {
            display: none;
        }
        .light-theme .btn-logout {
            background: rgba(0, 0, 0, 0.04);
            color: #475569;
        }
        .light-theme .btn-logout:hover {
            background: rgba(0, 0, 0, 0.08);
            color: #0f172a;
        }
        .light-theme .empty-state {
            background: #ffffff;
            border-color: rgba(0, 0, 0, 0.12);
        }
        .light-theme .gc-stat {
            background: #f8fafc;
        }
        .light-theme .w-badge {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.25);
            color: #ffffff;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; }

        /* ── TOPBAR ── */
        .topbar {
            position: fixed; top: 0; left: var(--sidebar-w); right: 0; height: 60px;
            background: rgba(15,17,23,0.85); backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 28px; z-index: 100;
        }
        .topbar-title { font-size: 15px; font-weight: 600; color: var(--text); }
        .topbar-right { display: flex; align-items: center; gap: 16px; }
        .topbar-date { font-size: 12px; color: var(--muted); }
        .btn-logout {
            display: flex; align-items: center; gap: 6px; padding: 7px 14px;
            background: rgba(255,255,255,0.06); border: 1px solid var(--border);
            color: var(--text); border-radius: 8px; font-size: 12px; font-weight: 500;
            cursor: pointer; text-decoration: none; font-family: 'Inter', sans-serif;
            transition: background .2s;
        }
        .btn-logout:hover { background: rgba(255,255,255,0.12); }

        /* ── SIDEBAR ── */
        .sidebar {
            position: fixed; top: 0; left: 0; width: var(--sidebar-w); height: 100vh;
            background: var(--surface); border-right: 1px solid var(--border);
            display: flex; flex-direction: column; padding: 0 0 24px; z-index: 200;
            overflow-y: auto;
        }
        .sidebar-brand {
            display: flex; align-items: center; gap: 10px; padding: 20px 20px 16px;
            border-bottom: 1px solid var(--border);
        }
        .brand-icon {
            width: 36px; height: 36px; border-radius: 10px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .brand-text { font-size: 14px; font-weight: 700; color: var(--text); line-height: 1.2; }
        .brand-sub { font-size: 10px; color: var(--muted); font-weight: 400; }

        .nav-section { padding: 20px 12px 4px; }
        .nav-label { font-size: 9.5px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: .08em; padding: 0 8px; margin-bottom: 6px; }
        .nav-item {
            display: flex; align-items: center; gap: 10px; padding: 9px 12px; border-radius: 9px;
            color: rgba(226,232,240,0.6); text-decoration: none; font-size: 13px; font-weight: 500;
            transition: all .15s; margin-bottom: 2px; cursor: pointer; border: none; background: none;
            width: 100%;
        }
        .nav-item i { font-size: 17px; flex-shrink: 0; }
        .nav-item:hover { background: rgba(255,255,255,0.06); color: var(--text); }
        .nav-item.active { background: rgba(99,102,241,0.15); color: #a5b4fc; }
        .nav-item.active i { color: var(--accent); }

        .sidebar-footer {
            margin-top: auto; padding: 16px 20px 0;
            border-top: 1px solid var(--border);
        }
        .docente-card {
            display: flex; align-items: center; gap: 10px; padding: 12px;
            background: var(--surface2); border-radius: 10px; border: 1px solid var(--border);
        }
        .avatar-circle {
            width: 36px; height: 36px; border-radius: 50%; flex-shrink: 0;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 700; color: #fff;
        }
        .docente-info { min-width: 0; }
        .docente-name { font-size: 12px; font-weight: 600; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .docente-role { font-size: 10px; color: var(--muted); }

        /* ── MAIN ── */
        .main { margin-left: var(--sidebar-w); padding-top: 60px; min-height: 100vh; }
        .page { padding: 32px 28px; max-width: 1200px; }

        /* ── WELCOME BANNER ── */
        .welcome-banner {
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #1e1b4b 100%);
            border: 1px solid rgba(99,102,241,0.3);
            border-radius: 16px; padding: 28px 32px; margin-bottom: 28px;
            position: relative; overflow: hidden;
        }
        .welcome-banner::before {
            content: ''; position: absolute; top: -40px; right: -40px;
            width: 200px; height: 200px; border-radius: 50%;
            background: radial-gradient(circle, rgba(139,92,246,0.3) 0%, transparent 70%);
        }
        .welcome-banner::after {
            content: ''; position: absolute; bottom: -60px; right: 80px;
            width: 160px; height: 160px; border-radius: 50%;
            background: radial-gradient(circle, rgba(99,102,241,0.2) 0%, transparent 70%);
        }
        .welcome-greeting { font-size: 22px; font-weight: 700; color: #fff; margin-bottom: 6px; }
        .welcome-greeting span { color: #a5b4fc; }
        .welcome-sub { font-size: 13px; color: rgba(165,180,252,0.7); }
        .welcome-badges { display: flex; gap: 8px; margin-top: 16px; flex-wrap: wrap; }
        .w-badge {
            display: inline-flex; align-items: center; gap: 5px; padding: 5px 12px;
            background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.15);
            border-radius: 99px; font-size: 11px; font-weight: 500; color: #c7d2fe;
        }

        /* ── KPI CARDS ── */
        .kpis { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 28px; }
        .kpi {
            background: var(--surface); border: 1px solid var(--border); border-radius: 14px;
            padding: 20px; position: relative; overflow: hidden; transition: transform .2s;
        }
        .kpi:hover { transform: translateY(-2px); }
        .kpi-glow { position: absolute; top: -20px; right: -20px; width: 80px; height: 80px; border-radius: 50%; opacity: .15; }
        .kpi-icon {
            width: 40px; height: 40px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center; font-size: 20px; margin-bottom: 14px;
        }
        .kpi-value { font-size: 28px; font-weight: 700; color: var(--text); line-height: 1; margin-bottom: 4px; }
        .kpi-label { font-size: 12px; color: var(--muted); font-weight: 500; }
        .kpi-delta { font-size: 11px; margin-top: 8px; display: flex; align-items: center; gap: 4px; }
        .kpi.k-indigo .kpi-glow { background: var(--accent); }
        .kpi.k-indigo .kpi-icon { background: rgba(99,102,241,0.15); color: #a5b4fc; }
        .kpi.k-green  .kpi-glow { background: var(--green); }
        .kpi.k-green  .kpi-icon { background: rgba(16,185,129,0.15); color: #6ee7b7; }
        .kpi.k-amber  .kpi-glow { background: var(--amber); }
        .kpi.k-amber  .kpi-icon { background: rgba(245,158,11,0.15); color: #fcd34d; }
        .kpi.k-sky    .kpi-glow { background: var(--sky); }
        .kpi.k-sky    .kpi-icon { background: rgba(14,165,233,0.15); color: #7dd3fc; }

        /* ── SECTION HEADER ── */
        .sec-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; }
        .sec-title { font-size: 16px; font-weight: 700; color: var(--text); display: flex; align-items: center; gap: 8px; }
        .sec-title i { color: var(--accent); font-size: 18px; }

        /* ── GRUPO CARDS ── */
        .grupos-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 16px; margin-bottom: 32px; }
        .grupo-card {
            background: var(--surface); border: 1px solid var(--border); border-radius: 14px;
            padding: 22px; transition: border-color .2s, transform .2s; position: relative; overflow: hidden;
        }
        .grupo-card:hover { border-color: rgba(99,102,241,0.4); transform: translateY(-2px); }
        .grupo-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, var(--accent), var(--accent2));
            border-radius: 14px 14px 0 0;
        }
        .gc-head { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 14px; }
        .gc-num {
            width: 44px; height: 44px; border-radius: 12px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            display: flex; align-items: center; justify-content: center;
            font-size: 16px; font-weight: 700; color: #fff; flex-shrink: 0;
        }
        .gc-badges { display: flex; flex-direction: column; align-items: flex-end; gap: 4px; }
        .badge {
            display: inline-flex; align-items: center; gap: 4px; padding: 3px 9px;
            border-radius: 99px; font-size: 10px; font-weight: 600;
        }
        .badge-turno-M { background: rgba(245,158,11,0.15); color: #fcd34d; border: 1px solid rgba(245,158,11,0.3); }
        .badge-turno-T { background: rgba(14,165,233,0.15); color: #7dd3fc; border: 1px solid rgba(14,165,233,0.3); }
        .badge-turno-N { background: rgba(139,92,246,0.15); color: #c4b5fd; border: 1px solid rgba(139,92,246,0.3); }
        .badge-activo  { background: rgba(16,185,129,0.15); color: #6ee7b7; border: 1px solid rgba(16,185,129,0.3); }

        .gc-nombre { font-size: 15px; font-weight: 700; color: var(--text); margin-bottom: 4px; }
        .gc-conv { font-size: 11px; color: var(--muted); margin-bottom: 14px; }
        .gc-materia { font-size: 11px; color: rgba(165,180,252,0.8); margin-bottom: 14px; display: flex; align-items: center; gap: 5px; }

        .gc-stats { display: grid; grid-template-columns: repeat(3,1fr); gap: 8px; margin-bottom: 16px; }
        .gc-stat {
            background: var(--surface2); border-radius: 8px; padding: 10px;
            text-align: center; border: 1px solid var(--border);
        }
        .gc-stat-val { font-size: 18px; font-weight: 700; color: var(--text); }
        .gc-stat-label { font-size: 9px; color: var(--muted); text-transform: uppercase; letter-spacing: .04em; margin-top: 2px; }
        .gc-stat .green { color: var(--green); }
        .gc-stat .amber { color: var(--amber); }
        .gc-stat .sky { color: var(--sky); }

        .gc-prog { margin-bottom: 16px; }
        .gc-prog-label { display: flex; justify-content: space-between; font-size: 11px; color: var(--muted); margin-bottom: 5px; }
        .prog-bar { height: 5px; background: var(--surface2); border-radius: 99px; overflow: hidden; }
        .prog-fill { height: 100%; border-radius: 99px; background: linear-gradient(90deg, var(--accent), var(--accent2)); transition: width .5s; }

        .btn-ver {
            display: flex; align-items: center; justify-content: center; gap: 7px; width: 100%;
            padding: 10px; background: rgba(99,102,241,0.12); border: 1px solid rgba(99,102,241,0.3);
            color: #a5b4fc; border-radius: 10px; font-size: 13px; font-weight: 600;
            text-decoration: none; transition: all .2s; font-family: 'Inter', sans-serif;
        }
        .btn-ver:hover { background: rgba(99,102,241,0.25); border-color: var(--accent); color: #c7d2fe; }

        /* ── EMPTY STATE ── */
        .empty-state {
            background: var(--surface); border: 1px dashed var(--border); border-radius: 14px;
            padding: 56px; text-align: center; color: var(--muted);
        }
        .empty-state i { font-size: 40px; display: block; margin-bottom: 12px; opacity: .4; }
        .empty-state p { font-size: 14px; }

        /* ── ALERTAS ── */
        .alert {
            padding: 12px 16px; border-radius: 10px; margin-bottom: 16px;
            font-size: 13px; display: flex; align-items: center; gap: 9px;
        }
        .alert-ok  { background: rgba(16,185,129,0.12); color: #6ee7b7; border: 1px solid rgba(16,185,129,0.25); }
        .alert-err { background: rgba(244,63,94,0.12); color: #fda4af; border: 1px solid rgba(244,63,94,0.25); }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            :root { --sidebar-w: 0px; }
            .sidebar { display: none; }
            .topbar { left: 0; }
            .kpis { grid-template-columns: repeat(2,1fr); }
        }
        @media (max-width: 480px) {
            .kpis { grid-template-columns: 1fr 1fr; }
            .page { padding: 20px 16px; }
        }
    </style>
</head>
<body>

<!-- ── SIDEBAR ── -->
<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon">
            <i class="ti ti-school" style="color:#fff;font-size:18px"></i>
        </div>
        <div class="brand-text">
            CUP — FICCT
            <div class="brand-sub">Portal Docente</div>
        </div>
    </div>

    <div class="nav-section">
        <div class="nav-label">Principal</div>
        <a href="{{ route('docente.dashboard') }}" class="nav-item active">
            <i class="ti ti-layout-dashboard"></i> Dashboard
        </a>
    </div>

    <div class="nav-section">
        <div class="nav-label">Mis Grupos</div>
        @foreach($grupos as $g)
        <a href="{{ route('docente.grupo.detalle', $g->grupo_id) }}" class="nav-item">
            <i class="ti ti-users"></i>
            Grupo {{ $g->numero_grupo }}
            <span style="margin-left:auto;font-size:10px;background:rgba(99,102,241,0.2);color:#a5b4fc;padding:1px 7px;border-radius:99px">{{ $g->total_postulantes }}</span>
        </a>
        @endforeach
    </div>

    <div class="sidebar-footer">
        <div class="docente-card">
            <div class="avatar-circle">
                {{ strtoupper(substr($docente->nombre,0,1).substr($docente->apellido,0,1)) }}
            </div>
            <div class="docente-info">
                <div class="docente-name">{{ $docente->nombre }} {{ $docente->apellido }}</div>
                <div class="docente-role">Docente · {{ $docente->especialidad ?? 'CUP FICCT' }}</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}" style="margin-top:10px">
            @csrf
            <button type="submit" class="btn-logout" style="width:100%;justify-content:center">
                <i class="ti ti-logout"></i> Cerrar sesión
            </button>
        </form>
    </div>
</aside>

<!-- ── TOPBAR ── -->
<div class="topbar">
    <div class="topbar-title">
        <i class="ti ti-layout-dashboard" style="color:var(--accent)"></i>
        Dashboard
    </div>
    <div class="topbar-right" style="display:flex;align-items:center;gap:16px">
        <button id="theme-toggle" class="btn-logout" style="padding: 7px 10px; cursor: pointer; margin-top:0; width:auto; border-radius:8px;" title="Alternar modo noche/día">
            <i class="ti ti-moon" id="theme-icon" style="font-size:16px;"></i>
        </button>
        <span class="topbar-date">
            <i class="ti ti-calendar"></i>
            {{ now()->locale('es')->isoFormat('dddd, D [de] MMMM YYYY') }}
        </span>
        <span style="font-size:12px;color:var(--muted);display:flex;align-items:center;gap:5px">
            <i class="ti ti-user-circle"></i>
            {{ Auth::user()->nombre }} {{ Auth::user()->apellido }}
        </span>
    </div>
</div>

<!-- ── MAIN ── -->
<main class="main">
<div class="page">

    @if(session('success'))
        <div class="alert alert-ok"><i class="ti ti-circle-check"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-err"><i class="ti ti-alert-circle"></i> {{ session('error') }}</div>
    @endif

    <!-- ── BIENVENIDA ── -->
    <div class="welcome-banner">
        <div class="welcome-greeting">
            ¡Bienvenido/a, <span>{{ $docente->nombre }} {{ $docente->apellido }}</span>! 👋
        </div>
        <div class="welcome-sub">
            Aquí puedes gestionar tus grupos, registrar asistencia y calificaciones del CUP FICCT.
        </div>
        <div class="welcome-badges">
            @if($docente->especialidad)
            <span class="w-badge"><i class="ti ti-briefcase"></i> {{ $docente->especialidad }}</span>
            @endif
            @if($docente->ci)
            <span class="w-badge"><i class="ti ti-id-badge"></i> CI: {{ $docente->ci }}</span>
            @endif
            @if($docente->codigo_docente)
            <span class="w-badge"><i class="ti ti-barcode"></i> Código: {{ $docente->codigo_docente }}</span>
            @endif
            <span class="w-badge">
                <i class="ti ti-point-filled" style="color:{{ ($docente->estado ?? (($docente->activo ?? false) ? 'ACTIVO' : 'INACTIVO')) === 'ACTIVO' ? '#10b981' : '#f59e0b' }}"></i>
                {{ $docente->estado ?? (($docente->activo ?? false) ? 'ACTIVO' : 'INACTIVO') }}
            </span>
        </div>
    </div>

    <!-- ── KPIs ── -->
    <div class="kpis">
        <div class="kpi k-indigo">
            <div class="kpi-glow"></div>
            <div class="kpi-icon"><i class="ti ti-layout-grid"></i></div>
            <div class="kpi-value">{{ $totalGrupos }}</div>
            <div class="kpi-label">Grupos asignados</div>
            <div class="kpi-delta" style="color:var(--accent)">
                <i class="ti ti-arrow-up-right"></i> Gestión activa
            </div>
        </div>

        <div class="kpi k-green">
            <div class="kpi-glow"></div>
            <div class="kpi-icon"><i class="ti ti-users"></i></div>
            <div class="kpi-value">{{ $totalEstudiantes }}</div>
            <div class="kpi-label">Estudiantes a cargo</div>
            <div class="kpi-delta" style="color:var(--green)">
                <i class="ti ti-school"></i> Total en tus grupos
            </div>
        </div>

        <div class="kpi k-amber">
            <div class="kpi-glow"></div>
            <div class="kpi-icon"><i class="ti ti-file-text"></i></div>
            <div class="kpi-value">{{ $totalNotas }}</div>
            <div class="kpi-label">Notas registradas</div>
            <div class="kpi-delta" style="color:var(--amber)">
                @if($promedioGeneral)
                    <i class="ti ti-chart-bar"></i> Promedio general: {{ round($promedioGeneral, 1) }}
                @else
                    <i class="ti ti-edit"></i> Sin registros aún
                @endif
            </div>
        </div>

        <div class="kpi k-sky">
            <div class="kpi-glow"></div>
            <div class="kpi-icon"><i class="ti ti-checkbox"></i></div>
            <div class="kpi-value">
                @if($pctAsistencia !== null)
                    {{ $pctAsistencia }}%
                @else
                    —
                @endif
            </div>
            <div class="kpi-label">Asistencia de hoy</div>
            <div class="kpi-delta" style="color:var(--sky)">
                <i class="ti ti-calendar-today"></i> {{ now()->format('d/m/Y') }}
            </div>
        </div>
    </div>

    <!-- ── MIS GRUPOS ── -->
    <div class="sec-header">
        <div class="sec-title">
            <i class="ti ti-layout-grid"></i> Mis Grupos
        </div>
    </div>

    @if($grupos->isEmpty())
        <div class="empty-state">
            <i class="ti ti-inbox"></i>
            <p>No tienes grupos asignados en esta gestión todavía.</p>
            <p style="font-size:12px;margin-top:6px">El administrador debe asignarte a un grupo para poder gestionar estudiantes.</p>
        </div>
    @else
        <div class="grupos-grid">
            @foreach($grupos as $g)
            @php
                $pct = $g->capacidad_maxima > 0 ? round(($g->total_postulantes / $g->capacidad_maxima) * 100) : 0;
                $turnoClass = match($g->turno) { 'MAÑANA' => 'M', 'TARDE' => 'T', default => 'N' };
                $turnoIcon = match($g->turno) { 'MAÑANA' => '🌅', 'TARDE' => '🌞', default => '🌙' };
            @endphp
            <div class="grupo-card">
                <div class="gc-head">
                    <div class="gc-num">{{ $g->numero_grupo }}</div>
                    <div class="gc-badges">
                        <span class="badge badge-turno-{{ $turnoClass }}">
                            {{ $turnoIcon }} {{ $g->turno }}
                        </span>
                        <span class="badge badge-activo">
                            <i class="ti ti-point-filled" style="font-size:8px"></i> {{ $g->estado }}
                        </span>
                    </div>
                </div>

                <div class="gc-nombre">Grupo {{ $g->numero_grupo }}</div>
                <div class="gc-conv"><i class="ti ti-building" style="font-size:11px"></i> {{ $g->convocatoria_nombre }}</div>

                @if($g->materias)
                <div class="gc-materia">
                    <i class="ti ti-book"></i> {{ $g->materias }}
                </div>
                @endif

                <div class="gc-stats">
                    <div class="gc-stat">
                        <div class="gc-stat-val green">{{ $g->total_postulantes }}</div>
                        <div class="gc-stat-label">Alumnos</div>
                    </div>
                    <div class="gc-stat">
                        <div class="gc-stat-val amber">{{ $g->notas_registradas }}</div>
                        <div class="gc-stat-label">Notas</div>
                    </div>
                    <div class="gc-stat">
                        <div class="gc-stat-val sky">
                            @if($g->promedio){{ $g->promedio }}@else—@endif
                        </div>
                        <div class="gc-stat-label">Promedio</div>
                    </div>
                </div>

                <div class="gc-prog">
                    <div class="gc-prog-label">
                        <span>Ocupación del grupo</span>
                        <span style="color:var(--text)">{{ $g->total_postulantes }}/{{ $g->capacidad_maxima }}</span>
                    </div>
                    <div class="prog-bar">
                        <div class="prog-fill" style="width:{{ min($pct, 100) }}%"></div>
                    </div>
                </div>

                <a href="{{ route('docente.grupo.detalle', $g->grupo_id) }}" class="btn-ver">
                    <i class="ti ti-arrow-right"></i> Ver grupo y gestionar
                </a>
            </div>
            @endforeach
        </div>
    @endif

</div>
</main>

<script>
    // Theme toggle behavior
    const themeToggleBtn = document.getElementById('theme-toggle');
    const themeIcon = document.getElementById('theme-icon');

    // Update icon status on load
    if (document.documentElement.classList.contains('light-theme')) {
        themeIcon.className = 'ti ti-sun';
    } else {
        themeIcon.className = 'ti ti-moon';
    }

    themeToggleBtn.addEventListener('click', () => {
        document.documentElement.classList.toggle('light-theme');
        let theme = 'dark';
        if (document.documentElement.classList.contains('light-theme')) {
            theme = 'light';
            themeIcon.className = 'ti ti-sun';
        } else {
            themeIcon.className = 'ti ti-moon';
        }
        localStorage.setItem('theme', theme);
    });
</script>
</body>
</html>
