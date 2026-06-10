<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIRT — Panel Administrador</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <script>
        // Pre-detect and apply theme before rendering to avoid flash
        if (localStorage.getItem('theme') === 'light' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: light)').matches)) {
            document.documentElement.classList.add('light-theme');
        } else {
            document.documentElement.classList.remove('light-theme');
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
            --table-hover: #1f2335;
        }

        .light-theme {
            --bg: #f1f5f9;
            --surface: #ffffff;
            --surface2: #f8fafc;
            --border: #e2e8f0;
            --text: #1e293b;
            --muted: #94a3b8;
            --table-hover: #fafafa;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Figtree', sans-serif; background: var(--bg); color: var(--text); }

        /* ── TOPBAR ── */
        .topbar {
            background: #1e3a6e;
            padding: 0 24px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: fixed; top: 0; left: 0; right: 0; z-index: 200;
        }
        .topbar-brand { color: #fff; font-size: 16px; font-weight: 600; display: flex; align-items: center; gap: 10px; }
        .topbar-right { display: flex; align-items: center; gap: 16px; }
        .topbar-user { color: #a8c8f0; font-size: 13px; display: flex; align-items: center; gap: 6px; }
        .btn-logout {
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.22);
            color: #fff; padding: 6px 14px;
            border-radius: 8px; font-size: 12px;
            cursor: pointer; text-decoration: none;
            display: flex; align-items: center; gap: 6px;
            transition: background .2s;
        }
        .btn-logout:hover { background: rgba(255,255,255,0.22); }

        /* ── HAMBURGER ── */
        .btn-hamburger {
            display: none;
            background: none; border: none;
            color: #fff; cursor: pointer;
            padding: 6px; border-radius: 6px;
            align-items: center; justify-content: center;
            transition: background .2s;
        }
        .btn-hamburger:hover { background: rgba(255,255,255,0.12); }
        .btn-hamburger i { font-size: 22px; }

        /* ── SIDEBAR ── */
        .sidebar {
            width: 224px;
            height: calc(100vh - 56px);
            background: #1e3a6e;
            position: fixed;
            top: 56px; left: 0;
            overflow-y: auto;
            padding: 20px 12px 24px;
            display: flex;
            flex-direction: column;
            gap: 2px;
            transition: transform .3s ease;
            z-index: 150;
        }

        /* ── SIDEBAR OVERLAY ── */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.55);
            z-index: 140;
            backdrop-filter: blur(2px);
        }
        .sidebar-overlay.active { display: block; }

        .nav-label {
            font-size: 10px; font-weight: 700;
            color: rgba(168,200,240,0.55);
            text-transform: uppercase;
            letter-spacing: .1em;
            padding: 16px 10px 6px;
            margin-top: 4px;
        }
        .nav-label:first-child { padding-top: 4px; }

        .nav-item {
            padding: 9px 12px;
            font-size: 13px;
            color: rgba(168,200,240,0.85);
            text-decoration: none;
            border-radius: 8px;
            display: flex; align-items: center; gap: 10px;
            transition: background .15s, color .15s;
            font-weight: 400;
        }
        .nav-item i { font-size: 16px; flex-shrink: 0; }
        .nav-item:hover {
            background: rgba(255,255,255,0.1);
            color: #fff;
        }
        .nav-item.active {
            background: rgba(255,255,255,0.15);
            color: #fff;
            font-weight: 500;
        }
        .nav-item.active i { color: #7dd3fc; }

        /* colores de ícono por sección */
        .nav-item.c-blue   i { color: #93c5fd; }
        .nav-item.c-amber  i { color: #fcd34d; }
        .nav-item.c-teal   i { color: #6ee7b7; }
        .nav-item.c-purple i { color: #c4b5fd; }
        .nav-item.c-rose   i { color: #fda4af; }
        .nav-item.c-sky    i { color: #7dd3fc; }

        .sidebar-footer {
            margin-top: auto;
            padding: 16px 10px 0;
            border-top: 1px solid rgba(255,255,255,0.08);
            font-size: 11px;
            color: rgba(168,200,240,0.4);
            text-align: center;
        }

        /* ── LAYOUT ── */
        .layout {
            margin-left: 224px;
            margin-top: 56px;
            padding: 24px;
            min-height: calc(100vh - 56px);
        }

        .page-title {
            font-size: 11px; color: var(--muted);
            text-transform: uppercase; letter-spacing: .08em;
            margin-bottom: 16px; font-weight: 600;
        }

        /* ── MÉTRICAS ── */
        .metrics { display: grid; grid-template-columns: repeat(4,1fr); gap: 12px; margin-bottom: 24px; }
        .metric {
            background: var(--surface); border-radius: 12px;
            padding: 18px 20px;
            border: 1px solid var(--border);
        }
        .metric-label { font-size: 12px; color: var(--muted); margin-bottom: 8px; display: flex; align-items: center; gap: 6px; }
        .metric-value { font-size: 28px; font-weight: 600; color: var(--text); }
        .metric-sub { font-size: 11px; color: var(--muted); margin-top: 4px; }
        
        .metric.blue   .metric-value { color: #93c5fd; }
        .metric.amber  .metric-value { color: #fcd34d; }
        .metric.teal   .metric-value { color: #6ee7b7; }
        .metric.purple .metric-value { color: #c4b5fd; }

        .light-theme .metric.blue   .metric-value { color: #1e3a6e; }
        .light-theme .metric.amber  .metric-value { color: #92400e; }
        .light-theme .metric.teal   .metric-value { color: #065f46; }
        .light-theme .metric.purple .metric-value { color: #4c1d95; }

        /* ── GRID 2 COLS ── */
        .two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px; }

        /* ── TABLE RESPONSIVE ── */
        .table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }

        /* ── CARD ── */
        .card {
            background: var(--surface); border-radius: 12px;
            border: 1px solid var(--border); padding: 20px;
        }
        .card-title {
            font-size: 13px; font-weight: 500; color: var(--text);
            margin-bottom: 16px; display: flex;
            justify-content: space-between; align-items: center;
        }
        .card-title a { font-size: 12px; color: var(--text); opacity: 0.8; text-decoration: none; font-weight: 400; }
        .card-title a:hover { opacity: 1; text-decoration: underline; }

        /* ── TABLA ── */
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th { text-align: left; padding: 8px; font-size: 11px; font-weight: 500; color: var(--muted); border-bottom: 1px solid var(--border); background: var(--surface2); }
        td { padding: 10px 8px; border-bottom: 1px solid var(--border); color: var(--text); vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: var(--table-hover); }

        /* ── BADGES ── */
        .badge { display: inline-flex; align-items: center; padding: 2px 10px; border-radius: 99px; font-size: 11px; font-weight: 500; }
        
        .badge-pend  { background: rgba(245,158,11,0.15); color: #fcd34d; }
        .badge-ok    { background: rgba(16,185,129,0.15); color: #6ee7b7; }
        .badge-err   { background: rgba(244,63,94,0.15); color: #fda4af; }
        .badge-blue  { background: rgba(37,99,235,0.15); color: #93c5fd; }
        .badge-doc   { background: rgba(139,92,246,0.15); color: #c4b5fd; }

        .light-theme .badge-pend { background: #fef3c7; color: #92400e; }
        .light-theme .badge-ok   { background: #d1fae5; color: #065f46; }
        .light-theme .badge-err  { background: #fee2e2; color: #991b1b; }
        .light-theme .badge-blue { background: #dbeafe; color: #1e40af; }
        .light-theme .badge-doc  { background: #ede9fe; color: #5b21b6; }

        /* ── AVATAR ── */
        .avatar { width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 600; flex-shrink: 0; }
        
        .av-blue   { background: rgba(37,99,235,0.15); color: #93c5fd; }
        .av-purple { background: rgba(139,92,246,0.15); color: #c4b5fd; }

        .light-theme .av-blue   { background: #dbeafe; color: #1e40af; }
        .light-theme .av-purple { background: #ede9fe; color: #5b21b6; }

        /* ── BOTONES ── */
        .btn { padding: 6px 14px; border-radius: 8px; font-size: 12px; cursor: pointer; border: none; font-family: 'Figtree', sans-serif; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; }
        
        .btn-sm-ok  { background: rgba(16,185,129,0.15); color: #6ee7b7; border: 1px solid rgba(16,185,129,0.3); }
        .btn-sm-err { background: rgba(244,63,94,0.15); color: #fda4af; border: 1px solid rgba(244,63,94,0.3); }

        .light-theme .btn-sm-ok  { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }
        .light-theme .btn-sm-err { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }

        /* ── ACCIONES RÁPIDAS ── */
        .acciones { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
        .accion-btn {
            padding: 12px 14px; border-radius: 10px;
            border: 1px solid var(--border); background: var(--surface2);
            font-size: 12px; color: var(--text); cursor: pointer;
            text-align: left; font-family: 'Figtree', sans-serif;
            display: flex; align-items: center; gap: 8px;
            text-decoration: none;
            transition: background .15s, border-color .15s;
        }
        .accion-btn:hover { background: var(--surface); border-color: var(--muted); }

        /* ── VACÍO ── */
        .empty { text-align: center; padding: 32px; color: var(--muted); font-size: 13px; }

        /* ══════════════════════════════════════
           RESPONSIVE — TABLET (≤ 1024px)
        ══════════════════════════════════════ */
        @media (max-width: 1024px) {
            .btn-hamburger { display: flex; }
            .topbar-user   { display: none; }

            .sidebar {
                transform: translateX(-100%);
                width: 260px;
                top: 0;
                height: 100vh;
                z-index: 160;
            }
            .sidebar.open { transform: translateX(0); }

            .layout {
                margin-left: 0;
                padding: 16px;
            }

            .metrics {
                grid-template-columns: repeat(2, 1fr);
            }

            .two-col {
                grid-template-columns: 1fr;
            }
        }

        /* ══════════════════════════════════════
           RESPONSIVE — MÓVIL (≤ 640px)
        ══════════════════════════════════════ */
        @media (max-width: 640px) {
            .topbar { padding: 0 12px; }
            .topbar-brand span { display: none; }

            .layout { padding: 12px; }

            .metrics {
                grid-template-columns: 1fr 1fr;
                gap: 8px;
            }
            .metric { padding: 14px; }
            .metric-value { font-size: 22px; }

            .two-col { grid-template-columns: 1fr; }

            .acciones { grid-template-columns: 1fr; }

            .card { padding: 14px; }
            .card-title { font-size: 12px; margin-bottom: 12px; }

            table { font-size: 11px; }
            th, td { padding: 7px 6px; }
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
<script>
    // Fuerza recarga si el navegador restaura la página desde bfcache
    window.addEventListener('pageshow', function(event) {
        if (event.persisted) {
            window.location.reload();
        }
    });
</script>
{{-- SIDEBAR OVERLAY (fondo oscuro móvil) --}}
<div class="sidebar-overlay" id="sidebar-overlay" onclick="closeSidebar()"></div>

{{-- TOPBAR --}}
<div class="topbar">
    <button type="button" class="btn-menu-mobile" onclick="document.querySelector('.sidebar').classList.toggle('open'); document.getElementById('sidebar-overlay-mobile').classList.toggle('show');">&#9776;</button>
    <div style="display:flex;align-items:center;gap:12px">
        <button class="btn-hamburger" id="btn-hamburger" onclick="toggleSidebar()" aria-label="Abrir menú">
            <i class="ti ti-menu-2" id="hamburger-icon"></i>
        </button>
        <div class="topbar-brand">
            <i class="ti ti-school" style="font-size:20px"></i>
            <span>CUP — FICCT</span>
        </div>
    </div>
    <div class="topbar-right">
        <!-- Theme Toggle Button -->
        <button id="theme-toggle" class="btn-logout" style="border:none;background:none;padding:8px" title="Cambiar Tema">
            <i class="ti ti-moon" id="theme-icon" style="font-size:18px"></i>
        </button>
        <span class="topbar-user">
            <i class="ti ti-user-circle" style="font-size:16px"></i>
            {{ Auth::user()->nombre }} {{ Auth::user()->apellido }}
        </span>
        <form method="POST" action="{{ route('logout') }}" style="display:inline">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="ti ti-logout"></i> <span class="hide-xs">Salir</span>
            </button>
        </form>
    </div>
</div>

{{-- SIDEBAR --}}
@include('admin.partials.sidebar')

{{-- CONTENIDO --}}
<div class="layout">

    <p class="page-title">Convocatoria activa — {{ $convocatoriaActiva ? $convocatoriaActiva->nombre : 'Ninguna' }}</p>

    {{-- MÉTRICAS --}}
    <div class="metrics">
        <div class="metric blue">
            <div class="metric-label"><i class="ti ti-users"></i> Postulantes</div>
            <div class="metric-value">{{ $stats['total_postulantes'] }}</div>
            <div class="metric-sub">Inscritos en el sistema</div>
        </div>
        <div class="metric amber">
            <div class="metric-label"><i class="ti ti-clock"></i> Pre-registros</div>
            <div class="metric-value">{{ $stats['pre_reg_pendientes'] }}</div>
            <div class="metric-sub" style="color:#b45309">Pendientes de revisión</div>
        </div>
        <div class="metric teal">
            <div class="metric-label"><i class="ti ti-layout-grid"></i> Grupos activos</div>
            <div class="metric-value">{{ $stats['total_grupos'] }}</div>
            <div class="metric-sub">Creados en el sistema</div>
        </div>
        <div class="metric purple">
            <div class="metric-label"><i class="ti ti-chalkboard"></i> Docentes</div>
            <div class="metric-value">{{ $stats['total_docentes'] }}</div>
            <div class="metric-sub">Registrados</div>
        </div>
    </div>

    <div class="two-col">

        {{-- PRE-REGISTROS PENDIENTES --}}
        <div class="card">
            <div class="card-title">
                Pre-registros pendientes
                <a href="{{ route('admin.pre-registros.index') }}">Ver todos →</a>
            </div>
            @if($pendientes->isEmpty())
                <div class="empty">
                    <i class="ti ti-circle-check" style="font-size:32px;display:block;margin-bottom:8px"></i>
                    No hay pre-registros pendientes
                </div>
            @else
                <div class="table-wrap">
                <div class="table-responsive"><table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Turno</th>
                            <th>Docs</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendientes as $pre)
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:8px">
                                    <div class="avatar av-blue">
                                        {{ strtoupper(substr($pre->nombre,0,1)) }}{{ strtoupper(substr($pre->apellido,0,1)) }}
                                    </div>
                                    <div>
                                        <div style="font-weight:500">{{ $pre->nombre }} {{ $pre->apellido }}</div>
                                        <div style="color:#94a3b8;font-size:11px">{{ $pre->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge badge-blue">{{ $pre->turno_preferido }}</span></td>
                            <td style="color:#64748b">—/3</td>
                            <td><a href="{{ route('admin.pre-registros.estudiante.show', $pre->id) }}" class="btn btn-sm-ok">Ver / Aprobar</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table></div>
                </div>
            @endif
        </div>

        {{-- ACCIONES RÁPIDAS --}}
        <div class="card">
            <div class="card-title">Acciones rápidas</div>
            <div class="acciones">
                <a href="{{ route('admin.grupos.index') }}" class="accion-btn">
                    <i class="ti ti-layout-grid" style="color:#1e3a6e;font-size:18px"></i>
                    Generar grupos
                </a>
                <a href="{{ route('admin.docentes.index') }}" class="accion-btn">
                    <i class="ti ti-user-check" style="color:#065f46;font-size:18px"></i>
                    Asignar docentes
                </a>
                <a href="{{ route('admin.reportes.index') }}" class="accion-btn">
                    <i class="ti ti-chart-bar" style="color:#5b21b6;font-size:18px"></i>
                    Ver reportes
                </a>
                <a href="{{ route('admin.resultados.admision') }}" class="accion-btn">
                    <i class="ti ti-trophy" style="color:#92400e;font-size:18px"></i>
                    Ejecutar admisión
                </a>
                <a href="{{ route('admin.carga-masiva.index') }}" class="accion-btn">
                    <i class="ti ti-upload" style="color:#1e3a6e;font-size:18px"></i>
                    Carga masiva CSV
                </a>
                <a href="{{ route('admin.convocatorias.index') }}" class="accion-btn">
                    <i class="ti ti-building" style="color:#065f46;font-size:18px"></i>
                    Nueva convocatoria
                </a>
            </div>
        </div>
    </div>

    {{-- LOG DE ACTIVIDAD --}}
    <div class="card">
        <div class="card-title">
            Registro de actividad reciente
            <a href="#">Ver todo →</a>
        </div>
        @if($logs->isEmpty())
            <div class="empty">
                <i class="ti ti-list" style="font-size:32px;display:block;margin-bottom:8px"></i>
                No hay actividad registrada aún
            </div>
        @else
            <div class="table-wrap">
            <div class="table-responsive"><table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fecha y hora</th>
                        <th>Usuario</th>
                        <th>Rol</th>
                        <th>Acción</th>
                        <th>Descripción</th>
                        <th>IP</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                    <tr>
                        <td style="color:#94a3b8">{{ $log->id }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($log->fecha_hora)->format('d/m/Y') }}<br>
                            <span style="color:#94a3b8;font-size:11px">{{ \Carbon\Carbon::parse($log->fecha_hora)->format('H:i:s') }}</span>
                        </td>
                        <td>
                            {{ $log->usuario_nombre }}<br>
                            <span style="color:#94a3b8;font-size:11px">{{ $log->usuario_email }}</span>
                        </td>
                        <td>
                            <span class="badge {{ $log->rol == 'ADMINISTRATIVO' ? 'badge-blue' : ($log->rol == 'DOCENTE' ? 'badge-doc' : 'badge-ok') }}">
                                {{ $log->rol }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $log->resultado == 'ok' ? 'badge-ok' : 'badge-err' }}">
                                {{ str_replace('_', ' ', $log->accion) }}
                            </span>
                        </td>
                        <td style="color:#64748b;max-width:200px">{{ $log->descripcion }}</td>
                        <td style="color:#94a3b8">{{ $log->ip }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table></div>
            </div>
        @endif
    </div>

</div>

<script>
    const themeToggleBtn = document.getElementById('theme-toggle');
    const themeIcon = document.getElementById('theme-icon');

    function updateThemeIcon() {
        if (document.documentElement.classList.contains('light-theme')) {
            themeIcon.className = 'ti ti-sun';
        } else {
            themeIcon.className = 'ti ti-moon';
        }
    }

    // Initialize icon
    updateThemeIcon();

    themeToggleBtn.addEventListener('click', () => {
        if (document.documentElement.classList.contains('light-theme')) {
            document.documentElement.classList.remove('light-theme');
            localStorage.setItem('theme', 'dark');
        } else {
            document.documentElement.classList.add('light-theme');
            localStorage.setItem('theme', 'light');
        }
        updateThemeIcon();
    });

    // ── SIDEBAR MÓVIL ──
    function toggleSidebar() {
        const sidebar  = document.querySelector('.sidebar');
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
        document.querySelector('.sidebar').classList.remove('open');
        document.getElementById('sidebar-overlay').classList.remove('active');
        document.getElementById('hamburger-icon').className = 'ti ti-menu-2';
    }

    // Cerrar sidebar al hacer clic en un nav-item (móvil)
    document.querySelectorAll('.nav-item').forEach(function(item) {
        item.addEventListener('click', function() {
            if (window.innerWidth <= 1024) closeSidebar();
        });
    });
</script>
</body>
</html>