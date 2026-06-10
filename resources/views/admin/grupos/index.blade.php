<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grupos — CUP FICCT</title>
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Figtree', sans-serif; background: #f1f5f9; color: #1e293b; }

        /* ── TOPBAR ── */
        .topbar {
            background: #1e3a6e; padding: 0 24px; height: 56px;
            display: flex; align-items: center; justify-content: space-between;
            position: fixed; top: 0; left: 0; right: 0; z-index: 200;
        }
        .topbar-brand { color: #fff; font-size: 16px; font-weight: 600; display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .topbar-right { display: flex; align-items: center; gap: 16px; }
        .topbar-user { color: #a8c8f0; font-size: 13px; display: flex; align-items: center; gap: 6px; }
        .btn-logout { background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.22); color: #fff; padding: 6px 14px; border-radius: 8px; font-size: 12px; cursor: pointer; text-decoration: none; display: flex; align-items: center; gap: 6px; transition: background .2s; }
        .btn-logout:hover { background: rgba(255,255,255,0.22); }

        /* ── SIDEBAR ── */
        .sidebar {
            width: 224px; height: calc(100vh - 56px);
            background: #1e3a6e; position: fixed; top: 56px; left: 0;
            overflow-y: auto; padding: 20px 12px 24px;
            display: flex; flex-direction: column; gap: 2px;
        }
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

        /* ── MAIN ── */
        .main { margin-left: 224px; padding-top: 56px; min-height: 100vh; }
        .page { padding: 28px; width: 100%; }

        /* ── PAGE HEADER ── */
        .page-header { margin-bottom: 22px; }
        .page-title { font-size: 20px; font-weight: 600; color: #1e293b; }
        .page-sub { font-size: 13px; color: #94a3b8; margin-top: 3px; }

        /* ── CONTEOS ── */
        .conteos { display: grid; grid-template-columns: repeat(4,1fr); gap: 12px; margin-bottom: 20px; }
        .conteo { background: #fff; border-radius: 10px; padding: 16px 20px; border: 1px solid #e2e8f0; }
        .conteo-label { font-size: 12px; color: #64748b; margin-bottom: 6px; display: flex; align-items: center; gap: 5px; }
        .conteo-valor { font-size: 24px; font-weight: 600; }

        /* ── FILTROS ── */
        .filtros { background: #fff; border-radius: 10px; padding: 16px 20px; border: 1px solid #e2e8f0; margin-bottom: 16px; display: flex; gap: 16px; align-items: flex-end; flex-wrap: wrap; }
        .filtros label { font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: .04em; display: block; margin-bottom: 5px; }
        .filtros select { padding: 7px 12px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; color: #374151; background: #f8fafc; font-family: 'Figtree', sans-serif; min-width: 160px; }
        .btn-filtrar { padding: 8px 18px; background: #1e3a6e; color: #fff; border: none; border-radius: 8px; font-size: 13px; cursor: pointer; font-family: 'Figtree', sans-serif; display: flex; align-items: center; gap: 6px; }
        .btn-filtrar:hover { background: #0f2147; }

        /* ── TABLA ── */
        .card { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; }
        .table-wrapper { width: 100%; overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; min-width: 900px; }
        th { text-align: left; padding: 12px 14px; font-size: 11px; font-weight: 600; color: #94a3b8; background: #f8fafc; border-bottom: 1px solid #f1f5f9; text-transform: uppercase; letter-spacing: .04em; white-space: nowrap; }
        td { padding: 12px 14px; border-bottom: 1px solid #f8fafc; color: #374151; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #fafafa; }

        /* ── BADGES ── */
        .badge { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 99px; font-size: 11px; font-weight: 500; }
        .badge-active { background: #d1fae5; color: #065f46; }
        .badge-pending { background: #fef3c7; color: #92400e; }
        .badge-error { background: #fee2e2; color: #991b1b; }
        .badge-info { background: #dbeafe; color: #1e40af; }

        /* ── AVATAR ── */
        .avatar { width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 600; flex-shrink: 0; }
        .av-blue   { background: #dbeafe; color: #1e40af; }
        .av-purple { background: #ede9fe; color: #5b21b6; }

        /* ── BOTONES ACCIÓN ── */
        .btn { padding: 6px 12px; border-radius: 8px; font-size: 12px; cursor: pointer; border: none; font-family: 'Figtree', sans-serif; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; font-weight: 500; }
        .btn-ok   { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }
        .btn-ok:hover { background: #a7f3d0; }
        .btn-err  { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
        .btn-err:hover { background: #fecaca; }
        .btn-info { background: #dbeafe; color: #1e40af; border: 1px solid #93c5fd; }
        .btn-info:hover { background: #bfdbfe; }

        .empty { text-align: center; padding: 56px; color: #94a3b8; }
        .empty i { font-size: 40px; display: block; margin-bottom: 10px; }

        /* ── PANEL GENERAR GRUPOS ── */
        .panel-generar { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; padding: 20px 24px; margin-bottom: 20px; }
        .panel-generar h3 { font-size: 14px; font-weight: 600; color: #1e293b; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
        .form-row { display: flex; gap: 16px; align-items: flex-end; flex-wrap: wrap; }
        .form-group { display: flex; flex-direction: column; gap: 5px; }
        .form-group label { font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: .04em; }
        .form-group select, .form-group input[type=number] { padding: 7px 12px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; color: #374151; background: #f8fafc; font-family: 'Figtree', sans-serif; min-width: 120px; }
        .form-group input[type=number]:disabled { opacity: .45; cursor: not-allowed; }
        .btn-generar { padding: 8px 20px; background: #1e3a6e; color: #fff; border: none; border-radius: 8px; font-size: 13px; cursor: pointer; font-family: 'Figtree', sans-serif; display: flex; align-items: center; gap: 6px; font-weight: 500; }
        .btn-generar:hover { background: #0f2147; }
        .check-auto { display: flex; align-items: center; gap: 7px; font-size: 13px; color: #374151; cursor: pointer; padding: 7px 0; }
        .check-auto input { width: 15px; height: 15px; cursor: pointer; accent-color: #1e3a6e; }
        .sugerencia { margin-top: 12px; padding: 10px 14px; border-radius: 8px; font-size: 12px; display: none; }
        .sugerencia.info { background: #dbeafe; color: #1e40af; border: 1px solid #93c5fd; }
        .sugerencia.warn { background: #fef3c7; color: #92400e; border: 1px solid #fcd34d; }
        .alert { padding: 12px 16px; border-radius: 8px; font-size: 13px; margin-bottom: 16px; display: flex; align-items: flex-start; gap: 10px; }
        .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }
        .alert-error   { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
    
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
    window.addEventListener('pageshow', function(event) {
        if (event.persisted) {
            window.location.reload();
        }
    });
</script>

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
            <button type="submit" class="btn-logout">
                <i class="ti ti-logout"></i> Salir
            </button>
        </form>
    </div>
</div>

@include('admin.partials.sidebar')

<main class="main">
<div class="page">

    <div class="page-header">
        <div class="page-title">Gestión de Grupos</div>
        <div class="page-sub">Administra los grupos académicos usando el mismo estilo del panel de pre-registros.</div>
    </div>

    @php
        $totalPostulantes = 0;
        $totalDocentes = 0;
        $capacidadTotal = 0;
        foreach($grupos as $g) {
            $totalPostulantes += $g->postulantes()->count();
            $totalDocentes += $g->docentes()->count();
            $capacidadTotal += $g->capacidad_maxima;
        }
        $ocupacion = $capacidadTotal > 0 ? round(($totalPostulantes / $capacidadTotal) * 100, 1) : 0;
    @endphp

    <div class="conteos">
        <div class="conteo">
            <div class="conteo-label"><i class="ti ti-layout-grid"></i> Total grupos</div>
            <div class="conteo-valor">{{ $grupos->count() }}</div>
        </div>
        <div class="conteo">
            <div class="conteo-label"><i class="ti ti-users"></i> Postulantes asignados</div>
            <div class="conteo-valor">{{ $totalPostulantes }}</div>
        </div>
        <div class="conteo">
            <div class="conteo-label"><i class="ti ti-chalkboard"></i> Docentes asignados</div>
            <div class="conteo-valor">{{ $totalDocentes }}</div>
        </div>
        <div class="conteo">
            <div class="conteo-label"><i class="ti ti-percentage"></i> Ocupación</div>
            <div class="conteo-valor">{{ $ocupacion }}%</div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success"><i class="ti ti-check"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error"><i class="ti ti-alert-circle"></i> {{ session('error') }}</div>
    @endif

    {{-- ── PANEL: GENERAR GRUPOS ── --}}
    @if($convocatoria)
    <div class="panel-generar">
        <h3><i class="ti ti-layout-grid" style="color:#1e3a6e"></i> Generar grupos para {{ $convocatoria->nombre }}</h3>
        <p style="font-size:12px;color:#64748b;margin-bottom:14px;">
            <i class="ti ti-info-circle" style="color:#2563eb"></i>
            El sistema calculará automáticamente la cantidad de grupos necesarios por cada turno según el total de postulantes inscritos y la capacidad especificada (ej. si hay más del límite por grupo, se crearán subgrupos como Tarde 1, Tarde 2, etc.). Si ya existen suficientes grupos para cubrir la cantidad requerida, se omitirá su creación.
        </p>
        <form method="POST" action="{{ route('admin.grupos.generar') }}" id="form-generar">
            @csrf
            <input type="hidden" name="convocatoria_id" value="{{ $convocatoria->id }}">
            <div class="form-row">
                <div class="form-group">
                    <label>Capacidad por grupo</label>
                    <input type="number" name="capacidad" value="70" min="5" max="100" required
                           style="max-width:140px">
                </div>
                <div class="form-group">
                    <label style="visibility:hidden">Acción</label>
                    <button type="submit" class="btn-generar">
                        <i class="ti ti-plus"></i> Generar grupos
                    </button>
                </div>
            </div>
            <div id="sugerencia" class="sugerencia info" style="display:none; margin-top:14px;"></div>
        </form>
    </div>
    @endif

    <form method="GET" action="{{ route('admin.grupos.index') }}" class="filtros">
        <div>
            <label>Convocatoria</label>
            <select name="convocatoria_id" onchange="this.form.submit()">
                <option value="">-- Seleccionar --</option>
                @foreach($convocatorias as $conv)
                    <option value="{{ $conv->id }}" {{ (request('convocatoria_id') == $conv->id || (!$convocatoriaId && $convocatoria && $convocatoria->id == $conv->id)) ? 'selected' : '' }}>{{ $conv->nombre }} ({{ $conv->estado }})</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn-filtrar">Filtrar</button>
    </form>

    <div class="card">
        @if($grupos->isEmpty())
            <div class="empty">
                <i class="ti ti-inbox"></i>
                <p>No hay grupos creados para esta convocatoria.</p>
            </div>
        @else
            <div class="table-wrapper">
                <div class="table-responsive"><table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Grupo</th>
                            <th>Turno</th>
                            <th>Postulantes</th>
                            <th>Docentes</th>
                            <th>Capacidad</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($grupos as $grupo)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $grupo->numero_grupo }}</td>
                                <td>{{ $grupo->turno }}</td>
                                <td>{{ $grupo->postulantes()->count() }}</td>
                                <td>{{ $grupo->docentes()->count() }}</td>
                                <td>{{ $grupo->capacidad_maxima }}</td>
                                <td><span class="badge badge-info">{{ $grupo->estado }}</span></td>
                                <td>
                                    <a href="{{ route('admin.grupos.show', $grupo) }}" class="btn btn-info">
                                        <i class="ti ti-eye"></i> Ver
                                    </a>
                                    <button onclick="abrirEditarTurno({{ $grupo->id }}, '{{ $grupo->turno }}')" class="btn btn-warn">
                                        <i class="ti ti-pencil"></i> Editar turno
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table></div>
            </div>

            {{-- Acciones masivas --}}
            @if($convocatoria)
            <div style="display:flex;gap:12px;margin-top:16px;flex-wrap:wrap">
                <button type="button" class="btn-generar" style="background:#059669"
                        data-form="form-auto-postulantes"
                        data-titulo="¿Distribuir postulantes?"
                        data-mensaje="Se asignará cada postulante APROBADO al grupo correspondiente según su turno."
                        data-label="Distribuir"
                        data-color="#059669"
                        onclick="abrirConfirmBtn(this)">
                    <i class="ti ti-users"></i> Distribución automática de postulantes
                </button>
                <form method="POST" action="{{ route('admin.grupos.auto-asignar') }}" id="form-auto-postulantes">
                    @csrf
                    <input type="hidden" name="convocatoria_id" value="{{ $convocatoria->id }}">
                </form>

                <button type="button" class="btn-generar" style="background:#1d4ed8"
                        data-form="form-auto-docentes"
                        data-titulo="¿Distribuir docentes?"
                        data-mensaje="Se asignará un docente por materia a cada grupo activo según su especialidad."
                        data-label="Distribuir"
                        data-color="#1d4ed8"
                        onclick="abrirConfirmBtn(this)">
                    <i class="ti ti-chalkboard"></i> Distribución automática de docentes
                </button>
                <form method="POST" action="{{ route('admin.grupos.auto-asignar-docentes') }}" id="form-auto-docentes">
                    @csrf
                    <input type="hidden" name="convocatoria_id" value="{{ $convocatoria->id }}">
                </form>

                <div style="display:flex;gap:8px;align-items:center">
                    <select id="sel-grupo-eliminar" style="padding:8px 12px;border:1px solid #e2e8f0;border-radius:8px;font-size:13px;font-family:'Figtree',sans-serif">
                        <option value="">— Seleccionar grupo —</option>
                        @foreach($grupos as $g)
                            <option value="{{ $g->id }}">Grupo {{ $g->numero_grupo }} ({{ $g->turno }})</option>
                        @endforeach
                    </select>
                    <form method="POST" action="{{ route('admin.grupos.limpiar') }}" id="form-eliminar-grupo">
                        @csrf
                        <input type="hidden" name="convocatoria_id" value="{{ $convocatoria->id }}">
                        <input type="hidden" name="grupo_id" id="input-grupo-id">
                    </form>
                    <button type="button" class="btn-generar" style="background:#dc2626" onclick="confirmarEliminarGrupo()">
                        <i class="ti ti-trash"></i> Eliminar grupo
                    </button>
                </div>
            </div>
            @endif

        @endif
    </div>

</div>
</main>
<script>
(function() {
    const sugerencia   = document.getElementById('sugerencia');
    const hiddenConv   = document.querySelector('#form-generar input[name=convocatoria_id]');
    const inpCapacidad = document.querySelector('#form-generar input[name=capacidad]');
    const selectConv   = document.querySelector('select[name=convocatoria_id]:not(#form-generar select)');

    if (!hiddenConv || !inpCapacidad || !sugerencia) return;

    // Sincronizar hidden con el selector de filtro de convocatoria
    if (selectConv) {
        selectConv.addEventListener('change', function() {
            hiddenConv.value = this.value;
            actualizarSugerencia();
        });
        if (!hiddenConv.value && selectConv.value) {
            hiddenConv.value = selectConv.value;
        }
    }

    function actualizarSugerencia() {
        const convId = hiddenConv.value;
        const cap = inpCapacidad.value;
        if (!convId || !cap) { sugerencia.style.display = 'none'; return; }

        const url = '{{ route("admin.grupos.calcular") }}?convocatoria_id=' + convId + '&capacidad=' + cap;
        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(r => r.json())
            .then(data => {
                sugerencia.style.display = 'block';
                sugerencia.className = 'sugerencia info';

                if (data.por_turno) {
                    let html = '<i class="ti ti-info-circle"></i> <strong>Estimación de grupos necesarios (Capacidad: ' + cap + '):</strong><br>';
                    for (const [t, info] of Object.entries(data.por_turno)) {
                        html += `&nbsp;&nbsp;• ${t}: ${info.total} inscritos → <strong>${info.grupos} grupo(s)</strong><br>`;
                    }
                    html += `<strong>Total: ${data.total_inscritos} inscritos → ${data.grupos_calculados} grupo(s) en total.</strong>`;
                    sugerencia.innerHTML = html;
                } else {
                    sugerencia.style.display = 'none';
                }
            })
            .catch(() => { sugerencia.style.display = 'none'; });
    }

    inpCapacidad.addEventListener('input', actualizarSugerencia);
    inpCapacidad.addEventListener('change', actualizarSugerencia);

    // Inicializar sugerencia si ya hay convocatoria
    if (hiddenConv.value) actualizarSugerencia();
})();
</script>
{{-- Modal de confirmación profesional --}}
<div id="confirm-modal" style="display:none;position:fixed;inset:0;background:rgba(15,23,42,0.5);z-index:1000;align-items:center;justify-content:center;backdrop-filter:blur(2px)">
    <div style="background:#fff;border-radius:16px;padding:32px;width:420px;box-shadow:0 20px 60px rgba(0,0,0,0.2);animation:fadeIn .15s ease">
        <div id="cm-icon" style="width:48px;height:48px;border-radius:50%;display:flex;align-items:center;justify-content:center;margin-bottom:16px;font-size:22px"></div>
        <h3 id="cm-title" style="font-size:18px;font-weight:600;color:#1e293b;margin-bottom:8px"></h3>
        <p id="cm-body" style="font-size:14px;color:#64748b;margin-bottom:24px;line-height:1.5"></p>
        <div style="display:flex;gap:10px;justify-content:flex-end">
            <button onclick="cerrarConfirm()" style="padding:10px 20px;border:1px solid #e2e8f0;border-radius:8px;background:#f8fafc;color:#475569;font-size:13px;font-family:'Figtree',sans-serif;cursor:pointer;font-weight:500">
                Cancelar
            </button>
            <button id="cm-btn-ok" style="padding:10px 24px;border:none;border-radius:8px;color:#fff;font-size:13px;font-family:'Figtree',sans-serif;cursor:pointer;font-weight:600">
                Confirmar
            </button>
        </div>
    </div>
</div>

<style>
@keyframes fadeIn { from { opacity:0; transform:scale(.96); } to { opacity:1; transform:scale(1); } }

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

<script>
let _pendingFormId = null;

function abrirConfirmBtn(btn) {
    _pendingFormId = btn.dataset.form;
    const color = btn.dataset.color || '#1e3a6e';
    mostrarModal(btn.dataset.titulo, btn.dataset.mensaje, btn.dataset.label, color);
}

function confirmarEliminarGrupo() {
    const sel = document.getElementById('sel-grupo-eliminar');
    if (!sel.value) { alert('Selecciona un grupo primero.'); return; }
    document.getElementById('input-grupo-id').value = sel.value;
    _pendingFormId = 'form-eliminar-grupo';
    const txt = sel.options[sel.selectedIndex].text;
    mostrarModal('¿Eliminar grupo?',
        'Se eliminará el ' + txt + ' junto con todas sus asignaciones. Esta acción no se puede deshacer.',
        'Eliminar', '#dc2626');
}

function mostrarModal(titulo, mensaje, btnLabel, color) {
    document.getElementById('cm-title').textContent = titulo;
    document.getElementById('cm-body').textContent  = mensaje;
    const btnOk = document.getElementById('cm-btn-ok');
    btnOk.textContent = btnLabel || 'Confirmar';
    btnOk.style.background = color;
    btnOk.onclick = function() {
        if (_pendingFormId) {
            document.getElementById(_pendingFormId).submit();
        }
        cerrarConfirm();
    };

    const icon = document.getElementById('cm-icon');
    if (color === '#dc2626') {
        icon.style.background = '#fee2e2';
        icon.innerHTML = '<i class="ti ti-alert-triangle" style="color:#dc2626"></i>';
    } else if (color === '#059669') {
        icon.style.background = '#d1fae5';
        icon.innerHTML = '<i class="ti ti-users" style="color:#059669"></i>';
    } else {
        icon.style.background = '#dbeafe';
        icon.innerHTML = '<i class="ti ti-chalkboard" style="color:#1d4ed8"></i>';
    }

    document.getElementById('confirm-modal').style.display = 'flex';
}

function cerrarConfirm() {
    document.getElementById('confirm-modal').style.display = 'none';
    _pendingFormId = null;
}

document.getElementById('confirm-modal').addEventListener('click', function(e) {
    if (e.target === this) cerrarConfirm();
});
</script>

{{-- Modal editar turno --}}
<div id="modal-turno" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.4);z-index:999;align-items:center;justify-content:center">
    <div style="background:#fff;border-radius:14px;padding:28px;width:340px;box-shadow:0 8px 32px rgba(0,0,0,0.18)">
        <h3 style="font-size:16px;font-weight:600;margin-bottom:16px">Editar turno del grupo</h3>
        <form method="POST" action="{{ route('admin.grupos.actualizar-turno') }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="grupo_id" id="modal-grupo-id">
            <div style="margin-bottom:16px">
                <label style="display:block;font-size:12px;font-weight:600;color:#475569;margin-bottom:6px;text-transform:uppercase">Turno</label>
                <select name="turno" id="modal-turno-select" style="width:100%;padding:9px 12px;border:1px solid #e2e8f0;border-radius:8px;font-size:13px;font-family:'Figtree',sans-serif">
                    <option value="MAÑANA">Mañana</option>
                    <option value="TARDE">Tarde</option>
                    <option value="NOCHE">Noche</option>
                </select>
            </div>
            <div style="display:flex;gap:10px">
                <button type="submit" class="btn-generar" style="flex:1;justify-content:center">Guardar</button>
                <button type="button" onclick="cerrarModal()" style="flex:1;padding:10px;border:1px solid #e2e8f0;border-radius:8px;background:#f1f5f9;cursor:pointer;font-family:'Figtree',sans-serif;font-size:13px">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<script>
function abrirEditarTurno(grupoId, turnoActual) {
    document.getElementById('modal-grupo-id').value = grupoId;
    document.getElementById('modal-turno-select').value = turnoActual;
    document.getElementById('modal-turno').style.display = 'flex';
}
function cerrarModal() {
    document.getElementById('modal-turno').style.display = 'none';
}
</script>
</body>
</html>