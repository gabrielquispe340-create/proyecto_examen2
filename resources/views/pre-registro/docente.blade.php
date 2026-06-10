<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">
    <title>CUP — Pre-registro Docente</title>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Figtree', sans-serif; background: #f1f5f9; color: #1e293b; min-height: 100vh; }

        .header { background: #1e3a6e; padding: 0 32px; height: 56px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 100; }
        .header-brand { color: #fff; font-size: 15px; font-weight: 600; display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .header-back  { color: #a8c8f0; font-size: 13px; text-decoration: none; display: flex; align-items: center; gap: 6px; }
        .header-back:hover { color: #fff; }

        .hero { background: linear-gradient(135deg, #3b1f6e 0%, #1e1047 100%); padding: 40px 32px 32px; text-align: center; color: #fff; }
        .hero-badge { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.2); border-radius: 99px; padding: 4px 14px; font-size: 12px; color: #c4b5fd; margin-bottom: 16px; }
        .hero h1 { font-size: 26px; font-weight: 700; margin-bottom: 8px; }
        .hero p  { font-size: 14px; color: #c4b5fd; }

        @keyframes fadeIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: none; } }

        .stepper { display: flex; justify-content: center; background: #fff; border-bottom: 1px solid #e2e8f0; padding: 0 32px; overflow-x: auto; }
        .step { display: flex; align-items: center; gap: 8px; padding: 14px 20px; font-size: 12px; font-weight: 500; color: #94a3b8; cursor: pointer; border-bottom: 2px solid transparent; white-space: nowrap; transition: color .2s, border-color .2s; }
        .step.active { color: #5b21b6; border-bottom-color: #5b21b6; }
        .step.done   { color: #065f46; }
        .step-num { width: 22px; height: 22px; border-radius: 50%; background: #e2e8f0; color: #64748b; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 600; flex-shrink: 0; }
        .step.active .step-num { background: #5b21b6; color: #fff; }
        .step.done   .step-num { background: #d1fae5; color: #065f46; }

        .container { max-width: 860px; margin: 0 auto; padding: 32px 20px 60px; }
        .section { display: none; animation: fadeIn .25s ease; }
        .section.active { display: block; }

        .card { background: #fff; border-radius: 14px; border: 1px solid #e2e8f0; padding: 28px; margin-bottom: 16px; }
        .card-header { display: flex; align-items: center; gap: 10px; margin-bottom: 22px; padding-bottom: 14px; border-bottom: 1px solid #f1f5f9; }
        .card-icon { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
        .ci-purple { background: #ede9fe; color: #5b21b6; }
        .ci-blue   { background: #dbeafe; color: #1e40af; }
        .ci-amber  { background: #fef3c7; color: #92400e; }
        .card-header h2 { font-size: 15px; font-weight: 600; color: #1e293b; }
        .card-header p  { font-size: 12px; color: #64748b; margin-top: 2px; }

        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .col-span-2 { grid-column: span 2; }

        .field { display: flex; flex-direction: column; gap: 5px; }
        .field label { font-size: 12px; font-weight: 500; color: #374151; }
        .field label .req { color: #ef4444; margin-left: 2px; }

        input[type="text"], input[type="email"], input[type="date"],
        input[type="number"], input[type="tel"], select, textarea {
            width: 100%; padding: 9px 12px; border: 1px solid #d1d5db; border-radius: 9px;
            font-size: 13px; color: #111827; background: #fff; outline: none;
            font-family: 'Figtree', sans-serif; transition: border-color .2s, box-shadow .2s;
        }
        input:focus, select:focus, textarea:focus { border-color: #5b21b6; box-shadow: 0 0 0 3px rgba(91,33,182,0.08); }
        input.is-error, select.is-error { border-color: #ef4444; }
        .field-error { font-size: 11px; color: #ef4444; display: flex; align-items: center; gap: 4px; }
        .field-hint  { font-size: 11px; color: #9ca3af; }

        /* Toggle switch */
        .toggle-group { display: flex; flex-direction: column; gap: 10px; }
        .toggle-item  { display: flex; align-items: center; justify-content: space-between; padding: 12px 16px; background: #f8fafc; border-radius: 10px; border: 1px solid #e2e8f0; }
        .toggle-label { font-size: 13px; color: #374151; display: flex; align-items: center; gap: 8px; }
        .toggle-label i { font-size: 18px; color: #5b21b6; }
        .switch { position: relative; width: 40px; height: 22px; }
        .switch input { opacity: 0; width: 0; height: 0; }
        .slider { position: absolute; inset: 0; background: #d1d5db; border-radius: 99px; cursor: pointer; transition: .3s; }
        .slider:before { content:''; position: absolute; width: 16px; height: 16px; left: 3px; top: 3px; background: #fff; border-radius: 50%; transition: .3s; }
        .switch input:checked + .slider { background: #5b21b6; }
        .switch input:checked + .slider:before { transform: translateX(18px); }

        /* Materias checkboxes */
        .materias-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; margin-top: 8px; }
        .materia-opt  { position: relative; }
        .materia-opt input[type="checkbox"] { position: absolute; opacity: 0; width: 0; height: 0; }
        .materia-label { display: flex; align-items: center; gap: 8px; padding: 10px 14px; border: 2px solid #e2e8f0; border-radius: 10px; cursor: pointer; font-size: 13px; color: #64748b; transition: all .2s; }
        .materia-label i { font-size: 18px; }
        .materia-opt input:checked + .materia-label { border-color: #5b21b6; background: #f5f3ff; color: #5b21b6; font-weight: 500; }

        /* Upload */
        .upload-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .upload-item .field-label { font-size: 12px; font-weight: 500; color: #374151; margin-bottom: 5px; }
        .upload-box { border: 2px dashed #d1d5db; border-radius: 10px; padding: 16px; text-align: center; cursor: pointer; transition: border-color .2s, background .2s; position: relative; }
        .upload-box:hover { border-color: #5b21b6; background: #faf8ff; }
        .upload-box input[type="file"] { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
        .upload-box i   { font-size: 24px; color: #94a3b8; display: block; margin-bottom: 6px; }
        .upload-box .up-title { font-size: 12px; font-weight: 500; color: #374151; }
        .upload-box .up-hint  { font-size: 10px; color: #9ca3af; margin-top: 3px; }
        .upload-box.has-file  { border-color: #6ee7b7; background: #f0fdf4; }
        .upload-box.has-file i { color: #059669; }
        .upload-box.req-border { border-color: #fca5a5; }

        /* Botones */
        .btn { padding: 10px 24px; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer; border: none; font-family: 'Figtree', sans-serif; display: inline-flex; align-items: center; gap: 6px; transition: background .2s, transform .1s; }
        .btn:active { transform: scale(.98); }
        .btn-primary   { background: #5b21b6; color: #fff; }
        .btn-primary:hover { background: #4c1d95; }
        .btn-secondary { background: #f1f5f9; color: #374151; border: 1px solid #e2e8f0; }
        .btn-secondary:hover { background: #e2e8f0; }
        .btn-success   { background: #059669; color: #fff; }
        .btn-success:hover { background: #047857; }
        .nav-btns { display: flex; justify-content: space-between; align-items: center; margin-top: 24px; }

        /* Alertas */
        .error-banner { background: #fef2f2; border: 1px solid #fecaca; border-radius: 10px; padding: 14px 18px; margin-bottom: 20px; font-size: 13px; color: #b91c1c; display: flex; gap: 10px; align-items: flex-start; }
        .error-banner i { font-size: 18px; flex-shrink: 0; margin-top: 1px; }
        .error-banner ul { list-style: none; }
        .error-banner ul li::before { content: '· '; }

        .conv-banner { background: #f5f3ff; border: 1px solid #ddd6fe; border-radius: 10px; padding: 12px 16px; display: flex; align-items: center; gap: 10px; margin-bottom: 24px; font-size: 13px; color: #5b21b6; }
        .no-conv { background: #fef9c3; border: 1px solid #fde68a; border-radius: 10px; padding: 16px 20px; text-align: center; font-size: 13px; color: #92400e; margin-bottom: 24px; }

        .info-box { background: #f8fafc; border-radius: 10px; padding: 14px 16px; margin-top: 20px; font-size: 12px; color: #64748b; border: 1px solid #e2e8f0; }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            .stepper { justify-content: flex-start; padding: 0 16px; -webkit-overflow-scrolling: touch; }
            .grid-2, .grid-3, .turno-grid, .upload-grid, .materias-grid { grid-template-columns: 1fr !important; }
            .col-span-2 { grid-column: span 1 !important; }
            .container { padding: 16px 12px 60px; }
            .card { padding: 20px 16px; }
            .hero { padding: 32px 16px 24px; }
            .nav-btns { flex-direction: column-reverse; gap: 12px; }
            .nav-btns .btn { width: 100%; justify-content: center; }
            .header { padding: 0 16px; }
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

<header class="header">
    <a href="{{ route('login') }}" class="header-brand">
        <i class="ti ti-school" style="font-size:20px"></i> CUP — FICCT
    </a>
    <a href="{{ route('login') }}" class="header-back">
        <i class="ti ti-arrow-left"></i> Volver al inicio
    </a>
</header>

<div class="hero">
    <div class="hero-badge"><i class="ti ti-chalkboard"></i> Pre-registro de docente</div>
    <h1>Formulario de Pre-registro Docente</h1>
    <p>Completa tus datos y sube los documentos requeridos para postular como docente del curso</p>
</div>

<div class="stepper">
    <div class="step active" id="tab-1"><span class="step-num">1</span> Datos personales</div>
    <div class="step"        id="tab-2"><span class="step-num">2</span> Formación académica</div>
    <div class="step"        id="tab-3"><span class="step-num">3</span> Documentos</div>
</div>

<div class="container">

    {{-- CONVOCATORIA --}}
    @if($convocatoria)
        <div class="conv-banner">
            <i class="ti ti-calendar-event"></i>
            <div><strong>Convocatoria activa:</strong> {{ $convocatoria->nombre }} — Fecha límite: <strong>{{ \Carbon\Carbon::parse($convocatoria->fecha_fin)->format('d/m/Y') }}</strong></div>
        </div>
    @else
        <div class="no-conv">
            <i class="ti ti-alert-circle" style="font-size:20px;display:block;margin-bottom:6px"></i>
            <strong>No hay convocatoria activa en este momento.</strong><br>
            El pre-registro estará habilitado cuando la administración abra una nueva convocatoria.
        </div>
    @endif

    {{-- ERRORES --}}
    @if($errors->any())
        <div class="error-banner">
            <i class="ti ti-alert-circle"></i>
            <div>
                <strong>Por favor corrige los siguientes errores:</strong>
                <ul>
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('pre-registro.docente.store') }}" enctype="multipart/form-data" id="form-doc" novalidate>
        @csrf

        {{-- ══ PASO 1: DATOS PERSONALES ══ --}}
        <div class="section active" id="sec-1">
            <div class="card">
                <div class="card-header">
                    <div class="card-icon ci-purple"><i class="ti ti-user"></i></div>
                    <div><h2>Datos personales</h2><p>Información básica del docente postulante</p></div>
                </div>
                <div class="grid-2">
                    <div class="field">
                        <label>Nombres <span class="req">*</span></label>
                        <input type="text" name="nombre" value="{{ old('nombre') }}" placeholder="Ej: Juan Carlos" class="{{ $errors->has('nombre') ? 'is-error':'' }}">
                        @error('nombre')<div class="field-error"><i class="ti ti-alert-circle"></i>{{ $message }}</div>@enderror
                    </div>
                    <div class="field">
                        <label>Apellidos <span class="req">*</span></label>
                        <input type="text" name="apellido" value="{{ old('apellido') }}" placeholder="Ej: García Pérez" class="{{ $errors->has('apellido') ? 'is-error':'' }}">
                        @error('apellido')<div class="field-error"><i class="ti ti-alert-circle"></i>{{ $message }}</div>@enderror
                    </div>
                    <div class="field">
                        <label>Carnet de identidad (CI) <span class="req">*</span></label>
                        <input type="text" name="ci" value="{{ old('ci') }}" placeholder="Ej: 12345678" class="{{ $errors->has('ci') ? 'is-error':'' }}">
                        @error('ci')<div class="field-error"><i class="ti ti-alert-circle"></i>{{ $message }}</div>@enderror
                    </div>
                    <div class="field">
                        <label>Extensión CI <span class="req">*</span></label>
                        <select name="ci_extension" class="{{ $errors->has('ci_extension') ? 'is-error':'' }}">
                            <option value="">Seleccionar...</option>
                            @foreach(['SC'=>'Santa Cruz','LP'=>'La Paz','CB'=>'Cochabamba','OR'=>'Oruro','PT'=>'Potosí','TJ'=>'Tarija','CH'=>'Chuquisaca','BN'=>'Beni','PD'=>'Pando'] as $k=>$v)
                                <option value="{{ $k }}" {{ old('ci_extension')==$k ? 'selected':'' }}>{{ $k }} — {{ $v }}</option>
                            @endforeach
                        </select>
                        @error('ci_extension')<div class="field-error"><i class="ti ti-alert-circle"></i>{{ $message }}</div>@enderror
                    </div>
                    <div class="field">
                        <label>Fecha de nacimiento <span class="req">*</span></label>
                        <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" class="{{ $errors->has('fecha_nacimiento') ? 'is-error':'' }}">
                        @error('fecha_nacimiento')<div class="field-error"><i class="ti ti-alert-circle"></i>{{ $message }}</div>@enderror
                    </div>
                    <div class="field">
                        <label>Teléfono / Celular</label>
                        <input type="tel" name="telefono" value="{{ old('telefono') }}" placeholder="Ej: 70000000">
                    </div>
                    <div class="field">
                        <label>Correo electrónico <span class="req">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Ej: docente@gmail.com" class="{{ $errors->has('email') ? 'is-error':'' }}">
                        @error('email')<div class="field-error"><i class="ti ti-alert-circle"></i>{{ $message }}</div>@enderror
                    </div>
                    <div class="field">
                        <label>Ciudad <span class="req">*</span></label>
                        <input type="text" name="ciudad" value="{{ old('ciudad') }}" placeholder="Ej: Santa Cruz de la Sierra" class="{{ $errors->has('ciudad') ? 'is-error':'' }}">
                        @error('ciudad')<div class="field-error"><i class="ti ti-alert-circle"></i>{{ $message }}</div>@enderror
                    </div>
                    <div class="field col-span-2">
                        <label>Dirección</label>
                        <input type="text" name="direccion" value="{{ old('direccion') }}" placeholder="Ej: Av. Cañoto #123, Barrio Centro">
                    </div>
                </div>
            </div>
            <div class="nav-btns">
                <span></span>
                <button type="button" class="btn btn-primary" onclick="goTo(2)">
                    Siguiente <i class="ti ti-arrow-right"></i>
                </button>
            </div>
        </div>

        {{-- ══ PASO 2: FORMACIÓN ACADÉMICA ══ --}}
        <div class="section" id="sec-2">
            <div class="card">
                <div class="card-header">
                    <div class="card-icon ci-blue"><i class="ti ti-school"></i></div>
                    <div><h2>Formación académica</h2><p>Títulos, especializaciones y materias que puede impartir</p></div>
                </div>
                <div class="grid-2" style="margin-bottom:20px">
                    <div class="field">
                        <label>Grado académico <span class="req">*</span></label>
                        <select name="grado_academico" class="{{ $errors->has('grado_academico') ? 'is-error':'' }}">
                            <option value="">Seleccionar...</option>
                            @foreach(['Licenciatura','Ingeniería','Maestría','Doctorado','Técnico Superior'] as $g)
                                <option value="{{ $g }}" {{ old('grado_academico')==$g ? 'selected':'' }}>{{ $g }}</option>
                            @endforeach
                        </select>
                        @error('grado_academico')<div class="field-error"><i class="ti ti-alert-circle"></i>{{ $message }}</div>@enderror
                    </div>
                    <div class="field">
                        <label>Especialidad / Área <span class="req">*</span></label>
                        <input type="text" name="especialidad" value="{{ old('especialidad') }}" placeholder="Ej: Matemáticas Aplicadas, Ciencias de la Computación" class="{{ $errors->has('especialidad') ? 'is-error':'' }}">
                        @error('especialidad')<div class="field-error"><i class="ti ti-alert-circle"></i>{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- Toggles maestría y diplomado --}}
                <div class="toggle-group" style="margin-bottom:20px">
                    <div class="toggle-item">
                        <span class="toggle-label">
                            <i class="ti ti-certificate"></i>
                            Tiene Maestría
                        </span>
                        <label class="switch">
                            <input type="checkbox" name="tiene_maestria" value="1" {{ old('tiene_maestria') ? 'checked':'' }}>
                            <span class="slider"></span>
                        </label>
                    </div>
                    <div class="toggle-item">
                        <span class="toggle-label">
                            <i class="ti ti-award"></i>
                            Tiene Diplomado en Educación Superior
                        </span>
                        <label class="switch">
                            <input type="checkbox" name="tiene_diplomado" value="1" {{ old('tiene_diplomado') ? 'checked':'' }}>
                            <span class="slider"></span>
                        </label>
                    </div>
                </div>

                {{-- Materias --}}
                <div class="field">
                    <label>Materias que puede impartir <span class="req">*</span></label>
                    <p class="field-hint" style="margin-bottom:8px">Selecciona una o más materias</p>
                    <div class="materias-grid">
                        @foreach($materias as $m)
                        @php
                            $icons = ['MAT'=>'ti-math-function','FIS'=>'ti-atom','COM'=>'ti-device-desktop','ING'=>'ti-language'];
                            $ico = $icons[$m->codigo] ?? 'ti-book';
                        @endphp
                        <label class="materia-opt">
                            <input type="checkbox" name="materias[]" value="{{ $m->id }}"
                                {{ in_array($m->id, old('materias', [])) ? 'checked':'' }}>
                            <span class="materia-label">
                                <i class="ti {{ $ico }}"></i> {{ $m->nombre }}
                            </span>
                        </label>
                        @endforeach
                    </div>
                    @error('materias')<div class="field-error" style="margin-top:6px"><i class="ti ti-alert-circle"></i>{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="nav-btns">
                <button type="button" class="btn btn-secondary" onclick="goTo(1)">
                    <i class="ti ti-arrow-left"></i> Anterior
                </button>
                <button type="button" class="btn btn-primary" onclick="goTo(3)">
                    Siguiente <i class="ti ti-arrow-right"></i>
                </button>
            </div>
        </div>

        {{-- ══ PASO 3: DOCUMENTOS ══ --}}
        <div class="section" id="sec-3">
            <div class="card">
                <div class="card-header">
                    <div class="card-icon ci-amber"><i class="ti ti-files"></i></div>
                    <div><h2>Documentos requeridos</h2><p>Sube los archivos en formato PDF, JPG o PNG (máx. 3 MB c/u)</p></div>
                </div>

                <div class="upload-grid">
                    @php
                    $docs = [
                        ['field'=>'doc_ci',               'tipo'=>'CI',                 'label'=>'Carnet de identidad',            'icon'=>'ti-id-badge-2',  'req'=>true],
                        ['field'=>'doc_titulo_provision',  'tipo'=>'TITULO_PROVISION',   'label'=>'Título en Provisión Nacional',   'icon'=>'ti-certificate', 'req'=>true],
                        ['field'=>'doc_diploma_academico', 'tipo'=>'DIPLOMA_ACADEMICO',  'label'=>'Diploma Académico',              'icon'=>'ti-award',       'req'=>true],
                        ['field'=>'doc_curriculum',        'tipo'=>'CURRICULUM_VITAE',   'label'=>'Curriculum Vitae',               'icon'=>'ti-file-cv',     'req'=>true],
                        ['field'=>'doc_cert_no_imped',     'tipo'=>'CERT_NO_IMPEDIMENTO','label'=>'Certificado de No Impedimento',  'icon'=>'ti-shield-check','req'=>true],
                        ['field'=>'doc_planilla_materias', 'tipo'=>'PLANILLA_MATERIAS',  'label'=>'Planilla de Materias',           'icon'=>'ti-list-check',  'req'=>true],
                        ['field'=>'doc_certificado_item',  'tipo'=>'CERTIFICADO_ITEM',   'label'=>'Certificado de Ítem (opcional)', 'icon'=>'ti-file-text',   'req'=>false],
                    ];
                    @endphp

                    @foreach($docs as $doc)
                    <div class="upload-item">
                        <div class="field-label">
                            {{ $doc['label'] }}
                            @if($doc['req'])<span style="color:#ef4444"> *</span>@else<span style="color:#9ca3af;font-size:11px"> (opcional)</span>@endif
                        </div>
                        <div class="upload-box {{ $errors->has($doc['field']) ? 'req-border':'' }}" id="box-{{ $doc['field'] }}">
                            <input type="file" name="{{ $doc['field'] }}" accept=".pdf,.jpg,.jpeg,.png"
                                   onchange="previewUpload(this,'box-{{ $doc['field'] }}','lbl-{{ $doc['field'] }}')">
                            <i class="ti {{ $doc['icon'] }}" id="ico-{{ $doc['field'] }}"></i>
                            <div class="up-title" id="lbl-{{ $doc['field'] }}">Seleccionar</div>
                            <div class="up-hint">PDF, JPG o PNG · 3 MB</div>
                        </div>
                        @error($doc['field'])
                            <div class="field-error" style="margin-top:4px;font-size:11px"><i class="ti ti-alert-circle"></i>{{ $message }}</div>
                        @enderror
                    </div>
                    @endforeach
                </div>

                <div class="info-box" style="margin-top:20px">
                    <i class="ti ti-info-circle" style="vertical-align:-2px"></i>
                    Al enviar este formulario, tu solicitud quedará en estado <strong>PENDIENTE</strong> hasta que el administrador la revise y apruebe. Recibirás tus credenciales de acceso por correo electrónico.
                </div>
            </div>
            <div class="nav-btns">
                <button type="button" class="btn btn-secondary" onclick="goTo(2)">
                    <i class="ti ti-arrow-left"></i> Anterior
                </button>
                <button type="submit" class="btn btn-success" {{ !$convocatoria ? 'disabled':'' }}>
                    <i class="ti ti-send"></i> Enviar pre-registro
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    // Si hay errores, ir al paso correcto
    let goStep = 1;
    @if($errors->has('nombre') || $errors->has('apellido') || $errors->has('ci') || $errors->has('email') || $errors->has('ciudad'))
        goStep = 1;
    @elseif($errors->has('grado_academico') || $errors->has('especialidad') || $errors->has('materias'))
        goStep = 2;
    @elseif($errors->has('doc_ci') || $errors->has('doc_titulo_provision') || $errors->has('doc_diploma_academico') || $errors->has('doc_curriculum') || $errors->has('doc_cert_no_imped') || $errors->has('doc_planilla_materias'))
        goStep = 3;
    @endif

    function goTo(n) {
        document.querySelectorAll('.section').forEach((s,i) => s.classList.toggle('active', i===n-1));
        document.querySelectorAll('.step').forEach((t,i) => {
            t.classList.remove('active','done');
            if (i===n-1) t.classList.add('active');
            if (i<n-1)   t.classList.add('done');
        });
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    if (goStep > 1) goTo(goStep);

    function previewUpload(input, boxId, lblId) {
        const box = document.getElementById(boxId);
        const lbl = document.getElementById(lblId);
        if (input.files && input.files[0]) {
            const size = (input.files[0].size/1024/1024).toFixed(2);
            lbl.textContent = input.files[0].name + ' (' + size + ' MB)';
            box.classList.add('has-file');
            box.classList.remove('req-border');
        }
    }
</script>
</body>
</html>