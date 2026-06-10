<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-store">
    <title>CUP — Carga Masiva CSV</title>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Figtree', sans-serif; background: #f1f5f9; color: #1e293b; }

        /* TOPBAR */
        .topbar { background: #1e3a6e; padding: 0 24px; height: 56px; display: flex; align-items: center; justify-content: space-between; position: fixed; top: 0; left: 0; right: 0; z-index: 200; }
        .topbar-brand { color: #fff; font-size: 16px; font-weight: 600; display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .topbar-right { display: flex; align-items: center; gap: 16px; }
        .topbar-user { color: #a8c8f0; font-size: 13px; display: flex; align-items: center; gap: 6px; }
        .btn-logout { background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.22); color: #fff; padding: 6px 14px; border-radius: 8px; font-size: 12px; cursor: pointer; text-decoration: none; display: flex; align-items: center; gap: 6px; }
        .btn-logout:hover { background: rgba(255,255,255,0.22); }

        /* SIDEBAR */
        .sidebar { width: 224px; height: calc(100vh - 56px); background: #1e3a6e; position: fixed; top: 56px; left: 0; overflow-y: auto; padding: 20px 12px 24px; display: flex; flex-direction: column; gap: 2px; }
        .nav-label { font-size: 10px; font-weight: 700; color: rgba(168,200,240,0.55); text-transform: uppercase; letter-spacing: .1em; padding: 16px 10px 6px; }
        .nav-item { padding: 9px 12px; font-size: 13px; color: rgba(168,200,240,0.85); text-decoration: none; border-radius: 8px; display: flex; align-items: center; gap: 10px; transition: background .15s; }
        .nav-item i { font-size: 16px; flex-shrink: 0; }
        .nav-item:hover { background: rgba(255,255,255,0.1); color: #fff; }
        .nav-item.active { background: rgba(255,255,255,0.15); color: #fff; font-weight: 500; }
        .nav-item.c-sky    i { color: #7dd3fc; }
        .nav-item.c-amber  i { color: #fcd34d; }
        .nav-item.c-blue   i { color: #93c5fd; }
        .nav-item.c-teal   i { color: #6ee7b7; }
        .nav-item.c-purple i { color: #c4b5fd; }
        .nav-item.c-rose   i { color: #fda4af; }
        .nav-item.active   i { color: #fcd34d; }
        .sidebar-footer { margin-top: auto; padding: 16px 10px 0; border-top: 1px solid rgba(255,255,255,0.08); font-size: 11px; color: rgba(168,200,240,0.4); text-align: center; }

        /* LAYOUT */
        .layout { margin-left: 224px; margin-top: 56px; padding: 24px; min-height: calc(100vh - 56px); }
        .page-header { margin-bottom: 24px; }
        .page-header h1 { font-size: 20px; font-weight: 700; }
        .page-header p  { font-size: 13px; color: #64748b; margin-top: 2px; }

        /* ALERTAS */
        .alert { border-radius: 10px; padding: 12px 16px; margin-bottom: 18px; font-size: 13px; display: flex; align-items: flex-start; gap: 10px; }
        .alert-ok  { background: #d1fae5; border: 1px solid #6ee7b7; color: #065f46; }
        .alert-err { background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; }

        /* GRID */
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px; }

        /* CARD */
        .card { background: #fff; border-radius: 14px; border: 1px solid #e2e8f0; padding: 24px; }
        .card-title { font-size: 15px; font-weight: 600; color: #1e293b; margin-bottom: 18px; display: flex; align-items: center; gap: 8px; }
        .card-title i { font-size: 20px; color: #1e3a6e; }

        /* FORM */
        .field { display: flex; flex-direction: column; gap: 5px; margin-bottom: 16px; }
        .field label { font-size: 12px; font-weight: 500; color: #374151; }
        .field label .req { color: #ef4444; }
        select, input[type="file"] { width: 100%; padding: 9px 12px; border: 1px solid #d1d5db; border-radius: 9px; font-size: 13px; font-family: 'Figtree', sans-serif; outline: none; background: #fff; }
        select:focus { border-color: #1e3a6e; box-shadow: 0 0 0 3px rgba(30,58,110,0.08); }

        /* TIPO SELECTOR */
        .tipo-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .tipo-opt { position: relative; }
        .tipo-opt input[type="radio"] { position: absolute; opacity: 0; }
        .tipo-label { display: flex; flex-direction: column; align-items: center; gap: 6px; padding: 14px; border: 2px solid #e2e8f0; border-radius: 10px; cursor: pointer; font-size: 13px; color: #64748b; transition: all .2s; text-align: center; }
        .tipo-label i { font-size: 24px; }
        .tipo-opt input:checked + .tipo-label { border-color: #1e3a6e; background: #eff4ff; color: #1e3a6e; font-weight: 600; }

        /* UPLOAD BOX */
        .upload-box { border: 2px dashed #d1d5db; border-radius: 10px; padding: 24px; text-align: center; cursor: pointer; transition: all .2s; position: relative; }
        .upload-box:hover { border-color: #1e3a6e; background: #f8faff; }
        .upload-box input { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; }
        .upload-box i { font-size: 32px; color: #94a3b8; display: block; margin-bottom: 8px; }
        .upload-box .up-txt { font-size: 13px; font-weight: 500; color: #374151; }
        .upload-box .up-hint { font-size: 11px; color: #9ca3af; margin-top: 4px; }
        .upload-box.has-file { border-color: #6ee7b7; background: #f0fdf4; }
        .upload-box.has-file i { color: #059669; }

        /* FORMATO INFO */
        .formato-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 14px 16px; margin-top: 14px; }
        .formato-box h4 { font-size: 12px; font-weight: 600; color: #374151; margin-bottom: 8px; display: flex; align-items: center; gap: 6px; }
        .formato-box code { display: block; background: #1e293b; color: #7dd3fc; padding: 10px 14px; border-radius: 8px; font-size: 12px; margin-top: 6px; }

        /* BTN */
        .btn { padding: 10px 24px; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer; border: none; font-family: 'Figtree', sans-serif; display: inline-flex; align-items: center; gap: 6px; transition: opacity .15s; }
        .btn:hover { opacity: .88; }
        .btn-primary { background: #1e3a6e; color: #fff; width: 100%; justify-content: center; padding: 12px; }

        /* HISTORIAL TABLE */
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        thead { background: #f8fafc; }
        th { text-align: left; padding: 10px 14px; font-size: 11px; font-weight: 600; color: #64748b; border-bottom: 1px solid #e2e8f0; }
        td { padding: 11px 14px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        .badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 99px; font-size: 11px; font-weight: 500; }
        .b-ok   { background: #d1fae5; color: #065f46; }
        .b-err  { background: #fee2e2; color: #991b1b; }
        .b-proc { background: #fef3c7; color: #92400e; }
        .b-post { background: #dbeafe; color: #1e40af; }
        .b-doc  { background: #ede9fe; color: #5b21b6; }
        .empty  { text-align: center; padding: 40px; color: #94a3b8; }
        .empty i { font-size: 36px; display: block; margin-bottom: 10px; }
    
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

{{-- TOPBAR --}}
<div class="topbar">
    <button type="button" class="btn-menu-mobile" onclick="document.querySelector('.sidebar').classList.toggle('open'); document.getElementById('sidebar-overlay-mobile').classList.toggle('show');">&#9776;</button>
    <a href="{{ route('admin.dashboard') }}" class="topbar-brand">
        <i class="ti ti-school" style="font-size:20px"></i> CUP — FICCT
    </a>
    <div class="topbar-right">
        <span class="topbar-user"><i class="ti ti-user-circle"></i> {{ Auth::user()->nombre }} {{ Auth::user()->apellido }}</span>
        <form method="POST" action="{{ route('logout') }}" style="display:inline">
            @csrf<button type="submit" class="btn-logout"><i class="ti ti-logout"></i> Salir</button>
        </form>
    </div>
</div>

{{-- SIDEBAR --}}
@include('admin.partials.sidebar')

{{-- LAYOUT --}}
<div class="layout">

    <div class="page-header">
        <h1>Carga Masiva CSV</h1>
        <p>Importa postulantes o docentes desde un archivo CSV para registrarlos automáticamente en el sistema</p>
    </div>

    {{-- ALERTAS --}}
    @if(session('success'))
        <div class="alert alert-ok"><i class="ti ti-circle-check" style="font-size:18px;flex-shrink:0"></i> {{ session('success') }}</div>
    @endif
    @if(session('error') || $errors->any())
        <div class="alert alert-err">
            <i class="ti ti-alert-circle" style="font-size:18px;flex-shrink:0"></i>
            <div>{{ session('error') ?? $errors->first() }}</div>
        </div>
    @endif

    <div class="grid-2">

        {{-- FORMULARIO --}}
        <div class="card">
            <div class="card-title"><i class="ti ti-upload"></i> Subir archivo CSV</div>

            <form method="POST" action="{{ route('admin.carga-masiva.procesar') }}" enctype="multipart/form-data">
                @csrf

                {{-- CONVOCATORIA --}}
                <div class="field">
                    <label>Convocatoria <span class="req">*</span></label>
                    <select name="convocatoria_id" required>
                        <option value="">Seleccionar convocatoria...</option>
                        @foreach($convocatorias as $conv)
                            <option value="{{ $conv->id }}">{{ $conv->nombre }} ({{ $conv->estado }})</option>
                        @endforeach
                    </select>
                </div>

                {{-- TIPO --}}
                <div class="field">
                    <label>Tipo de usuario <span class="req">*</span></label>
                    <div class="tipo-grid" style="margin-top:4px">
                        <label class="tipo-opt">
                            <input type="radio" name="tipo_usuario" value="POSTULANTE" checked>
                            <span class="tipo-label">
                                <i class="ti ti-users"></i>
                                Postulantes
                            </span>
                        </label>
                        <label class="tipo-opt">
                            <input type="radio" name="tipo_usuario" value="DOCENTE">
                            <span class="tipo-label">
                                <i class="ti ti-chalkboard"></i>
                                Docentes
                            </span>
                        </label>
                    </div>
                </div>

                {{-- ARCHIVO --}}
                <div class="field">
                    <label>Archivo CSV <span class="req">*</span></label>
                    <div class="upload-box" id="upload-box">
                        <input type="file" name="archivo_csv" accept=".csv,.txt"
                               onchange="previewFile(this)">
                        <i class="ti ti-file-spreadsheet" id="upload-ico"></i>
                        <div class="up-txt" id="upload-txt">Seleccionar archivo CSV</div>
                        <div class="up-hint">Solo archivos .CSV · Máx. 2 MB</div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-upload"></i> Procesar archivo
                </button>
            </form>

            {{-- FORMATO --}}
            <div class="formato-box">
                <h4><i class="ti ti-info-circle" style="color:#2563eb"></i> Formato del archivo CSV</h4>
                <p style="font-size:11px;color:#64748b;margin-bottom:6px">Columnas requeridas (con encabezado):</p>
                <code>CI, Nombre, Apellido, Email, Turno, CarreraId1, CarreraId2</code>
                <p style="font-size:11px;color:#9ca3af;margin-top:8px">Ejemplo:</p>
                <code style="margin-top:4px">50000001, Juan, Garcia, jgarcia@gmail.com, MAÑANA, 1, 2</code>
                <div style="margin-top:10px;font-size:11px;color:#64748b">
                    <strong>Turno:</strong> MAÑANA · TARDE · NOCHE &nbsp;|&nbsp;
                    <strong>CarreraId:</strong> 1=Sistemas · 2=Informática · 3=Redes · 4=Robótica
                </div>
            </div>
        </div>

        {{-- INSTRUCCIONES --}}
        <div style="display:flex;flex-direction:column;gap:16px">
            <div class="card">
                <div class="card-title"><i class="ti ti-info-circle"></i> ¿Cómo funciona?</div>
                @foreach([
                    ['ico'=>'ti-upload','col'=>'#2563eb','title'=>'Sube el archivo CSV','desc'=>'Selecciona la convocatoria, el tipo de usuario y el archivo con los datos.'],
                    ['ico'=>'ti-cpu','col'=>'#7c3aed','title'=>'El sistema procesa','desc'=>'Cada fila del CSV crea un usuario con contraseña = CI. Se detectan duplicados automáticamente.'],
                    ['ico'=>'ti-circle-check','col'=>'#059669','title'=>'Resultado','desc'=>'Verás cuántos registros fueron creados correctamente y cuáles fallaron con el motivo.'],
                ] as $paso)
                <div style="display:flex;gap:12px;margin-bottom:14px;align-items:flex-start">
                    <div style="width:34px;height:34px;border-radius:9px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <i class="ti {{ $paso['ico'] }}" style="font-size:18px;color:{{ $paso['col'] }}"></i>
                    </div>
                    <div>
                        <div style="font-size:13px;font-weight:600;color:#1e293b">{{ $paso['title'] }}</div>
                        <div style="font-size:12px;color:#64748b;margin-top:2px">{{ $paso['desc'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="card">
                <div class="card-title"><i class="ti ti-alert-triangle" style="color:#d97706"></i> Consideraciones</div>
                <ul style="list-style:none;display:flex;flex-direction:column;gap:8px">
                    @foreach([
                        'La contraseña inicial de cada usuario será su número de CI.',
                        'Si un email ya existe en el sistema, esa fila será omitida.',
                        'El turno asignado por defecto para postulantes es MAÑANA.',
                        'Los docentes quedan sin especialidad hasta que la actualicen.',
                    ] as $nota)
                    <li style="display:flex;align-items:flex-start;gap:8px;font-size:12px;color:#64748b">
                        <i class="ti ti-point-filled" style="font-size:10px;color:#d97706;flex-shrink:0;margin-top:3px"></i>
                        {{ $nota }}
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    {{-- HISTORIAL --}}
    <div class="card">
        <div class="card-title"><i class="ti ti-history"></i> Historial de cargas</div>
        @if($cargas->isEmpty())
            <div class="empty">
                <i class="ti ti-inbox"></i>
                <p>No hay cargas masivas registradas aún.</p>
            </div>
        @else
            <div class="table-responsive"><table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Archivo</th>
                        <th>Tipo</th>
                        <th>Total</th>
                        <th>Exitosos</th>
                        <th>Fallidos</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cargas as $c)
                    <tr>
                        <td style="color:#94a3b8">{{ $c->id }}</td>
                        <td style="font-weight:500">{{ $c->archivo_nombre }}</td>
                        <td>
                            <span class="badge {{ $c->tipo_usuario === 'POSTULANTE' ? 'b-post' : 'b-doc' }}">
                                {{ $c->tipo_usuario }}
                            </span>
                        </td>
                        <td>{{ $c->total_registros }}</td>
                        <td style="color:#059669;font-weight:600">{{ $c->exitosos }}</td>
                        <td style="color:{{ $c->fallidos > 0 ? '#e11d48' : '#94a3b8' }};font-weight:600">{{ $c->fallidos }}</td>
                        <td>
                            @if($c->estado === 'COMPLETADO')
                                <span class="badge b-ok"><i class="ti ti-check" style="font-size:10px"></i> Completado</span>
                            @elseif($c->estado === 'CON_ERRORES')
                                <span class="badge b-err"><i class="ti ti-alert-circle" style="font-size:10px"></i> Con errores</span>
                            @else
                                <span class="badge b-proc"><i class="ti ti-clock" style="font-size:10px"></i> Procesando</span>
                            @endif
                        </td>
                        <td style="color:#64748b;font-size:11px">
                            {{ \Carbon\Carbon::parse($c->created_at)->format('d/m/Y H:i') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table></div>
        @endif
    </div>

</div>

<script>
    function previewFile(input) {
        const box = document.getElementById('upload-box');
        const txt = document.getElementById('upload-txt');
        if (input.files && input.files[0]) {
            const size = (input.files[0].size / 1024).toFixed(1);
            txt.textContent = input.files[0].name + ' (' + size + ' KB)';
            box.classList.add('has-file');
        }
    }
    window.addEventListener('pageshow', e => { if (e.persisted) location.reload(); });
</script>
</body>
</html>