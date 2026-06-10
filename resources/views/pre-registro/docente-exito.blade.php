<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CUP — Pre-registro enviado</title>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Figtree', sans-serif; background: #f1f5f9; min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 24px; }
        .card { background: #fff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 48px 40px; max-width: 480px; width: 100%; text-align: center; }
        .icon-wrap { width: 72px; height: 72px; border-radius: 50%; background: #ede9fe; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; }
        .icon-wrap i { font-size: 36px; color: #5b21b6; }
        h1 { font-size: 22px; font-weight: 700; color: #1e293b; margin-bottom: 10px; }
        p  { font-size: 14px; color: #64748b; line-height: 1.6; }
        .ci-badge { background: #f5f3ff; border-radius: 10px; padding: 12px 20px; margin: 20px 0; font-size: 13px; color: #374151; }
        .ci-badge strong { font-size: 18px; color: #5b21b6; display: block; margin-top: 4px; }
        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 10px 24px; border-radius: 10px; font-size: 13px; font-weight: 600; background: #5b21b6; color: #fff; text-decoration: none; margin-top: 24px; }
        .btn:hover { background: #4c1d95; }
    
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
    <div class="card">
        <div class="icon-wrap"><i class="ti ti-circle-check"></i></div>
        <h1>¡Pre-registro enviado!</h1>
        <p>Tu solicitud como docente fue recibida correctamente, <strong>{{ $nombre }}</strong>. El administrador revisará tu documentación y te notificará por correo electrónico.</p>
        <div class="ci-badge">
            Tu CI registrado<strong>{{ $ci }}</strong>
        </div>
        <p style="font-size:12px;color:#9ca3af">El estado de tu pre-registro es <strong style="color:#92400e">PENDIENTE</strong> hasta que sea aprobado.</p>
        <a href="{{ route('login') }}" class="btn"><i class="ti ti-home"></i> Volver al inicio</a>
    </div>
</body>
</html>