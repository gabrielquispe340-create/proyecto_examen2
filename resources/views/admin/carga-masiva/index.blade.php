<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carga Masiva — CUP FICCT</title>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">
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
        .page { padding: 28px; max-width: 1000px; }
        .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; }
        .page-title { font-size: 20px; font-weight: 600; }
        .page-sub { font-size: 13px; color: #94a3b8; margin-top: 3px; }

        .alert { padding: 12px 16px; border-radius: 10px; margin-bottom: 16px; font-size: 13px; display: flex; align-items: center; gap: 8px; }
        .alert-ok  { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }
        .alert-err { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }

        .grid-2 { display: grid; grid-template-columns: 1.5fr 1fr; gap: 20px; margin-bottom: 24px; }
        
        /* Carga Card */
        .card { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; padding: 24px; display: flex; flex-direction: column; gap: 16px; }
        .card h3 { font-size: 15px; font-weight: 600; border-bottom: 1px solid #f1f5f9; padding-bottom: 12px; display: flex; align-items: center; gap: 8px; color: #1e293b; }
        
        .field { display: flex; flex-direction: column; gap: 6px; }
        .field label { font-size: 12px; font-weight: 600; color: #475569; text-transform: uppercase; letter-spacing: .04em; }
        .field select { padding: 9px 12px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; color: #1e293b; font-family: 'Figtree', sans-serif; background: #f8fafc; outline: none; }
        .field select:focus { border-color: #1e3a6e; background: #fff; }

        .upload-zone { border: 2px dashed #cbd5e1; border-radius: 10px; padding: 24px; text-align: center; background: #f8fafc; cursor: pointer; transition: all .15s; }
        .upload-zone:hover { border-color: #1e3a6e; background: #f1f5f9; }
        .upload-icon { font-size: 32px; color: #94a3b8; margin-bottom: 8px; }
        .upload-text { font-size: 13px; color: #475569; font-weight: 500; }
        .upload-sub { font-size: 11px; color: #94a3b8; margin-top: 4px; }
        
        .btn-upload { padding: 10px 24px; background: #1e3a6e; color: #fff; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; font-family: 'Figtree', sans-serif; display: inline-flex; align-items: center; gap: 8px; justify-content: center; transition: background .15s; }
        .btn-upload:hover { background: #0f2147; }

        /* Template card */
        .template-card { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; padding: 20px 24px; font-size: 13px; line-height: 1.6; }
        .template-card h4 { font-size: 13px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: .04em; margin-bottom: 12px; }
        .template-code { background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 6px; padding: 8px 12px; font-family: monospace; font-size: 11px; color: #0f172a; margin-bottom: 12px; word-break: break-all; }
        .template-card ul { margin-left: 20px; color: #475569; display: flex; flex-direction: column; gap: 4px; }

        /* Historial */
        .history-card { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; margin-bottom: 24px; }
        .history-header { padding: 16px 20px; border-bottom: 1px solid #f1f5f9; font-weight: 600; font-size: 14px; color: #1e293b; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th { text-align: left; padding: 12px 16px; font-size: 11px; font-weight: 600; color: #94a3b8; background: #f8fafc; border-bottom: 1px solid #f1f5f9; text-transform: uppercase; letter-spacing: .04em; }
        td { padding: 14px 16px; border-bottom: 1px solid #f8fafc; color: #374151; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #fafafa; }

        .badge { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 99px; font-size: 11px; font-weight: 500; }
        .badge-completado { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .badge-errores { background: #fef3c7; color: #92400e; border: 1px solid #fcd34d; }
        .badge-proc { background: #dbeafe; color: #1e40af; border: 1px solid #93c5fd; }

        .btn-err-sm { padding: 4px 8px; border-radius: 6px; font-size: 11px; cursor: pointer; border: 1px solid #fca5a5; background: #fee2e2; color: #991b1b; font-family: 'Figtree', sans-serif; font-weight: 500; transition: background .15s; }
        .btn-err-sm:hover { background: #fecaca; }

        /* Modal */
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.45); z-index: 999; align-items: center; justify-content: center; }
        .modal-overlay.open { display: flex; }
        .modal { background: #fff; border-radius: 14px; padding: 24px; width: 100%; max-width: 500px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1), 0 8px 10px -6px rgba(0,0,0,0.1); }
        .modal-title { font-size: 15px; font-weight: 600; color: #991b1b; margin-bottom: 12px; display: flex; align-items: center; gap: 8px; }
        .modal-body { max-height: 260px; overflow-y: auto; background: #fef2f2; border: 1px solid #fee2e2; border-radius: 8px; padding: 12px 16px; font-family: monospace; font-size: 11px; color: #b91c1c; display: flex; flex-direction: column; gap: 4px; }
        .modal-footer { display: flex; gap: 8px; margin-top: 18px; justify-content: flex-end; }
        .btn-cancel { padding: 8px 18px; background: #f1f5f9; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; cursor: pointer; font-family: 'Figtree', sans-serif; transition: background .15s; }
        .btn-cancel:hover { background: #e2e8f0; }

        .empty { text-align: center; padding: 40px; color: #94a3b8; }
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
            <button type="submit" class="btn-logout"><i class="ti ti-logout"></i> Salir</button>
        </form>
    </div>
</div>

@include('admin.partials.sidebar')

<main class="main">
<div class="page">

    <div class="page-header">
        <div>
            <div class="page-title">Carga Masiva de Usuarios</div>
            <div class="page-sub">Importa postulantes o docentes en lote utilizando archivos CSV</div>
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

        <div class="grid-2">
            
            {{-- SUBIR ARCHIVO CARD --}}
            <div class="card">
                <h3><i class="ti ti-upload" style="color:#1e3a6e"></i> Subir archivo CSV</h3>
                <form method="POST" action="{{ route('admin.carga-masiva.cargar') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="field" style="margin-bottom:14px">
                        <label>Tipo de Usuario a Importar *</label>
                        <select name="tipo_usuario" required>
                            <option value="POSTULANTE">Postulantes</option>
                            <option value="DOCENTE">Docentes</option>
                        </select>
                    </div>

                    <div class="field" style="margin-bottom:20px">
                        <label>Seleccionar Archivo (.csv) *</label>
                        <div class="upload-zone" onclick="document.getElementById('file-input').click()">
                            <i class="ti ti-file-spreadsheet upload-icon"></i>
                            <div class="upload-text" id="file-label">Haz clic para seleccionar tu archivo CSV</div>
                            <div class="upload-sub">Tamaño máximo de archivo: 5 MB</div>
                            <input type="file" name="archivo" id="file-input" style="display:none" accept=".csv" required onchange="actualizarLabel(this)">
                        </div>
                    </div>

                    <button type="submit" class="btn-upload">
                        <i class="ti ti-upload"></i> Procesar e Importar
                    </button>
                </form>
            </div>

            {{-- FORMATO REFERENCIA --}}
            <div class="template-card">
                <h4><i class="ti ti-info-circle"></i> Plantilla e Instrucciones</h4>
                <p style="margin-bottom:12px;color:#475569">Tu archivo debe ser un CSV separado por comas (,) y poseer las cabeceras exactas descritas abajo.</p>
                
                <strong>Estructura para Postulantes:</strong>
                <div class="template-code">
                    ci,nombre,apellido,email,telefono,sexo,carrera_pref_1,carrera_pref_2,turno
                </div>

                <strong>Estructura para Docentes:</strong>
                <div class="template-code" style="margin-bottom:18px">
                    ci,nombre,apellido,email,telefono,grado_academico,especialidad
                </div>

                <strong>Detalles importantes:</strong>
                <ul>
                    <li>Las contraseñas de las cuentas creadas se establecerán por defecto en `12345678`.</li>
                    <li>Mapeos de Carrera: coincidencia parcial (Ej: "sistemas" -> "Ingeniería en Sistemas").</li>
                    <li>Valores válidos para sexo: `M` o `F`.</li>
                    <li>Valores válidos para turno: `MAÑANA`, `TARDE`, `NOCHE`.</li>
                </ul>
            </div>

        </div>

        {{-- HISTORIAL DE CARGAS --}}
        <div class="history-card">
            <div class="history-header">Historial de Importaciones Recientes</div>
            @if($cargas->isEmpty())
                <div class="empty">
                    <i class="ti ti-history" style="font-size:36px;display:block;margin-bottom:10px"></i>
                    No se han registrado importaciones masivas aún.
                </div>
            @else
            <table>
                <thead>
                    <tr>
                        <th>Fecha e Importación</th>
                        <th>Archivo</th>
                        <th>Tipo</th>
                        <th style="text-align: center">Total Filas</th>
                        <th style="text-align: center">Éxito</th>
                        <th style="text-align: center">Errores</th>
                        <th>Estado</th>
                        <th>Detalle</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cargas as $c)
                    <tr>
                        <td style="font-size:12px">
                            {{ \Carbon\Carbon::parse($c->created_at)->format('d/m/Y') }}<br>
                            <span style="color:#94a3b8;font-size:11px">{{ \Carbon\Carbon::parse($c->created_at)->format('H:i:s') }}</span>
                        </td>
                        <td style="font-weight:500;color:#1e3a6e">{{ $c->archivo_nombre }}</td>
                        <td>
                            <span class="badge {{ $c->tipo_usuario === 'POSTULANTE' ? 'badge-blue' : 'badge-purple' }}">
                                {{ $c->tipo_usuario }}
                            </span>
                        </td>
                        <td style="text-align: center;font-weight:600">{{ $c->total_registros }}</td>
                        <td style="text-align: center;color:#10b981;font-weight:600">{{ $c->exitosos }}</td>
                        <td style="text-align: center;color:#ef4444;font-weight:600">{{ $c->fallidos }}</td>
                        <td>
                            <span class="badge {{ $c->estado === 'COMPLETADO' ? 'badge-completado' : ($c->estado === 'COMPLETADO_CON_ERRORES' ? 'badge-errores' : 'badge-proc') }}">
                                {{ str_replace('_', ' ', $c->estado) }}
                            </span>
                        </td>
                        <td>
                            @if($c->fallidos > 0)
                                <button class="btn-err-sm" onclick="abrirModalErrores('{!! addslashes($c->errores) !!}')">
                                    <i class="ti ti-bug"></i> Ver Errores
                                </button>
                            @else
                                <span style="color:#94a3b8;font-style:italic;font-size:12px">—</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>

    @endif

</div>
</main>

{{-- MODAL ERRORES --}}
<div class="modal-overlay" id="modal-errores">
    <div class="modal">
        <div class="modal-title"><i class="ti ti-alert-triangle"></i> Registro de Errores de Importación</div>
        <div class="modal-body" id="modal_error_body">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-cancel" onclick="cerrarModalErrores()">Cerrar</button>
        </div>
    </div>
</div>

<script>
function actualizarLabel(input) {
    const label = document.getElementById('file-label');
    if (input.files && input.files.length > 0) {
        label.textContent = input.files[0].name;
    } else {
        label.textContent = 'Haz clic para seleccionar tu archivo CSV';
    }
}

function abrirModalErrores(erroresJson) {
    const body = document.getElementById('modal_error_body');
    body.innerHTML = '';
    
    try {
        const list = JSON.parse(erroresJson);
        if (list.length === 0) {
            body.innerHTML = '<div>No se registraron errores en esta carga.</div>';
        } else {
            list.forEach(err => {
                const row = document.createElement('div');
                row.textContent = '• ' + err;
                body.appendChild(row);
            });
        }
    } catch(e) {
        body.innerHTML = '<div>Error al formatear los registros: ' + erroresJson + '</div>';
    }
    
    document.getElementById('modal-errores').classList.add('open');
}

function cerrarModalErrores() {
    document.getElementById('modal-errores').classList.remove('open');
}

// Cerrar con ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        cerrarModalErrores();
    }
});
</script>

</body>
</html>
