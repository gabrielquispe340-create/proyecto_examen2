<aside class="sidebar">
    <div class="sidebar-brand">
        <i class="ti ti-school"></i>
        <span>CUP — FICCT</span>
    </div>

    {{-- USUARIO --}}
    <div class="sidebar-user">
        <div class="s-avatar">
            {{ strtoupper(substr($postulante->nombre,0,1)) }}{{ strtoupper(substr($postulante->apellido,0,1)) }}
        </div>
        <div class="s-name">{{ $postulante->nombre }} {{ $postulante->apellido }}</div>
        <div class="s-code">{{ $postulante->codigo_estudiante }}</div>
    </div>

    <nav class="sidebar-menu">
        <div class="menu-label">Mi Cuenta</div>
        <a href="{{ route('postulante.dashboard') }}"
           class="menu-item {{ request()->routeIs('postulante.dashboard') ? 'active' : '' }}">
            <i class="ti ti-smart-home"></i><span>Inicio</span>
        </a>
        <a href="{{ route('postulante.notas') }}"
           class="menu-item {{ request()->routeIs('postulante.notas') ? 'active' : '' }}">
            <i class="ti ti-file-analytics"></i><span>Mis Notas</span>
        </a>
        <a href="{{ route('postulante.grupo') }}"
           class="menu-item {{ request()->routeIs('postulante.grupo') ? 'active' : '' }}">
            <i class="ti ti-users-group"></i><span>Mi Grupo</span>
        </a>
        <a href="{{ route('postulante.horario') }}"
           class="menu-item {{ request()->routeIs('postulante.horario') ? 'active' : '' }}">
            <i class="ti ti-calendar"></i><span>Mi Horario</span>
        </a>
    </nav>

    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout-side">
                <i class="ti ti-logout"></i> Cerrar Sesión
            </button>
        </form>
    </div>
</aside>