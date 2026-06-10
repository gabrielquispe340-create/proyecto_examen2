<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exámenes — CUP FICCT</title>
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Figtree', sans-serif; background: #f1f5f9; color: #1e293b; }

        /* ── TOPBAR ── */
        .topbar { background: #1e3a6e; padding: 0 24px; height: 56px; display: flex; align-items: center; justify-content: space-between; position: fixed; top: 0; left: 0; right: 0; z-index: 200; }
        .topbar-brand { color: #fff; font-size: 16px; font-weight: 600; display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .topbar-brand i { font-size: 20px; }
        .topbar-right { display: flex; align-items: center; gap: 16px; }
        .topbar-user { color: #a8c8f0; font-size: 13px; display: flex; align-items: center; gap: 6px; }
        .btn-logout { background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.22); color: #fff; padding: 6px 14px; border-radius: 8px; font-size: 12px; cursor: pointer; text-decoration: none; display: flex; align-items: center; gap: 6px; font-family: 'Figtree', sans-serif; transition: background .2s; }
        .btn-logout:hover { background: rgba(255,255,255,0.22); }

        /* ── SIDEBAR ── */
        .sidebar { width: 224px; height: calc(100vh - 56px); background: #1e3a6e; position: fixed; top: 56px; left: 0; overflow-y: auto; padding: 20px 12px 24px; display: flex; flex-direction: column; gap: 2px; }
        .nav-label { font-size: 10px; font-weight: 700; color: rgba(168,200,240,0.55); text-transform: uppercase; letter-spacing: .1em; padding: 16px 10px 6px; }
        .nav-label:first-child { padding-top: 4px; }
        .nav-item { padding: 9px 12px; font-size: 13px; color: rgba(168,200,240,0.85); text-decoration: none; border-radius: 8px; display: flex; align-items: center; gap: 10px; transition: background .15s, color .15s; font-weight: 400; }
        .nav-item i { font-size: 16px; flex-shrink: 0; }
        .nav-item:hover { background: rgba(255,255,255,0.10); color: #fff; }
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
        .page { padding: 28px; }

        /* ── PAGE HEADER ── */
        .page-header { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 24px; }
        .page-title { font-size: 20px; font-weight: 600; color: #1e293b; }
        .page-sub { font-size: 13px; color: #94a3b8; margin-top: 3px; }
        .btn-primary { padding: 9px 18px; background: #1e3a6e; color: #fff; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; font-family: 'Figtree', sans-serif; display: inline-flex; align-items: center; gap: 7px; text-decoration: none; transition: background .15s; }
        .btn-primary:hover { background: #0f2147; }

        /* ── STAT CARDS ── */
        .stat-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 20px; }
        .stat-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 18px 20px; display: flex; align-items: center; gap: 16px; }
        .stat-icon { width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .stat-icon i { font-size: 22px; }
        .stat-icon.blue   { background: #dbeafe; } .stat-icon.blue i   { color: #2563eb; }
        .stat-icon.amber  { background: #fef3c7; } .stat-icon.amber i  { color: #d97706; }
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exámenes — CUP FICCT</title>
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Figtree', sans-serif; background: #f1f5f9; color: #1e293b; }

        /* ── TOPBAR ── */
        .topbar { background: #1e3a6e; padding: 0 24px; height: 56px; display: flex; align-items: center; justify-content: space-between; position: fixed; top: 0; left: 0; right: 0; z-index: 200; }
        .topbar-brand { color: #fff; font-size: 16px; font-weight: 600; display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .topbar-brand i { font-size: 20px; }
        .topbar-right { display: flex; align-items: center; gap: 16px; }
        .topbar-user { color: #a8c8f0; font-size: 13px; display: flex; align-items: center; gap: 6px; }
        .btn-logout { background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.22); color: #fff; padding: 6px 14px; border-radius: 8px; font-size: 12px; cursor: pointer; text-decoration: none; display: flex; align-items: center; gap: 6px; font-family: 'Figtree', sans-serif; transition: background .2s; }
        .btn-logout:hover { background: rgba(255,255,255,0.22); }

        /* ── SIDEBAR ── */
        .sidebar { width: 224px; height: calc(100vh - 56px); background: #1e3a6e; position: fixed; top: 56px; left: 0; overflow-y: auto; padding: 20px 12px 24px; display: flex; flex-direction: column; gap: 2px; }
        .nav-label { font-size: 10px; font-weight: 700; color: rgba(168,200,240,0.55); text-transform: uppercase; letter-spacing: .1em; padding: 16px 10px 6px; }
        .nav-label:first-child { padding-top: 4px; }
        .nav-item { padding: 9px 12px; font-size: 13px; color: rgba(168,200,240,0.85); text-decoration: none; border-radius: 8px; display: flex; align-items: center; gap: 10px; transition: background .15s, color .15s; font-weight: 400; }
        .nav-item i { font-size: 16px; flex-shrink: 0; }
        .nav-item:hover { background: rgba(255,255,255,0.10); color: #fff; }
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
        .page { padding: 28px; }

        /* ── PAGE HEADER ── */
        .page-header { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 24px; }
        .page-title { font-size: 20px; font-weight: 600; color: #1e293b; }
        .page-sub { font-size: 13px; color: #94a3b8; margin-top: 3px; }
        .btn-primary { padding: 9px 18px; background: #1e3a6e; color: #fff; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; font-family: 'Figtree', sans-serif; display: inline-flex; align-items: center; gap: 7px; text-decoration: none; transition: background .15s; }
        .btn-primary:hover { background: #0f2147; }

        /* ── STAT CARDS ── */
        .stat-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 20px; }
        .stat-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 18px 20px; display: flex; align-items: center; gap: 16px; }
        .stat-icon { width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .stat-icon i { font-size: 22px; }
        .stat-icon.blue   { background: #dbeafe; } .stat-icon.blue i   { color: #2563eb; }
        .stat-icon.amber  { background: #fef3c7; } .stat-icon.amber i  { color: #d97706; }
        .stat-icon.green  { background: #d1fae5; } .stat-icon.green i  { color: #059669; }
        .stat-icon.indigo { background: #e0e7ff; } .stat-icon.indigo i { color: #4f46e5; }
        .stat-num { font-size: 26px; font-weight: 700; color: #0f172a; line-height: 1; }
        .stat-label-main { font-size: 13px; color: #374151; font-weight: 500; margin-top: 2px; }
        .stat-label-sub  { font-size: 11px; color: #94a3b8; margin-top: 1px; }

        /* ── CONTENT GRID ── */
        .content-grid { display: grid; grid-template-columns: minmax(0, 1fr) 272px; gap: 20px; align-items: start; }

        /* ── CARD ── */
        .card { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; }
        .card-body { padding: 16px 20px; }

        /* ── FILTERS ── */
        .filter-row { display: grid; gap: 12px; align-items: end; margin-bottom: 12px; }
        .filter-row-1 { grid-template-columns: 1fr 140px 130px 160px; }
        .filter-row-2 { grid-template-columns: 160px 160px auto; margin-bottom: 0; }
        .field label { font-size: 11px; font-weight: 600; color: #475569; text-transform: uppercase; letter-spacing: .04em; display: block; margin-bottom: 5px; }
        .field input, .field select { padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; color: #1e293b; font-family: 'Figtree', sans-serif; background: #f8fafc; width: 100%; }
        .field input:focus, .field select:focus { outline: none; border-color: #1e3a6e; background: #fff; }
        .search-wrap { position: relative; }
        .search-wrap i { position: absolute; right: 10px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 16px; pointer-events: none; }
        .search-wrap input { padding-right: 34px; }
        .btn-ghost { padding: 8px 14px; background: transparent; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; color: #64748b; cursor: pointer; font-family: 'Figtree', sans-serif; display: inline-flex; align-items: center; gap: 6px; white-space: nowrap; height: 36px; }
        .btn-ghost:hover { background: #f8fafc; }

        /* ── TABS ── */
        .tabs { display: flex; border-bottom: 2px solid #f1f5f9; }
        .tab { padding: 10px 16px; font-size: 13px; font-weight: 500; color: #94a3b8; text-decoration: none; border-bottom: 2px solid transparent; margin-bottom: -2px; transition: color .15s, border-color .15s; }
        .tab:hover { color: #475569; }
        .tab.active { color: #1e3a6e; border-bottom-color: #1e3a6e; }

        /* ── TABLE ── */
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th { text-align: left; padding: 11px 16px; font-size: 11px; font-weight: 600; color: #94a3b8; background: #f8fafc; border-bottom: 1px solid #f1f5f9; text-transform: uppercase; letter-spacing: .04em; }
        td { padding: 13px 16px; border-bottom: 1px solid #f8fafc; color: #374151; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #fafafa; }
        .exam-name { font-weight: 600; font-size: 13px; color: #1e293b; }
        .exam-conv-active { font-size: 11px; color: #2563eb; margin-top: 2px; display: flex; align-items: center; gap: 3px; }
        .exam-conv-closed { font-size: 11px; color: #94a3b8; margin-top: 2px; display: flex; align-items: center; gap: 3px; }

        /* ── BADGES ── */
        .badge { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 99px; font-size: 11px; font-weight: 500; }
        .badge-programado  { background: #fef3c7; color: #92400e; }
        .badge-desarrollo  { background: #dbeafe; color: #1e40af; }
        .badge-finalizado  { background: #d1fae5; color: #065f46; }
        .badge-cancelado   { background: #fee2e2; color: #991b1b; }
        .badge-presencial  { background: #e0e7ff; color: #3730a3; }
        .badge-virtual     { background: #d1fae5; color: #065f46; }

        /* ── ACTIONS ── */
        .actions { display: flex; align-items: center; gap: 6px; }
        .btn-icon { width: 30px; height: 30px; border-radius: 7px; border: 1px solid #e2e8f0; background: #fff; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #64748b; font-size: 16px; transition: all .15s; text-decoration: none; }
        .btn-icon:hover { background: #f1f5f9; color: #374151; }
        .btn-dots { background: none; border: none; cursor: pointer; color: #94a3b8; padding: 4px; border-radius: 6px; font-size: 18px; display: flex; align-items: center; }
        .btn-dots:hover { background: #f1f5f9; color: #374151; }

        /* ── EMPTY STATE ── */
        .empty-state { text-align: center; padding: 56px 20px; color: #94a3b8; }
        .empty-state i { font-size: 40px; display: block; margin-bottom: 12px; color: #cbd5e1; }
        .empty-state p { font-size: 14px; font-weight: 500; color: #64748b; margin-bottom: 4px; }
        .empty-state span { font-size: 13px; }

        /* ── PAGINATION ── */
        .pagination { display: flex; align-items: center; justify-content: space-between; padding: 14px 16px; border-top: 1px solid #f1f5f9; font-size: 12px; color: #64748b; }
        .pag-btns { display: flex; gap: 4px; }
        .pag-btn { width: 30px; height: 30px; border-radius: 7px; border: 1px solid #e2e8f0; background: #fff; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #64748b; font-size: 13px; font-weight: 500; }
        .pag-btn.active { background: #1e3a6e; color: #fff; border-color: #1e3a6e; }
        .pag-btn:hover:not(.active) { background: #f1f5f9; }

        /* ── SIDE CARDS ── */
        .side-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 18px; margin-bottom: 16px; }
        .side-card-title { font-size: 13px; font-weight: 600; color: #0f172a; margin-bottom: 14px; }
        .quick-action { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: 8px; border: 1px solid #e2e8f0; margin-bottom: 8px; cursor: pointer; text-decoration: none; color: #374151; font-size: 13px; font-weight: 500; transition: background .15s; }
        .quick-action:last-child { margin-bottom: 0; }
        .quick-action:hover { background: #f8fafc; }
        .qa-icon { width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .qa-icon i { font-size: 16px; }
        .qa-icon.blue   { background: #dbeafe; } .qa-icon.blue i   { color: #2563eb; }
        .qa-icon.green  { background: #d1fae5; } .qa-icon.green i  { color: #059669; }
        .qa-icon.amber  { background: #fef3c7; } .qa-icon.amber i  { color: #d97706; }
        .qa-icon.slate  { background: #f1f5f9; } .qa-icon.slate i  { color: #475569; }

        /* ── DONUT ── */
        .chart-row { display: flex; align-items: center; gap: 16px; }
        .chart-wrap { position: relative; width: 100px; height: 100px; flex-shrink: 0; }
        .chart-legend { display: flex; flex-direction: column; gap: 7px; flex: 1; }
        .legend-item { display: flex; align-items: center; gap: 7px; font-size: 12px; color: #475569; }
        .legend-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
        .legend-val { margin-left: auto; font-weight: 600; color: #374151; font-size: 12px; white-space: nowrap; }

        /* ── UPCOMING ── */
        .upcoming-item { display: flex; gap: 12px; padding: 12px 0; border-bottom: 1px solid #f1f5f9; }
        .upcoming-item:last-child { border-bottom: none; padding-bottom: 0; }
        .upcoming-icon { width: 36px; height: 36px; border-radius: 9px; background: #dbeafe; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .upcoming-icon i { font-size: 18px; color: #2563eb; }
        .upcoming-name { font-size: 13px; font-weight: 600; color: #1e3a6e; margin-bottom: 3px; text-decoration: none; display: block; }
        .upcoming-meta { font-size: 11px; color: #64748b; display: flex; align-items: center; gap: 4px; margin-bottom: 2px; }
        .upcoming-meta i { font-size: 13px; }
        .upcoming-empty { font-size: 13px; color: #94a3b8; text-align: center; padding: 16px 0 8px; }
        .btn-calendar { width: 100%; padding: 9px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; color: #475569; cursor: pointer; font-family: 'Figtree', sans-serif; font-weight: 500; margin-top: 12px; display: block; text-align: center; text-decoration: none; transition: background .15s; }
        .btn-calendar:hover { background: #f1f5f9; }

        /* ── INSCRITOS ── */
        .inscritos { display: flex; align-items: center; gap: 5px; color: #475569; }
        .inscritos i { font-size: 14px; }

        /* ── ALERTS ── */
        .alert { padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; font-size: 13px; display: flex; align-items: center; gap: 8px; }
        .alert-ok  { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }
        .alert-err { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }

        /* ── MODALS ── */
        .modal-overlay { display:none; position:fixed; inset:0; background:rgba(15,23,42,0.45); z-index:1000; align-items:center; justify-content:center; }
        .modal-overlay.open { display:flex; }
        .modal { background:#fff; border-radius:14px; width:100%; max-width:520px; box-shadow:0 20px 60px rgba(0,0,0,.18); overflow:hidden; animation:modalIn .18s ease; }
        .modal-lg { max-width:640px; }
        @keyframes modalIn { from { opacity:0; transform:translateY(-12px); } to { opacity:1; transform:translateY(0); } }
        .modal-header { display:flex; align-items:center; justify-content:space-between; padding:18px 22px; border-bottom:1px solid #f1f5f9; }
        .modal-title { font-size:15px; font-weight:600; color:#0f172a; display:flex; align-items:center; gap:9px; }
        .modal-title i { font-size:18px; }
        .modal-body { padding:22px; }
        .modal-footer { padding:14px 22px; border-top:1px solid #f1f5f9; display:flex; justify-content:flex-end; gap:10px; }
        .btn-close-modal { width:30px; height:30px; border:none; background:#f1f5f9; border-radius:7px; cursor:pointer; display:flex; align-items:center; justify-content:center; color:#64748b; font-size:18px; }
        .btn-close-modal:hover { background:#e2e8f0; }
        .btn-cancel { padding:9px 18px; background:#f1f5f9; border:1px solid #e2e8f0; border-radius:8px; font-size:13px; color:#475569; cursor:pointer; font-family:'Figtree',sans-serif; font-weight:500; }
        .btn-cancel:hover { background:#e2e8f0; }
        .btn-submit { padding:9px 20px; background:#1e3a6e; color:#fff; border:none; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer; font-family:'Figtree',sans-serif; display:inline-flex; align-items:center; gap:7px; }
        .btn-submit:hover { background:#0f2147; }
        .btn-submit.green { background:#059669; }
        .btn-submit.green:hover { background:#047857; }
        .btn-submit.amber { background:#d97706; }
        .btn-submit.amber:hover { background:#b45309; }
        .form-group { margin-bottom:16px; }
        .form-group label { font-size:11px; font-weight:600; color:#475569; text-transform:uppercase; letter-spacing:.04em; display:block; margin-bottom:5px; }
        .form-group input, .form-group select, .form-group textarea { width:100%; padding:9px 12px; border:1px solid #e2e8f0; border-radius:8px; font-size:13px; color:#1e293b; font-family:'Figtree',sans-serif; background:#f8fafc; }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus { outline:none; border-color:#1e3a6e; background:#fff; }
        .form-row { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
        .upload-area { border:2px dashed #e2e8f0; border-radius:10px; padding:28px; text-align:center; cursor:pointer; transition:border-color .15s, background .15s; }
        .upload-area:hover, .upload-area.drag { border-color:#1e3a6e; background:#f8fafc; }
        .upload-area i { font-size:32px; color:#94a3b8; display:block; margin-bottom:8px; }
        .upload-area p { font-size:13px; color:#475569; font-weight:500; }
        .upload-area span { font-size:12px; color:#94a3b8; }
        .upload-area input[type=file] { display:none; }
        .file-selected { display:none; align-items:center; gap:10px; padding:10px 14px; background:#f0fdf4; border:1px solid #6ee7b7; border-radius:8px; margin-top:12px; font-size:13px; color:#065f46; }
        .file-selected i { font-size:18px; }
        .reporte-info { background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:16px; margin-bottom:16px; }
        .reporte-info p { font-size:13px; color:#475569; line-height:1.6; }
        .reporte-row { display:flex; align-items:center; gap:10px; padding:8px 0; border-bottom:1px solid #f1f5f9; font-size:13px; color:#374151; }
        .reporte-row:last-child { border-bottom:none; padding-bottom:0; }
        .reporte-row i { font-size:16px; color:#1e3a6e; }

        /* Responsive Styles */
        @media (max-width: 1200px) {
            .content-grid { grid-template-columns: 1fr; }
            .stat-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 640px) {
            .stat-grid { grid-template-columns: 1fr; }
            .filter-row-1 { grid-template-columns: 1fr; }
            .filter-row-2 { grid-template-columns: 1fr; }
        }
    
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

{{-- ── TOPBAR ── --}}
<div class="topbar">
    <button type="button" class="btn-menu-mobile" onclick="document.querySelector('.sidebar').classList.toggle('open'); document.getElementById('sidebar-overlay-mobile').classList.toggle('show');">&#9776;</button>
    <a href="{{ route('admin.dashboard') }}" class="topbar-brand">
        <i class="ti ti-school"></i> CUP — FICCT
    </a>
    <div class="topbar-right">
        <span class="topbar-user">
            <i class="ti ti-user-circle"></i>
            {{ Auth::user()->nombre }} {{ Auth::user()->apellido }}
        </span>
        <form method="POST" action="{{ route('logout') }}" style="display:inline">
            @csrf
            <button type="submit" class="btn-logout"><i class="ti ti-logout"></i> Salir</button>
        </form>
    </div>
</div>

{{-- ── SIDEBAR ── --}}
@include('admin.partials.sidebar')

{{-- ── MAIN ── --}}
<main class="main">
<div class="page">

    @if(session('success'))
        <div class="alert alert-ok"><i class="ti ti-circle-check"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-err"><i class="ti ti-alert-circle"></i> {{ session('error') }}</div>
    @endif

    {{-- PAGE HEADER --}}
    <div class="page-header">
        <div>
            <div class="page-title">Exámenes</div>
            <div class="page-sub">Gestiona los exámenes de admisión, revisa resultados y exporta reportes.</div>
        </div>
        <button onclick="abrirModal('modalNuevoExamen')" class="btn-primary"><i class="ti ti-plus"></i> Nuevo examen</button>
    </div>

    {{-- STAT CARDS --}}
    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-icon blue"><i class="ti ti-file-description"></i></div>
            <div>
                <div class="stat-num">{{ $totalExamenes ?? 0 }}</div>
                <div class="stat-label-main">Total de exámenes</div>
                <div class="stat-label-sub">En el sistema</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon amber"><i class="ti ti-clock"></i></div>
            <div>
                <div class="stat-num">{{ $programados ?? 0 }}</div>
                <div class="stat-label-main">Programados</div>
                <div class="stat-label-sub">Próximos exámenes</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green"><i class="ti ti-circle-check"></i></div>
            <div>
                <div class="stat-num">{{ $finalizados ?? 0 }}</div>
                <div class="stat-label-main">Finalizados</div>
                <div class="stat-label-sub">Exámenes realizados</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon indigo"><i class="ti ti-users"></i></div>
            <div>
                <div class="stat-num">{{ number_format($totalInscritos ?? 0) }}</div>
                <div class="stat-label-main">Total de inscritos</div>
                <div class="stat-label-sub">En todos los exámenes</div>
            </div>
        </div>
    </div>

    {{-- CONTENT GRID --}}
    <div class="content-grid">

        {{-- ── LEFT ── --}}
        <div>
            <div class="card">
                {{-- FILTERS --}}
                <div class="card-body" style="border-bottom: 1px solid #f1f5f9;">
                    <form method="GET" action="{{ route('admin.examenes.index') }}">
                        <div class="filter-row filter-row-1">
                            <div class="field">
                                <label>Buscar</label>
                                <div class="search-wrap">
                                    <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar examen...">
                                    <i class="ti ti-search"></i>
                                </div>
                            </div>
                            <div class="field">
                                <label>Estado</label>
                                <select name="estado">
                                    <option value="">Todos</option>
                                    <option value="PROGRAMADO" {{ request('estado')=='PROGRAMADO' ? 'selected' : '' }}>Programado</option>
                                    <option value="EN_DESARROLLO" {{ request('estado')=='EN_DESARROLLO' ? 'selected' : '' }}>En desarrollo</option>
                                    <option value="FINALIZADO" {{ request('estado')=='FINALIZADO' ? 'selected' : '' }}>Finalizado</option>
                                    <option value="CANCELADO" {{ request('estado')=='CANCELADO' ? 'selected' : '' }}>Cancelado</option>
                                </select>
                            </div>
                            <div class="field">
                                <label>Tipo</label>
                                <select name="tipo">
                                    <option value="">Todos</option>
                                    <option value="PRESENCIAL" {{ request('tipo')=='PRESENCIAL' ? 'selected' : '' }}>Presencial</option>
                                    <option value="VIRTUAL" {{ request('tipo')=='VIRTUAL' ? 'selected' : '' }}>Virtual</option>
                                </select>
                            </div>
                            <div class="field">
                                <label>Convocatoria</label>
                                <select name="convocatoria_id">
                                    <option value="">Todos</option>
                                    @foreach($convocatorias ?? [] as $conv)
                                        <option value="{{ $conv->id }}" {{ request('convocatoria_id')==$conv->id ? 'selected' : '' }}>{{ $conv->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="filter-row filter-row-2">
                            <div class="field">
                                <label>Fecha desde</label>
                                <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}">
                            </div>
                            <div class="field">
                                <label>Fecha hasta</label>
                                <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}">
                            </div>
                            <div style="display:flex; gap:8px; align-items:flex-end;">
                                <button type="submit" class="btn-ghost"><i class="ti ti-filter"></i> Filtrar</button>
                                <a href="{{ route('admin.examenes.index') }}" class="btn-ghost"><i class="ti ti-refresh"></i> Limpiar</a>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- TABS --}}
                <div style="padding: 0 20px;">
                    <div class="tabs">
                        <a href="{{ route('admin.examenes.index') }}" class="tab {{ !request('tab') ? 'active' : '' }}">Todos</a>
                        <a href="{{ route('admin.examenes.index', ['tab'=>'programados']) }}" class="tab {{ request('tab')=='programados' ? 'active' : '' }}">Programados</a>
                        <a href="{{ route('admin.examenes.index', ['tab'=>'desarrollo']) }}" class="tab {{ request('tab')=='desarrollo' ? 'active' : '' }}">En desarrollo</a>
                        <a href="{{ route('admin.examenes.index', ['tab'=>'finalizados']) }}" class="tab {{ request('tab')=='finalizados' ? 'active' : '' }}">Finalizados</a>
                        <a href="{{ route('admin.examenes.index', ['tab'=>'cancelados']) }}" class="tab {{ request('tab')=='cancelados' ? 'active' : '' }}">Cancelados</a>
                    </div>
                </div>

                {{-- TABLE --}}
                @if(isset($examenes) && $examenes->count() > 0)
                <div style="overflow-x: auto; width: 100%; -webkit-overflow-scrolling: touch; border-radius: 8px;">
                <div class="table-responsive"><table style="min-width: 800px; width: 100%;">
                    <thead>
                        <tr>
                            <th>Examen</th>
                            <th>Convocatoria</th>
                            <th>Fecha</th>
                            <th>Tipo</th>
                            <th>Inscritos</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($examenes as $examen)
                        <tr>
                            <td>
                                <div class="exam-name">{{ $examen->nombre }}</div>
                                @if($examen->convocatoria && $examen->convocatoria->estado === 'ACTIVA')
                                    <div class="exam-conv-active"><i class="ti ti-circle-dot" style="font-size:11px"></i> Convocatoria Activa</div>
                                @else
                                    <div class="exam-conv-closed"><i class="ti ti-circle" style="font-size:11px"></i> Convocatoria Cerrada</div>
                                @endif
                            </td>
                            <td>{{ $examen->convocatoria->nombre ?? '—' }}</td>
                            <td style="color:#475569;">
                                {{ $examen->fecha ? \Carbon\Carbon::parse($examen->fecha)->format('d/m/Y') : '—' }}
                                <br><span style="color:#94a3b8;font-size:11px;">{{ $examen->hora ?? '09:00' }}</span>
                            </td>
                            <td>
                                <span class="badge {{ $examen->tipo === 'VIRTUAL' ? 'badge-virtual' : 'badge-presencial' }}">
                                    {{ ucfirst(strtolower($examen->tipo ?? 'Presencial')) }}
                                </span>
                            </td>
                            <td>
                                <div class="inscritos"><i class="ti ti-users"></i> {{ $examen->inscritos ?? 0 }}</div>
                            </td>
                            <td>
                                @php $est = $examen->estado ?? 'PROGRAMADO'; @endphp
                                <span class="badge
                                    {{ $est === 'PROGRAMADO'    ? 'badge-programado'  : '' }}
                                    {{ $est === 'EN_DESARROLLO' ? 'badge-desarrollo'  : '' }}
                                    {{ $est === 'FINALIZADO'    ? 'badge-finalizado'  : '' }}
                                    {{ $est === 'CANCELADO'     ? 'badge-cancelado'   : '' }}">
                                    {{ ucfirst(strtolower(str_replace('_',' ',$est))) }}
                                </span>
                            </td>
                            <td>
                                <div class="actions">
                                    <button class="btn-icon" title="Ver detalles" onclick="verDetallesExamen({
                                        nombre: '{{ addslashes($examen->nombre) }}',
                                        convocatoria: '{{ addslashes($examen->convocatoria->nombre ?? '—') }}',
                                        fecha: '{{ $examen->fecha ? \Carbon\Carbon::parse($examen->fecha)->format('d/m/Y') : '—' }}',
                                        hora: '{{ $examen->hora ?? '09:00' }}',
                                        tipo: '{{ ucfirst(strtolower($examen->tipo ?? 'Presencial')) }}',
                                        estado: '{{ ucfirst(strtolower(str_replace('_',' ',$examen->estado ?? 'PROGRAMADO'))) }}',
                                        inscritos: {{ $examen->inscritos ?? 0 }},
                                        total_notas: {{ $examen->total_notas ?? 0 }},
                                        aprobados: {{ $examen->aprobados ?? 0 }},
                                        reprobados: {{ $examen->reprobados ?? 0 }},
                                        promedio: '{{ $examen->promedio ?? '0.00' }}'
                                    })">
                                        <i class="ti ti-eye"></i>
                                    </button>
                                    <button class="btn-icon" title="Editar" onclick="abrirModalEditar({{ $examen->id }}, '{{ $examen->fecha ? \Carbon\Carbon::parse($examen->fecha)->format('Y-m-d') : '' }}', '{{ $examen->hora ?? '09:00' }}', '{{ $examen->tipo ?? 'PRESENCIAL' }}')">
                                        <i class="ti ti-edit"></i>
                                    </button>
                                    @if($examen->estado !== 'FINALIZADO' && $examen->estado !== 'CANCELADO')
                                        <form method="POST" action="{{ route('admin.examenes.update', $examen->id) }}" style="display:inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="estado" value="FINALIZADO">
                                            <button type="submit" class="btn-icon" title="Finalizar examen" style="border-color:#86efac;color:#16a34a;" onclick="return confirm('¿Estás seguro de que deseas FINALIZAR este examen? Esto bloqueará cambios adicionales.')">
                                                <i class="ti ti-checkbox"></i>
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.examenes.update', $examen->id) }}" style="display:inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="estado" value="CANCELADO">
                                            <button type="submit" class="btn-icon" title="Cancelar examen" style="border-color:#fca5a5;color:#dc2626;" onclick="return confirm('¿Estás seguro de que deseas CANCELAR este examen?')">
                                                <i class="ti ti-ban"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.examenes.update', $examen->id) }}" style="display:inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="estado" value="PROGRAMADO">
                                            <button type="submit" class="btn-icon" title="Reabrir / Reactivar examen" style="border-color:#fed7aa;color:#ea580c;" onclick="return confirm('¿Estás seguro de que deseas REABRIR este examen?')">
                                                <i class="ti ti-arrow-back-up"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <button class="btn-icon" title="Eliminar examen"
                                        style="border-color:#fca5a5;color:#dc2626;"
                                        onclick="confirmarEliminarExamen({{ $examen->id }}, '{{ addslashes($examen->nombre) }}')">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table></div>
                </div>

                {{-- PAGINATION --}}
                <div class="pagination">
                    <span>Mostrando {{ $examenes->firstItem() }} a {{ $examenes->lastItem() }} de {{ $examenes->total() }} exámenes</span>
                    <div class="pag-btns">
                        @if($examenes->onFirstPage())
                            <button class="pag-btn" disabled><i class="ti ti-chevron-left" style="font-size:14px"></i></button>
                        @else
                            <a href="{{ $examenes->previousPageUrl() }}" class="pag-btn"><i class="ti ti-chevron-left" style="font-size:14px"></i></a>
                        @endif
                        @for($i = 1; $i <= $examenes->lastPage(); $i++)
                            <a href="{{ $examenes->url($i) }}" class="pag-btn {{ $examenes->currentPage() == $i ? 'active' : '' }}">{{ $i }}</a>
                        @endfor
                        @if($examenes->hasMorePages())
                            <a href="{{ $examenes->nextPageUrl() }}" class="pag-btn"><i class="ti ti-chevron-right" style="font-size:14px"></i></a>
                        @else
                            <button class="pag-btn" disabled><i class="ti ti-chevron-right" style="font-size:14px"></i></button>
                        @endif
                    </div>
                </div>

                @else
                {{-- EMPTY STATE --}}
                <div class="empty-state">
                    <i class="ti ti-file-off"></i>
                    <p>No hay exámenes registrados</p>
                    <span>Crea el primer examen usando el botón "Nuevo examen"</span>
                </div>
                <div class="pagination">
                    <span>Mostrando 0 exámenes</span>
                    <div class="pag-btns">
                        <button class="pag-btn" disabled><i class="ti ti-chevron-left" style="font-size:14px"></i></button>
                        <button class="pag-btn active">1</button>
                        <button class="pag-btn" disabled><i class="ti ti-chevron-right" style="font-size:14px"></i></button>
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- ── RIGHT ── --}}
        <div>
            {{-- Acciones rápidas --}}
            <div class="side-card">
                <div class="side-card-title">Acciones rápidas</div>
                <button onclick="abrirModal('modalNuevoExamen')" class="quick-action" style="width:100%;text-align:left;background:none;font-family:'Figtree',sans-serif;">
                    <div class="qa-icon blue"><i class="ti ti-plus"></i></div>
                    Nuevo examen
                </button>
                <button onclick="abrirModal('modalImportar')" class="quick-action" style="width:100%;text-align:left;background:none;font-family:'Figtree',sans-serif;">
                    <div class="qa-icon green"><i class="ti ti-upload"></i></div>
                    Importar resultados
                </button>
                <button onclick="abrirModal('modalReporte')" class="quick-action" style="width:100%;text-align:left;background:none;font-family:'Figtree',sans-serif;">
                    <div class="qa-icon amber"><i class="ti ti-report"></i></div>
                    Generar reporte general
                </button>
                <button onclick="descargarPlantilla()" class="quick-action" style="width:100%;text-align:left;background:none;font-family:'Figtree',sans-serif;">
                    <div class="qa-icon slate"><i class="ti ti-file-spreadsheet"></i></div>
                    Plantilla de resultados
                </button>
            </div>

            {{-- Resumen de exámenes --}}
            <div class="side-card">
                <div class="side-card-title">Resumen de exámenes</div>
                <div class="chart-row">
                    <div class="chart-wrap">
                        <canvas id="donutChart"></canvas>
                    </div>
                    <div class="chart-legend">
                        <div class="legend-item">
                            <div class="legend-dot" style="background:#f59e0b;"></div>
                            Programados
                            <span class="legend-val">{{ $programados ?? 0 }} ({{ $totalExamenes > 0 ? round(($programados/$totalExamenes)*100) : 0 }}%)</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-dot" style="background:#10b981;"></div>
                            Finalizados
                            <span class="legend-val">{{ $finalizados ?? 0 }} ({{ $totalExamenes > 0 ? round(($finalizados/$totalExamenes)*100) : 0 }}%)</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-dot" style="background:#ef4444;"></div>
                            Cancelados
                            <span class="legend-val">{{ $cancelados ?? 0 }} ({{ $totalExamenes > 0 ? round(($cancelados/$totalExamenes)*100) : 0 }}%)</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Próximos exámenes --}}
            <div class="side-card">
                <div class="side-card-title">Próximos exámenes</div>
                @forelse($proximos ?? [] as $prox)
                <div class="upcoming-item">
                    <div class="upcoming-icon"><i class="ti ti-calendar-event"></i></div>
                    <div>
                        <a href="#" class="upcoming-name">{{ $prox->nombre }}</a>
                        <div class="upcoming-meta"><i class="ti ti-calendar"></i> {{ \Carbon\Carbon::parse($prox->fecha)->format('d/m/Y') }} - {{ $prox->hora ?? '09:00' }}</div>
                        <div class="upcoming-meta"><i class="ti ti-users"></i> {{ $prox->inscritos ?? 0 }} inscritos</div>
                    </div>
                </div>
                @empty
                <div class="upcoming-empty">No hay exámenes próximos</div>
                @endforelse
                <a href="#" class="btn-calendar">Ver calendario completo</a>
            </div>
        </div>

    </div>
</div>
</main>


{{-- ════════════════════════════════════════
     MODAL 1: NUEVO EXAMEN
════════════════════════════════════════ --}}
<div id="modalNuevoExamen" class="modal-overlay">
    <div class="modal modal-lg">
        <div class="modal-header">
            <div class="modal-title"><i class="ti ti-file-plus" style="color:#1e3a6e"></i> Nuevo examen</div>
            <button class="btn-close-modal" onclick="cerrarModal('modalNuevoExamen')"><i class="ti ti-x"></i></button>
        </div>
        <form method="POST" action="{{ route('admin.examenes.store') }}">
            @csrf
            <div class="modal-body">

                {{-- Errores de validación --}}
                @if($errors->any())
                <div style="background:#fee2e2;border:1px solid #fca5a5;border-radius:8px;padding:12px 14px;margin-bottom:14px;">
                    <ul style="margin:0;padding-left:16px;font-size:13px;color:#991b1b;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- Fila 1: Convocatoria + Materia --}}
                <div class="form-row">
                    <div class="form-group">
                        <label>Convocatoria *</label>
                        <select name="convocatoria_id" required>
                            <option value="">Seleccionar...</option>
                            @foreach($convocatorias ?? [] as $conv)
                                <option value="{{ $conv->id }}" {{ old('convocatoria_id') == $conv->id ? 'selected' : '' }}>
                                    {{ $conv->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Materia *</label>
                        <select name="materia_id" required>
                            <option value="">Seleccionar...</option>
                            @foreach($materias ?? [] as $mat)
                                <option value="{{ $mat->id }}" {{ old('materia_id') == $mat->id ? 'selected' : '' }}>
                                    {{ $mat->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Fila 2: N° examen + Fecha --}}
                <div class="form-row">
                    <div class="form-group">
                        <label>N° de examen *</label>
                        <select name="nro_examen" required>
                            <option value="">Seleccionar...</option>
                            <option value="1" {{ old('nro_examen') == '1' ? 'selected' : '' }}>Examen 1 — 30%</option>
                            <option value="2" {{ old('nro_examen') == '2' ? 'selected' : '' }}>Examen 2 — 30%</option>
                            <option value="3" {{ old('nro_examen') == '3' ? 'selected' : '' }}>Examen 3 — 40%</option>
                        </select>
                        <span style="font-size:11px;color:#94a3b8;margin-top:4px;display:block;">
                            El peso se asigna automáticamente (30-30-40)
                        </span>
                    </div>
                    <div class="form-group" style="margin-bottom:0">
                        <label>Fecha del examen</label>
                        <input type="date" name="fecha" value="{{ old('fecha') }}">
                        <span style="font-size:11px;color:#94a3b8;margin-top:4px;display:block;">Opcional — puede asignarse después</span>
                    </div>
                </div>

                {{-- Info peso --}}
                <div style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:8px;padding:10px 14px;font-size:12px;color:#1e40af;display:flex;align-items:center;gap:8px;margin-bottom:0;">
                    <i class="ti ti-info-circle" style="font-size:16px;flex-shrink:0;"></i>
                    Cada materia tiene 3 exámenes. No puede haber dos exámenes del mismo número para la misma materia y convocatoria.
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="cerrarModal('modalNuevoExamen')">Cancelar</button>
                <button type="submit" class="btn-submit"><i class="ti ti-device-floppy"></i> Crear examen</button>
            </div>
        </form>
    </div>
</div>

{{-- ════════════════════════════════════════
     MODAL 2: IMPORTAR RESULTADOS
════════════════════════════════════════ --}}
<div id="modalImportar" class="modal-overlay">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title"><i class="ti ti-upload" style="color:#059669"></i> Importar resultados</div>
            <button class="btn-close-modal" onclick="cerrarModal('modalImportar')"><i class="ti ti-x"></i></button>
        </div>
        <form method="POST" action="{{ route('admin.examenes.importar') }}" enctype="multipart/form-data" id="formImportar">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Examen destino *</label>
                    <select name="examen_id" required>
                        <option value="">Seleccionar examen...</option>
                        @if(isset($examenes))
                            @foreach($examenes as $ex)
                                <option value="{{ $ex->id }}">{{ $ex->nombre }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group" style="margin-bottom:0">
                    <label>Archivo CSV *</label>
                    <div class="upload-area" id="dropZone" onclick="document.getElementById('archivoCSV').click()"
                         ondragover="event.preventDefault();this.classList.add('drag')"
                         ondragleave="this.classList.remove('drag')"
                         ondrop="handleDrop(event)">
                        <i class="ti ti-file-type-csv"></i>
                        <p>Haz clic o arrastra tu archivo CSV aquí</p>
                        <span>Solo archivos .csv — máx. 5MB</span>
                        <input type="file" id="archivoCSV" name="archivo" accept=".csv" onchange="mostrarArchivo(this)">
                    </div>
                    <div class="file-selected" id="fileSelected">
                        <i class="ti ti-file-check"></i>
                        <span id="fileName">archivo.csv</span>
                    </div>
                </div>
                <p style="font-size:11px;color:#94a3b8;margin-top:10px;">
                    <i class="ti ti-info-circle" style="font-size:13px;vertical-align:middle;"></i>
                    El CSV debe tener columnas: <strong>codigo_estudiante, puntaje</strong>.
                    Descarga la plantilla si no la tienes.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="cerrarModal('modalImportar')">Cancelar</button>
                <button type="submit" class="btn-submit green"><i class="ti ti-upload"></i> Importar</button>
            </div>
        </form>
    </div>
</div>

{{-- ════════════════════════════════════════
     MODAL 3: EDITAR EXAMEN
════════════════════════════════════════ --}}
<div id="modalEditarExamen" class="modal-overlay">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title"><i class="ti ti-edit" style="color:#2563eb"></i> Editar examen</div>
            <button class="btn-close-modal" onclick="cerrarModal('modalEditarExamen')"><i class="ti ti-x"></i></button>
        </div>
        <form method="POST" id="formEditarExamen">
            @csrf
            @method('PATCH')
            <div class="modal-body">
                <div class="form-group">
                    <label>Fecha del examen</label>
                    <input type="date" name="fecha" id="editFecha" />
                </div>
                <div class="form-group">
                    <label>Hora del examen</label>
                    <input type="time" name="hora" id="editHora" />
                </div>
                <div class="form-group">
                    <label>Tipo de examen</label>
                    <select name="tipo" id="editTipo">
                        <option value="PRESENCIAL">Presencial</option>
                        <option value="VIRTUAL">Virtual</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="cerrarModal('modalEditarExamen')">Cancelar</button>
                <button type="submit" class="btn-submit blue"><i class="ti ti-check"></i> Guardar cambios</button>
            </div>
        </form>
    </div>
</div>

{{-- ════════════════════════════════════════
     MODAL 4: GENERAR REPORTE GENERAL
════════════════════════════════════════ --}}
<div id="modalReporte" class="modal-overlay">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title"><i class="ti ti-report" style="color:#d97706"></i> Generar reporte general</div>
            <button class="btn-close-modal" onclick="cerrarModal('modalReporte')"><i class="ti ti-x"></i></button>
        </div>
        <form method="GET" action="{{ route('admin.examenes.reporte') }}" target="_blank">
            <div class="modal-body">
                <div class="reporte-info">
                    <p>El reporte incluirá un resumen completo de todos los exámenes:</p>
                </div>
                <div class="reporte-row"><i class="ti ti-circle-check"></i> Lista de exámenes con fechas y estados</div>
                <div class="reporte-row"><i class="ti ti-circle-check"></i> Total de inscritos por examen</div>
                <div class="reporte-row"><i class="ti ti-circle-check"></i> Promedios y estadísticas por materia</div>
                <div class="reporte-row"><i class="ti ti-circle-check"></i> Porcentaje de aprobación general</div>
                <div class="form-row" style="margin-top:16px;">
                    <div class="form-group" style="margin-bottom:0">
                        <label>Convocatoria</label>
                        <select name="convocatoria_id">
                            <option value="">Todas</option>
                            @foreach($convocatorias ?? [] as $conv)
                                <option value="{{ $conv->id }}">{{ $conv->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" style="margin-bottom:0">
                        <label>Formato</label>
                        <select name="formato">
                            <option value="pdf">PDF</option>
                            <option value="excel">Excel (.xlsx)</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="cerrarModal('modalReporte')">Cancelar</button>
                <button type="submit" class="btn-submit amber"><i class="ti ti-download"></i> Generar y descargar</button>
            </div>
        </form>
    </div>
</div>

{{-- ════════════════════════════════════════
     MODAL 5: DETALLES DE EXAMEN
     ════════════════════════════════════════ --}}
<div id="modalVerExamen" class="modal-overlay">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title"><i class="ti ti-file-analytics" style="color:#1e3a6e"></i> Detalles del examen</div>
            <button class="btn-close-modal" onclick="cerrarModal('modalVerExamen')"><i class="ti ti-x"></i></button>
        </div>
        <div class="modal-body">
            <div style="text-align: center; margin-bottom: 20px;">
                <h3 id="detNombre" style="font-size: 18px; font-weight: 700; color: #0f172a; margin-bottom: 4px;"></h3>
                <span id="detConvocatoria" style="font-size: 13px; color: #64748b;"></span>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 20px;">
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 12px; border-radius: 10px;">
                    <div style="font-size: 11px; font-weight: 600; color: #94a3b8; text-transform: uppercase; margin-bottom: 4px;">Fecha y Hora</div>
                    <div id="detFechaHora" style="font-size: 13px; font-weight: 600; color: #334155;"></div>
                </div>
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 12px; border-radius: 10px;">
                    <div style="font-size: 11px; font-weight: 600; color: #94a3b8; text-transform: uppercase; margin-bottom: 4px;">Tipo y Estado</div>
                    <div style="display: flex; gap: 6px; align-items: center; margin-top: 4px;">
                        <span id="detTipo" class="badge"></span>
                        <span id="detEstado" class="badge"></span>
                    </div>
                </div>
            </div>

            <div style="border-top: 1px solid #f1f5f9; padding-top: 16px;">
                <h4 style="font-size: 12px; font-weight: 600; color: #475569; text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 12px;">Resultados y Estadísticas</h4>
                
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-bottom: 16px;">
                    <div style="text-align: center; padding: 10px; background: #eff6ff; border-radius: 8px; border: 1px solid #bfdbfe;">
                        <span style="font-size: 11px; color: #1e40af; font-weight: 500;">Calificados</span>
                        <div id="detCalificados" style="font-size: 18px; font-weight: 700; color: #1d4ed8; margin-top: 2px;">0</div>
                    </div>
                    <div style="text-align: center; padding: 10px; background: #ecfdf5; border-radius: 8px; border: 1px solid #a7f3d0;">
                        <span style="font-size: 11px; color: #065f46; font-weight: 500;">Inscritos</span>
                        <div id="detInscritos" style="font-size: 18px; font-weight: 700; color: #047857; margin-top: 2px;">0</div>
                    </div>
                    <div style="text-align: center; padding: 10px; background: #fef3c7; border-radius: 8px; border: 1px solid #fde68a;">
                        <span style="font-size: 11px; color: #92400e; font-weight: 500;">Promedio</span>
                        <div id="detPromedio" style="font-size: 18px; font-weight: 700; color: #b45309; margin-top: 2px;">0.00</div>
                    </div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <!-- Aprobados -->
                    <div>
                        <div style="display: flex; justify-content: space-between; font-size: 12px; margin-bottom: 4px;">
                            <span style="font-weight: 500; color: #1e293b; display: flex; align-items: center; gap: 6px;">
                                <span style="width: 8px; height: 8px; border-radius: 50%; background: #10b981;"></span>
                                Aprobados (>= 60)
                            </span>
                            <span id="detAprobadosTxt" style="font-weight: 600; color: #047857;">0 (0%)</span>
                        </div>
                        <div style="width: 100%; height: 8px; background: #e2e8f0; border-radius: 99px; overflow: hidden;">
                            <div id="detAprobadosBar" style="height: 100%; background: #10b981; width: 0%; transition: width 0.3s;"></div>
                        </div>
                    </div>

                    <!-- Reprobados -->
                    <div>
                        <div style="display: flex; justify-content: space-between; font-size: 12px; margin-bottom: 4px;">
                            <span style="font-weight: 500; color: #1e293b; display: flex; align-items: center; gap: 6px;">
                                <span style="width: 8px; height: 8px; border-radius: 50%; background: #ef4444;"></span>
                                Reprobados (< 60)
                            </span>
                            <span id="detReprobadosTxt" style="font-weight: 600; color: #b91c1c;">0 (0%)</span>
                        </div>
                        <div style="width: 100%; height: 8px; background: #e2e8f0; border-radius: 99px; overflow: hidden;">
                            <div id="detReprobadosBar" style="height: 100%; background: #ef4444; width: 0%; transition: width 0.3s;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-cancel" onclick="cerrarModal('modalVerExamen')">Cerrar</button>
        </div>
    </div>
</div>

{{-- FORM OCULTO ÚNICO PARA ELIMINAR --}}
<form id="form-eliminar-examen" method="POST" action="" style="display:none">
    @csrf
    @method('DELETE')
</form>

<script>
    // ── Chart ──
    const programados = {{ $programados ?? 0 }};
    const finalizados = {{ $finalizados ?? 0 }};
    const cancelados  = {{ $cancelados ?? 0 }};
    const total = programados + finalizados + cancelados;

    new Chart(document.getElementById('donutChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            datasets: [{
                data: total > 0 ? [programados, finalizados, cancelados] : [1, 0, 0],
                backgroundColor: total > 0 ? ['#f59e0b','#10b981','#ef4444'] : ['#e2e8f0'],
                borderWidth: 2,
                borderColor: '#fff',
            }]
        },
        options: {
            cutout: '68%',
            plugins: { legend: { display: false }, tooltip: { enabled: total > 0 } },
            animation: { duration: 600 }
        }
    });

    // ── Modals ──
    function abrirModal(id) {
        document.getElementById(id).classList.add('open');
        document.body.style.overflow = 'hidden';
    }
    function cerrarModal(id) {
        document.getElementById(id).classList.remove('open');
        document.body.style.overflow = '';
    }
    // Cerrar al hacer clic en el overlay
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', function(e) {
            if (e.target === this) cerrarModal(this.id);
        });
    });
    // Cerrar con Escape
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') document.querySelectorAll('.modal-overlay.open').forEach(m => cerrarModal(m.id));
    });

    // ── File upload ──
    function mostrarArchivo(input) {
        if (input.files && input.files[0]) {
            document.getElementById('fileName').textContent = input.files[0].name;
            document.getElementById('fileSelected').style.display = 'flex';
        }
    }
    
    // ── Editar examen ──
    function abrirModalEditar(examenId, fecha, hora, tipo) {
        document.getElementById('editFecha').value = fecha;
        document.getElementById('editHora').value = hora;
        document.getElementById('editTipo').value = tipo;
        
        const form = document.getElementById('formEditarExamen');
        form.action = `/admin/examenes/${examenId}`;
        
        abrirModal('modalEditarExamen');
    }
    
    // ── Detalles del examen (Ver) ──
    function verDetallesExamen(data) {
        document.getElementById('detNombre').textContent = data.nombre;
        document.getElementById('detConvocatoria').textContent = data.convocatoria;
        document.getElementById('detFechaHora').textContent = `${data.fecha} a las ${data.hora}`;
        
        // Tipo badge class & text
        const tipoBadge = document.getElementById('detTipo');
        tipoBadge.textContent = data.tipo;
        tipoBadge.className = 'badge ' + (data.tipo.toUpperCase() === 'VIRTUAL' ? 'badge-virtual' : 'badge-presencial');
        
        // Estado badge class & text
        const estadoBadge = document.getElementById('detEstado');
        estadoBadge.textContent = data.estado;
        
        const estUpper = data.estado.toUpperCase();
        let estClass = 'badge-programado';
        if (estUpper === 'EN DESARROLLO') estClass = 'badge-desarrollo';
        else if (estUpper === 'FINALIZADO') estClass = 'badge-finalizado';
        else if (estUpper === 'CANCELADO') estClass = 'badge-cancelado';
        estadoBadge.className = 'badge ' + estClass;
        
        document.getElementById('detCalificados').textContent = data.total_notas;
        document.getElementById('detInscritos').textContent = data.inscritos;
        document.getElementById('detPromedio').textContent = data.promedio || '0.00';
        
        const total = parseInt(data.total_notas) || 0;
        const aprobados = parseInt(data.aprobados) || 0;
        const reprobados = parseInt(data.reprobados) || 0;
        
        const pctAprobados = total > 0 ? Math.round((aprobados / total) * 100) : 0;
        const pctReprobados = total > 0 ? Math.round((reprobados / total) * 100) : 0;
        
        document.getElementById('detAprobadosTxt').textContent = `${aprobados} (${pctAprobados}%)`;
        document.getElementById('detAprobadosBar').style.width = `${pctAprobados}%`;
        
        document.getElementById('detReprobadosTxt').textContent = `${reprobados} (${pctReprobados}%)`;
        document.getElementById('detReprobadosBar').style.width = `${pctReprobados}%`;
        
        abrirModal('modalVerExamen');
    }
    
    function handleDrop(e) {
        e.preventDefault();
        document.getElementById('dropZone').classList.remove('drag');
        const file = e.dataTransfer.files[0];
        if (file && file.name.endsWith('.csv')) {
            const dt = new DataTransfer();
            dt.items.add(file);
            document.getElementById('archivoCSV').files = dt.files;
            document.getElementById('fileName').textContent = file.name;
            document.getElementById('fileSelected').style.display = 'flex';
        }
    }

    // ── Plantilla de resultados ──
    function descargarPlantilla() {
        const rows = [
            ['codigo_estudiante', 'puntaje'],
            ['EST-0001', '75.00'],
            ['EST-0002', '88.50'],
            ['EST-0003', '60.00'],
        ];
        const csv = rows.map(r => r.join(',')).join('\n');
        const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
        const url  = URL.createObjectURL(blob);
        const a    = document.createElement('a');
        a.href     = url;
        a.download = 'plantilla_resultados.csv';
        a.click();
        URL.revokeObjectURL(url);
    }

    // ── Eliminar examen ──
    function confirmarEliminarExamen(id, nombre) {
        if (confirm(`¿Estás seguro de que deseas eliminar el examen "${nombre}"?\nEsta acción eliminará todas las notas registradas en este examen y no se puede deshacer.`)) {
            const form = document.getElementById('form-eliminar-examen');
            form.action = `/admin/examenes/${id}`;
            form.submit();
        }
    }

    // Abrir modal Nuevo Examen si hay errores de validación
    @if($errors->any())
        abrirModal('modalNuevoExamen');
    @endif
</script>

</body>
</html>