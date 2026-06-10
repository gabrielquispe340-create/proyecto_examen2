<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bitácora de Logs — CUP FICCT</title>
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
        .page { padding: 28px; max-width: 1100px; }
        .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; }
        .page-title { font-size: 20px; font-weight: 600; }
        .page-sub { font-size: 13px; color: #94a3b8; margin-top: 3px; }

        /* Metrics */
        .metrics { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 24px; }
        .metric { background: #fff; border-radius: 12px; padding: 18px 20px; border: 1px solid #e2e8f0; }
        .metric-label { font-size: 12px; color: #64748b; margin-bottom: 8px; display: flex; align-items: center; gap: 6px; }
        .metric-value { font-size: 26px; font-weight: 600; color: #1e293b; }
        .metric.blue .metric-value { color: #1e3a6e; }
        .metric.green .metric-value { color: #0d9488; }
        .metric.rose .metric-value { color: #be123c; }

        /* Filter Panel */
        .filter-bar { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; padding: 16px 20px; margin-bottom: 24px; }
        .filter-form { display: flex; flex-wrap: wrap; gap: 12px; align-items: flex-end; }
        .filter-field { display: flex; flex-direction: column; gap: 4px; flex-grow: 1; min-width: 180px; }
        .filter-field label { font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: .04em; }
        .filter-select, .filter-input { padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-family: 'Figtree', sans-serif; background: #fff; outline: none; }
        .filter-select:focus, .filter-input:focus { border-color: #1e3a6e; }
        
        .btn-filter { padding: 9px 16px; background: #1e3a6e; color: #fff; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; font-family: 'Figtree', sans-serif; display: inline-flex; align-items: center; gap: 6px; height: 37px; }
        .btn-filter:hover { background: #0f2147; }
        .btn-clear { padding: 9px 16px; background: #fff; border: 1px solid #cbd5e1; color: #334155; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; font-family: 'Figtree', sans-serif; display: inline-flex; align-items: center; gap: 6px; text-decoration: none; height: 37px; }
        .btn-clear:hover { background: #f8fafc; }

        /* Card Table */
        .card { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; margin-bottom: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th { text-align: left; padding: 12px 16px; font-size: 11px; font-weight: 600; color: #94a3b8; background: #f8fafc; border-bottom: 1px solid #e2e8f0; text-transform: uppercase; letter-spacing: .04em; }
        td { padding: 12px 16px; border-bottom: 1px solid #f1f5f9; color: #374151; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #f8fafc; }

        .badge { display: inline-flex; align-items: center; padding: 2px 8px; border-radius: 99px; font-size: 10px; font-weight: 600; text-transform: uppercase; }
        .badge-green { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .badge-rose { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
        .badge-gray { background: #f1f5f9; color: #334155; border: 1px solid #cbd5e1; }

        .time-style { font-size: 11px; color: #94a3b8; display: block; margin-top: 2px; }
        .user-name { font-weight: 600; color: #1e293b; }
        .user-email { font-size: 11px; color: #64748b; display: block; font-family: monospace; }
        .module-badge { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; font-family: monospace; padding: 2px 6px; border-radius: 4px; font-size: 11px; }

        .empty { text-align: center; padding: 48px; color: #94a3b8; }
        .pagination-container { padding: 16px 20px; background: #f8fafc; border-top: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; }
    
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

    <div class="page-header">
        <div>
            <div class="page-title">Bitácora de Logs y Actividad</div>
            <div class="page-sub">Auditoría completa de operaciones y acciones de usuarios en el sistema</div>
        </div>
    </div>

    {{-- METRICAS --}}
    <div class="metrics">
        <div class="metric blue">
            <div class="metric-label"><i class="ti ti-history"></i> Total Acciones</div>
            <div class="metric-value">{{ $stats['total'] }}</div>
        </div>
        <div class="metric green">
            <div class="metric-label"><i class="ti ti-bolt"></i> Acciones Hoy</div>
            <div class="metric-value">{{ $stats['hoy'] }}</div>
        </div>
        <div class="metric rose">
            <div class="metric-label"><i class="ti ti-alert-triangle"></i> Operaciones Fallidas</div>
            <div class="metric-value">{{ $stats['errores'] }}</div>
        </div>
    </div>

    {{-- FILTROS --}}
    <div class="filter-bar">
        <form method="GET" action="{{ route('admin.logs.index') }}" class="filter-form">
            <div class="filter-field">
                <label>Buscar</label>
                <input type="text" name="search" value="{{ $search }}" placeholder="Usuario, email, descripción..." class="filter-input">
            </div>

            <div class="filter-field">
                <label>Módulo</label>
                <select name="modulo" class="filter-select">
                    <option value="">Todos los módulos</option>
                    @foreach($modulos as $mod)
                        <option value="{{ $mod }}" {{ $modulo === $mod ? 'selected' : '' }}>{{ strtoupper($mod) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="filter-field">
                <label>Acción</label>
                <select name="accion" class="filter-select">
                    <option value="">Todas las acciones</option>
                    @foreach($acciones as $acc)
                        <option value="{{ $acc }}" {{ $accion === $acc ? 'selected' : '' }}>{{ strtoupper(str_replace('_', ' ', $acc)) }}</option>
                    @endforeach
                </select>
            </div>

            <div style="display: flex; gap: 8px;">
                <button type="submit" class="btn-filter">
                    <i class="ti ti-filter"></i> Filtrar
                </button>
                @if($search || $modulo || $accion)
                    <a href="{{ route('admin.logs.index') }}" class="btn-clear">
                        <i class="ti ti-x"></i> Limpiar
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- LOGS CARD TABLE --}}
    <div class="card">
        @if($logs->isEmpty())
            <div class="empty">
                <i class="ti ti-database-off" style="font-size:36px;display:block;margin-bottom:8px"></i>
                No se encontraron logs de actividad que coincidan con los filtros.
            </div>
        @else
            <div style="overflow-x: auto">
                <div class="table-responsive"><table>
                    <thead>
                        <tr>
                            <th style="width: 140px;">Fecha y Hora</th>
                            <th>Usuario</th>
                            <th>Módulo</th>
                            <th>Acción</th>
                            <th>Descripción de Actividad</th>
                            <th>IP</th>
                            <th style="text-align: center">Resultado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $l)
                            <tr>
                                <td>
                                    <strong>{{ \Carbon\Carbon::parse($l->fecha_hora)->format('d/m/Y') }}</strong>
                                    <span class="time-style">{{ \Carbon\Carbon::parse($l->fecha_hora)->format('H:i:s') }}</span>
                                </td>
                                <td>
                                    <span class="user-name">{{ $l->usuario_nombre ?? 'Anónimo' }}</span>
                                    <span class="user-email">{{ $l->usuario_email ?? 'system@ficct.uagrm' }}</span>
                                </td>
                                <td><span class="module-badge">{{ $l->modulo ?? 'sistema' }}</span></td>
                                <td>
                                    <strong style="color: #475569; font-size:12px;">
                                        {{ strtoupper(str_replace('_', ' ', $l->accion)) }}
                                    </strong>
                                </td>
                                <td style="max-width: 320px; line-height: 1.4; color: #4b5563;">{{ $l->descripcion }}</td>
                                <td style="font-family: monospace; font-size:11px;">{{ $l->ip }}</td>
                                <td style="text-align: center">
                                    @if($l->resultado === 'ok')
                                        <span class="badge badge-green">Éxito</span>
                                    @elseif($l->resultado === 'error')
                                        <span class="badge badge-rose">Fallo</span>
                                    @else
                                        <span class="badge badge-gray">{{ $l->resultado }}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table></div>
            </div>

            <div class="pagination-container">
                <div style="font-size: 12px; color: #64748b;">
                    Mostrando {{ $logs->firstItem() ?? 0 }} a {{ $logs->lastItem() ?? 0 }} de {{ $logs->total() }} registros
                </div>
                <div>
                    {{ $logs->links() }}
                </div>
            </div>
        @endif
    </div>

</div>
</main>

</body>
</html>
