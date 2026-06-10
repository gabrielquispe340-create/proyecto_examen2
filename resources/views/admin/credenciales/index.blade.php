<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credenciales Temporales — CUP FICCT</title>
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

        .alert { padding: 12px 16px; border-radius: 10px; margin-bottom: 16px; font-size: 13px; display: flex; align-items: center; gap: 8px; }
        .alert-ok  { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }
        .alert-err { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }

        /* Metrics */
        .metrics { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 24px; }
        .metric { background: #fff; border-radius: 12px; padding: 18px 20px; border: 1px solid #e2e8f0; }
        .metric-label { font-size: 12px; color: #64748b; margin-bottom: 8px; display: flex; align-items: center; gap: 6px; }
        .metric-value { font-size: 26px; font-weight: 600; color: #1e293b; }
        .metric.blue .metric-value { color: #1e3a6e; }
        .metric.green .metric-value { color: #059669; }
        .metric.amber .metric-value { color: #d97706; }

        /* Actions panel */
        .action-bar { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; padding: 16px 20px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap; }
        .action-buttons { display: flex; gap: 12px; }
        
        .btn { padding: 9px 18px; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; font-family: 'Figtree', sans-serif; display: inline-flex; align-items: center; gap: 6px; transition: background .15s, border-color .15s; text-decoration: none; }
        .btn-primary { background: #1e3a6e; color: #fff; }
        .btn-primary:hover { background: #0f2147; }
        .btn-secondary { background: #fff; border: 1px solid #cbd5e1; color: #334155; }
        .btn-secondary:hover { background: #f8fafc; }
        .btn-teal { background: #0d9488; color: #fff; }
        .btn-teal:hover { background: #0f766e; }
        .btn-danger { background: #dc2626; color: #fff; }
        .btn-danger:hover { background: #b91c1c; }

        .search-form { display: flex; gap: 8px; width: 100%; max-width: 320px; }
        .search-input { flex-grow: 1; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-family: 'Figtree', sans-serif; outline: none; }
        .search-input:focus { border-color: #1e3a6e; }

        /* Table Card */
        .card { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; margin-bottom: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th { text-align: left; padding: 12px 16px; font-size: 11px; font-weight: 600; color: #94a3b8; background: #f8fafc; border-bottom: 1px solid #e2e8f0; text-transform: uppercase; letter-spacing: .04em; }
        td { padding: 14px 16px; border-bottom: 1px solid #f1f5f9; color: #374151; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #f8fafc; }

        .badge { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 99px; font-size: 11px; font-weight: 500; gap: 4px; }
        .badge-green { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .badge-amber { background: #fef3c7; color: #92400e; border: 1px solid #fcd34d; }

        .code-style { font-family: monospace; font-size: 12px; background: #f1f5f9; padding: 2px 6px; border-radius: 4px; color: #0f172a; font-weight: 600; }
        .email-style { font-weight: 500; color: #1e3a6e; }

        .empty { text-align: center; padding: 48px; color: #94a3b8; }

        /* Pagination style */
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
            <div class="page-title">Credenciales Temporales</div>
            <div class="page-sub">Genera y simula el envío de accesos a docentes y postulantes</div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-ok"><i class="ti ti-circle-check"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-err"><i class="ti ti-alert-circle"></i> {{ session('error') }}</div>
    @endif

    {{-- METRICAS --}}
    <div class="metrics">
        <div class="metric blue">
            <div class="metric-label"><i class="ti ti-key"></i> Total Credenciales</div>
            <div class="metric-value">{{ $stats['total'] }}</div>
        </div>
        <div class="metric green">
            <div class="metric-label"><i class="ti ti-mail-fast"></i> Enviadas (Simulado)</div>
            <div class="metric-value">{{ $stats['enviado'] }}</div>
        </div>
        <div class="metric amber">
            <div class="metric-label"><i class="ti ti-mail-opened"></i> Pendientes de Envío</div>
            <div class="metric-value">{{ $stats['pendiente'] }}</div>
        </div>
    </div>

    {{-- ACTIONS PANEL --}}
    <div class="action-bar">
        <div class="action-buttons">
            <form action="{{ route('admin.credenciales.generar') }}" method="POST" style="display:inline">
                @csrf
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-refresh"></i> Generar Faltantes
                </button>
            </form>

            <form action="{{ route('admin.credenciales.enviar-masivo') }}" method="POST" style="display:inline" onsubmit="return confirm('¿Estás seguro de simular el envío de todas las credenciales pendientes?')">
                @csrf
                <button type="submit" class="btn btn-teal">
                    <i class="ti ti-send"></i> Simular Envío Masivo
                </button>
            </form>
        </div>

        <form method="GET" action="{{ route('admin.credenciales.index') }}" class="search-form">
            <input type="text" name="search" value="{{ $search }}" placeholder="Buscar por correo o código..." class="search-input">
            <button type="submit" class="btn btn-secondary" style="padding: 8px 12px;"><i class="ti ti-search"></i></button>
            @if($search)
                <a href="{{ route('admin.credenciales.index') }}" class="btn btn-secondary" style="padding: 8px 12px;"><i class="ti ti-x"></i></a>
            @endif
        </form>
    </div>

    {{-- CREDENTIALS CARD TABLE --}}
    <div class="card">
        @if($credenciales->isEmpty())
            <div class="empty">
                <i class="ti ti-key-off" style="font-size:36px;display:block;margin-bottom:8px"></i>
                No se encontraron credenciales temporales registradas.
            </div>
        @else
            <div style="overflow-x: auto">
                <div class="table-responsive"><table>
                    <thead>
                        <tr>
                            <th>Email de Destinatario</th>
                            <th>Código de Registro (Login)</th>
                            <th>Contraseña Temporal</th>
                            <th>Estado de Envío</th>
                            <th style="text-align: right">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($credenciales as $c)
                            <tr>
                                <td class="email-style">{{ $c->email }}</td>
                                <td><span class="code-style">{{ $c->codigo_registro }}</span></td>
                                <td><span class="code-style" style="background:#fef2f2;color:#991b1b">••••••••</span> ({{ $c->contrasena_correo }})</td>
                                <td>
                                    @if($c->correo_enviado)
                                        <span class="badge badge-green"><i class="ti ti-check"></i> Enviado</span>
                                    @else
                                        <span class="badge badge-amber"><i class="ti ti-mail-opened"></i> Pendiente</span>
                                    @endif
                                </td>
                                <td style="text-align: right">
                                    <form action="{{ route('admin.credenciales.enviar', $c->id) }}" method="POST" style="display:inline">
                                        @csrf
                                        <button type="submit" class="btn btn-secondary" style="padding:6px 12px;font-size:12px">
                                            <i class="ti ti-send"></i> Enviar Simulado
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table></div>
            </div>

            <div class="pagination-container">
                <div style="font-size: 12px; color: #64748b;">
                    Mostrando {{ $credenciales->firstItem() ?? 0 }} a {{ $credenciales->lastItem() ?? 0 }} de {{ $credenciales->total() }} registros
                </div>
                <div>
                    {{ $credenciales->links() }}
                </div>
            </div>
        @endif
    </div>

</div>
</main>

</body>
</html>
