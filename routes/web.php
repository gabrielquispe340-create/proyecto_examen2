<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Public\PreRegistroEstudianteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PostulanteController;
use Illuminate\Support\Facades\DB;

// ── RAÍZ → LOGIN (O AL DASHBOARD CORRESPONDIENTE SI YA ESTÁ LOGUEADO) ──
Route::get('/', function () {
    return redirect()->route('login');
});

// ── DASHBOARD GENÉRICO (Redirige al dashboard de su rol) ─────
Route::get('/dashboard', function () {
    if (Illuminate\Support\Facades\Auth::check()) {
        $usuario = Illuminate\Support\Facades\Auth::user();
        $rol = Illuminate\Support\Facades\DB::table('rol')->where('id', $usuario->rol_id)->value('nombre_rol');

        return match($rol) {
            'ADMINISTRATIVO' => redirect()->route('admin.dashboard'),
            'DOCENTE'        => redirect()->route('docente.dashboard'),
            'POSTULANTE'     => redirect()->route('postulante.dashboard'),
            default          => view('dashboard'),
        };
    }
    return redirect()->route('login');
})->middleware(['auth', 'verified'])->name('dashboard');

// ── PERFIL ──────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ── AUTH (login / logout) ────────────────────────────────────
require __DIR__.'/auth.php';

