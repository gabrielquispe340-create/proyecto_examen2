<aside class="sidebar">
    <div class="nav-label">Menú</div>
    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }} c-sky">
        <i class="ti ti-home"></i> Inicio
    </a>
    <a href="{{ route('admin.pre-registros.index') }}" class="nav-item {{ request()->routeIs('admin.pre-registros.*') ? 'active' : '' }} c-amber">
        <i class="ti ti-clock"></i> Pre-registros
    </a>
    <a href="{{ route('admin.postulantes.index') }}" class="nav-item {{ request()->routeIs('admin.postulantes.*') ? 'active' : '' }} c-blue">
        <i class="ti ti-id-badge"></i> Postulantes
    </a>
    <a href="{{ route('admin.docentes.index') }}" class="nav-item {{ request()->routeIs('admin.docentes.*') ? 'active' : '' }} c-purple">
        <i class="ti ti-chalkboard"></i> Docentes
    </a>

    <div class="nav-label">Académico</div>
    <a href="{{ route('admin.grupos.index') }}" class="nav-item {{ request()->routeIs('admin.grupos.*') ? 'active' : '' }} c-teal">
        <i class="ti ti-layout-grid"></i> Grupos
    </a>
    <a href="{{ route('admin.horarios.index') }}" class="nav-item {{ request()->routeIs('admin.horarios.*') ? 'active' : '' }} c-sky">
        <i class="ti ti-calendar-time"></i> Horarios
    </a>
    <a href="{{ route('admin.examenes.index') }}" class="nav-item {{ request()->routeIs('admin.examenes.*') ? 'active' : '' }} c-rose">
        <i class="ti ti-file-text"></i> Exámenes
    </a>
    <a href="{{ route('admin.convocatorias.index') }}" class="nav-item {{ request()->routeIs('admin.convocatorias.*') ? 'active' : '' }} c-blue">
        <i class="ti ti-building"></i> Convocatoria
    </a>

    <div class="nav-label">Sistema</div>
    <a href="{{ route('admin.reportes.index') }}" class="nav-item {{ request()->routeIs('admin.reportes.*') ? 'active' : '' }} c-purple">
        <i class="ti ti-chart-bar"></i> Reportes
    </a>
    <a href="{{ route('admin.carga-masiva.index') }}" class="nav-item {{ request()->routeIs('admin.carga-masiva.*') ? 'active' : '' }} c-teal">
        <i class="ti ti-upload"></i> Carga Masiva
    </a>
    <a href="{{ route('admin.credenciales.index') }}" class="nav-item {{ request()->routeIs('admin.credenciales.*') ? 'active' : '' }} c-sky">
        <i class="ti ti-key"></i> Credenciales
    </a>
    <a href="{{ route('admin.logs.index') }}" class="nav-item {{ request()->routeIs('admin.logs.*') ? 'active' : '' }} c-rose">
        <i class="ti ti-device-desktop-analytics"></i> Logs Actividad
    </a>

    <div class="sidebar-footer">UAGRM &copy; {{ date('Y') }}</div>
</aside>
