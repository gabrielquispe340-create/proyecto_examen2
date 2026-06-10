<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">
    <title>CUP — Mi Horario</title>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Figtree', sans-serif; background: #f1f5f9; color: #1e293b; display: flex; min-height: 100vh; }

        /* ── SIDEBAR ── */
        .sidebar { width: 240px; background: linear-gradient(180deg,#1e3a6e 0%,#0f2147 100%); position: fixed; top: 0; bottom: 0; left: 0; z-index: 100; display: flex; flex-direction: column; }
        .sidebar-brand { padding: 22px 20px; font-size: 16px; font-weight: 700; color: #fff; display: flex; align-items: center; gap: 10px; border-bottom: 1px solid rgba(255,255,255,0.08); }
        .sidebar-brand i { font-size: 22px; color: #7dd3fc; }
        .sidebar-user { margin: 16px 12px; padding: 14px; background: rgba(255,255,255,0.07); border-radius: 12px; border: 1px solid rgba(255,255,255,0.1); }
        .s-avatar { width: 36px; height: 36px; border-radius: 50%; background: #2563eb; color: #fff; font-weight: 700; font-size: 13px; display: flex; align-items: center; justify-content: center; margin-bottom: 10px; }
        .s-name { font-size: 13px; font-weight: 600; color: #fff; }
        .s-code { font-size: 11px; color: #7dd3fc; margin-top: 2px; }
        .nav-label { font-size: 10px; font-weight: 700; color: rgba(255,255,255,0.35); text-transform: uppercase; letter-spacing: .1em; padding: 14px 20px 6px; }
        .nav-item { display: flex; align-items: center; gap: 10px; padding: 10px 16px; margin: 1px 10px; border-radius: 9px; color: rgba(255,255,255,0.7); text-decoration: none; font-size: 13px; font-weight: 500; transition: all .15s; }
        .nav-item i { font-size: 17px; }
        .nav-item:hover { background: rgba(255,255,255,0.08); color: #fff; }
        .nav-item.active { background: #2563eb; color: #fff; box-shadow: 0 4px 12px rgba(37,99,235,0.3); }
        .sidebar-footer { margin-top: auto; padding: 16px 20px; border-top: 1px solid rgba(255,255,255,0.08); }
        .btn-logout-side { width: 100%; padding: 9px; border-radius: 9px; background: rgba(239,68,68,0.12); border: 1px solid rgba(239,68,68,0.25); color: #fca5a5; font-size: 12px; font-weight: 600; cursor: pointer; font-family: 'Figtree', sans-serif; display: flex; align-items: center; justify-content: center; gap: 6px; transition: all .2s; }
        .btn-logout-side:hover { background: rgba(239,68,68,0.22); color: #fff; }

        /* ── MAIN ── */
        .main { margin-left: 240px; flex: 1; display: flex; flex-direction: column; }
        .topbar { height: 60px; background: #fff; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; padding: 0 32px; position: sticky; top: 0; z-index: 50; }
        .topbar h1 { font-size: 17px; font-weight: 700; }
        .topbar p  { font-size: 12px; color: #64748b; margin-top: 1px; }

        /* ── CONTENT ── */
        .content { padding: 28px 32px; }

        /* ── SIN GRUPO ── */
        .sin-grupo { background: #fff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 60px; text-align: center; color: #94a3b8; }
        .sin-grupo i { font-size: 48px; display: block; margin-bottom: 16px; }
        .sin-grupo h2 { font-size: 18px; color: #475569; margin-bottom: 8px; }
        .sin-grupo p  { font-size: 14px; }

        /* ── GRUPO INFO ── */
        .grupo-header { background: linear-gradient(135deg,#1e3a6e,#2563eb); border-radius: 14px; padding: 22px 28px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; }
        .gh-left { display: flex; align-items: center; gap: 16px; }
        .gh-icon { width: 52px; height: 52px; background: rgba(255,255,255,0.15); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 26px; color: #fff; }
        .gh-txt h2 { color: #fff; font-size: 20px; font-weight: 700; }
        .gh-txt p  { color: rgba(255,255,255,0.75); font-size: 13px; margin-top: 4px; }
        .gh-badge { background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3); color: #fff; padding: 6px 18px; border-radius: 99px; font-size: 12px; font-weight: 600; }

        /* ── COLORES MATERIA ── */
        @php
        $colores = [
            'MAT' => ['bg'=>'#eff4ff','color'=>'#1e40af','icon'=>'ti-math-function'],
            'FIS' => ['bg'=>'#f5f3ff','color'=>'#5b21b6','icon'=>'ti-atom'],
            'COM' => ['bg'=>'#ecfeff','color'=>'#0e7490','icon'=>'ti-device-desktop'],
            'ING' => ['bg'=>'#f0fdf4','color'=>'#065f46','icon'=>'ti-language'],
        ];
        $diasOrden = ['LUNES','MARTES','MIERCOLES','JUEVES','VIERNES','SABADO'];
        $diasLabel = ['LUNES'=>'Lunes','MARTES'=>'Martes','MIERCOLES'=>'Miércoles','JUEVES'=>'Jueves','VIERNES'=>'Viernes','SABADO'=>'Sábado'];
        @endphp

        /* ── DÍA BLOCK ── */
        .dia-block { margin-bottom: 20px; }
        .dia-label { font-size: 12px; font-weight: 700; color: #1e3a6e; text-transform: uppercase; letter-spacing: .08em; padding: 8px 0; border-bottom: 2px solid #1e3a6e; margin-bottom: 12px; display: flex; align-items: center; gap: 8px; }
        .dia-label i { font-size: 16px; }

        .clases-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px,1fr)); gap: 12px; }

        /* ── CLASE CARD ── */
        .clase-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px; display: flex; flex-direction: column; gap: 10px; transition: transform .2s, box-shadow .2s; }
        .clase-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,0.06); }
        .clase-top { display: flex; align-items: center; gap: 10px; }
        .clase-icon { width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
        .clase-materia { font-size: 14px; font-weight: 600; color: #1e293b; }
        .clase-divider { border: none; border-top: 1px solid #f1f5f9; }
        .clase-info { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
        .ci-item { display: flex; flex-direction: column; gap: 2px; }
        .ci-label { font-size: 10px; color: #94a3b8; font-weight: 500; text-transform: uppercase; letter-spacing: .05em; }
        .ci-val   { font-size: 12px; color: #374151; font-weight: 500; display: flex; align-items: center; gap: 4px; }
        .ci-val i { font-size: 13px; color: #64748b; }
        .hora-badge { display: inline-flex; align-items: center; gap: 5px; background: #eff4ff; color: #1e40af; padding: 5px 12px; border-radius: 8px; font-size: 12px; font-weight: 600; }
        .hora-badge i { font-size: 14px; }
    
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

{{-- SIDEBAR --}}
<aside class="sidebar">
    <div class="sidebar-brand"><i class="ti ti-school"></i> CUP — FICCT</div>
    <div class="sidebar-user">
        <div class="s-avatar">{{ strtoupper(substr($postulante->nombre,0,1)) }}{{ strtoupper(substr($postulante->apellido,0,1)) }}</div>
        <div class="s-name">{{ $postulante->nombre }} {{ $postulante->apellido }}</div>
        <div class="s-code">{{ $postulante->codigo_estudiante }}</div>
    </div>
    <div class="nav-label">Mi cuenta</div>
    <a href="{{ route('postulante.dashboard') }}" class="nav-item"><i class="ti ti-smart-home"></i> Inicio</a>
    <a href="{{ route('postulante.notas') }}"     class="nav-item"><i class="ti ti-file-analytics"></i> Mis Notas</a>
    <a href="{{ route('postulante.grupo') }}"     class="nav-item"><i class="ti ti-users-group"></i> Mi Grupo</a>
    <a href="{{ route('postulante.horario') }}"   class="nav-item active"><i class="ti ti-calendar"></i> Mi Horario</a>
    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout-side"><i class="ti ti-logout"></i> Cerrar Sesión</button>
        </form>
    </div>
</aside>

{{-- MAIN --}}
<div class="main">
    <header class="topbar">
        <div style="display:flex;align-items:center;gap:12px">
            <button type="button" class="btn-menu-mobile" onclick="document.querySelector('.sidebar').classList.toggle('open'); document.getElementById('sidebar-overlay-mobile').classList.toggle('show');" style="color:#0f172a; padding:4px;">&#9776;</button>
            <div>
                <h1>Mi Horario de Clases</h1>
                <p class="hide-mobile" style="font-size:13px; color:#64748b; margin-top:2px;">Clases del curso preuniversitario — {{ $grupo?->codigo_grupo ?? 'Sin grupo asignado' }}</p>
            </div>
        </div>
        
        <div class="topbar-right" style="display:flex; align-items:center;">
            <div class="dropdown-container" style="position:relative;">
                <button onclick="let d=document.getElementById('postulante-dropdown'); d.style.display = d.style.display==='none' ? 'block' : 'none';" style="background:none;border:none;cursor:pointer;padding:8px;color:#64748b;display:flex;align-items:center;justify-content:center;">
                    <i class="ti ti-dots-vertical" style="font-size:22px;"></i>
                </button>
                <div id="postulante-dropdown" class="dropdown-menu" style="display:none; position:absolute; right:0; top:100%; background:#fff; border:1px solid #e2e8f0; border-radius:12px; box-shadow:0 10px 25px rgba(0,0,0,0.1); width:200px; z-index:1000; overflow:hidden;">
                    <div style="padding:12px 16px; border-bottom:1px solid #e2e8f0; background:#f8fafc;">
                        <div style="font-size:13px; font-weight:600; color:#0f172a;">{{ $postulante->nombre }} {{ $postulante->apellido }}</div>
                        <div style="font-size:11px; color:#64748b; margin-top:2px;">Reg: {{ $postulante->codigo_estudiante }}</div>
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

    <div class="content">
        @if(!$grupo)
            <div class="sin-grupo">
                <i class="ti ti-calendar-off"></i>
                <h2>Sin grupo asignado</h2>
                <p>Aún no tienes un grupo asignado. El administrador lo asignará pronto.<br>Vuelve a revisar más tarde.</p>
            </div>

        @elseif($horarios->isEmpty())
            <div class="sin-grupo">
                <i class="ti ti-calendar-x"></i>
                <h2>Horario no disponible</h2>
                <p>Tu grupo <strong>{{ $grupo->codigo_grupo }}</strong> aún no tiene horario cargado.<br>El administrador lo configurará próximamente.</p>
            </div>

        @else
            {{-- INFO DEL GRUPO --}}
            <div class="grupo-header">
                <div class="gh-left">
                    <div class="gh-icon"><i class="ti ti-users-group"></i></div>
                    <div class="gh-txt">
                        <h2>Grupo {{ $grupo->codigo_grupo }}</h2>
                        <p>Turno {{ $grupo->turno }} &mdash; Curso preuniversitario FICCT</p>
                    </div>
                </div>
                <div class="gh-badge">
                    <i class="ti ti-clock" style="vertical-align:-2px"></i>
                    {{ $horarios->flatten()->count() }} clases por semana
                </div>
            </div>

            {{-- HORARIO POR DÍA --}}
            @foreach($diasOrden as $dia)
                @if(isset($horarios[$dia]))
                <div class="dia-block">
                    <div class="dia-label">
                        <i class="ti ti-calendar-event"></i>
                        {{ $diasLabel[$dia] }}
                        <span style="font-size:11px;font-weight:400;color:#64748b;text-transform:none;letter-spacing:0">
                            &mdash; {{ $horarios[$dia]->count() }} {{ $horarios[$dia]->count() == 1 ? 'clase' : 'clases' }}
                        </span>
                    </div>
                    <div class="clases-grid">
                        @foreach($horarios[$dia] as $h)
                        @php
                            $codigo = $h->materia_codigo;
                            $cfg = $colores[$codigo] ?? ['bg'=>'#f1f5f9','color'=>'#475569','icon'=>'ti-book'];
                            $hi = \Carbon\Carbon::parse($h->hora_inicio)->format('H:i');
                            $hf = \Carbon\Carbon::parse($h->hora_fin)->format('H:i');
                        @endphp
                        <div class="clase-card">
                            <div class="clase-top">
                                <div class="clase-icon" style="background:{{ $cfg['bg'] }};color:{{ $cfg['color'] }}">
                                    <i class="ti {{ $cfg['icon'] }}"></i>
                                </div>
                                <div class="clase-materia">{{ $h->materia }}</div>
                            </div>
                            <hr class="clase-divider">
                            <div class="hora-badge">
                                <i class="ti ti-clock"></i>
                                {{ $hi }} — {{ $hf }}
                            </div>
                            <div class="clase-info">
                                <div class="ci-item">
                                    <div class="ci-label">Aula</div>
                                    <div class="ci-val"><i class="ti ti-door"></i> {{ $h->aula ?? 'Por asignar' }}</div>
                                </div>
                                <div class="ci-item">
                                    <div class="ci-label">Docente</div>
                                    <div class="ci-val"><i class="ti ti-user"></i> {{ $h->docente }}</div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            @endforeach
        @endif
    </div>
</div>

<script>
    window.addEventListener('pageshow', function(e) {
        if (e.persisted) window.location.reload();
    });
</script>
</body>
</html>