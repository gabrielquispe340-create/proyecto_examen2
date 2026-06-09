<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle Pre-registro Docente — CUP FICCT</title>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        /* Reuse styles from detalle-estudiante for consistency */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Figtree', sans-serif; background: #f1f5f9; color: #1e293b; }
        .topbar { background: #1e3a6e; padding: 0 24px; height: 56px; display: flex; align-items: center; justify-content: space-between; position: fixed; top: 0; left: 0; right: 0; z-index: 200; }
        .topbar-brand { color: #fff; font-size: 16px; font-weight: 600; display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .topbar-right { display: flex; align-items: center; gap: 16px; }
        .btn-logout { background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.22); color: #fff; padding: 6px 14px; border-radius: 8px; font-size: 12px; cursor: pointer; display: flex; align-items: center; gap: 6px; }
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
        .page { padding: 24px 28px; width: 100%; }
        .breadcrumb { display: flex; align-items: center; gap: 6px; font-size: 13px; color: #94a3b8; margin-bottom: 20px; }
        .breadcrumb a { color: #94a3b8; text-decoration: none; }
        .page-header { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 20px; flex-wrap: wrap; gap: 12px; }
        .header-left { display: flex; align-items: center; gap: 14px; }
        .avatar-lg { width: 52px; height: 52px; border-radius: 50%; background: #ede9fe; color: #5b21b6; display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: 600; }
        .page-title { font-size: 20px; font-weight: 600; color: #1e293b; }
        .page-sub { font-size: 13px; color: #94a3b8; margin-top: 3px; display: flex; align-items: center; gap: 8px; }
        .header-actions { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
        .badge { display: inline-flex; align-items: center; padding: 4px 12px; border-radius: 99px; font-size: 12px; font-weight: 500; }
        .badge-pend  { background: #fef3c7; color: #92400e; }
        .badge-aprov { background: #d1fae5; color: #065f46; }
        .badge-rech  { background: #fee2e2; color: #991b1b; }
        .btn { padding: 8px 16px; border-radius: 8px; font-size: 13px; cursor: pointer; border: none; font-family: 'Figtree', sans-serif; display: inline-flex; align-items: center; gap: 6px; font-weight: 500; }
        .btn-back   { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }
        .btn-ok   { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }
        .btn-err  { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
        .card { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; margin-bottom: 14px; overflow: hidden; }
        .card-header { padding: 12px 16px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; gap: 8px; }
        .card-header-title { font-size: 12px; font-weight: 600; color: #374151; text-transform: uppercase; }
        .card-body { padding: 16px; }
        .fields-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; }
        .fields-grid.cols-2 { grid-template-columns: repeat(2, 1fr); }
        .field { display: flex; flex-direction: column; gap: 3px; }
        .field-label { font-size: 10px; font-weight: 700; color: #94a3b8; text-transform: uppercase; }
        .field-value { font-size: 13px; color: #1e293b; font-weight: 500; }
        .docs-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; }
        .doc-card { border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px 14px; display: flex; align-items: center; gap: 10px; }
        .doc-icon { width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 18px; }
        .doc-icon.pdf { background: #fee2e2; color: #991b1b; }
        .doc-icon.img { background: #dbeafe; color: #1e40af; }
        .doc-info { flex: 1; min-width: 0; }
        .doc-tipo { font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; }
        .doc-nombre { font-size: 12px; color: #374151; font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .doc-link { color: #1e40af; font-size: 12px; text-decoration: none; display: flex; align-items: center; gap: 4px; }
        .doc-missing { background: #f8fafc; color: #94a3b8; border-style: dashed; }
        @media(max-width: 1200px) { .fields-grid { grid-template-columns: repeat(3, 1fr); } }
        @media(max-width: 900px) { .fields-grid { grid-template-columns: repeat(2, 1fr); } .docs-grid { grid-template-columns: 1fr; } }
        @media(max-width: 600px) { .page { padding: 16px; } .fields-grid { grid-template-columns: 1fr; } .avatar-lg { width: 44px; height: 44px; font-size: 18px; } }
    </style>
</head>
<body>

<div class="topbar">
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

    <div class="breadcrumb">
        <a href="{{ route('admin.pre-registros.index') }}"><i class="ti ti-arrow-left" style="font-size:14px"></i> Pre-registros</a>
        <span style="color:#cbd5e1">/</span>
        <span>Detalle Docente #{{ $pre->id }}</span>
    </div>

    <div class="page-header">
        <div class="header-left">
            <div class="avatar-lg">{{ strtoupper(substr($pre->nombre,0,1)) }}{{ strtoupper(substr($pre->apellido,0,1)) }}</div>
            <div>
                <div class="page-title">{{ $pre->nombre }} {{ $pre->apellido }}</div>
                <div class="page-sub">
                    <span>{{ $pre->email }}</span>
                    <span class="badge {{ $pre->estado=='PENDIENTE'?'badge-pend':($pre->estado=='APROBADO'?'badge-aprov':'badge-rech') }}">{{ $pre->estado }}</span>
                </div>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.pre-registros.index') }}" class="btn btn-back"><i class="ti ti-arrow-left"></i> Volver</a>
            @if($pre->estado === 'PENDIENTE')
                <button class="btn btn-err" onclick="abrirModalRechazar()"><i class="ti ti-x"></i> Rechazar</button>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-header"><i class="ti ti-user"></i><div class="card-header-title">Datos Personales</div></div>
        <div class="card-body">
            <div class="fields-grid">
                <div class="field"><div class="field-label">Nombres</div><div class="field-value">{{ $pre->nombre }}</div></div>
                <div class="field"><div class="field-label">Apellidos</div><div class="field-value">{{ $pre->apellido }}</div></div>
                <div class="field"><div class="field-label">CI</div><div class="field-value">{{ $pre->ci }}-{{ $pre->ci_extension }}</div></div>
                <div class="field"><div class="field-label">Teléfono</div><div class="field-value">{{ $pre->telefono ?? '—' }}</div></div>
                <div class="field"><div class="field-label">Correo</div><div class="field-value">{{ $pre->email }}</div></div>
                <div class="field"><div class="field-label">Ciudad</div><div class="field-value">{{ $pre->ciudad ?? '—' }}</div></div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><i class="ti ti-book"></i><div class="card-header-title">Materias postuladas</div></div>
        <div class="card-body">
            @if($materias && $materias->isNotEmpty())
                <div class="fields-grid cols-2">
                    @foreach($materias as $m)
                        <div class="field"><div class="field-label">Materia</div><div class="field-value">{{ $m }}</div></div>
                    @endforeach
                </div>
            @else
                <div class="empty">No se registraron materias</div>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-header"><i class="ti ti-paperclip"></i><div class="card-header-title">Documentos adjuntos ({{ $docs->count() }})</div></div>
        <div class="card-body">
            <div class="docs-grid">
                @foreach($docs as $doc)
                    @php
                        $ext = strtolower(pathinfo($doc->nombre_archivo, PATHINFO_EXTENSION));
                        $esPdf = $ext === 'pdf';
                        $urlDoc = Storage::url($doc->ruta_servidor);
                        $tamano = $doc->tamanio_bytes ? round($doc->tamanio_bytes/1024,1) . ' KB' : '';
                    @endphp
                    <div class="doc-card">
                        <div class="doc-icon {{ $esPdf ? 'pdf' : 'img' }}"><i class="ti {{ $esPdf ? 'ti-file-type-pdf' : 'ti-photo' }}"></i></div>
                        <div class="doc-info">
                            <div class="doc-tipo">{{ $doc->tipo }}</div>
                            <div class="doc-nombre">{{ $doc->nombre_archivo }}</div>
                            @if($tamano)<div class="doc-size">{{ $tamano }}</div>@endif
                        </div>
                        @if($esPdf)
                            <a href="{{ $urlDoc }}" target="_blank" class="doc-link"><i class="ti ti-external-link"></i> Ver</a>
                        @else
                            <a href="#" class="doc-link" onclick="verImagen('{{ $urlDoc }}'); return false;"><i class="ti ti-eye"></i> Ver</a>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @if($pre->estado === 'RECHAZADO' && $pre->observacion_admin)
    <div class="card">
        <div class="card-header"><i class="ti ti-alert-circle" style="color:#991b1b"></i><div class="card-header-title" style="color:#991b1b">Motivo del rechazo</div></div>
        <div class="card-body"><div class="obs-box" style="background:#fee2e2;border-color:#fca5a5;color:#991b1b">{{ $pre->observacion_admin }}</div></div>
    </div>
    @endif

    <div class="card">
        <div class="card-header"><i class="ti ti-info-circle"></i><div class="card-header-title">Información del Registro</div></div>
        <div class="card-body">
            <div class="fields-grid cols-2">
                <div class="field"><div class="field-label">Fecha de Solicitud</div><div class="field-value">{{ $pre->created_at ? \Carbon\Carbon::parse($pre->created_at)->format('d/m/Y H:i') : '—' }}</div></div>
                <div class="field"><div class="field-label">IP de Registro</div><div class="field-value">{{ $pre->ip_registro ?? 'No registrada' }}</div></div>
                @if($pre->revisado_en)
                <div class="field"><div class="field-label">Revisado el</div><div class="field-value">{{ \Carbon\Carbon::parse($pre->revisado_en)->format('d/m/Y H:i') }}</div></div>
                @endif
                <div class="field"><div class="field-label">Estado Actual</div><div class="field-value"><span class="badge {{ $pre->estado=='PENDIENTE'?'badge-pend':($pre->estado=='APROBADO'?'badge-aprov':'badge-rech') }}">{{ $pre->estado }}</span></div></div>
            </div>
        </div>
    </div>

</div>
</main>

<div class="img-overlay" id="img-overlay" onclick="cerrarImagen()"><div class="img-overlay-close"><i class="ti ti-x"></i> Cerrar</div><img id="img-preview" src="" alt="Documento"></div>

{{-- MODAL RECHAZAR DOCENTE --}}
<div class="modal-overlay" id="modal-rechazar">
    <div class="modal">
        <div class="modal-header"><div class="modal-icon error"><i class="ti ti-alert-circle"></i></div><div><h3 class="modal-title">¿Rechazar solicitud?</h3><p class="modal-subtitle">{{ $pre->nombre }} {{ $pre->apellido }}</p></div></div>
        <div class="modal-body"><p>Especifica el motivo del rechazo. El usuario recibirá notificación de esta decisión.</p></div>
        <form method="POST" action="{{ route('admin.pre-registros.docente.rechazar', $pre->id) }}">
            @csrf
            <textarea name="observacion" placeholder="Describe el motivo del rechazo..." required></textarea>
            <div class="modal-footer">
                <button type="button" class="btn-modal btn-modal-cancel" onclick="cerrarModalRechazar()">Cancelar</button>
                <button type="submit" class="btn-modal btn-modal-danger">Confirmar rechazo</button>
            </div>
        </form>
    </div>
</div>

<script>
function verImagen(url) {
    document.getElementById('img-preview').src = url;
    document.getElementById('img-overlay').classList.add('open');
}
function cerrarImagen() { document.getElementById('img-overlay').classList.remove('open'); document.getElementById('img-preview').src = ''; }
function abrirModalRechazar() { document.getElementById('modal-rechazar').classList.add('open'); }
function cerrarModalRechazar() { document.getElementById('modal-rechazar').classList.remove('open'); }
// ESC y click fuera
document.addEventListener('keydown', function(e){ if(e.key==='Escape'){ cerrarImagen(); cerrarModalRechazar(); } });
document.addEventListener('click', function(e){ if(e.target.classList && e.target.classList.contains('modal-overlay')){ cerrarImagen(); cerrarModalRechazar(); } });
</script>

</body>
</html>