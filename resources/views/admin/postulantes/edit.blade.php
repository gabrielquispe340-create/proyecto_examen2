<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar postulante — CUP FICCT</title>
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">
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
        .btn-logout:hover { background: rgba(255,255,255,0.22); }

        .sidebar { width: 224px; height: calc(100vh - 56px); background: #1e3a6e; position: fixed; top: 56px; left: 0; overflow-y: auto; padding: 20px 12px 24px; display: flex; flex-direction: column; gap: 2px; }
        .nav-label { font-size: 10px; font-weight: 700; color: rgba(168,200,240,0.55); text-transform: uppercase; letter-spacing: .1em; padding: 16px 10px 6px; }
        .nav-label:first-child { padding-top: 4px; }
        .nav-item { padding: 9px 12px; font-size: 13px; color: rgba(168,200,240,0.85); text-decoration: none; border-radius: 8px; display: flex; align-items: center; gap: 10px; transition: background .15s, color .15s; }
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
        .page { padding: 28px; max-width: 780px; }

        .page-header { margin-bottom: 24px; display: flex; align-items: center; gap: 14px; }
        .back-btn { color: #64748b; text-decoration: none; font-size: 13px; display: flex; align-items: center; gap: 5px; padding: 6px 12px; border: 1px solid #e2e8f0; border-radius: 8px; background: #fff; }
        .back-btn:hover { background: #f1f5f9; }
        .page-title { font-size: 20px; font-weight: 600; color: #1e293b; }
        .page-sub { font-size: 13px; color: #94a3b8; margin-top: 2px; }

        .card { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; margin-bottom: 20px; overflow: hidden; }
        .card-title { font-size: 13px; font-weight: 600; color: #475569; padding: 14px 20px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; gap: 8px; }
        .card-body { padding: 20px; }

        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; }

        .form-group { display: flex; flex-direction: column; gap: 5px; }
        .form-group label { font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: .04em; }
        .form-group input,
        .form-group select { padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; color: #374151; background: #f8fafc; font-family: 'Figtree', sans-serif; width: 100%; transition: border-color .15s; }
        .form-group input:focus,
        .form-group select:focus { outline: none; border-color: #1e3a6e; background: #fff; }
        .form-group .error { font-size: 11px; color: #dc2626; margin-top: 2px; }

        .section-sep { height: 1px; background: #f1f5f9; margin: 20px 0; }

        .btn { padding: 9px 20px; border-radius: 8px; font-size: 13px; cursor: pointer; border: none; font-family: 'Figtree', sans-serif; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-weight: 500; }
        .btn-primary { background: #1e3a6e; color: #fff; }
        .btn-primary:hover { background: #0f2147; }
        .btn-cancel { background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; }
        .btn-cancel:hover { background: #e2e8f0; }

        .alert-err { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; padding: 12px 16px; border-radius: 8px; font-size: 13px; margin-bottom: 16px; }
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
        <a href="{{ route('admin.postulantes.show', $postulante) }}" class="back-btn">
            <i class="ti ti-arrow-left"></i> Volver
        </a>
        <div>
            <div class="page-title">Editar postulante</div>
            <div class="page-sub">{{ $postulante->nombre }} {{ $postulante->apellido }} · <span style="font-family:monospace">{{ $postulante->codigo_estudiante }}</span></div>
        </div>
    </div>

    @if($errors->any())
        <div class="alert-err">
            <strong><i class="ti ti-alert-circle"></i> Corrige los errores:</strong>
            <ul style="margin-top:6px;padding-left:18px">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.postulantes.update', $postulante) }}">
        @csrf
        @method('PATCH')

        {{-- Datos personales --}}
        <div class="card">
            <div class="card-title"><i class="ti ti-user" style="color:#1e3a6e"></i> Datos personales</div>
            <div class="card-body">
                <div class="grid-2" style="margin-bottom:16px">
                    <div class="form-group">
                        <label>Nombre *</label>
                        <input type="text" name="nombre" value="{{ old('nombre', $postulante->nombre) }}" required>
                        @error('nombre')<span class="error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Apellido *</label>
                        <input type="text" name="apellido" value="{{ old('apellido', $postulante->apellido) }}" required>
                        @error('apellido')<span class="error">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="grid-3">
                    <div class="form-group">
                        <label>Email *</label>
                        <input type="email" name="email" value="{{ old('email', $postulante->email) }}" required>
                        @error('email')<span class="error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Teléfono</label>
                        <input type="text" name="telefono" value="{{ old('telefono', $postulante->telefono) }}">
                    </div>
                    <div class="form-group">
                        <label>Ciudad</label>
                        <input type="text" name="ciudad" value="{{ old('ciudad', $postulante->ciudad) }}">
                    </div>
                </div>
                <div class="section-sep"></div>
                <div class="form-group">
                    <label>Dirección</label>
                    <input type="text" name="direccion" value="{{ old('direccion', $postulante->direccion) }}">
                </div>
            </div>
        </div>

        {{-- Datos académicos --}}
        <div class="card">
            <div class="card-title"><i class="ti ti-school" style="color:#1e3a6e"></i> Datos académicos</div>
            <div class="card-body">
                <div class="grid-3" style="margin-bottom:16px">
                    <div class="form-group">
                        <label>Turno *</label>
                        <select name="turno_asignado" required>
                            @foreach(['MAÑANA','TARDE','NOCHE'] as $t)
                                <option value="{{ $t }}" {{ old('turno_asignado', $postulante->turno_asignado) === $t ? 'selected' : '' }}>{{ ucfirst(strtolower($t)) }}</option>
                            @endforeach
                        </select>
                        @error('turno_asignado')<span class="error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Estado *</label>
                        <select name="estado" required>
                            @foreach(['REGISTRADO','CON_PAGO','RETIRADO'] as $s)
                                <option value="{{ $s }}" {{ old('estado', $postulante->estado) === $s ? 'selected' : '' }}>{{ $s }}</option>
                            @endforeach
                        </select>
                        @error('estado')<span class="error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Colegio</label>
                        <input type="text" name="colegio_nombre" value="{{ old('colegio_nombre', $postulante->colegio_nombre) }}">
                    </div>
                </div>
                <div class="grid-2">
                    <div class="form-group">
                        <label>Carrera preferida 1</label>
                        <select name="carrera_pref_1_id">
                            <option value="">— Sin preferencia —</option>
                            @foreach($carreras as $c)
                                <option value="{{ $c->id }}" {{ old('carrera_pref_1_id', $postulante->carrera_pref_1_id) == $c->id ? 'selected' : '' }}>{{ $c->nombre }}</option>
                            @endforeach
                        </select>
                        @error('carrera_pref_1_id')<span class="error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Carrera preferida 2</label>
                        <select name="carrera_pref_2_id">
                            <option value="">— Sin preferencia —</option>
                            @foreach($carreras as $c)
                                <option value="{{ $c->id }}" {{ old('carrera_pref_2_id', $postulante->carrera_pref_2_id) == $c->id ? 'selected' : '' }}>{{ $c->nombre }}</option>
                            @endforeach
                        </select>
                        @error('carrera_pref_2_id')<span class="error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Acciones --}}
        <div style="display:flex;gap:12px;justify-content:flex-end">
            <a href="{{ route('admin.postulantes.show', $postulante) }}" class="btn btn-cancel">
                <i class="ti ti-x"></i> Cancelar
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="ti ti-device-floppy"></i> Guardar cambios
            </button>
        </div>
    </form>

</div>
</main>
</body>
</html>