// ── ADMIN ────────────────────────────────────────────────────
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
         ->name('dashboard');

    // Pre-registros
    Route::get('/pre-registros', [App\Http\Controllers\Admin\PreRegistroController::class, 'index'])
         ->name('pre-registros.index');
    Route::get('/pre-registros/estudiante/{id}', [App\Http\Controllers\Admin\PreRegistroController::class, 'showEstudiante'])
         ->name('pre-registros.estudiante.show');
    Route::get('/pre-registros/docente/{id}', [App\Http\Controllers\Admin\PreRegistroController::class, 'showDocente'])
         ->name('pre-registros.docente.show');
    Route::post('/pre-registros/estudiante/{id}/aprobar', [App\Http\Controllers\Admin\PreRegistroController::class, 'aprobarEstudiante'])
         ->name('pre-registros.estudiante.aprobar');
    Route::post('/pre-registros/estudiante/{id}/rechazar', [App\Http\Controllers\Admin\PreRegistroController::class, 'rechazarEstudiante'])
         ->name('pre-registros.estudiante.rechazar');
    Route::post('/pre-registros/docente/{id}/rechazar', [App\Http\Controllers\Admin\PreRegistroController::class, 'rechazarDocente'])
         ->name('pre-registros.docente.rechazar');

    // Docentes
    Route::get('/docentes', [App\Http\Controllers\Admin\DocenteController::class, 'index'])
         ->name('docentes.index');
    Route::get('/docentes/{id}/edit', [App\Http\Controllers\Admin\DocenteController::class, 'edit'])
         ->name('docentes.edit');
    Route::put('/docentes/{id}', [App\Http\Controllers\Admin\DocenteController::class, 'update'])
         ->name('docentes.update');

    // Grupos
    Route::get('/grupos', [App\Http\Controllers\Admin\GrupoController::class, 'index'])
         ->name('grupos.index');
    Route::post('/grupos/generar', [App\Http\Controllers\Admin\GrupoController::class, 'generar'])
         ->name('grupos.generar');
    Route::post('/grupos/limpiar', [App\Http\Controllers\Admin\GrupoController::class, 'limpiar'])
         ->name('grupos.limpiar');
    Route::put('/grupos/actualizar-turno', [App\Http\Controllers\Admin\GrupoController::class, 'actualizarTurno'])
         ->name('grupos.actualizar-turno');
    Route::post('/grupos/auto-asignar', [App\Http\Controllers\Admin\GrupoController::class, 'autoAsignar'])
         ->name('grupos.auto-asignar');
    Route::post('/grupos/auto-asignar-docentes', [App\Http\Controllers\Admin\GrupoController::class, 'autoAsignarDocentes'])
         ->name('grupos.auto-asignar-docentes');
    Route::get('/grupos/{grupo}', [App\Http\Controllers\Admin\GrupoController::class, 'show'])
         ->name('grupos.show');
    Route::post('/grupos/{grupo}/asignar-postulante', [App\Http\Controllers\Admin\GrupoController::class, 'asignarPostulante'])
         ->name('grupos.asignar-postulante');
    Route::post('/grupos/{grupo}/desasignar-postulante', [App\Http\Controllers\Admin\GrupoController::class, 'desasignarPostulante'])
         ->name('grupos.desasignar-postulante');
    Route::post('/grupos/{grupo}/asignar-docente', [App\Http\Controllers\Admin\GrupoController::class, 'asignarDocente'])
         ->name('grupos.asignar-docente');
    Route::post('/grupos/{grupo}/desasignar-docente', [App\Http\Controllers\Admin\GrupoController::class, 'desasignarDocente'])
         ->name('grupos.desasignar-docente');
    Route::get('/grupos/{grupo}/docentes', [App\Http\Controllers\Admin\GrupoController::class, 'docentesPorGrupo'])
         ->name('grupos.docentes');
    Route::get('/grupos/calcular-cantidad', [App\Http\Controllers\Admin\GrupoController::class, 'calcularGrupos'])
         ->name('grupos.calcular');

    // Exámenes
    Route::get('/examenes',                  [App\Http\Controllers\Admin\ExamenController::class, 'index'])    ->name('examenes.index');
    Route::post('/examenes',                 [App\Http\Controllers\Admin\ExamenController::class, 'store'])    ->name('examenes.store');
    Route::patch('/examenes/{id}',           [App\Http\Controllers\Admin\ExamenController::class, 'update'])   ->name('examenes.update');
    Route::delete('/examenes/{id}',          [App\Http\Controllers\Admin\ExamenController::class, 'destroy'])  ->name('examenes.destroy');
    Route::post('/examenes/importar',        [App\Http\Controllers\Admin\ExamenController::class, 'importar']) ->name('examenes.importar');
    Route::get('/examenes/reporte',          [App\Http\Controllers\Admin\ExamenController::class, 'reporte'])  ->name('examenes.reporte');

    // Convocatorias
    Route::get('/convocatorias', [App\Http\Controllers\Admin\ConvocatoriaController::class, 'index'])
         ->name('convocatorias.index');
    Route::post('/convocatorias', [App\Http\Controllers\Admin\ConvocatoriaController::class, 'store'])
         ->name('convocatorias.store');
    Route::get('/convocatorias/{id}/edit', [App\Http\Controllers\Admin\ConvocatoriaController::class, 'edit'])
         ->name('convocatorias.edit');
    Route::patch('/convocatorias/{id}', [App\Http\Controllers\Admin\ConvocatoriaController::class, 'update'])
         ->name('convocatorias.update');
    Route::post('/convocatorias/{id}/activar', [App\Http\Controllers\Admin\ConvocatoriaController::class, 'activar'])
         ->name('convocatorias.activar');
    Route::post('/convocatorias/{id}/concluir', [App\Http\Controllers\Admin\ConvocatoriaController::class, 'concluir'])
         ->name('convocatorias.concluir');

    // Reportes
    Route::get('/reportes',          [App\Http\Controllers\Admin\ReporteController::class, 'index'])     ->name('reportes.index');
    Route::get('/reportes/descargar', [App\Http\Controllers\Admin\ReporteController::class, 'descargar']) ->name('reportes.descargar');

    // Resultados / Admisión
    Route::get('/admision', [App\Http\Controllers\Admin\AcademicoController::class, 'admisionView'])
         ->name('resultados.admision');
    Route::post('/admision/calcular', [App\Http\Controllers\Admin\AcademicoController::class, 'ejecutarCalculosAdmision'])
         ->name('resultados.calcular');

    // Carga masiva
    Route::get('/carga-masiva', [\App\Http\Controllers\Admin\CargaMasivaController::class, 'index'])
         ->name('carga-masiva.index');
    Route::post('/carga-masiva/procesar', [\App\Http\Controllers\Admin\CargaMasivaController::class, 'procesar'])
         ->name('carga-masiva.procesar');

    // Horarios
    Route::get('/horarios',          [App\Http\Controllers\Admin\HorarioController::class, 'index'])   ->name('horarios.index');
    Route::post('/horarios',         [App\Http\Controllers\Admin\HorarioController::class, 'store'])   ->name('horarios.store');
    Route::put('/horarios/{id}',     [App\Http\Controllers\Admin\HorarioController::class, 'update'])  ->name('horarios.update');
    Route::delete('/horarios/{id}',  [App\Http\Controllers\Admin\HorarioController::class, 'destroy']) ->name('horarios.destroy');

    // Logs de Actividad
    Route::get('/logs', [App\Http\Controllers\Admin\LogController::class, 'index'])
         ->name('logs.index');

    // Credenciales
    Route::get('/credenciales', [\App\Http\Controllers\Admin\CredencialController::class, 'index'])
         ->name('credenciales.index');
    Route::post('/credenciales/generar', [\App\Http\Controllers\Admin\CredencialController::class, 'generar'])
         ->name('credenciales.generar');
    Route::post('/credenciales/enviar/{id}', [\App\Http\Controllers\Admin\CredencialController::class, 'enviar'])
         ->name('credenciales.enviar');
    Route::post('/credenciales/enviar-masivo', [\App\Http\Controllers\Admin\CredencialController::class, 'enviarMasivo'])
         ->name('credenciales.enviar-masivo');
});

