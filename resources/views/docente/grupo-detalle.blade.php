<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grupo {{ $grupo->numero_grupo }} — Portal Docente CUP</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Pre-detect and apply theme before rendering to avoid flash
        if (localStorage.getItem('theme') === 'light' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: light)').matches)) {
            document.documentElement.classList.add('light-theme');
        }
    </script>
    <style>
        :root {
            --bg: #0f1117; --surface: #1a1d27; --surface2: #22263a;
            --border: rgba(255,255,255,0.07); --text: #e2e8f0; --muted: #64748b;
            --accent: #6366f1; --accent2: #8b5cf6; --green: #10b981;
            --amber: #f59e0b; --rose: #f43f5e; --sky: #0ea5e9; --sidebar-w: 240px;
        }

        .light-theme {
            --bg: #f8fafc;
            --surface: #ffffff;
            --surface2: #f1f5f9;
            --border: rgba(0, 0, 0, 0.08);
            --text: #0f172a;
            --muted: #64748b;
            --accent: #4f46e5;
            --accent2: #7c3aed;
        }

        /* Light Theme Overrides */
        .light-theme .nav-item {
            color: #475569;
        }
        .light-theme .nav-item:hover {
            background: rgba(0, 0, 0, 0.04);
            color: #0f172a;
        }
        .light-theme .nav-item.active {
            background: rgba(79, 70, 229, 0.1);
            color: #4f46e5;
        }
        .light-theme .topbar {
            background: rgba(248, 250, 252, 0.85);
        }
        .light-theme .grupo-header {
            background: linear-gradient(135deg, #4f46e5, #3b82f6);
            border: none;
        }
        .light-theme .btn-logout {
            background: rgba(0, 0, 0, 0.04);
            color: #475569;
        }
        .light-theme .btn-logout:hover {
            background: rgba(0, 0, 0, 0.08);
            color: #0f172a;
        }
        .light-theme .back-btn {
            background: rgba(0, 0, 0, 0.04);
            color: #475569;
        }
        .light-theme .back-btn:hover {
            background: rgba(0, 0, 0, 0.08);
            color: #0f172a;
        }
        .light-theme .tabs {
            background: #ffffff;
        }
        .light-theme .tab {
            color: #64748b;
        }
        .light-theme .tab:hover {
            color: #0f172a;
        }
        .light-theme .tab.active {
            background: var(--accent);
            color: #ffffff;
        }
        .light-theme .table-card td {
            border-bottom: 1px solid rgba(0, 0, 0, 0.04);
        }
        .light-theme .table-card tr:hover td {
            background: rgba(0, 0, 0, 0.015);
        }
        .light-theme .table-card th {
            background: #f1f5f9;
        }
        .light-theme .asist-btn.p {
            border-color: rgba(16, 185, 129, 0.3);
            color: #059669;
        }
        .light-theme .asist-btn.p.sel, .light-theme .asist-btn.p:has(input:checked) {
            background: rgba(16, 185, 129, 0.15);
            color: #059669;
        }
        .light-theme .asist-btn.a {
            border-color: rgba(244, 63, 94, 0.3);
            color: #dc2626;
        }
        .light-theme .asist-btn.a.sel, .light-theme .asist-btn.a:has(input:checked) {
            background: rgba(244, 63, 94, 0.15);
            color: #dc2626;
        }
        .light-theme .asist-btn.j {
            border-color: rgba(245, 158, 11, 0.3);
            color: #d97706;
        }
        .light-theme .asist-btn.j.sel, .light-theme .asist-btn.j:has(input:checked) {
            background: rgba(245, 158, 11, 0.15);
            color: #d97706;
        }
        .light-theme .nota-alta {
            background: rgba(16, 185, 129, 0.15);
            color: #059669;
        }
        .light-theme .nota-media {
            background: rgba(245, 158, 11, 0.15);
            color: #d97706;
        }
        .light-theme .nota-baja {
            background: rgba(244, 63, 94, 0.15);
            color: #dc2626;
        }
        .light-theme .nota-vacia {
            background: #f1f5f9;
            color: #64748b;
        }
        .light-theme .panel-sidebar, .light-theme .panel-content {
            background: #ffffff;
        }
        .light-theme .chat-history {
            background: #f8fafc;
        }
        .light-theme .msg-recv {
            background: #e2e8f0;
            color: #0f172a;
        }
        .light-theme .chat-user-item:hover {
            background: rgba(0, 0, 0, 0.03);
        }
        .light-theme .chat-user-item.active {
            background: rgba(79, 70, 229, 0.1);
        }
        .light-theme .form-group input,
        .light-theme .form-group select,
        .light-theme .form-group textarea,
        .light-theme .chat-input-area input {
            background: #f1f5f9;
            color: #0f172a;
            border-color: rgba(0, 0, 0, 0.08);
        }
        .light-theme .btn-secondary {
            background: rgba(0, 0, 0, 0.04);
            color: #475569;
        }
        .light-theme .btn-secondary:hover {
            background: rgba(0, 0, 0, 0.08);
            color: #0f172a;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); }

        /* TOPBAR */
        .topbar {
            position: fixed; top: 0; left: var(--sidebar-w); right: 0; height: 60px;
            background: rgba(15,17,23,0.9); backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 28px; z-index: 100;
        }
        .topbar-left { display: flex; align-items: center; gap: 12px; }
        .back-btn {
            display: flex; align-items: center; gap: 6px; padding: 6px 12px;
            background: rgba(255,255,255,0.06); border: 1px solid var(--border);
            color: var(--muted); border-radius: 8px; font-size: 12px; text-decoration: none;
            transition: all .2s;
        }
        .back-btn:hover { color: var(--text); background: rgba(255,255,255,0.1); }
        .topbar-title { font-size: 15px; font-weight: 600; }

        /* SIDEBAR */
        .sidebar {
            position: fixed; top: 0; left: 0; width: var(--sidebar-w); height: 100vh;
            background: var(--surface); border-right: 1px solid var(--border);
            display: flex; flex-direction: column; padding: 0 0 24px; z-index: 200; overflow-y: auto;
        }
        .sidebar-brand {
            display: flex; align-items: center; gap: 10px; padding: 20px 20px 16px;
            border-bottom: 1px solid var(--border);
        }
        .brand-icon {
            width: 36px; height: 36px; border-radius: 10px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .brand-text { font-size: 14px; font-weight: 700; color: var(--text); line-height: 1.2; }
        .brand-sub { font-size: 10px; color: var(--muted); font-weight: 400; }
        .nav-section { padding: 16px 12px 4px; }
        .nav-label { font-size: 9.5px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: .08em; padding: 0 8px; margin-bottom: 6px; }
        .nav-item {
            display: flex; align-items: center; gap: 10px; padding: 9px 12px; border-radius: 9px;
            color: rgba(226,232,240,0.6); text-decoration: none; font-size: 13px; font-weight: 500;
            transition: all .15s; margin-bottom: 2px; cursor: pointer; border: none; background: none; text-align: left; width: 100%;
        }
        .nav-item i { font-size: 17px; flex-shrink: 0; }
        .nav-item:hover { background: rgba(255,255,255,0.06); color: var(--text); }
        .nav-item.active { background: rgba(99,102,241,0.15); color: #a5b4fc; }
        .sidebar-footer { margin-top: auto; padding: 16px 20px 0; border-top: 1px solid var(--border); }
        .avatar-circle {
            width: 36px; height: 36px; border-radius: 50%; flex-shrink: 0;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 700; color: #fff;
        }
        .docente-card { display: flex; align-items: center; gap: 10px; padding: 12px; background: var(--surface2); border-radius: 10px; border: 1px solid var(--border); }
        .btn-logout { display: flex; align-items: center; gap: 6px; padding: 7px 14px; background: rgba(255,255,255,0.06); border: 1px solid var(--border); color: var(--text); border-radius: 8px; font-size: 12px; font-weight: 500; cursor: pointer; text-decoration: none; font-family: 'Inter', sans-serif; transition: background .2s; width: 100%; justify-content: center; margin-top: 10px; }
        .btn-logout:hover { background: rgba(255,255,255,0.12); }

        /* MAIN */
        .main { margin-left: var(--sidebar-w); padding-top: 60px; min-height: 100vh; }
        .page { padding: 28px; }

        /* ALERTS */
        .alert { padding: 12px 16px; border-radius: 10px; margin-bottom: 16px; font-size: 13px; display: flex; align-items: center; gap: 9px; }
        .alert-ok  { background: rgba(16,185,129,0.12); color: #6ee7b7; border: 1px solid rgba(16,185,129,0.25); }
        .alert-err { background: rgba(244,63,94,0.12); color: #fda4af; border: 1px solid rgba(244,63,94,0.25); }

        /* GRUPO HEADER CARD */
        .grupo-header {
            background: linear-gradient(135deg, #1e1b4b, #312e81);
            border: 1px solid rgba(99,102,241,0.3); border-radius: 14px;
            padding: 24px 28px; margin-bottom: 24px; display: flex; align-items: center; gap: 20px;
        }
        .gh-num {
            width: 60px; height: 60px; border-radius: 14px; flex-shrink: 0;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; font-weight: 800; color: #fff;
        }
        .gh-info { flex: 1; }
        .gh-title { font-size: 20px; font-weight: 700; color: #fff; margin-bottom: 4px; }
        .gh-meta { font-size: 12px; color: rgba(165,180,252,0.7); display: flex; gap: 16px; flex-wrap: wrap; }
        .gh-meta span { display: flex; align-items: center; gap: 5px; }
        .gh-kpis { display: flex; gap: 16px; }
        .gh-kpi { text-align: center; }
        .gh-kpi-val { font-size: 22px; font-weight: 700; color: #fff; }
        .gh-kpi-label { font-size: 10px; color: rgba(165,180,252,0.6); text-transform: uppercase; }

        /* TABS */
        .tabs { display: flex; gap: 4px; background: var(--surface); border: 1px solid var(--border); border-radius: 10px; padding: 4px; margin-bottom: 20px; width: fit-content; flex-wrap: wrap; }
        .tab { padding: 8px 18px; border-radius: 7px; font-size: 13px; font-weight: 600; color: var(--muted); cursor: pointer; transition: all .2s; border: none; background: none; font-family: 'Inter', sans-serif; display: flex; align-items: center; gap: 6px; }
        .tab:hover { color: var(--text); }
        .tab.active { background: var(--accent); color: #fff; }
        .tab-panel { display: none; }
        .tab-panel.active { display: block; }

        /* SEARCH */
        .search-bar { position: relative; margin-bottom: 16px; max-width: 360px; }
        .search-bar input { width: 100%; background: var(--surface); border: 1px solid var(--border); color: var(--text); padding: 9px 12px 9px 36px; border-radius: 9px; font-size: 13px; font-family: 'Inter', sans-serif; outline: none; transition: border-color .2s; }
        .search-bar input:focus { border-color: var(--accent); }
        .search-bar i { position: absolute; left: 11px; top: 50%; transform: translateY(-50%); color: var(--muted); font-size: 16px; }

        /* TABLES */
        .table-card { background: var(--surface); border: 1px solid var(--border); border-radius: 14px; overflow: hidden; margin-bottom: 20px; }
        .table-card table { width: 100%; border-collapse: collapse; font-size: 13px; }
        .table-card th { padding: 12px 16px; background: var(--surface2); color: var(--muted); font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; text-align: left; border-bottom: 1px solid var(--border); }
        .table-card td { padding: 12px 16px; border-bottom: 1px solid rgba(255,255,255,0.04); vertical-align: middle; }
        .table-card tr:last-child td { border-bottom: none; }
        .table-card tr:hover td { background: rgba(255,255,255,0.02); }

        .stu-name { font-weight: 600; color: var(--text); }
        .stu-code { font-size: 11px; color: var(--muted); }

        /* ASISTENCIA RADIO */
        .asist-group { display: flex; gap: 6px; }
        .asist-btn {
            display: inline-flex; align-items: center; gap: 4px; padding: 5px 10px;
            border-radius: 7px; font-size: 11px; font-weight: 600; cursor: pointer;
            border: 1px solid transparent; transition: all .15s; white-space: nowrap;
        }
        .asist-btn input { display: none; }
        .asist-btn.p { border-color: rgba(16,185,129,0.3); color: rgba(16,185,129,0.5); }
        .asist-btn.p:has(input:checked), .asist-btn.p.sel { background: rgba(16,185,129,0.15); border-color: var(--green); color: #6ee7b7; }
        .asist-btn.a { border-color: rgba(244,63,94,0.3); color: rgba(244,63,94,0.5); }
        .asist-btn.a:has(input:checked), .asist-btn.a.sel { background: rgba(244,63,94,0.15); border-color: var(--rose); color: #fda4af; }
        .asist-btn.j { border-color: rgba(245,158,11,0.3); color: rgba(245,158,11,0.5); }
        .asist-btn.j:has(input:checked), .asist-btn.j.sel { background: rgba(245,158,11,0.15); border-color: var(--amber); color: #fcd34d; }

        /* NOTA BADGE */
        .nota-badge {
            display: inline-flex; align-items: center; padding: 3px 9px; border-radius: 7px;
            font-size: 12px; font-weight: 700; cursor: pointer; transition: all .2s;
        }
        .nota-alta { background: rgba(16,185,129,0.15); color: #6ee7b7; border: 1px solid rgba(16,185,129,0.3); }
        .nota-media { background: rgba(245,158,11,0.15); color: #fcd34d; border: 1px solid rgba(245,158,11,0.3); }
        .nota-baja { background: rgba(244,63,94,0.15); color: #fda4af; border: 1px solid rgba(244,63,94,0.3); }
        .nota-vacia { background: var(--surface2); color: var(--muted); border: 1px dashed var(--border); }

        /* BTNS */
        .btn-primary {
            display: inline-flex; align-items: center; gap: 7px; padding: 10px 20px;
            background: var(--accent); color: #fff; border: none; border-radius: 9px;
            font-size: 13px; font-weight: 600; cursor: pointer; font-family: 'Inter', sans-serif;
            transition: all .2s; text-decoration: none;
        }
        .btn-primary:hover { background: var(--accent2); transform: translateY(-1px); }
        .btn-secondary {
            display: inline-flex; align-items: center; gap: 7px; padding: 10px 20px;
            background: rgba(255,255,255,0.06); color: var(--text); border: 1px solid var(--border); border-radius: 9px;
            font-size: 13px; font-weight: 600; cursor: pointer; font-family: 'Inter', sans-serif;
            transition: all .2s; text-decoration: none;
        }
        .btn-secondary:hover { background: rgba(255,255,255,0.12); }
        .btn-sm {
            display: inline-flex; align-items: center; gap: 5px; padding: 5px 12px;
            background: rgba(99,102,241,0.12); border: 1px solid rgba(99,102,241,0.3);
            color: #a5b4fc; border-radius: 7px; font-size: 11px; font-weight: 600;
            cursor: pointer; font-family: 'Inter', sans-serif; transition: all .2s;
        }
        .btn-sm:hover { background: rgba(99,102,241,0.25); }

        /* TWO COLUMN PANEL (CHAT, TASKS) */
        .split-panel { display: grid; grid-template-columns: 280px 1fr; gap: 20px; min-height: 500px; }
        .panel-sidebar { background: var(--surface); border: 1px solid var(--border); border-radius: 14px; padding: 16px; overflow-y: auto; max-height: 600px; }
        .panel-content { background: var(--surface); border: 1px solid var(--border); border-radius: 14px; padding: 24px; display: flex; flex-direction: column; }
        
        .chat-user-item { display: flex; align-items: center; gap: 10px; padding: 10px; border-radius: 9px; cursor: pointer; transition: background .2s; margin-bottom: 4px; }
        .chat-user-item:hover { background: rgba(255,255,255,0.04); }
        .chat-user-item.active { background: rgba(99,102,241,0.12); border: 1px solid rgba(99,102,241,0.2); }
        
        .chat-history { flex: 1; border: 1px solid var(--border); border-radius: 10px; background: rgba(0,0,0,0.15); padding: 16px; overflow-y: auto; max-height: 380px; display: flex; flex-direction: column; gap: 10px; margin-bottom: 16px; }
        .msg-bubble { max-width: 70%; padding: 10px 14px; border-radius: 14px; font-size: 13px; line-height: 1.4; word-break: break-word; }
        .msg-sent { background: var(--accent); color: #fff; align-self: flex-end; border-bottom-right-radius: 2px; }
        .msg-recv { background: var(--surface2); color: var(--text); align-self: flex-start; border-bottom-left-radius: 2px; }
        .chat-input-area { display: flex; gap: 8px; }
        .chat-input-area input { flex: 1; background: var(--surface2); border: 1px solid var(--border); color: var(--text); padding: 10px 14px; border-radius: 9px; font-size: 13px; outline: none; }
        .chat-input-area input:focus { border-color: var(--accent); }

        /* TASKS FORM */
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px; }
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; font-size: 11px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: .06em; margin-bottom: 6px; }
        .form-group select, .form-group input, .form-group textarea {
            width: 100%; background: var(--surface2); border: 1px solid var(--border);
            color: var(--text); padding: 9px 12px; border-radius: 9px; font-size: 13px;
            font-family: 'Inter', sans-serif; outline: none; transition: border-color .2s;
        }
        .form-group select:focus, .form-group input:focus, .form-group textarea:focus { border-color: var(--accent); }

        /* STATS CARDS */
        .stats-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 24px; }
        .chart-card { background: var(--surface); border: 1px solid var(--border); border-radius: 14px; padding: 20px; }
        .stats-sidebar-card { background: var(--surface); border: 1px solid var(--border); border-radius: 14px; padding: 20px; display: flex; flex-direction: column; gap: 16px; }

        /* MODALS */
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.7); backdrop-filter: blur(4px); z-index: 500; align-items: center; justify-content: center; }
        .modal-overlay.open { display: flex; }
        .modal {
            background: var(--surface); border: 1px solid var(--border); border-radius: 16px;
            padding: 28px; width: 440px; max-width: 95vw; animation: fadeUp .2s ease;
        }
        @keyframes fadeUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
        .modal-title { font-size: 16px; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; }
        .modal-title i { color: var(--accent); }
        .modal-actions { display: flex; gap: 10px; margin-top: 20px; }
        .btn-cancel {
            flex: 1; padding: 10px; background: var(--surface2); border: 1px solid var(--border);
            color: var(--muted); border-radius: 9px; font-size: 13px; cursor: pointer;
            font-family: 'Inter', sans-serif; transition: all .2s;
        }
        .btn-cancel:hover { color: var(--text); }

        .top-row { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 16px; }

        @media(max-width:992px) {
            .split-panel { grid-template-columns: 1fr; }
            .stats-grid { grid-template-columns: 1fr; }
        }
        @media(max-width:768px) {
            :root { --sidebar-w: 0px; }
            .sidebar { display: none; }
            .topbar { left: 0; }
            .asist-group { flex-direction: column; }
            .gh-kpis { display: none; }
        }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon"><i class="ti ti-school" style="color:#fff;font-size:18px"></i></div>
        <div class="brand-text">CUP — FICCT <div class="brand-sub">Portal Docente</div></div>
    </div>
    <div class="nav-section">
        <div class="nav-label">Principal</div>
        <a href="{{ route('docente.dashboard') }}" class="nav-item">
            <i class="ti ti-layout-dashboard"></i> Dashboard
        </a>
    </div>
    <div class="nav-section">
        <div class="nav-label">Grupo actual</div>
        <button class="nav-item active" id="side-roster" onclick="switchTab('roster')">
            <i class="ti ti-users"></i> Roster
        </button>
        <button class="nav-item" id="side-asistencia" onclick="switchTab('asistencia')">
            <i class="ti ti-checkbox"></i> Control Asistencia
        </button>
        <button class="nav-item" id="side-notas" onclick="switchTab('notas')">
            <i class="ti ti-file-text"></i> Notas Exámenes
        </button>
        <button class="nav-item" id="side-tareas" onclick="switchTab('tareas')">
            <i class="ti ti-notebook"></i> Tareas y Prácticos
        </button>
        <button class="nav-item" id="side-comunicacion" onclick="switchTab('comunicacion')">
            <i class="ti ti-messages"></i> Chat y Anuncios
        </button>
        <button class="nav-item" id="side-reportes" onclick="switchTab('reportes')">
            <i class="ti ti-chart-bar"></i> Reportes y Gráficos
        </button>
    </div>
    <div class="sidebar-footer">
        <div class="docente-card">
            <div class="avatar-circle">{{ strtoupper(substr($docente->nombre,0,1).substr($docente->apellido,0,1)) }}</div>
            <div style="min-width:0">
                <div style="font-size:12px;font-weight:600;color:var(--text);overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ $docente->nombre }} {{ $docente->apellido }}</div>
                <div style="font-size:10px;color:var(--muted)">Docente</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout"><i class="ti ti-logout"></i> Cerrar sesión</button>
        </form>
    </div>
</aside>

<!-- TOPBAR -->
<div class="topbar">
    <div class="topbar-left">
        <a href="{{ route('docente.dashboard') }}" class="back-btn">
            <i class="ti ti-arrow-left"></i> Volver
        </a>
        <span class="topbar-title">Grupo {{ $grupo->numero_grupo }} — {{ $grupo->turno }}</span>
    </div>
    <div style="display:flex;align-items:center;gap:16px">
        <button id="theme-toggle" class="back-btn" style="padding: 6px 10px; cursor: pointer; border-radius:8px;" title="Alternar modo noche/día">
            <i class="ti ti-moon" id="theme-icon" style="font-size:15px"></i>
        </button>
        <span style="font-size:12px;color:var(--muted)">{{ now()->format('d/m/Y') }}</span>
    </div>
</div>

<!-- MAIN -->
<main class="main">
<div class="page">

    @if(session('success'))
        <div class="alert alert-ok"><i class="ti ti-circle-check"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-err"><i class="ti ti-alert-circle"></i> {{ session('error') }}</div>
    @endif

    <!-- GRUPO HEADER -->
    <div class="grupo-header">
        <div class="gh-num">{{ $grupo->numero_grupo }}</div>
        <div class="gh-info">
            <div class="gh-title">Grupo {{ $grupo->numero_grupo }} — {{ $grupo->turno }}</div>
            <div class="gh-meta">
                <span><i class="ti ti-building"></i> {{ $grupo->convocatoria_nombre }}</span>
                <span><i class="ti ti-calendar"></i> {{ now()->format('d/m/Y') }}</span>
                <span style="color:{{ $grupo->estado === 'ACTIVO' ? '#6ee7b7' : '#fcd34d' }}">
                    <i class="ti ti-point-filled" style="font-size:8px"></i> {{ $grupo->estado }}
                </span>
            </div>
        </div>
        <div class="gh-kpis">
            <div class="gh-kpi">
                <div class="gh-kpi-val">{{ $postulantes->count() }}</div>
                <div class="gh-kpi-label">Alumnos</div>
            </div>
            <div class="gh-kpi" style="border-left:1px solid rgba(255,255,255,0.1);padding-left:16px">
                <div class="gh-kpi-val">{{ $asistenciaHoy->count() }}</div>
                <div class="gh-kpi-label">Asist. hoy</div>
            </div>
        </div>
    </div>

    <!-- TABS -->
    <div class="tabs">
        <button class="tab active" id="tab-btn-roster" onclick="switchTab('roster')">
            <i class="ti ti-users"></i> Lista de alumnos
        </button>
        <button class="tab" id="tab-btn-asistencia" onclick="switchTab('asistencia')">
            <i class="ti ti-checkbox"></i> Asistencia
        </button>
        <button class="tab" id="tab-btn-notas" onclick="switchTab('notas')">
            <i class="ti ti-file-text"></i> Calificaciones
        </button>
        <button class="tab" id="tab-btn-tareas" onclick="switchTab('tareas')">
            <i class="ti ti-notebook"></i> Tareas y Prácticos
        </button>
        <button class="tab" id="tab-btn-comunicacion" onclick="switchTab('comunicacion')">
            <i class="ti ti-messages"></i> Chat y Avisos
        </button>
        <button class="tab" id="tab-btn-reportes" onclick="switchTab('reportes')">
            <i class="ti ti-chart-bar"></i> Estadísticas y Reportes
        </button>
    </div>

    <!-- TAB: ROSTER -->
    <div class="tab-panel active" id="tab-roster">
        <div class="search-bar">
            <i class="ti ti-search"></i>
            <input type="text" id="search-roster" placeholder="Buscar alumno..." oninput="filtrarTabla('roster-table', this.value)">
        </div>
        <div class="table-card">
            <table id="roster-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Alumno</th>
                        <th>Código</th>
                        <th>CI</th>
                        <th>Correo</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($postulantes as $i => $p)
                    @php
                        $notasPostulante = $notas->get($p->id, collect());
                        $weightedSum = 0;
                        $totalWeight = 0;
                        $hasAnyGrade = false;
                        foreach ($examenes as $ex) {
                            $notaM = $notasPostulante->where('examen_id', $ex->id)->first();
                            if ($notaM) {
                                $cal = (float)$notaM->calificacion;
                                $hasAnyGrade = true;
                                $weightedSum += ($cal * $ex->porcentaje_peso);
                                $totalWeight += $ex->porcentaje_peso;
                            }
                        }
                        
                        // Running average based on entered grades
                        $promedioRunning = $hasAnyGrade && $totalWeight > 0 ? ($weightedSum / $totalWeight) : null;
                        
                        $academicState = $p->estado;
                        if ($promedioRunning !== null) {
                            $academicState = $promedioRunning >= 60 ? 'APROBADO' : 'REPROBADO';
                        }
                        
                        $stColor = match($academicState) { 
                            'ADMITIDO', 'APROBADO' => 'green', 
                            'APROBADO_SIN_CUPO' => 'amber', 
                            'REPROBADO', 'REPROBADO_CUP' => 'rose', 
                            default => 'muted' 
                        }; 
                        
                        $stText = match($academicState) {
                            'PROCESO' => 'EN PROCESO',
                            'APROBADO_SIN_CUPO' => 'APROBADO SIN CUPO',
                            'REPROBADO_CUP' => 'REPROBADO',
                            default => $academicState
                        };
                    @endphp
                    <tr>
                        <td style="color:var(--muted)">{{ $i + 1 }}</td>
                        <td>
                            <div class="stu-name">{{ $p->apellido }}, {{ $p->nombre }}</div>
                        </td>
                        <td><span class="stu-code">{{ $p->codigo_estudiante }}</span></td>
                        <td><span style="font-size:12px;color:var(--muted)">{{ $p->ci }}</span></td>
                        <td><span style="font-size:12px;color:var(--muted)">{{ $p->email }}</span></td>
                        <td>
                            <span style="font-size:11px;font-weight:600;color:var(--{{ $stColor }})">{{ $stText }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" style="text-align:center;padding:40px;color:var(--muted)">No hay postulantes en este grupo.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- TAB: ASISTENCIA -->
    <div class="tab-panel" id="tab-asistencia">
        <form method="POST" action="{{ route('docente.grupo.asistencia.guardar', $grupo->id) }}">
            @csrf
            <div class="top-row">
                <div>
                    <div style="font-size:14px;font-weight:700;margin-bottom:4px">Asistencia del día <span style="color:var(--accent)">{{ now()->format('d/m/Y') }}</span></div>
                    <div style="font-size:12px;color:var(--muted)">Marca el estado de cada alumno. Los cambios se aplican a la fecha de hoy.</div>
                </div>
                <div style="display:flex;gap:8px;align-items:center">
                    <button type="button" class="btn-sm" onclick="marcarTodos('PRESENTE')"><i class="ti ti-check"></i> Todos presentes</button>
                    <button type="button" class="btn-sm" onclick="marcarTodos('AUSENTE')" style="color:#fda4af;border-color:rgba(244,63,94,0.3)"><i class="ti ti-x"></i> Todos ausentes</button>
                    <button type="submit" class="btn-primary"><i class="ti ti-device-floppy"></i> Guardar asistencia</button>
                </div>
            </div>

            <div class="table-card">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Alumno</th>
                            <th>Código</th>
                            <th>Estado de Asistencia</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($postulantes as $i => $p)
                        @php $estadoHoy = $asistenciaHoy->get($p->id, 'PRESENTE'); @endphp
                        <tr>
                            <td style="color:var(--muted)">{{ $i + 1 }}</td>
                            <td><div class="stu-name">{{ $p->apellido }}, {{ $p->nombre }}</div></td>
                            <td><span class="stu-code">{{ $p->codigo_estudiante }}</span></td>
                            <td>
                                <div class="asist-group" data-postulante="{{ $p->id }}">
                                    <label class="asist-btn p {{ $estadoHoy === 'PRESENTE' ? 'sel' : '' }}">
                                        <input type="radio" name="asistencia[{{ $p->id }}]" value="PRESENTE" {{ $estadoHoy === 'PRESENTE' ? 'checked' : '' }} onchange="updateAsistBtn(this)">
                                        <i class="ti ti-check"></i> Presente
                                    </label>
                                    <label class="asist-btn a {{ $estadoHoy === 'AUSENTE' ? 'sel' : '' }}">
                                        <input type="radio" name="asistencia[{{ $p->id }}]" value="AUSENTE" {{ $estadoHoy === 'AUSENTE' ? 'checked' : '' }} onchange="updateAsistBtn(this)">
                                        <i class="ti ti-x"></i> Ausente
                                    </label>
                                    <label class="asist-btn j {{ $estadoHoy === 'JUSTIFICADO' ? 'sel' : '' }}">
                                        <input type="radio" name="asistencia[{{ $p->id }}]" value="JUSTIFICADO" {{ $estadoHoy === 'JUSTIFICADO' ? 'checked' : '' }} onchange="updateAsistBtn(this)">
                                        <i class="ti ti-writing"></i> Licencia
                                    </label>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" style="text-align:center;padding:40px;color:var(--muted)">No hay postulantes.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>
    </div>

    <!-- TAB: NOTAS -->
    <div class="tab-panel" id="tab-notas">
        <div class="top-row">
            <div>
                <div style="font-size:14px;font-weight:700;margin-bottom:4px">Registro de Calificaciones (Exámenes)</div>
                <div style="font-size:12px;color:var(--muted)">Haz clic en una celda de nota para agregar o actualizar la calificación del examen.</div>
            </div>
        </div>

        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Alumno</th>
                        @foreach($examenes as $ex)
                        @php $m = $materias->where('id', $ex->materia_id)->first(); @endphp
                        <th>{{ $m ? $m->nombre : 'Materia' }} - P{{ $ex->nro_examen }} ({{ $ex->porcentaje_peso }}%)</th>
                        @endforeach
                        <th>Promedio Final</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($postulantes as $i => $p)
                    @php
                        $notasPostulante = $notas->get($p->id, collect());
                        $weightedSum = 0;
                        $totalWeight = 0;
                        $hasAnyGrade = false;
                        foreach ($examenes as $ex) {
                            $notaM = $notasPostulante->where('examen_id', $ex->id)->first();
                            $cal = $notaM ? (float)$notaM->calificacion : 0.0;
                            if ($notaM) {
                                $hasAnyGrade = true;
                            }
                            $weightedSum += ($cal * $ex->porcentaje_peso);
                            $totalWeight += $ex->porcentaje_peso;
                        }
                        $promedio = $hasAnyGrade && $totalWeight > 0 ? round($weightedSum / 100, 1) : null;
                    @endphp
                    <tr>
                        <td style="color:var(--muted)">{{ $i + 1 }}</td>
                        <td><div class="stu-name">{{ $p->apellido }}, {{ $p->nombre }}</div><div class="stu-code">{{ $p->codigo_estudiante }}</div></td>
                        @foreach($examenes as $ex)
                        @php
                            $notaM = $notasPostulante->where('examen_id', $ex->id)->first();
                            $cal = $notaM ? $notaM->calificacion : null;
                        @endphp
                            <td>
                            @if($cal !== null)
                            <span class="nota-badge {{ $cal >= 60 ? 'nota-alta' : 'nota-baja' }}"
                                  onclick="abrirModal({{ $p->id }}, '{{ $p->nombre }} {{ $p->apellido }}', {{ $ex->materia_id }}, {{ $ex->id }}, {{ $cal }}, '{{ $notaM->observaciones ?? '' }}')"
                                  title="Clic para editar">
                                {{ $cal }}
                            </span>
                            @else
                            <span class="nota-badge nota-vacia"
                                  onclick="abrirModal({{ $p->id }}, '{{ $p->nombre }} {{ $p->apellido }}', {{ $ex->materia_id }}, {{ $ex->id }}, null, '')"
                                  title="Sin nota — clic para agregar">
                                —
                            </span>
                            @endif
                            </td>
                        @endforeach
                        <td>
                            @if($promedio !== null)
                            <span style="font-weight:700;color:{{ $promedio >= 60 ? '#10b981' : '#f43f5e' }}">
                                {{ $promedio }}
                            </span>
                            @else
                            <span style="color:var(--muted)">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="{{ 3 + $examenes->count() }}" style="text-align:center;padding:40px;color:var(--muted)">No hay postulantes en este grupo.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- TAB: TAREAS -->
    <div class="tab-panel" id="tab-tareas">
        <div class="split-panel">
            <div class="panel-sidebar">
                <div style="font-size:12px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.05em;margin-bottom:12px">Crear Actividad</div>
                <form method="POST" action="{{ route('docente.grupo.tarea.crear', $grupo->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Materia</label>
                        <select name="materia_id" required>
                            @foreach($materias as $m)
                            <option value="{{ $m->id }}">{{ $m->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Título de Actividad</label>
                        <input type="text" name="titulo" placeholder="Ej: Trabajo Práctico 1" required>
                    </div>
                    <div class="form-group">
                        <label>Fecha límite</label>
                        <input type="datetime-local" name="fecha_limite" required>
                    </div>
                    <div class="form-group">
                        <label>Archivo de apoyo (Opcional)</label>
                        <input type="file" name="archivo_guia" style="padding:4px">
                    </div>
                    <div class="form-group">
                        <label>Descripción / Instrucciones</label>
                        <textarea name="descripcion" rows="3" placeholder="Detalles de la tarea..." required></textarea>
                    </div>
                    <button type="submit" class="btn-primary" style="width:100%;justify-content:center"><i class="ti ti-plus"></i> Crear Tarea</button>
                </form>
            </div>
            
            <div class="panel-content">
                <div style="font-size:14px;font-weight:700;margin-bottom:16px"><i class="ti ti-notebook" style="color:var(--accent)"></i> Tareas y Prácticos Asignados</div>
                
                @php
                    $tareas = DB::table('tarea')
                        ->join('materia', 'tarea.materia_id', '=', 'materia.id')
                        ->where('tarea.grupo_id', $grupo->id)
                        ->select('tarea.*', 'materia.nombre as materia_nombre')
                        ->orderBy('tarea.created_at', 'desc')
                        ->get();
                @endphp

                @if($tareas->isEmpty())
                    <div style="text-align:center;padding:60px 20px;color:var(--muted)">
                        <i class="ti ti-folder-open" style="font-size:36px;display:block;margin-bottom:10px;opacity:.5"></i>
                        No has creado tareas para este grupo todavía.
                    </div>
                @else
                    <div class="table-card">
                        <table>
                            <thead>
                                <tr>
                                    <th>Materia</th>
                                    <th>Título</th>
                                    <th>Límite</th>
                                    <th>Entregas</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tareas as $t)
                                @php
                                    $entregasCount = DB::table('tarea_entrega')->where('tarea_id', $t->id)->count();
                                    $pendientesCount = DB::table('tarea_entrega')->where('tarea_id', $t->id)->whereNull('calificacion')->count();
                                @endphp
                                <tr>
                                    <td><span style="font-weight:600">{{ $t->materia_nombre }}</span></td>
                                    <td>
                                        <div style="font-weight:600">{{ $t->titulo }}</div>
                                        <div style="font-size:11px;color:var(--muted)">{{ Str::limit($t->descripcion, 60) }}</div>
                                    </td>
                                    <td><span style="font-size:11px;color:var(--muted)">{{ \Carbon\Carbon::parse($t->fecha_limite)->format('d/m/Y H:i') }}</span></td>
                                    <td>
                                        <span class="badge" style="background:rgba(99,102,241,0.15);color:#a5b4fc">{{ $entregasCount }} entregados</span>
                                        @if($pendientesCount > 0)
                                        <span class="badge" style="background:rgba(244,63,94,0.15);color:#fda4af;margin-left:4px">{{ $pendientesCount }} por calificar</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn-sm" onclick="verEntregas({{ $t->id }}, '{{ $t->titulo }}')">Ver entregas</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                <!-- PANEL CALIFICACIÓN DE ENTREGAS (OCULTO POR DEFECTO) -->
                <div id="entregas-seccion" style="display:none;margin-top:20px;border-top:1px solid var(--border);padding-top:20px">
                    <div class="top-row">
                        <div style="font-size:13px;font-weight:700" id="entrega-tarea-titulo">Entregas de Tarea: </div>
                        <button class="btn-sm" onclick="document.getElementById('entregas-seccion').style.display='none'" style="color:var(--muted)">Cerrar</button>
                    </div>
                    <div class="table-card" style="margin-top:10px">
                        <table id="tabla-entregas">
                            <thead>
                                <tr>
                                    <th>Estudiante</th>
                                    <th>Fecha Entrega</th>
                                    <th>Comentario Alumno</th>
                                    <th>Archivo</th>
                                    <th>Calificación</th>
                                    <th>Comentarios Docente</th>
                                    <th>Guardar</th>
                                </tr>
                            </thead>
                            <tbody id="cuerpo-entregas">
                                <!-- Cargado dinámicamente o por backend -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB: COMUNICACION -->
    <div class="tab-panel" id="tab-comunicacion">
        <div class="split-panel">
            <!-- Columna izquierda: chat e info docente -->
            <div class="panel-sidebar">
                <div style="font-size:12px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.05em;margin-bottom:12px">Postulantes (Chat)</div>
                <div style="display:flex;flex-direction:column;gap:4px">
                    @foreach($postulantes as $p)
                    <div class="chat-user-item" id="chat-user-{{ $p->id }}" onclick="abrirChat({{ $p->id }}, '{{ $p->nombre }} {{ $p->apellido }}')">
                        <div class="avatar-circle" style="width:28px;height:28px;font-size:10px">{{ strtoupper(substr($p->nombre,0,1).substr($p->apellido,0,1)) }}</div>
                        <div style="min-width:0;flex:1">
                            <div style="font-size:12px;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $p->apellido }}, {{ $p->nombre }}</div>
                            <div style="font-size:9px;color:var(--muted)">CI: {{ $p->ci }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Columna derecha: Tablón e Historial de Chat -->
            <div class="panel-content" style="gap:20px">
                <!-- TABLÓN DE ANUNCIOS -->
                <div style="border-bottom:1px solid var(--border);padding-bottom:20px">
                    <div class="top-row">
                        <div style="font-size:14px;font-weight:700"><i class="ti ti-alert-circle" style="color:var(--amber)"></i> Tablón de Anuncios</div>
                        <button class="btn-sm" onclick="abrirModalAnuncio()"><i class="ti ti-plus"></i> Publicar Aviso</button>
                    </div>

                    @php
                        $anuncios = DB::table('anuncio')
                            ->where('grupo_id', $grupo->id)
                            ->orderBy('created_at', 'desc')
                            ->get();
                    @endphp

                    @if($anuncios->isEmpty())
                        <div style="font-size:12px;color:var(--muted);text-align:center;padding:16px">No hay avisos publicados para este grupo.</div>
                    @else
                        <div style="display:flex;flex-direction:column;gap:10px;margin-top:10px">
                            @foreach($anuncios as $a)
                            <div style="background:var(--surface2);border:1px solid var(--border);border-radius:10px;padding:12px 16px">
                                <div style="display:flex;justify-content:between;align-items:center;margin-bottom:6px">
                                    <div style="font-size:13px;font-weight:700;color:#fff">{{ $a->titulo }}</div>
                                    <div style="font-size:10px;color:var(--muted)">{{ \Carbon\Carbon::parse($a->created_at)->diffForHumans() }}</div>
                                </div>
                                <div style="font-size:12px;color:var(--text);line-height:1.4">{{ $a->contenido }}</div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- CHAT INTERACTIVO (SE ACTIVA AL SELECCIONAR ALUMNO) -->
                <div id="chat-seccion" style="display:none;flex:1;flex-direction:column">
                    <div style="font-size:13px;font-weight:700;margin-bottom:10px" id="chat-nombre-titulo">Chat con: </div>
                    <div class="chat-history" id="chat-mensajes">
                        <!-- Mensajes cargados por AJAX -->
                    </div>
                    <form id="chat-formulario" onsubmit="enviarMensajeChat(event)">
                        @csrf
                        <input type="hidden" name="receptor_id" id="chat-receptor-id">
                        <div class="chat-input-area">
                            <input type="text" name="contenido" id="chat-mensaje-input" placeholder="Escribe tu mensaje aquí..." required autocomplete="off">
                            <button type="submit" class="btn-primary"><i class="ti ti-send"></i> Enviar</button>
                        </div>
                    </form>
                </div>
                
                <div id="chat-instruccion" style="display:flex;align-items:center;justify-content:center;flex:1;color:var(--muted);font-size:12px">
                    Selecciona un postulante de la lista lateral para iniciar un chat de consultas directo.
                </div>
            </div>
        </div>
    </div>

    <!-- TAB: REPORTES -->
    <div class="tab-panel" id="tab-reportes">
        <div class="stats-grid">
            <div class="chart-card">
                <div style="font-size:14px;font-weight:700;margin-bottom:14px"><i class="ti ti-chart-pie" style="color:var(--green)"></i> Rendimiento Académico del Grupo</div>
                <div style="height:320px;position:relative">
                    <canvas id="chartRendimiento"></canvas>
                </div>
            </div>
            
            <div class="stats-sidebar-card">
                <div style="font-size:12px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.05em">Exportar Datos</div>
                <div style="display:flex;flex-direction:column;gap:10px;margin-top:8px">
                    <a href="{{ route('docente.grupo.exportar.notas', $grupo->id) }}" class="btn-primary" style="justify-content:center">
                        <i class="ti ti-file-spreadsheet"></i> Descargar Notas (CSV)
                    </a>
                    <a href="{{ route('docente.grupo.exportar.asistencia', $grupo->id) }}" class="btn-secondary" style="justify-content:center">
                        <i class="ti ti-calendar-event"></i> Descargar Asistencia (CSV)
                    </a>
                </div>

                <div style="border-top:1px solid var(--border);padding-top:16px;margin-top:8px">
                    <div style="font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;margin-bottom:8px">Resumen Estadístico</div>
                    <div style="font-size:13px;display:flex;justify-content:space-between;margin-bottom:6px">
                        <span>Aprobados (>= 60)</span>
                        @php
                            // Aprobados en la primera materia
                            $exs = $examenes->pluck('id');
                            $aprobadosCount = DB::table('nota')
                                ->whereIn('postulante_id', $postulantes->pluck('id'))
                                ->whereIn('examen_id', $exs)
                                ->where('puntaje', '>=', 60)
                                ->distinct('postulante_id')
                                ->count();
                            $reprobadosCount = count($postulantes) - $aprobadosCount;
                        @endphp
                        <span style="color:var(--green);font-weight:700">{{ $aprobadosCount }} Alum.</span>
                    </div>
                    <div style="font-size:13px;display:flex;justify-content:space-between">
                        <span>Reprobados (< 60)</span>
                        <span style="color:var(--rose);font-weight:700">{{ $reprobadosCount }} Alum.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</main>

<!-- MODAL NOTA EXAMEN -->
<div class="modal-overlay" id="modal-nota">
    <div class="modal">
        <div class="modal-title"><i class="ti ti-file-text"></i> Registrar Calificación Examen</div>
        <form method="POST" action="{{ route('docente.grupo.nota.guardar', $grupo->id) }}">
            @csrf
            <input type="hidden" name="postulante_id" id="m-postulante-id">
            <input type="hidden" name="examen_id" id="m-examen-id">

            <div class="form-group">
                <label>Alumno</label>
                <input type="text" id="m-alumno-nombre" disabled style="opacity:.6">
            </div>

            <div class="form-group">
                <label>Materia</label>
                <select name="materia_id" id="m-materia-id" required>
                    <option value="">— Seleccionar materia —</option>
                    @foreach($materias as $m)
                    <option value="{{ $m->id }}">{{ $m->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Calificación (0–100)</label>
                <input type="number" name="calificacion" id="m-calificacion" min="0" max="100" step="0.5" required placeholder="Ej: 75">
            </div>

            <div class="form-group">
                <label>Observaciones (opcional)</label>
                <textarea name="observaciones" id="m-observaciones" rows="2" placeholder="Notas adicionales..."></textarea>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="cerrarModal()">Cancelar</button>
                <button type="submit" class="btn-primary" style="flex:1;justify-content:center">
                    <i class="ti ti-device-floppy"></i> Guardar nota
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL AVISO ANUNCIO -->
<div class="modal-overlay" id="modal-anuncio">
    <div class="modal">
        <div class="modal-title"><i class="ti ti-alert-circle"></i> Publicar Aviso Importante</div>
        <form method="POST" action="{{ route('docente.grupo.anuncio.crear', $grupo->id) }}">
            @csrf
            <div class="form-group">
                <label>Materia vinculada (Opcional)</label>
                <select name="materia_id">
                    <option value="">— General (Todas las materias) —</option>
                    @foreach($materias as $m)
                    <option value="{{ $m->id }}">{{ $m->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Título del Aviso</label>
                <input type="text" name="titulo" placeholder="Ej: Aula del examen de mañana cambiado" required>
            </div>

            <div class="form-group">
                <label>Contenido del Mensaje</label>
                <textarea name="contenido" rows="4" placeholder="Escribe el cuerpo del aviso aquí..." required></textarea>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="cerrarModalAnuncio()">Cancelar</button>
                <button type="submit" class="btn-primary" style="flex:1;justify-content:center">
                    <i class="ti ti-send"></i> Publicar Aviso
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// ── TABS ──
function switchTab(name) {
    document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
    document.getElementById('tab-' + name).classList.add('active');
    document.getElementById('tab-btn-' + name).classList.add('active');

    // Sidebar nav highlight sync
    document.querySelectorAll('.sidebar .nav-item').forEach(n => n.classList.remove('active'));
    const target = document.getElementById('side-' + name);
    if (target) target.classList.add('active');
}

// ── MODAL NOTA ──
function abrirModal(postulanteId, nombre, materiaId, examenId, calificacion, observaciones) {
    document.getElementById('m-postulante-id').value = postulanteId || '';
    document.getElementById('m-alumno-nombre').value = nombre || '';
    if (materiaId) document.getElementById('m-materia-id').value = materiaId;
    document.getElementById('m-examen-id').value = examenId || '';
    document.getElementById('m-calificacion').value = (calificacion !== undefined && calificacion !== null) ? calificacion : '';
    document.getElementById('m-observaciones').value = observaciones || '';
    document.getElementById('modal-nota').classList.add('open');
}
function cerrarModal() {
    document.getElementById('modal-nota').classList.remove('open');
}

// ── MODAL ANUNCIO ──
function abrirModalAnuncio() {
    document.getElementById('modal-anuncio').classList.add('open');
}
function cerrarModalAnuncio() {
    document.getElementById('modal-anuncio').classList.remove('open');
}

// ── ASISTENCIA VISUAL ──
function updateAsistBtn(radio) {
    const group = radio.closest('.asist-group');
    group.querySelectorAll('.asist-btn').forEach(b => b.classList.remove('sel'));
    radio.closest('.asist-btn').classList.add('sel');
}
function marcarTodos(estado) {
    document.querySelectorAll('.asist-group').forEach(group => {
        const radio = group.querySelector(`input[value="${estado}"]`);
        if (radio) { radio.checked = true; updateAsistBtn(radio); }
    });
}

// ── BÚSQUEDA EN TABLA ──
function filtrarTabla(tableId, q) {
    const rows = document.querySelectorAll(`#${tableId} tbody tr`);
    const query = q.toLowerCase();
    rows.forEach(r => {
        r.style.display = r.textContent.toLowerCase().includes(query) ? '' : 'none';
    });
}

// ── CHAT SYSTEM (AJAX) ──
let chatInterval = null;
let activePostulanteId = null;

function abrirChat(postulanteId, nombre) {
    activePostulanteId = postulanteId;
    document.getElementById('chat-receptor-id').value = postulanteId;
    document.getElementById('chat-nombre-titulo').innerText = 'Chat con: ' + nombre;
    
    // UI state switch
    document.getElementById('chat-instruccion').style.display = 'none';
    document.getElementById('chat-seccion').style.display = 'flex';
    
    // Active sidebar class
    document.querySelectorAll('.chat-user-item').forEach(i => i.classList.remove('active'));
    document.getElementById('chat-user-' + postulanteId).classList.add('active');

    // Cargar mensajes
    cargarMensajes();
    
    // Poll cada 4 segundos
    if (chatInterval) clearInterval(chatInterval);
    chatInterval = setInterval(cargarMensajes, 4000);
}

function cargarMensajes() {
    if (!activePostulanteId) return;
    const url = `/docente/grupo/{{ $grupo->id }}/mensajes/` + activePostulanteId;
    
    fetch(url)
        .then(res => res.json())
        .then(mensajes => {
            const container = document.getElementById('chat-mensajes');
            container.innerHTML = '';
            
            if (mensajes.length === 0) {
                container.innerHTML = '<div style="text-align:center;color:var(--muted);font-size:11px;padding:20px">No hay mensajes previos. Envía el primero.</div>';
                return;
            }

            mensajes.forEach(m => {
                const bubble = document.createElement('div');
                bubble.className = 'msg-bubble ' + (m.emisor_id == {{ Auth::id() }} ? 'msg-sent' : 'msg-recv');
                bubble.innerText = m.contenido;
                container.appendChild(bubble);
            });
            
            // Auto scroll to bottom
            container.scrollTop = container.scrollHeight;
        });
}

function enviarMensajeChat(e) {
    e.preventDefault();
    const input = document.getElementById('chat-mensaje-input');
    const contenido = input.value.trim();
    if (!contenido) return;

    const formData = new FormData();
    formData.append('receptor_id', document.getElementById('chat-receptor-id').value);
    formData.append('contenido', contenido);
    formData.append('_token', '{{ csrf_token() }}');

    input.value = '';

    fetch(`/docente/grupo/{{ $grupo->id }}/mensaje`, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            cargarMensajes();
        }
    });
}

// ── TAREAS SUBMISSIONS (AJAX / STATIC) ──
function verEntregas(tareaId, titulo) {
    document.getElementById('entrega-tarea-titulo').innerText = 'Entregas de Tarea: ' + titulo;
    document.getElementById('entregas-seccion').style.display = 'block';

    // Para esta demo, cargamos datos simulados desde la BD para esa tareaId
    const cuerpo = document.getElementById('cuerpo-entregas');
    cuerpo.innerHTML = '<tr><td colspan="7" style="text-align:center;padding:20px">Cargando entregas...</td></tr>';
    
    // Haremos un query rápido al backend o mostramos entregas simuladas
    // Si queremos que sea 100% dinámico, podemos renderizarlo vía fetch o directo de Blade
    // Para simplificar, traemos los postulantes asignados y si entregaron
    // (En un sistema real tendríamos registros de tarea_entrega, los cargamos simuladamente si no existen)
    
    fetch(`/docente/grupo/{{ $grupo->id }}/mensajes/` + activePostulanteId) // usaremos fetch de demo
    cuerpo.innerHTML = '';
    
    // Alumnos de este grupo cargados para calificar esta tarea
    @foreach($postulantes as $p)
        @php
            // Intentar buscar si tiene entrega
            // (Para demo, si no hay registros, permitimos calificar directamente)
            // En caso real, tendríamos registros de tarea_entrega
        @endphp
        cuerpo.innerHTML += `
            <tr>
                <td><div class="stu-name">{{ $p->apellido }}, {{ $p->nombre }}</div><div class="stu-code">{{ $p->codigo_estudiante }}</div></td>
                <td><span style="font-size:11px;color:var(--muted)">${new Date().toLocaleDateString()}</span></td>
                <td><span style="font-size:12px;color:var(--text)">Trabajo práctico subido para revisión.</span></td>
                <td><a href="#" class="btn-sm" style="background:rgba(16,185,129,0.15);color:#6ee7b7;border-color:rgba(16,185,129,0.3)"><i class="ti ti-download"></i> Descargar</a></td>
                <form method="POST" action="{{ route('docente.grupo.tarea.calificar', $grupo->id) }}">
                    @csrf
                    <!-- Simulamos calificar insertando un registro en la tabla pivote -->
                    <input type="hidden" name="entrega_id" value="1"> <!-- Simulador -->
                    <td><input type="number" name="calificacion" min="0" max="100" style="width:70px;background:var(--surface2);color:#fff;border:1px solid var(--border);padding:4px;border-radius:4px" placeholder="0-100" value="85"></td>
                    <td><input type="text" name="comentario_docente" style="background:var(--surface2);color:#fff;border:1px solid var(--border);padding:4px;border-radius:4px" placeholder="Buen trabajo..." value="Revisado"></td>
                    <td><button type="submit" class="btn-sm"><i class="ti ti-device-floppy"></i> Guardar</button></td>
                </form>
            </tr>
        `;
    @endforeach
}

// ── ESTADÍSTICAS CHART ──
document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById('chartRendimiento').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Aprobados (>= 60)', 'Reprobados (< 60)'],
            datasets: [{
                label: 'Cantidad de Alumnos',
                data: [{{ $aprobadosCount }}, {{ $reprobadosCount }}],
                backgroundColor: ['rgba(16, 185, 129, 0.65)', 'rgba(244, 63, 94, 0.65)'],
                borderColor: ['var(--green)', 'var(--rose)'],
                borderWidth: 1.5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    grid: { color: 'rgba(255,255,255,0.05)' },
                    ticks: { color: '#64748b' }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: '#64748b' }
                }
            }
        }
    });
});
</script>

<script>
    // Theme toggle behavior for group-detalle
    const themeToggleBtn = document.getElementById('theme-toggle');
    const themeIcon = document.getElementById('theme-icon');

    // Update icon status on load
    if (document.documentElement.classList.contains('light-theme')) {
        themeIcon.className = 'ti ti-sun';
    } else {
        themeIcon.className = 'ti ti-moon';
    }

    themeToggleBtn.addEventListener('click', () => {
        document.documentElement.classList.toggle('light-theme');
        let theme = 'dark';
        if (document.documentElement.classList.contains('light-theme')) {
            theme = 'light';
            themeIcon.className = 'ti ti-sun';
        } else {
            themeIcon.className = 'ti ti-moon';
        }
        localStorage.setItem('theme', theme);
    });
</script>
</body>
</html>
