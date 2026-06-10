<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">
    <title>CUP — Mi Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Figtree', sans-serif; background: #f1f5f9; color: #1e293b; display: flex; min-height: 100vh; }

        /* ── SIDEBAR ── */
        .sidebar {
            width: 240px; background: linear-gradient(180deg,#1e3a6e 0%,#0f2147 100%);
            position: fixed; top: 0; bottom: 0; left: 0; z-index: 100;
            display: flex; flex-direction: column;
        }
        .sidebar-brand {
            padding: 22px 20px; font-size: 16px; font-weight: 700; color: #fff;
            display: flex; align-items: center; gap: 10px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .sidebar-brand i { font-size: 22px; color: #7dd3fc; }
        .sidebar-user {
            margin: 16px 12px; padding: 14px;
            background: rgba(255,255,255,0.07);
            border-radius: 12px; border: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar-user .s-name { font-size: 13px; font-weight: 600; color: #fff; }
        .sidebar-user .s-code { font-size: 11px; color: #7dd3fc; margin-top: 2px; }
        .s-avatar {
            width: 36px; height: 36px; border-radius: 50%;
            background: #2563eb; color: #fff; font-weight: 700; font-size: 13px;
            display: flex; align-items: center; justify-content: center; margin-bottom: 10px;
        }

        .nav-label { font-size: 10px; font-weight: 700; color: rgba(255,255,255,0.35); text-transform: uppercase; letter-spacing: .1em; padding: 14px 20px 6px; }
        .nav-item { display: flex; align-items: center; gap: 10px; padding: 10px 16px; margin: 1px 10px; border-radius: 9px; color: rgba(255,255,255,0.7); text-decoration: none; font-size: 13px; font-weight: 500; transition: all .15s; }
        .nav-item i { font-size: 17px; }
        .nav-item:hover { background: rgba(255,255,255,0.08); color: #fff; }
        .nav-item.active { background: #2563eb; color: #fff; box-shadow: 0 4px 12px rgba(37,99,235,0.3); }

        .sidebar-footer { margin-top: auto; padding: 16px 20px; border-top: 1px solid rgba(255,255,255,0.08); }
        .btn-logout-side {
            width: 100%; padding: 9px; border-radius: 9px;
            background: rgba(239,68,68,0.12); border: 1px solid rgba(239,68,68,0.25);
            color: #fca5a5; font-size: 12px; font-weight: 600; cursor: pointer;
            font-family: 'Figtree', sans-serif;
            display: flex; align-items: center; justify-content: center; gap: 6px;
            transition: all .2s;
        }
        .btn-logout-side:hover { background: rgba(239,68,68,0.22); color: #fff; }

        /* ── MAIN ── */
        .main { margin-left: 240px; flex: 1; display: flex; flex-direction: column; }

        /* ── TOPBAR ── */
        .topbar {
            height: 60px; background: #fff; border-bottom: 1px solid #e2e8f0;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 32px; position: sticky; top: 0; z-index: 50;
        }
        .topbar-left h1 { font-size: 17px; font-weight: 700; color: #0f172a; }
        .topbar-left p  { font-size: 12px; color: #64748b; margin-top: 1px; }
        .topbar-right { display: flex; align-items: center; gap: 12px; }
        .topbar-badge {
            padding: 5px 12px; border-radius: 99px; font-size: 11px; font-weight: 600;
            display: flex; align-items: center; gap: 5px;
        }
        .tb-proceso  { background: #eff4ff; color: #1e40af; }
        .tb-aprobado { background: #d1fae5; color: #065f46; }
        .tb-reprobado{ background: #fee2e2; color: #991b1b; }
        .tb-sincupo  { background: #fef3c7; color: #b45309; }

        /* ── CONTENT ── */
        .content { padding: 28px 32px; max-width: 1200px; }

        /* ── HERO ── */
        .hero {
            border-radius: 16px; padding: 28px 32px; margin-bottom: 24px;
            display: flex; align-items: center; justify-content: space-between;
            overflow: hidden; position: relative;
        }
        .hero::before {
            content:''; position: absolute; width: 280px; height: 280px; border-radius: 50%;
            right: -60px; top: -80px; background: rgba(255,255,255,0.06); pointer-events: none;
        }
        .hero::after {
            content:''; position: absolute; width: 180px; height: 180px; border-radius: 50%;
            right: 80px; bottom: -60px; background: rgba(255,255,255,0.04); pointer-events: none;
        }
        .hero.proceso  { background: linear-gradient(135deg,#1e3a6e 0%,#2563eb 100%); }
        .hero.aprobado { background: linear-gradient(135deg,#047857 0%,#10b981 100%); }
        .hero.reprobado{ background: linear-gradient(135deg,#be123c 0%,#f43f5e 100%); }
        .hero.sincupo  { background: linear-gradient(135deg,#d97706 0%,#f59e0b 100%); }
        .hero-left { display: flex; align-items: center; gap: 20px; z-index: 1; }
        .hero-icon {
            width: 64px; height: 64px; border-radius: 16px;
            background: rgba(255,255,255,0.15);
            display: flex; align-items: center; justify-content: center; font-size: 30px;
        }
        .hero-text h2 { font-size: 22px; font-weight: 700; color: #fff; }
        .hero-text p  { font-size: 13px; color: rgba(255,255,255,0.8); margin-top: 5px; max-width: 420px; line-height: 1.5; }
        .hero-right { z-index: 1; }
        .hero-pill {
            background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3);
            padding: 8px 22px; border-radius: 99px; font-size: 13px; font-weight: 700;
            color: #fff; letter-spacing: .04em; text-transform: uppercase;
            animation: pulse 2.5s infinite;
        }
        @keyframes pulse { 0%,100%{transform:scale(1)} 50%{transform:scale(1.04)} }

        /* ── METRICS ── */
        .metrics { display: grid; grid-template-columns: repeat(4,1fr); gap: 14px; margin-bottom: 24px; }
        .metric-card {
            background: #fff; border-radius: 14px; border: 1px solid #e2e8f0;
            padding: 20px; display: flex; align-items: center; justify-content: space-between;
            transition: transform .2s, box-shadow .2s;
        }
        .metric-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.05); }
        .metric-info h3 { font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: .04em; }
        .metric-info .val { font-size: 26px; font-weight: 700; color: #0f172a; margin-top: 6px; }
        .metric-info .sub { font-size: 11px; color: #94a3b8; margin-top: 3px; }
        .metric-ico { width: 44px; height: 44px; border-radius: 11px; display: flex; align-items: center; justify-content: center; font-size: 20px; }
        .ico-blue   { background: #eff4ff; color: #2563eb; }
        .ico-green  { background: #d1fae5; color: #059669; }
        .ico-amber  { background: #fef3c7; color: #d97706; }
        .ico-purple { background: #ede9fe; color: #5b21b6; }

        /* ── GRID 2 COL ── */
        .grid-2 { display: grid; grid-template-columns: 1.4fr 1fr; gap: 18px; margin-bottom: 18px; }
        .grid-3 { display: grid; grid-template-columns: repeat(3,1fr); gap: 18px; margin-bottom: 18px; }

        /* ── CARD ── */
        .card { background: #fff; border-radius: 14px; border: 1px solid #e2e8f0; padding: 24px; }
        .card-title {
            font-size: 14px; font-weight: 700; color: #0f172a;
            display: flex; align-items: center; gap: 8px; margin-bottom: 18px;
        }
        .card-title i { font-size: 18px; color: #2563eb; }

        /* ── NOTAS POR MATERIA ── */
        .materia-row { margin-bottom: 18px; }
        .materia-row:last-child { margin-bottom: 0; }
        .materia-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px; }
        .materia-name { font-size: 13px; font-weight: 600; color: #374151; display: flex; align-items: center; gap: 7px; }
        .materia-name i { font-size: 16px; }
        .materia-score { font-size: 15px; font-weight: 700; }
        .score-ok   { color: #059669; }
        .score-fail { color: #e11d48; }
        .score-pend { color: #94a3b8; }
        .progress-bar { height: 7px; background: #f1f5f9; border-radius: 99px; overflow: hidden; }
        .progress-fill { height: 100%; border-radius: 99px; transition: width .8s ease; }
        .fill-ok   { background: linear-gradient(90deg,#10b981,#059669); }
        .fill-fail { background: linear-gradient(90deg,#f43f5e,#e11d48); }
        .fill-pend { background: #e2e8f0; }
        .examen-dots { display: flex; gap: 5px; margin-top: 7px; }
        .examen-dot {
            flex: 1; padding: 4px 0; border-radius: 6px; text-align: center;
            font-size: 10px; font-weight: 600;
        }
        .dot-ok   { background: #d1fae5; color: #065f46; }
        .dot-fail { background: #fee2e2; color: #991b1b; }
        .dot-pend { background: #f1f5f9; color: #94a3b8; }

        /* ── INFO PERSONAL ── */
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .info-item { border-bottom: 1px solid #f8fafc; padding-bottom: 12px; }
        .info-item:nth-last-child(-n+2) { border-bottom: none; padding-bottom: 0; }
        .info-label { font-size: 11px; color: #94a3b8; font-weight: 500; margin-bottom: 4px; }
        .info-value { font-size: 13px; color: #334155; font-weight: 600; }

        /* ── CARRERAS ── */
        .carrera-item {
            display: flex; align-items: center; gap: 12px; padding: 12px;
            background: #f8fafc; border-radius: 10px; border: 1px solid #e2e8f0; margin-bottom: 8px;
        }
        .carrera-item:last-child { margin-bottom: 0; }
        .carrera-num {
            width: 28px; height: 28px; border-radius: 50%; font-weight: 700; font-size: 12px;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .cn-1 { background: #dbeafe; color: #1e40af; }
        .cn-2 { background: #e2e8f0; color: #475569; }
        .carrera-info h4 { font-size: 13px; font-weight: 600; color: #334155; }
        .carrera-info p  { font-size: 11px; color: #94a3b8; margin-top: 2px; }

        /* ── GRUPO ── */
        .grupo-box {
            background: linear-gradient(135deg,#eff4ff,#f5f3ff);
            border: 1px solid #c7d7fd; border-radius: 12px; padding: 18px;
            text-align: center;
        }
        .grupo-box .g-label { font-size: 11px; color: #6366f1; font-weight: 600; text-transform: uppercase; letter-spacing: .06em; }
        .grupo-box .g-num   { font-size: 36px; font-weight: 800; color: #1e293b; margin: 6px 0; }
        .grupo-box .g-turno { font-size: 12px; color: #64748b; }
        .grupo-vacio { text-align: center; padding: 20px; color: #94a3b8; font-size: 13px; }

        /* ── BADGE INLINE ── */
        .badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 99px; font-size: 11px; font-weight: 500; }
        .b-ok   { background: #d1fae5; color: #065f46; }
        .b-fail { background: #fee2e2; color: #991b1b; }
        .b-pend { background: #f1f5f9; color: #64748b; }
        .b-blue { background: #dbeafe; color: #1e40af; }

        /* ── HAMBURGER ── */
        .btn-hamburger {
            display: none;
            background: none; border: none;
            color: #0f172a; cursor: pointer;
            padding: 6px; border-radius: 6px;
            align-items: center; justify-content: center;
            transition: background .2s;
        }
        .btn-hamburger:hover { background: rgba(0,0,0,0.06); }
        .btn-hamburger i { font-size: 22px; }

        /* ── SIDEBAR OVERLAY ── */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.55);
            z-index: 90;
            backdrop-filter: blur(2px);
        }
        .sidebar-overlay.active { display: block; }

        /* ══════════════════════════════════════
           RESPONSIVE — TABLET (≤ 1024px)
        ══════════════════════════════════════ */
        @media (max-width: 1024px) {
            .btn-hamburger { display: flex; }

            .sidebar {
                transform: translateX(-100%);
                transition: transform .3s ease;
                z-index: 100;
            }
            .sidebar.open { transform: translateX(0); }

            .main { margin-left: 0; }

            .content { padding: 20px 16px; }

            .metrics { grid-template-columns: repeat(2, 1fr); }

            .grid-2 { grid-template-columns: 1fr; }
            .grid-3 { grid-template-columns: 1fr 1fr; }

            .hero { flex-direction: column; gap: 16px; padding: 20px; }
            .hero-right { align-self: flex-start; }
        }

        /* ══════════════════════════════════════
           RESPONSIVE — MÓVIL (≤ 640px)
        ══════════════════════════════════════ */
        @media (max-width: 640px) {
            .topbar { padding: 0 12px; }
            .topbar-left h1 { font-size: 14px; }
            .topbar-left p  { display: none; }
            .topbar-badge span { display: none; }

            .content { padding: 12px; }

            .metrics {
                grid-template-columns: 1fr 1fr;
                gap: 8px;
            }
            .metric-card { padding: 14px; }
            .metric-info .val { font-size: 20px; }

            .grid-2 { grid-template-columns: 1fr; }
            .grid-3 { grid-template-columns: 1fr; }

            .hero { padding: 16px; }
            .hero-icon { width: 48px; height: 48px; font-size: 22px; }
            .hero-text h2 { font-size: 16px; }
            .hero-text p  { font-size: 12px; }
            .hero-left { gap: 12px; }

            .info-grid { grid-template-columns: 1fr; }

            .card { padding: 14px; }
            .card-title { font-size: 13px; }
        }
    
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

{{-- SIDEBAR OVERLAY (fondo oscuro móvil) --}}
<div class="sidebar-overlay" id="sidebar-overlay" onclick="closeSidebar()"></div>

{{-- SIDEBAR --}}
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <i class="ti ti-school"></i> CUP — FICCT
    </div>
    <div class="sidebar-user">
        <div class="s-avatar">{{ strtoupper(substr($postulante->nombre,0,1)) }}{{ strtoupper(substr($postulante->apellido,0,1)) }}</div>
        <div class="s-name">{{ $postulante->nombre }} {{ $postulante->apellido }}</div>
        <div class="s-code">{{ $postulante->codigo_estudiante }}</div>
    </div>

    <div class="nav-label">Mi cuenta</div>
    <a href="{{ route('postulante.dashboard') }}" class="nav-item active">
        <i class="ti ti-smart-home"></i> Inicio
    </a>
    <a href="{{ route('postulante.notas') }}" class="nav-item">
        <i class="ti ti-file-analytics"></i> Mis Notas
    </a>
    <a href="{{ route('postulante.grupo') }}" class="nav-item">
        <i class="ti ti-users-group"></i> Mi Grupo
    </a>
    <a href="{{ route('postulante.horario') }}" class="nav-item">
        <i class="ti ti-calendar"></i> Mi Horario
    </a>

    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout-side">
                <i class="ti ti-logout"></i> Cerrar Sesión
            </button>
        </form>
    </div>
</aside>

{{-- MAIN --}}
<div class="main">
    {{-- TOPBAR --}}
    <header class="topbar">
        <div style="display:flex;align-items:center;gap:10px">
            <button class="btn-hamburger" id="btn-hamburger" onclick="toggleSidebar()" aria-label="Abrir menú">
                <i class="ti ti-menu-2" id="hamburger-icon"></i>
            </button>
            <div class="topbar-left">
    <button type="button" class="btn-menu-mobile" onclick="document.querySelector('.sidebar').classList.toggle('open'); document.getElementById('sidebar-overlay-mobile').classList.toggle('show');">&#9776;</button>
                <h1>Hola, {{ $postulante->nombre }} 👋</h1>
                <p>Bienvenido a tu panel de admisiones — CUP FICCT</p>
            </div>
        </div>
        <div class="topbar-right">
            @php
                $estado = $estadisticas['estado'] ?? 'PROCESO';
            @endphp
            @if(in_array($estado, ['APROBADO','ADMITIDO']))
                <span class="topbar-badge tb-aprobado"><i class="ti ti-circle-check"></i> Admitido</span>
            @elseif($estado === 'APROBADO_SIN_CUPO')
                <span class="topbar-badge tb-sincupo"><i class="ti ti-alert-triangle"></i> Aprobado sin cupo</span>
            @elseif(in_array($estado, ['REPROBADO', 'REPROBADO_CUP','RECHAZADO']))
                <span class="topbar-badge tb-reprobado"><i class="ti ti-circle-x"></i> No admitido</span>
            @else
                <span class="topbar-badge tb-proceso"><i class="ti ti-clock"></i> En proceso</span>
            @endif
            
            <div class="dropdown-container" style="position:relative;">
                <button onclick="let d=document.getElementById('postulante-dropdown'); d.style.display = d.style.display==='none' ? 'block' : 'none';" style="background:none;border:none;cursor:pointer;padding:8px;color:#64748b;display:flex;align-items:center;justify-content:center;">
                    <i class="ti ti-dots-vertical" style="font-size:22px;"></i>
                </button>
                <div id="postulante-dropdown" class="dropdown-menu" style="display:none; position:absolute; right:0; top:100%; background:#fff; border:1px solid #e2e8f0; border-radius:12px; box-shadow:0 10px 25px rgba(0,0,0,0.1); width:200px; z-index:1000; overflow:hidden;">
                    <div style="padding:12px 16px; border-bottom:1px solid #e2e8f0; background:#f8fafc;">
                        <div style="font-size:13px; font-weight:600; color:#0f172a;">{{ $postulante->nombre }} {{ $postulante->apellido }}</div>
                        <div style="font-size:11px; color:#64748b; margin-top:2px;">{{ $postulante->email ?? 'Postulante' }}</div>
                    </div>
                    <a href="{{ route('postulante.dashboard') }}" style="display:flex; align-items:center; gap:10px; padding:12px 16px; color:#475569; text-decoration:none; font-size:13px; transition:background 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='none'">
                        <i class="ti ti-layout-dashboard" style="font-size:16px;"></i> Mi Panel
                    </a>
                    <form method="POST" action="{{ route('logout') }}" style="margin:0; border-top:1px solid #e2e8f0;">
                        @csrf
                        <button type="submit" style="width:100%; text-align:left; padding:12px 16px; background:none; border:none; cursor:pointer; color:#ef4444; font-size:13px; font-weight:500; display:flex; align-items:center; gap:10px; transition:background 0.2s;" onmouseover="this.style.background='#fee2e2'" onmouseout="this.style.background='none'">
                            <i class="ti ti-logout" style="font-size:16px;"></i> Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    {{-- CONTENT --}}
    <div class="content">

        {{-- HERO --}}
        @if(in_array($estado, ['APROBADO','ADMITIDO']))
            <div class="hero aprobado">
                <div class="hero-left">
                    <div class="hero-icon">🎉</div>
                    <div class="hero-text">
                        <h2>¡Felicidades! Has sido Admitido</h2>
                        <p>Superaste exitosamente el proceso de admisión. Has sido asignado a la carrera de <strong>{{ $estadisticas['carrera_asignada']?->nombre ?? 'Carrera asignada' }}</strong>.</p>
                    </div>
                </div>
                <div class="hero-right"><div class="hero-pill">Admitido</div></div>
            </div>
        @elseif($estado === 'APROBADO_SIN_CUPO')
            <div class="hero sincupo">
                <div class="hero-left">
                    <div class="hero-icon">⚠️</div>
                    <div class="hero-text">
                        <h2>Aprobado sin Cupo</h2>
                        <p>¡Buen esfuerzo! Tu promedio final de <strong>{{ number_format($estadisticas['promedio'] ?? 0, 1) }} pts</strong> es mayor o igual al puntaje mínimo de aprobación (60 pts). Sin embargo, debido al límite de cupos disponibles por carrera, no fue posible asignarte una vacante en tus opciones seleccionadas.</p>
                    </div>
                </div>
                <div class="hero-right"><div class="hero-pill">Sin Cupo</div></div>
            </div>
        @elseif(in_array($estado, ['REPROBADO', 'REPROBADO_CUP','RECHAZADO']))
            <div class="hero reprobado">
                <div class="hero-left">
                    <div class="hero-icon">💪</div>
                    <div class="hero-text">
                        <h2>Resultado del Proceso: No Admitido</h2>
                        @if($estadisticas['reprobo_examen'] ?? false)
                            <p>Has reprobado uno de los exámenes del proceso de admisión. Para ser admitido, debes aprobar todos los exámenes individuales con una nota de al menos 60 pts. ¡No te rindas y sigue adelante!</p>
                        @else
                            <p>Tu promedio final de <strong>{{ number_format($estadisticas['promedio'] ?? 0, 1) }} pts</strong> fue menor al puntaje mínimo requerido de aprobación (60 pts). No te rindas, ¡sigue preparándote para la próxima gestión!</p>
                        @endif
                    </div>
                </div>
                <div class="hero-right"><div class="hero-pill">No Admitido</div></div>
            </div>
        @else
            <div class="hero proceso">
                <div class="hero-left">
                    <div class="hero-icon">📝</div>
                    <div class="hero-text">
                        <h2>Proceso de Admisión en Curso</h2>
                        <p>Tus calificaciones están siendo registradas. Mantente al día con tus evaluaciones y revisa tu progreso aquí.</p>
                    </div>
                </div>
                <div class="hero-right"><div class="hero-pill">En Proceso</div></div>
            </div>
        @endif

        {{-- MÉTRICAS --}}
        <div class="metrics">
            <div class="metric-card">
                <div class="metric-info">
                    <h3>Promedio actual</h3>
                    <div class="val">{{ number_format($estadisticas['promedio'] ?? 0, 1) }}</div>
                    <div class="sub">Sobre 100 puntos</div>
                </div>
                <div class="metric-ico ico-blue"><i class="ti ti-trophy"></i></div>
            </div>
            <div class="metric-card">
                <div class="metric-info">
                    <h3>Notas registradas</h3>
                    <div class="val">{{ $estadisticas['notas_registradas'] }}</div>
                    <div class="sub">Evaluaciones</div>
                </div>
                <div class="metric-ico ico-green"><i class="ti ti-list-check"></i></div>
            </div>
            <div class="metric-card">
                <div class="metric-info">
                    <h3>Grupo</h3>
                    <div class="val">{{ $estadisticas['grupo']?->codigo_grupo ?? '—' }}</div>
                    <div class="sub">Turno: {{ $postulante->turno_asignado ?? 'Pendiente' }}</div>
                </div>
                <div class="metric-ico ico-amber"><i class="ti ti-users-group"></i></div>
            </div>
            <div class="metric-card">
                <div class="metric-info">
                    <h3>Ranking</h3>
                    <div class="val">#{{ $estadisticas['posicion_ranking'] ?? '—' }}</div>
                    <div class="sub">Posición general</div>
                </div>
                <div class="metric-ico ico-purple"><i class="ti ti-trending-up"></i></div>
            </div>
        </div>

        {{-- NOTAS + DATOS PERSONALES --}}
        <div class="grid-2">

            {{-- NOTAS POR MATERIA --}}
            <div class="card">
                <div class="card-title"><i class="ti ti-chart-bar"></i> Progreso por Materia</div>

                @php
                    $materiaConfig = [
                        'MAT' => ['nombre'=>'Matemáticas',  'icon'=>'ti-math-function', 'color'=>'#2563eb'],
                        'FIS' => ['nombre'=>'Física',        'icon'=>'ti-atom',          'color'=>'#7c3aed'],
                        'COM' => ['nombre'=>'Computación',   'icon'=>'ti-device-desktop','color'=>'#0891b2'],
                        'ING' => ['nombre'=>'Inglés',        'icon'=>'ti-language',      'color'=>'#059669'],
                    ];
                    $notasPorMateria = [];
                    foreach(($resultado ? [] : []) as $n) {} // fallback vacío
                    // Obtener notas del postulante por materia
                    $notasDB = \Illuminate\Support\Facades\DB::table('nota as n')
                        ->join('examen as e','e.id','=','n.examen_id')
                        ->join('materia as m','m.id','=','e.materia_id')
                        ->where('n.postulante_id', $postulante->id)
                        ->select('m.codigo','m.nombre as materia','n.puntaje','e.nro_examen')
                        ->orderBy('m.codigo')->orderBy('e.nro_examen')
                        ->get()->groupBy('codigo');
                    $detallePromedios = $postulante->obtenerDetallePromedios();
                @endphp

                @foreach($materiaConfig as $codigo => $cfg)
                @php
                    $notas  = $notasDB[$codigo] ?? collect();
                    $prom   = $notas->count() ? $detallePromedios['materias'][$codigo] : null;
                    $aprobado = $prom !== null && $prom >= 60;
                    $scoreClass = $prom === null ? 'score-pend' : ($aprobado ? 'score-ok' : 'score-fail');
                    $fillClass  = $prom === null ? 'fill-pend' : ($aprobado ? 'fill-ok' : 'fill-fail');
                    $width = $prom !== null ? $prom : 0;
                @endphp
                <div class="materia-row">
                    <div class="materia-header">
                        <div class="materia-name" style="color:{{ $cfg['color'] }}">
                            <i class="ti {{ $cfg['icon'] }}"></i>
                            {{ $cfg['nombre'] }}
                        </div>
                        <span class="{{ $scoreClass }}" style="font-size:15px;font-weight:700">
                            {{ $prom !== null ? $prom . ' pts' : 'Sin notas' }}
                        </span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill {{ $fillClass }}" style="width:{{ $width }}%"></div>
                    </div>
                    <div class="examen-dots">
                        @for($i = 1; $i <= 3; $i++)
                            @php $nota = $notas->firstWhere('nro_examen', $i); @endphp
                            @if($nota)
                                <div class="examen-dot {{ $nota->puntaje >= 60 ? 'dot-ok' : 'dot-fail' }}">
                                    E{{ $i }}: {{ number_format($nota->puntaje,0) }}
                                </div>
                            @else
                                <div class="examen-dot dot-pend">E{{ $i }}: —</div>
                            @endif
                        @endfor
                    </div>
                </div>
                @endforeach
            </div>

            {{-- DATOS + GRUPO --}}
            <div style="display:flex;flex-direction:column;gap:14px">

                {{-- GRUPO ASIGNADO --}}
                <div class="card">
                    <div class="card-title"><i class="ti ti-users-group"></i> Mi Grupo</div>
                    @if($estadisticas['grupo'])
                        <div class="grupo-box">
                            <div class="g-label">Grupo asignado</div>
                            <div class="g-num">{{ $estadisticas['grupo']->codigo_grupo }}</div>
                            <div class="g-turno">
                                <i class="ti ti-clock" style="vertical-align:-2px"></i>
                                Turno {{ $postulante->turno_asignado }}
                            </div>
                        </div>
                        <a href="{{ route('postulante.grupo') }}" style="display:flex;align-items:center;justify-content:center;gap:6px;margin-top:14px;font-size:12px;color:#2563eb;text-decoration:none;font-weight:500">
                            Ver detalles del grupo <i class="ti ti-arrow-right"></i>
                        </a>
                    @else
                        <div class="grupo-vacio">
                            <i class="ti ti-clock" style="font-size:28px;display:block;margin-bottom:8px"></i>
                            Aún no tienes grupo asignado.<br>
                            <span style="font-size:11px">El administrador lo asignará pronto.</span>
                        </div>
                    @endif
                </div>

                {{-- CARRERAS --}}
                <div class="card">
                    <div class="card-title"><i class="ti ti-books"></i> Carreras Postuladas</div>
                    <div class="carrera-item">
                        <div class="carrera-num cn-1">1</div>
                        <div class="carrera-info">
                            <h4>{{ $postulante->carreraPref1?->nombre ?? 'No registrada' }}</h4>
                            <p>Primera preferencia</p>
                        </div>
                    </div>
                    <div class="carrera-item">
                        <div class="carrera-num cn-2">2</div>
                        <div class="carrera-info">
                            <h4>{{ $postulante->carreraPref2?->nombre ?? 'No registrada' }}</h4>
                            <p>Segunda preferencia</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- DATOS PERSONALES --}}
        <div class="card">
            <div class="card-title"><i class="ti ti-user"></i> Mis Datos Personales</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Nombre completo</div>
                    <div class="info-value">{{ $postulante->nombre }} {{ $postulante->apellido }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Carnet de identidad</div>
                    <div class="info-value">{{ $postulante->ci }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Correo electrónico</div>
                    <div class="info-value">{{ $postulante->email }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Teléfono</div>
                    <div class="info-value">{{ $postulante->telefono ?? '—' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Colegio de procedencia</div>
                    <div class="info-value">{{ $postulante->colegio_nombre ?? '—' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Código de estudiante</div>
                    <div class="info-value">{{ $postulante->codigo_estudiante }}</div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    window.addEventListener('pageshow', function(e) {
        if (e.persisted) window.location.reload();
    });

    // ── SIDEBAR MÓVIL ──
    function toggleSidebar() {
        const sidebar  = document.getElementById('sidebar');
        const overlay  = document.getElementById('sidebar-overlay');
        const icon     = document.getElementById('hamburger-icon');
        const isOpen   = sidebar.classList.contains('open');
        if (isOpen) {
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
            icon.className = 'ti ti-menu-2';
        } else {
            sidebar.classList.add('open');
            overlay.classList.add('active');
            icon.className = 'ti ti-x';
        }
    }

    function closeSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const icon    = document.getElementById('hamburger-icon');
        sidebar.classList.remove('open');
        overlay.classList.remove('active');
        icon.className = 'ti ti-menu-2';
    }

    // Cerrar sidebar al hacer clic en nav-item (móvil)
    document.querySelectorAll('.nav-item').forEach(function(item) {
        item.addEventListener('click', function() {
            if (window.innerWidth <= 1024) closeSidebar();
        });
    });
</script>
</body>
</html>