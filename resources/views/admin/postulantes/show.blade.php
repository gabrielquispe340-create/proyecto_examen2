<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $postulante->nombre }} {{ $postulante->apellido }} — CUP FICCT</title>
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600&display=swap" rel="stylesheet">
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
        .nav-item { padding: 9px 12px; font-size: 13px; color: rgba(168,200,240,0.85); text-decoration: none; border-radius: 8px; display: flex; align-items: center; gap: 10px; transition: background .15s, color .15s; }
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
        .page { padding: 28px; max-width: 960px; }

        /* Header */
        .page-header { margin-bottom: 24px; display: flex; align-items: center; gap: 16px; }
        .back-btn { color: #64748b; text-decoration: none; font-size: 13px; display: flex; align-items: center; gap: 5px; padding: 6px 12px; border: 1px solid #e2e8f0; border-radius: 8px; background: #fff; }
        .back-btn:hover { background: #f1f5f9; }
        .page-title { font-size: 20px; font-weight: 600; color: #1e293b; }
        .page-sub { font-size: 13px; color: #94a3b8; margin-top: 2px; }

        /* Avatar grande */
        .perfil-header { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; padding: 24px; margin-bottom: 20px; display: flex; align-items: center; gap: 20px; }
        .avatar-lg { width: 64px; height: 64px; border-radius: 50%; background: #1e3a6e; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 22px; font-weight: 600; flex-shrink: 0; }
        .perfil-info h2 { font-size: 18px; font-weight: 600; color: #1e293b; }
        .perfil-info p { font-size: 13px; color: #64748b; margin-top: 3px; }
        .perfil-badges { display: flex; gap: 8px; margin-top: 10px; flex-wrap: wrap; }

        /* Cards de secciones */
        .card { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; margin-bottom: 20px; overflow: hidden; }
        .card-title { font-size: 13px; font-weight: 600; color: #475569; padding: 14px 20px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; gap: 8px; }
        .card-title i { font-size: 16px; }
        .card-body { padding: 20px; }

        /* Grid de datos */
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; }
        .dato { display: flex; flex-direction: column; gap: 3px; }
        .dato-label { font-size: 11px; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: .04em; }
        .dato-valor { font-size: 14px; color: #1e293b; }
        .dato-vacio { color: #cbd5e1; font-style: italic; }

        /* Badges */
        .badge { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 99px; font-size: 11px; font-weight: 500; }
        .badge-reg  { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
        .badge-pago { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }
        .badge-ret  { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
        .badge-man  { background: #fef9c3; color: #854d0e; }
        .badge-tar  { background: #dbeafe; color: #1e40af; }
        .badge-noch { background: #ede9fe; color: #5b21b6; }
        .badge-ok   { background: #d1fae5; color: #065f46; }
        .badge-no   { background: #fee2e2; color: #991b1b; }
        .badge-grup { background: #e0f2fe; color: #0369a1; }

        /* Código mono */
        .codigo { font-family: monospace; font-size: 13px; background: #f1f5f9; color: #475569; padding: 2px 8px; border-radius: 6px; }

        /* Tabla notas */
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th { text-align: left; padding: 10px 14px; font-size: 11px; font-weight: 600; color: #94a3b8; background: #f8fafc; border-bottom: 1px solid #f1f5f9; text-transform: uppercase; letter-spacing: .04em; }
        td { padding: 11px 14px; border-bottom: 1px solid #f8fafc; color: #374151; }
        tr:last-child td { border-bottom: none; }

        /* Pago */
        .pago-row { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid #f1f5f9; }
        .pago-row:last-child { border-bottom: none; }

        /* Botones */
        .btn { padding: 7px 14px; border-radius: 8px; font-size: 13px; cursor: pointer; border: none; font-family: 'Figtree', sans-serif; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; font-weight: 500; }
        .btn-warn { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
        .btn-warn:hover { background: #fde68a; }
        .btn-primary { background: #1e3a6e; color: #fff; }
        .btn-primary:hover { background: #0f2147; }

        /* Sin datos */
        .sin-datos { text-align: center; padding: 32px; color: #94a3b8; font-size: 13px; }
        .sin-datos i { font-size: 28px; display: block; margin-bottom: 8px; }
    
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

    {{-- Header --}}
    <div class="page-header">
        <a href="{{ route('admin.postulantes.index') }}" class="back-btn">
            <i class="ti ti-arrow-left"></i> Volver
        </a>
        <div>
            <div class="page-title">Detalle del postulante</div>
            <div class="page-sub">Información completa, grupo y notas</div>
        </div>
        <div style="margin-left:auto">
            <a href="{{ route('admin.postulantes.edit', $postulante) }}" class="btn btn-warn">
                <i class="ti ti-edit"></i> Editar
            </a>
        </div>
    </div>

    {{-- Perfil --}}
    @php
        $iniciales = strtoupper(substr($postulante->nombre,0,1) . substr($postulante->apellido,0,1));
        $turnoClass = match($postulante->turno_asignado) {
            'MAÑANA' => 'badge-man', 'TARDE' => 'badge-tar', 'NOCHE' => 'badge-noch', default => ''
        };
        $estadoClass = match($postulante->estado) {
            'CON_PAGO'   => 'badge-pago',
            'RETIRADO'   => 'badge-ret',
            default      => 'badge-reg',
        };
        $grupo = $postulante->grupoPostulante->grupo ?? null;
    @endphp

    <div class="perfil-header">
        <div class="avatar-lg">{{ $iniciales }}</div>
        <div class="perfil-info">
            <h2>{{ $postulante->nombre }} {{ $postulante->apellido }}</h2>
            <p>{{ $postulante->email }} &nbsp;·&nbsp; CI: {{ $postulante->ci }}</p>
            <div class="perfil-badges">
                <span class="badge {{ $estadoClass }}">{{ $postulante->estado }}</span>
                <span class="badge {{ $turnoClass }}">{{ $postulante->turno_asignado }}</span>
                @if($grupo)
                    <span class="badge badge-grup"><i class="ti ti-layout-grid" style="font-size:10px"></i> Grupo {{ $grupo->numero_grupo }}</span>
                @else
                    <span class="badge badge-no">Sin grupo</span>
                @endif
                <span class="codigo">{{ $postulante->codigo_estudiante }}</span>
            </div>
        </div>
    </div>

    {{-- Datos personales --}}
    <div class="card">
        <div class="card-title"><i class="ti ti-user" style="color:#1e3a6e"></i> Datos personales</div>
        <div class="card-body">
            <div class="grid-3" style="margin-bottom:16px">
                <div class="dato">
                    <span class="dato-label">Nombre completo</span>
                    <span class="dato-valor">{{ $postulante->nombre }} {{ $postulante->apellido }}</span>
                </div>
                <div class="dato">
                    <span class="dato-label">CI</span>
                    <span class="dato-valor">{{ $postulante->ci }}</span>
                </div>
                <div class="dato">
                    <span class="dato-label">Fecha de nacimiento</span>
                    <span class="dato-valor {{ $postulante->fecha_nacimiento ? '' : 'dato-vacio' }}">
                        {{ $postulante->fecha_nacimiento ? \Carbon\Carbon::parse($postulante->fecha_nacimiento)->format('d/m/Y') : 'No registrada' }}
                    </span>
                </div>
            </div>
            <div class="grid-3">
                <div class="dato">
                    <span class="dato-label">Email</span>
                    <span class="dato-valor">{{ $postulante->email }}</span>
                </div>
                <div class="dato">
                    <span class="dato-label">Teléfono</span>
                    <span class="dato-valor {{ $postulante->telefono ? '' : 'dato-vacio' }}">{{ $postulante->telefono ?? 'No registrado' }}</span>
                </div>
                <div class="dato">
                    <span class="dato-label">Ciudad</span>
                    <span class="dato-valor {{ $postulante->ciudad ? '' : 'dato-vacio' }}">{{ $postulante->ciudad ?? 'No registrada' }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Datos académicos --}}
    <div class="card">
        <div class="card-title"><i class="ti ti-school" style="color:#1e3a6e"></i> Datos académicos</div>
        <div class="card-body">
            <div class="grid-2" style="margin-bottom:16px">
                <div class="dato">
                    <span class="dato-label">Carrera preferida 1</span>
                    <span class="dato-valor">{{ $postulante->carreraPref1->nombre ?? '—' }}</span>
                </div>
                <div class="dato">
                    <span class="dato-label">Carrera preferida 2</span>
                    <span class="dato-valor {{ $postulante->carreraPref2 ? '' : 'dato-vacio' }}">{{ $postulante->carreraPref2->nombre ?? 'No indicada' }}</span>
                </div>
            </div>
            <div class="grid-3">
                <div class="dato">
                    <span class="dato-label">Turno asignado</span>
                    <span class="dato-valor"><span class="badge {{ $turnoClass }}">{{ $postulante->turno_asignado }}</span></span>
                </div>
                <div class="dato">
                    <span class="dato-label">Grupo</span>
                    <span class="dato-valor">
                        @if($grupo)
                            <span class="badge badge-grup">Grupo {{ $grupo->numero_grupo }} — {{ $grupo->turno }}</span>
                        @else
                            <span class="dato-vacio">Sin grupo asignado</span>
                        @endif
                    </span>
                </div>
                <div class="dato">
                    <span class="dato-label">Colegio</span>
                    <span class="dato-valor {{ $postulante->colegio_nombre ? '' : 'dato-vacio' }}">{{ $postulante->colegio_nombre ?? 'No registrado' }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Pagos --}}
    <div class="card">
        <div class="card-title"><i class="ti ti-receipt" style="color:#065f46"></i> Pagos</div>
        <div class="card-body">
            @if($postulante->pagos->isEmpty())
                <div class="sin-datos"><i class="ti ti-receipt-off"></i> Sin pagos registrados</div>
            @else
                @foreach($postulante->pagos as $pago)
                    <div class="pago-row">
                        <div>
                            <div style="font-size:13px;font-weight:500">Recibo: <span class="codigo">{{ $pago->nro_recibo }}</span></div>
                            <div style="font-size:12px;color:#94a3b8;margin-top:2px">{{ $pago->created_at ? \Carbon\Carbon::parse($pago->created_at)->format('d/m/Y H:i') : '—' }}</div>
                        </div>
                        <div style="text-align:right">
                            <div style="font-size:16px;font-weight:600;color:#1e293b">Bs. {{ number_format($pago->monto, 2) }}</div>
                            <span class="badge {{ $pago->estado === 'VALIDADO' ? 'badge-ok' : ($pago->estado === 'ANULADO' ? 'badge-ret' : 'badge-reg') }}">
                                {{ $pago->estado }}
                            </span>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    {{-- Notas --}}
    <div class="card">
        <div class="card-title"><i class="ti ti-notes" style="color:#5b21b6"></i> Notas por examen</div>
        @if($postulante->notas->isEmpty())
            <div class="sin-datos"><i class="ti ti-file-off"></i> Sin notas registradas</div>
        @else
            <div class="table-responsive"><table>
                <thead>
                    <tr>
                        <th>Materia</th>
                        <th>Examen N°</th>
                        <th>Fecha</th>
                        <th>Puntaje</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($postulante->notas->sortBy(fn($n) => [$n->examen->materia->nombre ?? '', $n->examen->nro_examen]) as $nota)
                        <tr>
                            <td>{{ $nota->examen->materia->nombre ?? '—' }}</td>
                            <td>Examen {{ $nota->examen->nro_examen ?? '—' }}</td>
                            <td>{{ $nota->examen->fecha ? \Carbon\Carbon::parse($nota->examen->fecha)->format('d/m/Y') : '—' }}</td>
                            <td style="font-weight:600">{{ number_format($nota->puntaje, 2) }}</td>
                            <td>
                                <span class="badge {{ $nota->puntaje >= 60 ? 'badge-ok' : 'badge-ret' }}">
                                    {{ $nota->puntaje >= 60 ? 'Aprobado' : 'Reprobado' }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table></div>
        @endif
    </div>

    {{-- Resultado final --}}
    @if($postulante->resultadoFinal)
        @php $rf = $postulante->resultadoFinal; @endphp
        <div class="card">
            <div class="card-title"><i class="ti ti-trophy" style="color:#b45309"></i> Resultado final</div>
            <div class="card-body">
                <div class="grid-3" style="margin-bottom:16px">
                    <div class="dato">
                        <span class="dato-label">Promedio Matemáticas</span>
                        <span class="dato-valor">{{ $rf->promedio_mat ?? '—' }}</span>
                    </div>
                    <div class="dato">
                        <span class="dato-label">Promedio Física</span>
                        <span class="dato-valor">{{ $rf->promedio_fis ?? '—' }}</span>
                    </div>
                    <div class="dato">
                        <span class="dato-label">Promedio Computación</span>
                        <span class="dato-valor">{{ $rf->promedio_com ?? '—' }}</span>
                    </div>
                </div>
                <div class="grid-3">
                    <div class="dato">
                        <span class="dato-label">Promedio Inglés</span>
                        <span class="dato-valor">{{ $rf->promedio_ing ?? '—' }}</span>
                    </div>
                    <div class="dato">
                        <span class="dato-label">Promedio total</span>
                        <span class="dato-valor" style="font-size:20px;font-weight:700;color:#1e3a6e">{{ $rf->promedio_total ?? '—' }}</span>
                    </div>
                    <div class="dato">
                        <span class="dato-label">Estado de admisión</span>
                        <span class="dato-valor">
                            <span class="badge {{ $rf->aprobado_general ? 'badge-ok' : 'badge-ret' }}">
                                {{ $rf->estado_admision }}
                            </span>
                        </span>
                    </div>
                </div>
                @if($rf->carreraAsignada)
                    <div style="margin-top:16px" class="dato">
                        <span class="dato-label">Carrera asignada</span>
                        <span class="dato-valor" style="font-weight:600">{{ $rf->carreraAsignada->nombre }}</span>
                    </div>
                @endif
            </div>
        </div>
    @endif

</div>
</main>
</body>
</html>