// ── PANEL POSTULANTE ─────────────────────────────────────────
Route::middleware(['auth', 'role:POSTULANTE'])->prefix('postulante')->name('postulante.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Postulante\DashboardController::class, 'index'])
         ->name('dashboard');
    Route::get('/notas', [App\Http\Controllers\Postulante\DashboardController::class, 'verNotas'])
         ->name('notas');
    Route::get('/grupo', [App\Http\Controllers\Postulante\DashboardController::class, 'verGrupo'])
         ->name('grupo');
    Route::get('/horario', [App\Http\Controllers\Postulante\DashboardController::class, 'verHorario'])
         ->name('horario');
});

// ── PANELES (stubs temporales) ───────────────────────────────
// ── PANEL DOCENTE ─────────────────────────────────────────────
Route::middleware(['auth'])->prefix('docente')->name('docente.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Docente\DashboardController::class, 'index'])
         ->name('dashboard');
    Route::get('/grupo/{grupoId}/postulantes', [App\Http\Controllers\Docente\DashboardController::class, 'grupoDetalle'])
         ->name('grupo.detalle');
    Route::post('/grupo/{grupoId}/asistencia', [App\Http\Controllers\Docente\DashboardController::class, 'guardarAsistencia'])
         ->name('grupo.asistencia.guardar');
    Route::post('/grupo/{grupoId}/nota', [App\Http\Controllers\Docente\DashboardController::class, 'guardarNota'])
         ->name('grupo.nota.guardar');

    // Nuevas acciones del dashboard docente
    Route::post('/grupo/{grupoId}/tarea', [App\Http\Controllers\Docente\DashboardController::class, 'crearTarea'])
         ->name('grupo.tarea.crear');
    Route::post('/grupo/{grupoId}/tarea/calificar', [App\Http\Controllers\Docente\DashboardController::class, 'calificarTarea'])
         ->name('grupo.tarea.calificar');
    Route::post('/grupo/{grupoId}/anuncio', [App\Http\Controllers\Docente\DashboardController::class, 'crearAnuncio'])
         ->name('grupo.anuncio.crear');
    Route::post('/grupo/{grupoId}/mensaje', [App\Http\Controllers\Docente\DashboardController::class, 'enviarMensaje'])
         ->name('grupo.mensaje.enviar');
    Route::get('/grupo/{grupoId}/mensajes/{postulanteId}', [App\Http\Controllers\Docente\DashboardController::class, 'obtenerMensajes'])
         ->name('grupo.mensajes.historial');
    Route::get('/grupo/{grupoId}/exportar/notas', [App\Http\Controllers\Docente\DashboardController::class, 'exportarNotas'])
         ->name('grupo.exportar.notas');
    Route::get('/grupo/{grupoId}/exportar/asistencia', [App\Http\Controllers\Docente\DashboardController::class, 'exportarAsistencia'])
         ->name('grupo.exportar.asistencia');
});

// ── PRE-REGISTRO ESTUDIANTE (público) ────────────────────────
Route::get('/pre-registro/estudiante',
    [PreRegistroEstudianteController::class, 'create'])->name('pre-registro.estudiante');

Route::post('/pre-registro/estudiante',
    [PreRegistroEstudianteController::class, 'store'])->name('pre-registro.estudiante.store');

Route::get('/pre-registro/estudiante/exito',
    [PreRegistroEstudianteController::class, 'exito'])->name('pre-registro.estudiante.exito');

// ── PRE-REGISTRO DOCENTE (público) ──────────────────────────
Route::get('/pre-registro/docente',
    [App\Http\Controllers\Public\PreRegistroDocenteController::class, 'create'])->name('pre-registro.docente');

Route::post('/pre-registro/docente',
    [App\Http\Controllers\Public\PreRegistroDocenteController::class, 'store'])->name('pre-registro.docente.store');

Route::get('/pre-registro/docente/exito',
    [App\Http\Controllers\Public\PreRegistroDocenteController::class, 'exito'])->name('pre-registro.docente.exito');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:ADMINISTRATIVO'])->group(function () {
 
    // Postulantes
    Route::get('postulantes',               [PostulanteController::class, 'index'])->name('postulantes.index');
    Route::get('postulantes/export',        [PostulanteController::class, 'export'])->name('postulantes.export');
    Route::resource('postulantes', PostulanteController::class)
     ->except(['store']);
 
});