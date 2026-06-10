<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Docente — CUP FICCT</title>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Figtree', sans-serif; background: #f1f5f9; color: #1e293b; }

        .topbar { background: #1e3a6e; padding: 0 24px; height: 56px; display: flex; align-items: center; justify-content: space-between; position: fixed; top: 0; left: 0; right: 0; z-index: 200; }
        .topbar-brand { color: #fff; font-size: 16px; font-weight: 600; display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .topbar-right { display: flex; align-items: center; gap: 16px; }
        .topbar-user { color: #a8c8f0; font-size: 13px; display: flex; align-items: center; gap: 6px; }
        .btn-logout { background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.22); color: #fff; padding: 6px 14px; border-radius: 8px; font-size: 12px; cursor: pointer; text-decoration: none; display: flex; align-items: center; gap: 6px; }

        .sidebar { width: 224px; height: calc(100vh - 56px); background: #1e3a6e; position: fixed; top: 56px; left: 0; overflow-y: auto; padding: 20px 12px 24px; display: flex; flex-direction: column; gap: 2px; }
        .nav-label { font-size: 10px; font-weight: 700; color: rgba(168,200,240,0.55); text-transform: uppercase; letter-spacing: .1em; padding: 16px 10px 6px; }
        .nav-item { padding: 9px 12px; font-size: 13px; color: rgba(168,200,240,0.85); text-decoration: none; border-radius: 8px; display: flex; align-items: center; gap: 10px; transition: background .15s; }
        .nav-item:hover, .nav-item.active { background: rgba(255,255,255,0.15); color: #fff; }
        .sidebar-footer { margin-top: auto; padding: 16px 10px 0; font-size: 11px; color: rgba(168,200,240,0.4); }

        .main { margin-left: 224px; padding-top: 56px; min-height: 100vh; }
        .page { padding: 28px 32px; max-width: 700px; }

        .page-header { margin-bottom: 24px; }
        .page-title { font-size: 22px; font-weight: 600; color: #1e293b; }
        .page-sub { font-size: 13px; color: #64748b; margin-top: 2px; }

        .card { background: #fff; border-radius: 14px; border: 1px solid #e2e8f0; padding: 28px; }

        .avatar-big { width: 64px; height: 64px; border-radius: 50%; background: #1e3a6e; color: #fff; font-size: 22px; font-weight: 600; display: flex; align-items: center; justify-content: center; margin-bottom: 16px; }

        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 6px; text-transform: uppercase; letter-spacing: .05em; }
        .form-group input, .form-group select { width: 100%; padding: 9px 12px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; font-family: 'Figtree', sans-serif; color: #1e293b; background: #fff; }
        .form-group input:focus, .form-group select:focus { outline: none; border-color: #1e3a6e; box-shadow: 0 0 0 3px rgba(30,58,110,0.08); }
        .form-group input[disabled] { background: #f8fafc; color: #94a3b8; cursor: not-allowed; }

        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

        .btn-primary { padding: 10px 24px; background: #1e3a6e; color: #fff; border: none; border-radius: 8px; font-size: 13px; font-weight: 500; cursor: pointer; font-family: 'Figtree', sans-serif; display: inline-flex; align-items: center; gap: 6px; }
        .btn-primary:hover { background: #0f2147; }
        .btn-secondary { padding: 10px 20px; background: #f1f5f9; border: 1px solid #e2e8f0; color: #475569; border-radius: 8px; font-size: 13px; cursor: pointer; font-family: 'Figtree', sans-serif; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
        .btn-secondary:hover { background: #e2e8f0; }

        .alert { padding: 12px 16px; border-radius: 10px; margin-bottom: 16px; font-size: 13px; display: flex; align-items: center; gap: 8px; }
        .alert-ok  { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }
        .alert-err { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }

        .info-block { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 14px 16px; margin-bottom: 20px; font-size: 13px; color: #475569; }
        .info-block strong { color: #1e293b; }
    
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

<div class="topbar">
    <button type="button" class="btn-menu-mobile" onclick="document.querySelector('.sidebar').classList.toggle('open'); document.getElementById('sidebar-overlay-mobile').classList.toggle('show');">&#9776;</button>
    <a href="{{ route('admin.dashboard') }}" class="topbar-brand">
        <i class="ti ti-school" style="font-size:20px"></i> CUP — FICCT
    </a>
    <div class="topbar-right">
        <span class="topbar-user">
            <i class="ti ti-user-circle"></i>
            {{ Auth::user()->nombre ?? '' }} {{ Auth::user()->apellido ?? '' }}
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
        <div class="page-title">Editar Docente</div>
        <div class="page-sub">Actualiza la especialidad y estado del docente</div>
    </div>

    @if(session('success'))
        <div class="alert alert-ok"><i class="ti ti-circle-check"></i> {{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-err"><i class="ti ti-alert-circle"></i> {{ $errors->first() }}</div>
    @endif

    <div class="card">
        {{-- Info del docente (solo lectura) --}}
        <div class="avatar-big">{{ strtoupper(substr($docente->nombre,0,1).substr($docente->apellido,0,1)) }}</div>

        <div class="info-block" style="margin-bottom:24px">
            <strong>{{ $docente->nombre }} {{ $docente->apellido }}</strong><br>
            Código: <span style="font-family:monospace;font-weight:600;color:#1e3a6e">{{ $docente->codigo_docente ?? '—' }}</span> &nbsp;|&nbsp; CI: {{ $docente->ci }} &nbsp;|&nbsp; Email: {{ $docente->email }}
        </div>

        <form method="POST" action="{{ route('admin.docentes.update', $docente->id) }}">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group">
                    <label>Especialidad / Materia</label>
                    <select name="especialidad">
                        <option value="">— Sin asignar —</option>
                        @foreach($materias as $materia)
                            <option value="{{ $materia->nombre }}"
                                {{ old('especialidad', $docente->especialidad) == $materia->nombre ? 'selected' : '' }}>
                                {{ $materia->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Teléfono</label>
                    <input type="text" name="telefono" value="{{ old('telefono', $docente->telefono) }}" placeholder="Ej: 70000001">
                </div>
            </div>

            <div class="form-group" style="max-width:200px">
                <label>Estado</label>
                <select name="estado">
                    <option value="ACTIVO"   {{ old('estado', $docente->estado) == 'ACTIVO'   ? 'selected' : '' }}>Activo</option>
                    <option value="INACTIVO" {{ old('estado', $docente->estado) == 'INACTIVO' ? 'selected' : '' }}>Inactivo</option>
                    <option value="LICENCIA" {{ old('estado', $docente->estado) == 'LICENCIA' ? 'selected' : '' }}>Licencia</option>
                </select>
            </div>

            <div style="display:flex;gap:12px;margin-top:8px">
                <button type="submit" class="btn-primary"><i class="ti ti-device-floppy"></i> Guardar cambios</button>
                <a href="{{ route('admin.docentes.index') }}" class="btn-secondary"><i class="ti ti-arrow-left"></i> Volver</a>
            </div>
        </form>
    </div>

</div>
</main>
</body>
</html>