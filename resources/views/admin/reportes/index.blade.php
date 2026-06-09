<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes — CUP FICCT</title>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Figtree', sans-serif; background: #f1f5f9; color: #1e293b; }

        /* TOPBAR */
        .topbar { background: #1e3a6e; padding: 0 24px; height: 56px; display: flex; align-items: center; justify-content: space-between; position: fixed; top: 0; left: 0; right: 0; z-index: 200; }
        .topbar-brand { color: #fff; font-size: 16px; font-weight: 600; display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .topbar-right { display: flex; align-items: center; gap: 16px; }
        .topbar-user { color: #a8c8f0; font-size: 13px; display: flex; align-items: center; gap: 6px; }
        .btn-logout { background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.22); color: #fff; padding: 6px 14px; border-radius: 8px; font-size: 12px; cursor: pointer; text-decoration: none; display: flex; align-items: center; gap: 6px; font-family: 'Figtree',sans-serif; transition: background .2s; }
        .btn-logout:hover { background: rgba(255,255,255,0.22); }

        /* SIDEBAR */
        .sidebar { width: 224px; height: calc(100vh - 56px); background: #1e3a6e; position: fixed; top: 56px; left: 0; overflow-y: auto; padding: 20px 12px 24px; display: flex; flex-direction: column; gap: 2px; }
        .nav-label { font-size: 10px; font-weight: 700; color: rgba(168,200,240,0.55); text-transform: uppercase; letter-spacing: .1em; padding: 16px 10px 6px; }
        .nav-label:first-child { padding-top: 4px; }
        .nav-item { padding: 9px 12px; font-size: 13px; color: rgba(168,200,240,0.85); text-decoration: none; border-radius: 8px; display: flex; align-items: center; gap: 10px; transition: background .15s; }
        .nav-item i { font-size: 16px; flex-shrink: 0; }
        .nav-item:hover { background: rgba(255,255,255,0.10); color: #fff; }
        .nav-item.active { background: rgba(255,255,255,0.15); color: #fff; font-weight: 500; }
        .nav-item.active i { color: #7dd3fc; }
        .nav-item.c-blue i { color: #93c5fd; } .nav-item.c-amber i { color: #fcd34d; }
        .nav-item.c-teal i { color: #6ee7b7; } .nav-item.c-purple i { color: #c4b5fd; }
        .nav-item.c-rose i  { color: #fda4af; } .nav-item.c-sky i   { color: #7dd3fc; }
        .sidebar-footer { margin-top: auto; padding: 16px 10px 0; font-size: 11px; color: rgba(168,200,240,0.4); }

        /* MAIN */
        .main { margin-left: 224px; padding-top: 56px; min-height: 100vh; }
        .page { padding: 28px; }

        /* PAGE HEADER */
        .page-header { margin-bottom: 24px; }
        .page-title { font-size: 20px; font-weight: 600; color: #1e293b; }
        .page-sub { font-size: 13px; color: #94a3b8; margin-top: 3px; }

        /* STATS */
        .stat-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 14px; margin-bottom: 24px; }
        .stat-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px 18px; display: flex; align-items: center; gap: 14px; }
        .stat-icon { width: 42px; height: 42px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .stat-icon i { font-size: 20px; }
        .si-blue   { background: #dbeafe; } .si-blue i   { color: #2563eb; }
        .si-green  { background: #d1fae5; } .si-green i  { color: #059669; }
        .si-amber  { background: #fef3c7; } .si-amber i  { color: #d97706; }
        .si-purple { background: #ede9fe; } .si-purple i { color: #7c3aed; }
        .si-rose   { background: #ffe4e6; } .si-rose i   { color: #e11d48; }
        .stat-num { font-size: 22px; font-weight: 700; color: #0f172a; line-height: 1; }
        .stat-lbl { font-size: 12px; color: #64748b; margin-top: 2px; }

        /* SECTION TITLE */
        .section-title { font-size: 14px; font-weight: 600; color: #0f172a; margin-bottom: 14px; display: flex; align-items: center; gap: 8px; }
        .section-title i { font-size: 17px; color: #1e3a6e; }

        /* REPORT GRID */
        .report-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 28px; }
        .report-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; display: flex; flex-direction: column; gap: 12px; transition: box-shadow .2s, border-color .2s; }
        .report-card:hover { box-shadow: 0 4px 16px rgba(30,58,110,0.10); border-color: #c7d8f5; }
        .rc-header { display: flex; align-items: flex-start; gap: 12px; }
        .rc-icon { width: 42px; height: 42px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .rc-icon i { font-size: 20px; }
        .rc-info { flex: 1; }
        .rc-title { font-size: 14px; font-weight: 600; color: #1e293b; margin-bottom: 3px; }
        .rc-desc  { font-size: 12px; color: #64748b; line-height: 1.5; }
        .rc-tags  { display: flex; gap: 6px; flex-wrap: wrap; }
        .rc-tag   { font-size: 11px; padding: 2px 8px; border-radius: 99px; font-weight: 500; }
        .tag-blue   { background: #dbeafe; color: #1e40af; }
        .tag-green  { background: #d1fae5; color: #065f46; }
        .tag-amber  { background: #fef3c7; color: #92400e; }
        .tag-purple { background: #ede9fe; color: #5b21b6; }
        .tag-rose   { background: #ffe4e6; color: #9f1239; }
        .tag-slate  { background: #f1f5f9; color: #475569; }
        .rc-actions { display: flex; gap: 8px; margin-top: 4px; }
        .btn-dl { flex: 1; padding: 8px 12px; border-radius: 8px; font-size: 12px; font-weight: 600; cursor: pointer; font-family: 'Figtree',sans-serif; display: inline-flex; align-items: center; justify-content: center; gap: 6px; border: none; text-decoration: none; transition: opacity .15s, filter .15s; }
        .btn-dl:hover { filter: brightness(0.92); }
        .btn-pdf   { background: #ef4444; color: #fff; }
        .btn-excel { background: #059669; color: #fff; }
        .btn-csv   { background: #475569; color: #fff; }

        /* LOG TABLE */
        .card { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; }
        .card-header { padding: 16px 20px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; }
        .card-header-title { font-size: 14px; font-weight: 600; color: #0f172a; display: flex; align-items: center; gap: 8px; }
        .card-header-title i { font-size: 17px; color: #1e3a6e; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th { text-align: left; padding: 11px 16px; font-size: 11px; font-weight: 600; color: #94a3b8; background: #f8fafc; border-bottom: 1px solid #f1f5f9; text-transform: uppercase; letter-spacing: .04em; }
        td { padding: 12px 16px; border-bottom: 1px solid #f8fafc; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #fafafa; }
        .badge { display: inline-flex; align-items: center; padding: 2px 9px; border-radius: 99px; font-size: 11px; font-weight: 500; }
        .b-ok   { background: #d1fae5; color: #065f46; }
        .b-err  { background: #fee2e2; color: #991b1b; }
        .b-warn { background: #fef3c7; color: #92400e; }
        .empty-state { text-align: center; padding: 40px; color: #94a3b8; }
        .empty-state i { font-size: 36px; display: block; margin-bottom: 10px; color: #cbd5e1; }

        /* FILTER BAR */
        .filter-bar { display: flex; gap: 10px; align-items: center; }
        .filter-bar select, .filter-bar input { padding: 7px 11px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 12px; color: #374151; font-family: 'Figtree',sans-serif; background: #f8fafc; }
        .filter-bar select:focus, .filter-bar input:focus { outline: none; border-color: #1e3a6e; }
        .btn-filter { padding: 7px 14px; background: #1e3a6e; color: #fff; border: none; border-radius: 8px; font-size: 12px; font-weight: 600; cursor: pointer; font-family: 'Figtree',sans-serif; display: flex; align-items: center; gap: 5px; }

        /* ALERTS */
        .alert { padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; font-size: 13px; display: flex; align-items: center; gap: 8px; }
        .alert-ok  { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }
        .alert-err { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }

        /* CONVOCATORIA SELECTOR */
        .conv-bar { background: #fff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 14px 18px; margin-bottom: 20px; display: flex; align-items: center; gap: 14px; font-size: 13px; }
        .conv-bar label { font-weight: 600; color: #374151; white-space: nowrap; }
        .conv-bar select { flex: 1; max-width: 300px; padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; font-family: 'Figtree',sans-serif; color: #1e293b; background: #f8fafc; }
        .conv-bar select:focus { outline: none; border-color: #1e3a6e; }
        .conv-info { font-size: 12px; color: #64748b; margin-left: auto; }
    </style>
</head>
<body>

{{-- TOPBAR --}}
<div class="topbar">
    <a href="{{ route('admin.dashboard') }}" class="topbar-brand">
        <i class="ti ti-school"></i> CUP — FICCT
    </a>
    <div class="topbar-right">
        <span class="topbar-user"><i class="ti ti-user-circle"></i> {{ Auth::user()->nombre }} {{ Auth::user()->apellido }}</span>
        <form method="POST" action="{{ route('logout') }}" style="display:inline">
            @csrf
            <button type="submit" class="btn-logout"><i class="ti ti-logout"></i> Salir</button>
        </form>
    </div>
</div>

{{-- SIDEBAR --}}
@include('admin.partials.sidebar')

{{-- MAIN --}}
<main class="main">
<div class="page">

    @if(session('success'))
        <div class="alert alert-ok"><i class="ti ti-circle-check"></i> {{ session('success') }}</div>
    @endif

    {{-- HEADER --}}
    <div class="page-header">
        <div class="page-title">Reportes</div>
        <div class="page-sub">Descarga reportes completos del sistema en PDF o Excel.</div>
    </div>

    {{-- STATS --}}
    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-icon si-blue"><i class="ti ti-users"></i></div>
            <div>
                <div class="stat-num">{{ $stats['postulantes'] }}</div>
                <div class="stat-lbl">Postulantes</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon si-green"><i class="ti ti-circle-check"></i></div>
            <div>
                <div class="stat-num">{{ $stats['admitidos'] }}</div>
                <div class="stat-lbl">Admitidos</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon si-amber"><i class="ti ti-chalkboard"></i></div>
            <div>
                <div class="stat-num">{{ $stats['docentes'] }}</div>
                <div class="stat-lbl">Docentes</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon si-purple"><i class="ti ti-layout-grid"></i></div>
            <div>
                <div class="stat-num">{{ $stats['grupos'] }}</div>
                <div class="stat-lbl">Grupos</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon si-rose"><i class="ti ti-file-text"></i></div>
            <div>
                <div class="stat-num">{{ $stats['examenes'] }}</div>
                <div class="stat-lbl">Exámenes</div>
            </div>
        </div>
    </div>

    {{-- CONVOCATORIA FILTER --}}
    <div class="conv-bar">
        <label><i class="ti ti-filter" style="margin-right:5px;color:#1e3a6e;"></i>Filtrar por convocatoria:</label>
        <select id="convSelect" onchange="aplicarConvocatoria()">
            <option value="">Todas las convocatorias</option>
            @foreach($convocatorias as $conv)
                <option value="{{ $conv->id }}" {{ request('conv') == $conv->id ? 'selected' : '' }}>
                    {{ $conv->nombre }} — {{ ucfirst(strtolower($conv->estado)) }}
                </option>
            @endforeach
        </select>
        <span class="conv-info">Los reportes se generarán para la convocatoria seleccionada</span>
    </div>

    {{-- REPORTES: POSTULANTES --}}
    <div class="section-title"><i class="ti ti-users"></i> Postulantes</div>
    <div class="report-grid">

        <div class="report-card">
            <div class="rc-header">
                <div class="rc-icon si-blue"><i class="ti ti-list"></i></div>
                <div class="rc-info">
                    <div class="rc-title">Lista completa de postulantes</div>
                    <div class="rc-desc">Todos los postulantes registrados con datos personales, carrera preferida y estado.</div>
                </div>
            </div>
            <div class="rc-tags">
                <span class="rc-tag tag-blue">Nombre completo</span>
                <span class="rc-tag tag-slate">CI</span>
                <span class="rc-tag tag-slate">Carrera</span>
                <span class="rc-tag tag-slate">Turno</span>
                <span class="rc-tag tag-slate">Estado</span>
            </div>
            <div class="rc-actions">
                <a href="{{ route('admin.reportes.descargar', ['tipo'=>'postulantes','formato'=>'pdf']) }}{{ request('conv') ? '&conv='.request('conv') : '' }}" class="btn-dl btn-pdf"><i class="ti ti-file-type-pdf"></i> PDF</a>
                <a href="{{ route('admin.reportes.descargar', ['tipo'=>'postulantes','formato'=>'excel']) }}{{ request('conv') ? '&conv='.request('conv') : '' }}" class="btn-dl btn-excel"><i class="ti ti-file-spreadsheet"></i> Excel</a>
                <a href="{{ route('admin.reportes.descargar', ['tipo'=>'postulantes','formato'=>'csv']) }}{{ request('conv') ? '&conv='.request('conv') : '' }}" class="btn-dl btn-csv"><i class="ti ti-file-type-csv"></i> CSV</a>
            </div>
        </div>

        <div class="report-card">
            <div class="rc-header">
                <div class="rc-icon si-green"><i class="ti ti-trophy"></i></div>
                <div class="rc-info">
                    <div class="rc-title">Postulantes aprobados</div>
                    <div class="rc-desc">Lista de postulantes que aprobaron el CUP con su promedio final y carrera asignada.</div>
                </div>
            </div>
            <div class="rc-tags">
                <span class="rc-tag tag-green">Aprobados</span>
                <span class="rc-tag tag-slate">Promedio</span>
                <span class="rc-tag tag-slate">Carrera asignada</span>
                <span class="rc-tag tag-slate">Ranking</span>
            </div>
            <div class="rc-actions">
                <a href="{{ route('admin.reportes.descargar', ['tipo'=>'aprobados','formato'=>'pdf']) }}{{ request('conv') ? '&conv='.request('conv') : '' }}" class="btn-dl btn-pdf"><i class="ti ti-file-type-pdf"></i> PDF</a>
                <a href="{{ route('admin.reportes.descargar', ['tipo'=>'aprobados','formato'=>'excel']) }}{{ request('conv') ? '&conv='.request('conv') : '' }}" class="btn-dl btn-excel"><i class="ti ti-file-spreadsheet"></i> Excel</a>
                <a href="{{ route('admin.reportes.descargar', ['tipo'=>'aprobados','formato'=>'csv']) }}{{ request('conv') ? '&conv='.request('conv') : '' }}" class="btn-dl btn-csv"><i class="ti ti-file-type-csv"></i> CSV</a>
            </div>
        </div>

        <div class="report-card">
            <div class="rc-header">
                <div class="rc-icon si-rose"><i class="ti ti-circle-x"></i></div>
                <div class="rc-info">
                    <div class="rc-title">Postulantes reprobados</div>
                    <div class="rc-desc">Lista de postulantes que no superaron el puntaje mínimo requerido.</div>
                </div>
            </div>
            <div class="rc-tags">
                <span class="rc-tag tag-rose">Reprobados</span>
                <span class="rc-tag tag-slate">Promedio</span>
                <span class="rc-tag tag-slate">Materia más baja</span>
            </div>
            <div class="rc-actions">
                <a href="{{ route('admin.reportes.descargar', ['tipo'=>'reprobados','formato'=>'pdf']) }}{{ request('conv') ? '&conv='.request('conv') : '' }}" class="btn-dl btn-pdf"><i class="ti ti-file-type-pdf"></i> PDF</a>
                <a href="{{ route('admin.reportes.descargar', ['tipo'=>'reprobados','formato'=>'excel']) }}{{ request('conv') ? '&conv='.request('conv') : '' }}" class="btn-dl btn-excel"><i class="ti ti-file-spreadsheet"></i> Excel</a>
                <a href="{{ route('admin.reportes.descargar', ['tipo'=>'reprobados','formato'=>'csv']) }}{{ request('conv') ? '&conv='.request('conv') : '' }}" class="btn-dl btn-csv"><i class="ti ti-file-type-csv"></i> CSV</a>
            </div>
        </div>

    </div>

    {{-- REPORTES: NOTAS --}}
    <div class="section-title"><i class="ti ti-file-analytics"></i> Notas y promedios</div>
    <div class="report-grid">

        <div class="report-card">
            <div class="rc-header">
                <div class="rc-icon si-purple"><i class="ti ti-chart-bar"></i></div>
                <div class="rc-info">
                    <div class="rc-title">Promedios generales</div>
                    <div class="rc-desc">Promedio de cada postulante por materia (MAT, FIS, COM, ING) y promedio total.</div>
                </div>
            </div>
            <div class="rc-tags">
                <span class="rc-tag tag-purple">Matemáticas</span>
                <span class="rc-tag tag-purple">Física</span>
                <span class="rc-tag tag-purple">Computación</span>
                <span class="rc-tag tag-purple">Inglés</span>
            </div>
            <div class="rc-actions">
                <a href="{{ route('admin.reportes.descargar', ['tipo'=>'promedios','formato'=>'pdf']) }}{{ request('conv') ? '&conv='.request('conv') : '' }}" class="btn-dl btn-pdf"><i class="ti ti-file-type-pdf"></i> PDF</a>
                <a href="{{ route('admin.reportes.descargar', ['tipo'=>'promedios','formato'=>'excel']) }}{{ request('conv') ? '&conv='.request('conv') : '' }}" class="btn-dl btn-excel"><i class="ti ti-file-spreadsheet"></i> Excel</a>
                <a href="{{ route('admin.reportes.descargar', ['tipo'=>'promedios','formato'=>'csv']) }}{{ request('conv') ? '&conv='.request('conv') : '' }}" class="btn-dl btn-csv"><i class="ti ti-file-type-csv"></i> CSV</a>
            </div>
        </div>

        <div class="report-card">
            <div class="rc-header">
                <div class="rc-icon si-amber"><i class="ti ti-math"></i></div>
                <div class="rc-info">
                    <div class="rc-title">Estadísticas por materia</div>
                    <div class="rc-desc">Promedio, nota máxima, mínima, % de aprobación por materia y convocatoria.</div>
                </div>
            </div>
            <div class="rc-tags">
                <span class="rc-tag tag-amber">Promedio</span>
                <span class="rc-tag tag-slate">Máx / Mín</span>
                <span class="rc-tag tag-green">% Aprobación</span>
            </div>
            <div class="rc-actions">
                <a href="{{ route('admin.reportes.descargar', ['tipo'=>'estadisticas_materia','formato'=>'pdf']) }}{{ request('conv') ? '&conv='.request('conv') : '' }}" class="btn-dl btn-pdf"><i class="ti ti-file-type-pdf"></i> PDF</a>
                <a href="{{ route('admin.reportes.descargar', ['tipo'=>'estadisticas_materia','formato'=>'excel']) }}{{ request('conv') ? '&conv='.request('conv') : '' }}" class="btn-dl btn-excel"><i class="ti ti-file-spreadsheet"></i> Excel</a>
                <a href="{{ route('admin.reportes.descargar', ['tipo'=>'estadisticas_materia','formato'=>'csv']) }}{{ request('conv') ? '&conv='.request('conv') : '' }}" class="btn-dl btn-csv"><i class="ti ti-file-type-csv"></i> CSV</a>
            </div>
        </div>

        <div class="report-card">
            <div class="rc-header">
                <div class="rc-icon si-green"><i class="ti ti-award"></i></div>
                <div class="rc-info">
                    <div class="rc-title">Ranking final de admisión</div>
                    <div class="rc-desc">Lista ordenada por promedio total con el estado de admisión y carrera asignada.</div>
                </div>
            </div>
            <div class="rc-tags">
                <span class="rc-tag tag-green">Ranking</span>
                <span class="rc-tag tag-slate">Promedio total</span>
                <span class="rc-tag tag-blue">Estado admisión</span>
            </div>
            <div class="rc-actions">
                <a href="{{ route('admin.reportes.descargar', ['tipo'=>'ranking','formato'=>'pdf']) }}{{ request('conv') ? '&conv='.request('conv') : '' }}" class="btn-dl btn-pdf"><i class="ti ti-file-type-pdf"></i> PDF</a>
                <a href="{{ route('admin.reportes.descargar', ['tipo'=>'ranking','formato'=>'excel']) }}{{ request('conv') ? '&conv='.request('conv') : '' }}" class="btn-dl btn-excel"><i class="ti ti-file-spreadsheet"></i> Excel</a>
                <a href="{{ route('admin.reportes.descargar', ['tipo'=>'ranking','formato'=>'csv']) }}{{ request('conv') ? '&conv='.request('conv') : '' }}" class="btn-dl btn-csv"><i class="ti ti-file-type-csv"></i> CSV</a>
            </div>
        </div>

    </div>

    {{-- REPORTES: GRUPOS Y DOCENTES --}}
    <div class="section-title"><i class="ti ti-layout-grid"></i> Grupos y docentes</div>
    <div class="report-grid">

        <div class="report-card">
            <div class="rc-header">
                <div class="rc-icon si-teal" style="background:#ccfbf1;"><i class="ti ti-layout-grid" style="color:#0d9488;"></i></div>
                <div class="rc-info">
                    <div class="rc-title">Grupos habilitados</div>
                    <div class="rc-desc">Listado de grupos activos con turno, capacidad, inscritos y cupos disponibles.</div>
                </div>
            </div>
            <div class="rc-tags">
                <span class="rc-tag tag-blue">Turno</span>
                <span class="rc-tag tag-slate">Capacidad</span>
                <span class="rc-tag tag-green">Cupos libres</span>
            </div>
            <div class="rc-actions">
                <a href="{{ route('admin.reportes.descargar', ['tipo'=>'grupos','formato'=>'pdf']) }}{{ request('conv') ? '&conv='.request('conv') : '' }}" class="btn-dl btn-pdf"><i class="ti ti-file-type-pdf"></i> PDF</a>
                <a href="{{ route('admin.reportes.descargar', ['tipo'=>'grupos','formato'=>'excel']) }}{{ request('conv') ? '&conv='.request('conv') : '' }}" class="btn-dl btn-excel"><i class="ti ti-file-spreadsheet"></i> Excel</a>
                <a href="{{ route('admin.reportes.descargar', ['tipo'=>'grupos','formato'=>'csv']) }}{{ request('conv') ? '&conv='.request('conv') : '' }}" class="btn-dl btn-csv"><i class="ti ti-file-type-csv"></i> CSV</a>
            </div>
        </div>

        <div class="report-card">
            <div class="rc-header">
                <div class="rc-icon si-purple"><i class="ti ti-chalkboard"></i></div>
                <div class="rc-info">
                    <div class="rc-title">Docentes por grupo</div>
                    <div class="rc-desc">Asignación de docentes por grupo, materia, día y hora de clases.</div>
                </div>
            </div>
            <div class="rc-tags">
                <span class="rc-tag tag-purple">Docente</span>
                <span class="rc-tag tag-slate">Materia</span>
                <span class="rc-tag tag-slate">Horario</span>
                <span class="rc-tag tag-slate">Aula</span>
            </div>
            <div class="rc-actions">
                <a href="{{ route('admin.reportes.descargar', ['tipo'=>'docentes_grupo','formato'=>'pdf']) }}{{ request('conv') ? '&conv='.request('conv') : '' }}" class="btn-dl btn-pdf"><i class="ti ti-file-type-pdf"></i> PDF</a>
                <a href="{{ route('admin.reportes.descargar', ['tipo'=>'docentes_grupo','formato'=>'excel']) }}{{ request('conv') ? '&conv='.request('conv') : '' }}" class="btn-dl btn-excel"><i class="ti ti-file-spreadsheet"></i> Excel</a>
                <a href="{{ route('admin.reportes.descargar', ['tipo'=>'docentes_grupo','formato'=>'csv']) }}{{ request('conv') ? '&conv='.request('conv') : '' }}" class="btn-dl btn-csv"><i class="ti ti-file-type-csv"></i> CSV</a>
            </div>
        </div>

        <div class="report-card">
            <div class="rc-header">
                <div class="rc-icon si-amber"><i class="ti ti-star"></i></div>
                <div class="rc-info">
                    <div class="rc-title">Grupo con más aprobados</div>
                    <div class="rc-desc">Ranking de grupos ordenado por porcentaje de aprobación.</div>
                </div>
            </div>
            <div class="rc-tags">
                <span class="rc-tag tag-amber">% Aprobación</span>
                <span class="rc-tag tag-slate">Total / Aprobados</span>
            </div>
            <div class="rc-actions">
                <a href="{{ route('admin.reportes.descargar', ['tipo'=>'grupo_top','formato'=>'pdf']) }}{{ request('conv') ? '&conv='.request('conv') : '' }}" class="btn-dl btn-pdf"><i class="ti ti-file-type-pdf"></i> PDF</a>
                <a href="{{ route('admin.reportes.descargar', ['tipo'=>'grupo_top','formato'=>'excel']) }}{{ request('conv') ? '&conv='.request('conv') : '' }}" class="btn-dl btn-excel"><i class="ti ti-file-spreadsheet"></i> Excel</a>
                <a href="{{ route('admin.reportes.descargar', ['tipo'=>'grupo_top','formato'=>'csv']) }}{{ request('conv') ? '&conv='.request('conv') : '' }}" class="btn-dl btn-csv"><i class="ti ti-file-type-csv"></i> CSV</a>
            </div>
        </div>

    </div>

    {{-- LOG DE ACTIVIDAD --}}
    <div class="card">
        <div class="card-header">
            <div class="card-header-title"><i class="ti ti-activity"></i> Registro de actividad reciente</div>
            <form method="GET" action="{{ route('admin.reportes.index') }}" class="filter-bar">
                <input type="hidden" name="conv" value="{{ request('conv') }}">
                <select name="modulo">
                    <option value="">Todos los módulos</option>
                    <option value="postulantes"  {{ request('modulo')=='postulantes'  ? 'selected':'' }}>Postulantes</option>
                    <option value="docentes"     {{ request('modulo')=='docentes'     ? 'selected':'' }}>Docentes</option>
                    <option value="examenes"     {{ request('modulo')=='examenes'     ? 'selected':'' }}>Exámenes</option>
                    <option value="grupos"       {{ request('modulo')=='grupos'       ? 'selected':'' }}>Grupos</option>
                    <option value="convocatoria" {{ request('modulo')=='convocatoria' ? 'selected':'' }}>Convocatoria</option>
                </select>
                <select name="resultado">
                    <option value="">Todos</option>
                    <option value="ok"         {{ request('resultado')=='ok'         ? 'selected':'' }}>OK</option>
                    <option value="error"      {{ request('resultado')=='error'      ? 'selected':'' }}>Error</option>
                    <option value="advertencia"{{ request('resultado')=='advertencia'? 'selected':'' }}>Advertencia</option>
                </select>
                <button type="submit" class="btn-filter"><i class="ti ti-filter"></i> Filtrar</button>
                <a href="{{ route('admin.reportes.descargar', ['tipo'=>'log_actividad','formato'=>'excel']) }}" class="btn-dl btn-excel" style="padding:7px 12px;font-size:12px;border-radius:8px;"><i class="ti ti-file-spreadsheet"></i> Exportar log</a>
            </form>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Fecha / Hora</th>
                    <th>Usuario</th>
                    <th>Rol</th>
                    <th>Acción</th>
                    <th>Módulo</th>
                    <th>Descripción</th>
                    <th>IP</th>
                    <th>Resultado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td style="white-space:nowrap;color:#475569;font-size:12px;">
                        {{ \Carbon\Carbon::parse($log->fecha_hora)->format('d/m/Y') }}<br>
                        <span style="color:#94a3b8;">{{ \Carbon\Carbon::parse($log->fecha_hora)->format('H:i:s') }}</span>
                    </td>
                    <td>
                        <div style="font-weight:500;font-size:13px;color:#1e293b;">{{ $log->usuario_nombre ?? '—' }}</div>
                        <div style="font-size:11px;color:#94a3b8;">{{ $log->usuario_email ?? '' }}</div>
                    </td>
                    <td style="font-size:12px;color:#475569;">{{ $log->rol ?? '—' }}</td>
                    <td><code style="font-size:11px;background:#f1f5f9;padding:2px 6px;border-radius:4px;color:#374151;">{{ $log->accion }}</code></td>
                    <td style="font-size:12px;color:#475569;">{{ $log->modulo ?? '—' }}</td>
                    <td style="font-size:12px;color:#374151;max-width:260px;">{{ Str::limit($log->descripcion, 70) }}</td>
                    <td style="font-size:11px;color:#94a3b8;white-space:nowrap;">{{ $log->ip ?? '—' }}</td>
                    <td>
                        @if($log->resultado === 'ok')
                            <span class="badge b-ok">OK</span>
                        @elseif($log->resultado === 'error')
                            <span class="badge b-err">Error</span>
                        @else
                            <span class="badge b-warn">Advertencia</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">
                        <div class="empty-state">
                            <i class="ti ti-activity-heartbeat"></i>
                            <p style="font-size:14px;font-weight:500;color:#64748b;">No hay actividad registrada aún</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($logs->hasPages())
        <div style="padding:12px 16px;border-top:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;font-size:12px;color:#64748b;">
            <span>Mostrando {{ $logs->firstItem() }} a {{ $logs->lastItem() }} de {{ $logs->total() }} registros</span>
            <div style="display:flex;gap:4px;">
                @if(!$logs->onFirstPage())
                    <a href="{{ $logs->previousPageUrl() }}" style="width:28px;height:28px;border-radius:6px;border:1px solid #e2e8f0;background:#fff;display:flex;align-items:center;justify-content:center;text-decoration:none;color:#64748b;"><i class="ti ti-chevron-left" style="font-size:13px;"></i></a>
                @endif
                @if($logs->hasMorePages())
                    <a href="{{ $logs->nextPageUrl() }}" style="width:28px;height:28px;border-radius:6px;border:1px solid #e2e8f0;background:#fff;display:flex;align-items:center;justify-content:center;text-decoration:none;color:#64748b;"><i class="ti ti-chevron-right" style="font-size:13px;"></i></a>
                @endif
            </div>
        </div>
        @endif
    </div>

</div>
</main>

<script>
function aplicarConvocatoria() {
    const val = document.getElementById('convSelect').value;
    const url = new URL(window.location.href);
    if (val) url.searchParams.set('conv', val);
    else url.searchParams.delete('conv');
    window.location.href = url.toString();
}
</script>

</body>
</html>