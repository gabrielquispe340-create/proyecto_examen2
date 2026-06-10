<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CUP — Mi Grupo de Admisión</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Figtree', sans-serif; background: #f8fafc; color: #1e293b; min-height: 100vh; display: flex; }

        /* ── SIDEBAR ── */
        .sidebar {
            width: 260px; background: linear-gradient(180deg, #1e3a6e 0%, #0f2147 100%); color: #fff;
            display: flex; flex-direction: column; position: fixed; top: 0; bottom: 0; left: 0; z-index: 100;
        }
        .sidebar-brand {
            padding: 24px; font-size: 20px; font-weight: 700; display: flex; align-items: center; gap: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .sidebar-menu {
            flex: 1; padding: 24px 16px; display: flex; flex-direction: column; gap: 6px;
        }
        .menu-label {
            font-size: 11px; font-weight: 600; text-transform: uppercase;
            color: rgba(255, 255, 255, 0.4); padding: 10px 12px 6px; letter-spacing: 0.05em;
        }
        .menu-item {
            display: flex; align-items: center; gap: 12px; padding: 12px;
            color: rgba(255, 255, 255, 0.75); text-decoration: none; font-size: 14px; font-weight: 500; border-radius: 10px; transition: all 0.2s;
        }
        .menu-item:hover { background: rgba(255, 255, 255, 0.08); color: #fff; }
        .menu-item.active { background: #2563eb; color: #fff; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2); }
        .sidebar-footer { padding: 20px; border-top: 1px solid rgba(255, 255, 255, 0.1); font-size: 12px; color: rgba(255, 255, 255, 0.4); text-align: center; }

        /* ── MAIN CONTENT ── */
        .main-content { margin-left: 260px; flex: 1; display: flex; flex-direction: column; min-height: 100vh; }
        .topbar {
            height: 70px; background: #fff; border-bottom: 1px solid #e2e8f0;
            display: flex; align-items: center; justify-content: space-between; padding: 0 40px;
        }
        .welcome-msg h1 { font-size: 20px; font-weight: 700; color: #0f172a; }
        .welcome-msg p { font-size: 13px; color: #64748b; margin-top: 2px; }
        .user-profile { display: flex; align-items: center; gap: 12px; }
        .avatar {
            width: 40px; height: 40px; border-radius: 50%; background: #dbeafe; color: #2563eb;
            display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px;
        }
        .user-info .name { font-size: 14px; font-weight: 600; color: #0f172a; }
        .user-info .code { font-size: 11px; color: #64748b; }

        .btn-logout {
            background: none; border: 1px solid #e2e8f0; padding: 8px 16px; border-radius: 8px;
            font-size: 13px; font-weight: 500; color: #64748b; cursor: pointer; display: flex; align-items: center; gap: 6px;
            transition: all 0.2s; font-family: 'Figtree', sans-serif;
        }
        .btn-logout:hover { background: #fee2e2; border-color: #fca5a5; color: #ef4444; }

        .content-wrapper { padding: 40px; max-width: 1200px; width: 100%; margin: 0 auto; flex: 1; }

        /* ── HERO BANNER ── */
        .group-hero {
            background: linear-gradient(135deg, #1e3a6e 0%, #162b4e 100%);
            border-radius: 16px;
            padding: 32px;
            color: #fff;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .hero-title h2 { font-size: 24px; font-weight: 700; }
        .hero-title p { font-size: 14px; color: #a8c8f0; margin-top: 6px; }
        
        .turno-badge {
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.25);
            color: #fff;
            padding: 6px 16px;
            border-radius: 99px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        /* ── GRID ── */
        .grid-layout {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 24px;
        }

        .card {
            background: #fff; border: 1px solid #e2e8f0; border-radius: 16px;
            padding: 24px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.01);
        }
        .card-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; border-bottom: 1px solid #f1f5f9; padding-bottom: 14px; }
        .card-title {
            font-size: 16px; font-weight: 700; color: #0f172a;
            display: flex; align-items: center; gap: 8px;
        }
        .card-title i { color: #2563eb; font-size: 18px; }

        /* ── LIST ITEMS ── */
        .list-items { display: flex; flex-direction: column; gap: 14px; }
        .list-item {
            display: flex;
            align-items: center;
            gap: 16px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 16px;
        }
        .item-icon {
            width: 44px; height: 44px; border-radius: 10px;
            background: #eff6ff; color: #2563eb;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
        }
        .list-item.docente .item-icon { background: #ecfdf5; color: #10b981; }
        .item-details h4 { font-size: 14px; font-weight: 600; color: #1e293b; }
        .item-details p { font-size: 12px; color: #64748b; margin-top: 2px; }

        @media (max-width: 768px) {
            .grid-layout { grid-template-columns: 1fr; }
        }

        .sidebar-user { margin: 14px 12px; padding: 14px; background: rgba(255,255,255,0.07); border-radius: 12px; border: 1px solid rgba(255,255,255,0.1); }
        .s-avatar { width: 36px; height: 36px; border-radius: 50%; background: #2563eb; color: #fff; font-weight: 700; font-size: 13px; display: flex; align-items: center; justify-content: center; margin-bottom: 10px; }
        .s-name   { font-size: 13px; font-weight: 600; color: #fff; }
        .s-code   { font-size: 11px; color: #7dd3fc; margin-top: 2px; }
        .btn-logout-side { width: 100%; padding: 9px; border-radius: 9px; background: rgba(239,68,68,0.12); border: 1px solid rgba(239,68,68,0.25); color: #fca5a5; font-size: 12px; font-weight: 600; cursor: pointer; font-family: inherit; display: flex; align-items: center; justify-content: center; gap: 6px; }
        .btn-logout-side:hover { background: rgba(239,68,68,0.22); color: #fff; }
    
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
    @include('postulante.partials.sidebar')

    {{-- MAIN CONTENT --}}
    <div class="main-content">
        {{-- TOPBAR --}}
        <header class="topbar">
            <div style="display:flex;align-items:center;gap:12px">
                <button type="button" class="btn-menu-mobile" onclick="document.querySelector('.sidebar').classList.toggle('open'); document.getElementById('sidebar-overlay-mobile').classList.toggle('show');" style="color:#0f172a; padding:4px;">&#9776;</button>
                <div class="welcome-msg">
                    <h1>Mi Grupo Asignado</h1>
                    <p class="hide-mobile" style="font-size:13px; color:#64748b; margin-top:2px;">Información detallada de tu grupo, docentes y horarios.</p>
                </div>
            </div>
            
            <div class="topbar-right" style="display:flex; align-items:center;">
                <div class="dropdown-container" style="position:relative;">
                    <button onclick="let d=document.getElementById('postulante-dropdown'); d.style.display = d.style.display==='none' ? 'block' : 'none';" style="background:none;border:none;cursor:pointer;padding:8px;color:#64748b;display:flex;align-items:center;justify-content:center;">
                        <i class="ti ti-dots-vertical" style="font-size:22px;"></i>
                    </button>
                    <div id="postulante-dropdown" class="dropdown-menu" style="display:none; position:absolute; right:0; top:100%; background:#fff; border:1px solid #e2e8f0; border-radius:12px; box-shadow:0 10px 25px rgba(0,0,0,0.1); width:200px; z-index:1000; overflow:hidden;">
                        <div style="padding:12px 16px; border-bottom:1px solid #e2e8f0; background:#f8fafc;">
                            <div style="font-size:13px; font-weight:600; color:#0f172a;">{{ $postulante->nombre_completo }}</div>
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

        {{-- CONTENT WRAPPER --}}
        <main class="content-wrapper">

            {{-- HERO BANNER --}}
            <div class="group-hero">
                <div class="hero-title">
                    <h2>Grupo {{ $grupo->numero_grupo }}</h2>
                    <p>Facultad de Ciencias de la Computación y Telecomunicaciones</p>
                </div>
                <div class="turno-badge">
                    Turno: {{ $grupo->turno }}
                </div>
            </div>

            {{-- GRID --}}
            <div class="grid-layout">
                {{-- MATERIAS --}}
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="ti ti-notebook"></i>
                            <span>Materias del Curso</span>
                        </div>
                    </div>
                    <div class="list-items">
                        @forelse($grupo->materias as $materia)
                            <div class="list-item">
                                <div class="item-icon">
                                    <i class="ti ti-book"></i>
                                </div>
                                <div class="item-details">
                                    <h4>{{ $materia->nombre }}</h4>
                                    <p>Código: {{ $materia->codigo }}</p>
                                </div>
                            </div>
                        @empty
                            <p style="color: #64748b; font-style: italic;">No hay materias registradas en este grupo.</p>
                        @endforelse
                    </div>
                </div>

                {{-- DOCENTES --}}
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="ti ti-chalkboard"></i>
                            <span>Docentes Designados</span>
                        </div>
                    </div>
                    <div class="list-items">
                        @forelse($grupo->docentes as $docente)
                            <div class="list-item docente">
                                <div class="item-icon">
                                    <i class="ti ti-user-check"></i>
                                </div>
                                <div class="item-details">
                                    <h4>{{ $docente->nombre }} {{ $docente->apellido }}</h4>
                                    <p>Email: {{ $docente->email }} | Especialidad: {{ $docente->especialidad ?? 'Computación' }}</p>
                                </div>
                            </div>
                        @empty
                            <p style="color: #64748b; font-style: italic;">No hay docentes designados para este grupo aún.</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </main>
    </div>

</body>
</html>