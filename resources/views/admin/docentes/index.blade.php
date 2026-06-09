<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Docentes — CUP FICCT</title>
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Figtree', sans-serif; background: #f1f5f9; color: #1e293b; }

        .topbar { background: #1e3a6e; padding: 0 24px; height: 56px; display: flex; align-items: center; justify-content: space-between; position: fixed; top: 0; left: 0; right: 0; z-index: 200; }
        .topbar-brand { color: #fff; font-size: 16px; font-weight: 600; display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .topbar-right { display: flex; align-items: center; gap: 16px; }
        .topbar-user { color: #a8c8f0; font-size: 13px; display: flex; align-items: center; gap: 6px; }
        .btn-logout { background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.22); color: #fff; padding: 6px 14px; border-radius: 8px; font-size: 12px; cursor: pointer; text-decoration: none; display: flex; align-items: center; gap: 6px; transition: background .2s; }
        .btn-logout:hover { background: rgba(255,255,255,0.22); }

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
        .sidebar-footer { margin-top: auto; padding: 16px 10px 0; font-size: 11px; color: rgba(168,200,240,0.4); }

        .main { margin-left: 224px; padding-top: 56px; min-height: 100vh; }
        .page { padding: 28px; max-width: 1200px; }

        .page-header { margin-bottom: 22px; display: flex; align-items: flex-start; justify-content: space-between; }
        .page-title { font-size: 20px; font-weight: 600; color: #1e293b; }
        .page-sub { font-size: 13px; color: #94a3b8; margin-top: 3px; }

        .conteos { display: grid; grid-template-columns: repeat(4,1fr); gap: 12px; margin-bottom: 20px; }
        .conteo { background: #fff; border-radius: 10px; padding: 16px 20px; border: 1px solid #e2e8f0; }
        .conteo-label { font-size: 12px; color: #64748b; margin-bottom: 6px; display: flex; align-items: center; gap: 5px; }
        .conteo-valor { font-size: 24px; font-weight: 600; color: #1e293b; }
        .conteo.total  .conteo-valor { color: #1e3a6e; }
        .conteo.activo .conteo-valor { color: #065f46; }
        .conteo.inactivo .conteo-valor { color: #991b1b; }
        .conteo.licencia .conteo-valor { color: #92400e; }

        .filtros { background: #fff; border-radius: 10px; padding: 16px 20px; border: 1px solid #e2e8f0; margin-bottom: 16px; display: flex; gap: 16px; align-items: flex-end; flex-wrap: wrap; }
        .filtros label { font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: .04em; display: block; margin-bottom: 5px; }
        .filtros select, .filtros input { padding: 7px 12px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; color: #374151; background: #f8fafc; font-family: 'Figtree', sans-serif; }
        .filtros input { min-width: 220px; }
        .filtros select { min-width: 140px; }
        .btn-filtrar { padding: 8px 18px; background: #1e3a6e; color: #fff; border: none; border-radius: 8px; font-size: 13px; cursor: pointer; font-family: 'Figtree', sans-serif; display: flex; align-items: center; gap: 6px; }
        .btn-filtrar:hover { background: #0f2147; }
        .btn-limpiar { padding: 8px 14px; background: #f1f5f9; border: 1px solid #e2e8f0; color: #64748b; border-radius: 8px; font-size: 13px; cursor: pointer; font-family: 'Figtree', sans-serif; text-decoration: none; display: flex; align-items: center; gap: 6px; }
        .btn-limpiar:hover { background: #e2e8f0; }

        .card { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; }
        .card-header { padding: 12px 16px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; }
        .card-info { font-size: 13px; color: #64748b; }
        .btn-export { font-size: 12px; color: #64748b; text-decoration: none; display: flex; align-items: center; gap: 5px; }
        .btn-export:hover { color: #1e3a6e; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th { text-align: left; padding: 12px 16px; font-size: 11px; font-weight: 600; color: #94a3b8; background: #f8fafc; border-bottom: 1px solid #f1f5f9; text-transform: uppercase; letter-spacing: .04em; }
        td { padding: 13px 16px; border-bottom: 1px solid #f8fafc; color: #374151; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #fafafa; }

        .badge { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 99px; font-size: 11px; font-weight: 500; }
        .badge-reg  { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
        .badge-pago     { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }
        .badge-aprobado { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }
        .badge-ret  { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
        .badge-man  { background: #fef9c3; color: #854d0e; }
        .badge-tar  { background: #dbeafe; color: #1e40af; }
        .badge-noch { background: #ede9fe; color: #5b21b6; }

        .avatar { width: 32px; height: 32px; border-radius: 50%; background: #1e3a6e; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 600; flex-shrink: 0; }

        .codigo { font-family: monospace; font-size: 12px; background: #f1f5f9; color: #475569; padding: 2px 8px; border-radius: 6px; }

        .btn { padding: 5px 10px; border-radius: 7px; font-size: 12px; cursor: pointer; border: none; font-family: 'Figtree', sans-serif; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; font-weight: 500; }
        .btn-info { background: #dbeafe; color: #1e40af; border: 1px solid #93c5fd; }
        .btn-info:hover { background: #bfdbfe; }
        .btn-warn { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
        .btn-warn:hover { background: #fde68a; }
        .btn-err  { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
        .btn-err:hover { background: #fecaca; }

        .pagination { padding: 12px 16px; border-top: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; }
        .pag-info { font-size: 12px; color: #94a3b8; }
        .pag-links { display: flex; gap: 4px; }
        .pag-btn { padding: 5px 10px; border-radius: 7px; font-size: 12px; text-decoration: none; border: 1px solid #e2e8f0; color: #475569; background: #fff; }
        .pag-btn:hover { background: #1e3a6e; color: #fff; border-color: #1e3a6e; }
        .pag-btn.active { background: #1e3a6e; color: #fff; border-color: #1e3a6e; font-weight: 600; }
        .pag-btn.disabled { color: #cbd5e1; cursor: not-allowed; }

        .empty { text-align: center; padding: 56px; color: #94a3b8; }
        .empty i { font-size: 40px; display: block; margin-bottom: 10px; }

        .alert { padding: 12px 16px; border-radius: 10px; margin-bottom: 16px; font-size: 13px; display: flex; align-items: center; gap: 8px; }
        .alert-ok  { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }
        .alert-err { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
    </style>
</head>
<body>

{{-- TOPBAR --}}
<div class="topbar">
    <a href="{{ route('admin.dashboard') }}" class="topbar-brand">
        <i class="ti ti-school" style="font-size:20px"></i> CUP — FICCT
    </a>
    <div class="topbar-right">
        <span class="topbar-user">
            <i class="ti ti-user-circle" style="font-size:16px"></i>
            {{ Auth::user()->nombre ?? Auth::user()->name }} {{ Auth::user()->apellido ?? '' }}
        </span>
        <form method="POST" action="{{ route('logout') }}" style="display:inline">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="ti ti-logout"></i> Salir
            </button>
        </form>
    </div>
</div>

{{-- SIDEBAR --}}
@include('admin.partials.sidebar')

{{-- CONTENIDO --}}
<main class="main">
<div class="page">

    <div class="page-header">
        <div>
            <div class="page-title">Docentes</div>
            <div class="page-sub">Gestiona los docentes registrados en el sistema</div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-ok"><i class="ti ti-circle-check"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-err"><i class="ti ti-alert-circle"></i> {{ session('error') }}</div>
    @endif

    <div class="conteos">
        <div class="conteo total">
            <div class="conteo-label"><i class="ti ti-users"></i> Total</div>
            <div class="conteo-valor">{{ $stats['total'] }}</div>
        </div>
        <div class="conteo activo">
            <div class="conteo-label"><i class="ti ti-heartbeat"></i> Activos</div>
            <div class="conteo-valor">{{ $stats['activos'] }}</div>
        </div>
        <div class="conteo inactivo">
            <div class="conteo-label"><i class="ti ti-user-x"></i> Inactivos</div>
            <div class="conteo-valor">{{ $stats['inactivos'] }}</div>
        </div>
        <div class="conteo licencia">
            <div class="conteo-label"><i class="ti ti-bed"></i> Licencia</div>
            <div class="conteo-valor">{{ $stats['licencia'] }}</div>
        </div>
    </div>

    <form method="GET" action="{{ route('admin.docentes.index') }}" class="filtros">
        <div>
            <label>Buscar</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nombre, CI, email o especialidad...">
        </div>
        <div>
            <label>Estado</label>
            <select name="estado">
                <option value="">Todos</option>
                <option value="ACTIVO" {{ request('estado')=='ACTIVO' ? 'selected' : '' }}>Activo</option>
                <option value="INACTIVO" {{ request('estado')=='INACTIVO' ? 'selected' : '' }}>Inactivo</option>
                <option value="LICENCIA" {{ request('estado')=='LICENCIA' ? 'selected' : '' }}>Licencia</option>
            </select>
        </div>
        <div style="display:flex;gap:8px">
            <button type="submit" class="btn-filtrar">
                <i class="ti ti-filter"></i> Filtrar
            </button>
            @if(request()->hasAny(['search','estado']))
                <a href="{{ route('admin.docentes.index') }}" class="btn-limpiar">
                    <i class="ti ti-x"></i> Limpiar
                </a>
            @endif
        </div>
    </form>

    <div class="card">
        <div class="card-header">
            <span class="card-info">
                Mostrando {{ $docentes->firstItem() ?? 0 }}–{{ $docentes->lastItem() ?? 0 }} de {{ $docentes->total() }} docentes
            </span>
        </div>

        @if($docentes->isEmpty())
            <div class="empty">
                <i class="ti ti-chalkboard"></i>
                No se encontraron docentes
            </div>
        @else
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Código</th>
                    <th>Docente</th>
                    <th>CI</th>
                    <th>Email</th>
                    <th>Especialidad</th>
                    <th>Grupo asignado</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($docentes as $i => $docente)
                <tr>
                    <td style="color:#94a3b8">{{ $docentes->firstItem() + $i }}</td>
                    <td>
                        @if($docente->codigo_docente)
                            <span class="codigo">{{ $docente->codigo_docente }}</span>
                        @else
                            <span style="color:#94a3b8;font-style:italic">—</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px">
                            <div class="avatar">{{ strtoupper(substr($docente->nombre,0,1).substr($docente->apellido,0,1)) }}</div>
                            <div>
                                <div style="font-weight:500">{{ $docente->nombre }} {{ $docente->apellido }}</div>
                                <div style="color:#94a3b8;font-size:11px">{{ $docente->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="font-size:12px;color:#64748b">{{ $docente->ci }}</td>
                    <td style="font-size:12px;color:#64748b">{{ $docente->email }}</td>
                    <td>{{ $docente->especialidad ? ucfirst(strtolower($docente->especialidad)) : '—' }}</td>
                    <td>
                        @if($docente->grupos->isEmpty())
                            <span style="font-size:11px;color:#94a3b8;font-style:italic">Sin grupo</span>
                        @else
                            @foreach($docente->grupos as $grp)
                                @php
                                    $turno = $grp->turno ?? '';
                                    $turnoColor = match($turno) {
                                        'MAÑANA' => 'background:#fef9c3;color:#854d0e;',
                                        'TARDE'  => 'background:#dbeafe;color:#1e40af;',
                                        'NOCHE'  => 'background:#ede9fe;color:#5b21b6;',
                                        default  => 'background:#f1f5f9;color:#475569;',
                                    };
                                @endphp
                                <span style="display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:99px;font-size:11px;font-weight:500;{{ $turnoColor }}">
                                    <i class="ti ti-layout-grid" style="font-size:11px"></i>
                                    Grupo {{ $grp->numero_grupo }} &middot; {{ ucfirst(strtolower($turno)) }}
                                </span>
                            @endforeach
                        @endif
                    </td>
                    <td>
                        @php
                            $estadoClass = ['ACTIVO'=>'badge-aprobado','INACTIVO'=>'badge-ret','LICENCIA'=>'badge-man'];
                        @endphp
                        <span class="badge {{ $estadoClass[$docente->estado] ?? '' }}">
                            {{ ucfirst(strtolower(str_replace('_',' ',$docente->estado))) }}
                        </span>
                    </td>
                    <td style="white-space:nowrap">
                        <a href="{{ route('admin.docentes.edit', $docente->id) }}" class="btn btn-warn">
                            <i class="ti ti-pencil"></i> Editar
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @if($docentes->hasPages())
        <div class="pagination">
            <span class="pag-info">Página {{ $docentes->currentPage() }} de {{ $docentes->lastPage() }}</span>
            <div class="pag-links">
                @if($docentes->onFirstPage())
                    <span class="pag-btn disabled">← Anterior</span>
                @else
                    <a href="{{ $docentes->previousPageUrl() }}" class="pag-btn">← Anterior</a>
                @endif

                @foreach($docentes->getUrlRange(max(1,$docentes->currentPage()-2), min($docentes->lastPage(),$docentes->currentPage()+2)) as $page => $url)
                    <a href="{{ $url }}" class="pag-btn {{ $page == $docentes->currentPage() ? 'active' : '' }}">{{ $page }}</a>
                @endforeach

                @if($docentes->hasMorePages())
                    <a href="{{ $docentes->nextPageUrl() }}" class="pag-btn">Siguiente →</a>
                @else
                    <span class="pag-btn disabled">Siguiente →</span>
                @endif
            </div>
        </div>
        @endif
        @endif
    </div>

</div>
</main>

</body>
</html>