<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proceso de Admisión — CUP FICCT</title>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">
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
            --text-primary: #93c5fd;
        }

        .light-theme {
            --bg: #f1f5f9;
            --surface: #ffffff;
            --surface2: #f8fafc;
            --border: #e2e8f0;
            --text: #1e293b;
            --muted: #94a3b8;
            --table-hover: #fafafa;
            --text-primary: #1e3a6e;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Figtree', sans-serif; background: var(--bg); color: var(--text); }

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
        .page-sub { font-size: 13px; color: var(--muted); margin-top: 3px; }

        .alert { padding: 12px 16px; border-radius: 10px; margin-bottom: 16px; font-size: 13px; display: flex; align-items: center; gap: 8px; }
        .alert-ok  { background: rgba(16,185,129,0.15); color: #6ee7b7; border: 1px solid rgba(16,185,129,0.3); }
        .alert-err { background: rgba(244,63,94,0.15); color: #fda4af; border: 1px solid rgba(244,63,94,0.3); }
        
        .light-theme .alert-ok  { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }
        .light-theme .alert-err { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }

        /* Cuadrícula de métricas */
        .grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 24px; }
        .metric { background: var(--surface); border-radius: 12px; padding: 18px 20px; border: 1px solid var(--border); }
        .metric-label { font-size: 12px; color: var(--muted); margin-bottom: 8px; display: flex; align-items: center; gap: 6px; }
        .metric-value { font-size: 26px; font-weight: 600; color: var(--text); }
        .metric-sub { font-size: 11px; color: var(--muted); margin-top: 4px; }
        
        .metric.blue .metric-value { color: #93c5fd; }
        .metric.teal .metric-value { color: #6ee7b7; }
        .metric.amber .metric-value { color: #fcd34d; }
        .metric.rose .metric-value { color: #fda4af; }

        .light-theme .metric.blue .metric-value { color: #1e3a6e; }
        .light-theme .metric.teal .metric-value { color: #059669; }
        .light-theme .metric.amber .metric-value { color: #d97706; }
        .light-theme .metric.rose .metric-value { color: #dc2626; }

        /* Ejecutar Proceso */
        .action-card { background: linear-gradient(135deg, #1e3a6e 0%, #0f2147 100%); border-radius: 12px; padding: 24px; color: #fff; margin-bottom: 24px; border: none; }
        .action-card h3 { font-size: 16px; font-weight: 600; margin-bottom: 8px; display: flex; align-items: center; gap: 8px; }
        .action-card p { font-size: 13px; color: #93c5fd; margin-bottom: 18px; line-height: 1.5; }
        .btn-action { padding: 10px 20px; background: #fbbf24; color: #000; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; font-family: 'Figtree', sans-serif; display: inline-flex; align-items: center; gap: 6px; transition: background .15s; }
        .btn-action:hover { background: #f59e0b; }

        /* Tabla de resultados */
        .card { background: var(--surface); border-radius: 12px; border: 1px solid var(--border); overflow: hidden; margin-bottom: 24px; }
        .card-header { padding: 16px 20px; border-bottom: 1px solid var(--border); font-weight: 600; font-size: 14px; color: var(--text); display: flex; justify-content: space-between; align-items: center; }
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th { text-align: left; padding: 12px 14px; font-size: 10px; font-weight: 600; color: var(--muted); background: var(--surface2); border-bottom: 1px solid var(--border); text-transform: uppercase; letter-spacing: .04em; }
        td { padding: 12px 14px; border-bottom: 1px solid var(--border); color: var(--text); vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: var(--table-hover); }
        
        .badge { display: inline-flex; align-items: center; padding: 2px 8px; border-radius: 99px; font-size: 10px; font-weight: 500; }
        
        .badge-admitido { background: rgba(16,185,129,0.15); color: #6ee7b7; border: 1px solid rgba(16,185,129,0.3); }
        .badge-sincupo  { background: rgba(245,158,11,0.15); color: #fcd34d; border: 1px solid rgba(245,158,11,0.3); }
        .badge-reprobado { background: rgba(244,63,94,0.15); color: #fda4af; border: 1px solid rgba(244,63,94,0.3); }

        .light-theme .badge-admitido { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .light-theme .badge-sincupo  { background: #fef3c7; color: #92400e; border: 1px solid #fcd34d; }
        .light-theme .badge-reprobado { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }

        .rank-badge { width: 24px; height: 24px; border-radius: 50%; background: var(--surface2); display: inline-flex; align-items: center; justify-content: center; font-weight: 700; font-size: 11px; color: var(--text); }
        tr:nth-child(1) .rank-badge { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
        tr:nth-child(2) .rank-badge { background: var(--surface2); color: var(--text); border: 1px solid var(--border); }
        tr:nth-child(3) .rank-badge { background: #ffedd5; color: #c2410c; border: 1px solid #fed7aa; }

        .empty { text-align: center; padding: 48px; color: var(--muted); }
    </style>
</head>
<body>

<div class="topbar">
    <a href="{{ route('admin.dashboard') }}" class="topbar-brand">
        <i class="ti ti-school" style="font-size:20px"></i> CUP — FICCT
    </a>
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
            <button type="submit" class="btn-logout"><i class="ti ti-logout"></i> Salir</button>
        </form>
    </div>
</div>

@include('admin.partials.sidebar')

<main class="main">
<div class="page">

    <div class="page-header">
        <div>
            <div class="page-title">Proceso de Admisión y Rankings</div>
            <div class="page-sub">Calcula resultados finales y asigna carreras según el rendimiento y los cupos disponibles</div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-ok"><i class="ti ti-circle-check"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-err"><i class="ti ti-alert-circle"></i> {{ session('error') }}</div>
    @endif

    @if(!$activeConv)
        <div class="alert alert-err"><i class="ti ti-alert-triangle"></i> No existe una convocatoria activa. Activa una primero en la sección de Convocatorias.</div>
    @else

        {{-- MÉTRICAS RÁPIDAS --}}
        @if(!$resultados->isEmpty())
        <div class="grid-4">
            <div class="metric blue">
                <div class="metric-label"><i class="ti ti-users"></i> Total Postulantes</div>
                <div class="metric-value">{{ $stats['total_postulantes'] }}</div>
                <div class="metric-sub">Inscritos en la convocatoria</div>
            </div>
            <div class="metric teal">
                <div class="metric-label"><i class="ti ti-circle-check"></i> Admitidos</div>
                <div class="metric-value">{{ $stats['admitidos'] }}</div>
                <div class="metric-sub">Ingresaron a una carrera</div>
            </div>
            <div class="metric amber">
                <div class="metric-label"><i class="ti ti-clock"></i> Aprobados sin Cupo</div>
                <div class="metric-value">{{ $stats['aprobados_sin_cupo'] }}</div>
                <div class="metric-sub">Nota >= 60, sin cupo</div>
            </div>
            <div class="metric rose">
                <div class="metric-label"><i class="ti ti-circle-x"></i> Reprobados</div>
                <div class="metric-value">{{ $stats['reprobados'] }}</div>
                <div class="metric-sub">Nota final < 60</div>
            </div>
        </div>
        @endif

        {{-- EJECUTAR PROCESO DE ADMISIÓN --}}
        <div class="action-card">
            <h3><i class="ti ti-settings"></i> Procesar Calificaciones y Ejecutar Admisión</h3>
            <p>Al hacer clic en el botón de abajo, el sistema realizará automáticamente los siguientes cálculos para la convocatoria <strong>{{ $activeConv->nombre }}</strong>:
                <br>1. Promediará las notas ponderadas de las 4 materias (Matemáticas, Física, Computación e Inglés) por postulante (aprobación >= 60).
                <br>2. Ordenará y rankeará a todos los estudiantes según su promedio total de forma descendente.
                <br>3. Asignará la carrera admitida respetando el cupo máximo por carrera (75 cupos) y las preferencias (1ª y 2ª opción) de cada estudiante de manera estrictamente meritocrática.
            </p>
            <form method="POST" action="{{ route('admin.resultados.calcular') }}" onsubmit="return confirm('¿Estás seguro de que deseas ejecutar la admisión? Esto recalculará y actualizará el ranking y asignación de carreras de todos los postulantes.')">
                @csrf
                <button type="submit" class="btn-action">
                    <i class="ti ti-cpu"></i> Ejecutar Proceso de Admisión
                </button>
            </form>
        </div>

        {{-- CU19: RANKING DE ADMITIDOS --}}
        <div class="card">
            <div class="card-header">
                <h3>Ranking General de Resultados</h3>
                <span class="badge badge-purple"><i class="ti ti-list-numbers"></i> Convocatoria: {{ $activeConv->nombre }}</span>
            </div>

            @if($resultados->isEmpty())
                <div class="empty">
                    <i class="ti ti-list" style="font-size:36px;display:block;margin-bottom:10px;color:#94a3b8"></i>
                    Aún no se ha ejecutado el proceso de admisión para esta convocatoria.
                </div>
            @else
                <div style="overflow-x: auto">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 60px; text-align: center">Rank</th>
                                <th style="width: 130px">Código</th>
                                <th>Postulante</th>
                                <th style="width: 70px; text-align: center">MAT</th>
                                <th style="width: 70px; text-align: center">FIS</th>
                                <th style="width: 70px; text-align: center">COM</th>
                                <th style="width: 70px; text-align: center">ING</th>
                                <th style="width: 90px; text-align: center">Final</th>
                                <th>Carrera Asignada</th>
                                <th style="width: 140px; text-align: center">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($resultados as $res)
                            <tr>
                                <td style="text-align: center">
                                    <div class="rank-badge">{{ $res->ranking }}</div>
                                </td>
                                <td style="font-weight:600;color:var(--text-primary)">{{ $res->codigo_estudiante }}</td>
                                <td>
                                    <div style="font-weight:600;font-size:13px">{{ $res->postulante_nombre }} {{ $res->postulante_apellido }}</div>
                                </td>
                                <td style="text-align: center;color:#64748b">{{ number_format($res->promedio_mat, 1) }}</td>
                                <td style="text-align: center;color:#64748b">{{ number_format($res->promedio_fis, 1) }}</td>
                                <td style="text-align: center;color:#64748b">{{ number_format($res->promedio_com, 1) }}</td>
                                <td style="text-align: center;color:#64748b">{{ number_format($res->promedio_ing, 1) }}</td>
                                <td style="text-align: center;font-weight:700;color:var(--text-primary);font-size:13px">{{ number_format($res->promedio_total, 1) }}</td>
                                <td style="font-weight:500;color:var(--text)">
                                    {{ $res->carrera_nombre ?? '—' }}
                                </td>
                                <td style="text-align: center">
                                    <span class="badge {{ $res->estado_admision === 'ADMITIDO' ? 'badge-admitido' : ($res->estado_admision === 'APROBADO_SIN_CUPO' ? 'badge-sincupo' : 'badge-reprobado') }}">
                                        {{ str_replace('_', ' ', $res->estado_admision) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    @endif

</div>
</main>

<script>
    // Fuerza recarga si el navegador restaura la página desde bfcache
    window.addEventListener('pageshow', function(event) {
        if (event.persisted) {
            window.location.reload();
        }
    });

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
</script>
</body>
</html>
