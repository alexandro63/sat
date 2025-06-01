<?php

use App\Http\Controllers\AvanceEstudianteController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\PlantelAdministrativoController;
use App\Http\Controllers\ProgramaAcademicoController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\HistorialAuditoriaController;
use App\Http\Controllers\MetodologiaController;
use App\Http\Controllers\ModuloController;
use App\Http\Controllers\ObservacionController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TallerController;

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();


Route::middleware(['atlantis_menu', 'set_session_data', 'check_user_login', 'auth'])->group(function () {

    Route::get('/inicio', [HomeController::class, 'index'])->name('home');

    /**Administration*/
    Route::prefix('administracion')->group(function () {
        //Roles
        Route::resource('roles', RoleController::class);
        Route::post('get-roles', [RoleController::class, 'getRoleData']);
        Route::post('get-routes', [RoleController::class, 'getRoutes']);

        //Personas
        Route::resource('personas', PersonaController::class);
        Route::get('get-personas', [PersonaController::class, 'getPeopleData']);

        //Usuarios
        Route::resource('usuarios', UsuarioController::class);
        Route::get('get-usuarios', [UsuarioController::class, 'getUserData']);
    });

    /**Registros */
    Route::prefix('registros')->group(function () {
        // Docente
        Route::resource('docentes', DocenteController::class);
        Route::get('get-docentes', [DocenteController::class, 'getDocentesData']);
        // Plantel Administrativo
        Route::resource('plantel-administrativo', PlantelAdministrativoController::class);
        Route::post('get-plantel', [PlantelAdministrativoController::class, 'getPlantelAdministrativoData']);
        // Programa Academico
        Route::resource('programa-academico', ProgramaAcademicoController::class);
        Route::get('get-programa-academico', [ProgramaAcademicoController::class, 'getProgramaAcademicoData']);
        // Estudiante
        Route::resource('estudiantes', EstudianteController::class);
        Route::get('get-estudiantes', [EstudianteController::class, 'getEstudiantesData']);
        // Proyecto
        Route::resource('proyectos', EstudianteController::class);
        Route::get('get-proyectos', [EstudianteController::class, 'getProyectosData']);
        // Metodologia
        Route::resource('metodologias', MetodologiaController::class);
        Route::get('get-metodologias', [MetodologiaController::class, 'getProyectosData']);
        // Modulo
        Route::resource('modulos', ModuloController::class);
        Route::get('get-modulos', [ModuloController::class, 'getModulosData']);
        // Pago
        Route::resource('pagos', PagoController::class);
        Route::get('get-pagos', [PagoController::class, 'getPagosData']);
        // Taller
        Route::resource('talleres', TallerController::class);
        Route::get('get-talleres', [TallerController::class, 'getTalleresData']);
        // Avance Estudiante
        Route::resource('avance-estudiante', AvanceEstudianteController::class);
        Route::get('get-avance-estudiante', [AvanceEstudianteController::class, 'getAvanceEstudianteData']);
        // Observación
        Route::resource('observacion', ObservacionController::class);
        Route::get('get-observacion', [ObservacionController::class, 'getObservacionData']);
        // Observación
        Route::resource('historial-auditoria', HistorialAuditoriaController::class);
        Route::get('get-historial-auditoria', [HistorialAuditoriaController::class, 'getHistorialAuditoriaData']);
    });

    /** Reports */
    //Reportes de Avance Estudiante
    Route::prefix('reportes')->group(function () {
        Route::get('avance-estudiante', [ReportController::class, 'avanceEstudiante'])->name('avance_estudiante.index');
        Route::get('entregas-avance', [ReportController::class, 'entregasAvance'])->name('entregas_avance.index');
    });


    // Route::prefix('modulos')->group(function () {
    //     Route::get('tesis', [ModuleController::class, 'tesis'])->name('tesis.index');
    //     Route::get('proyecto-grado', [ModuleController::class, 'proyectoGrado'])->name('proyecto_grado.index');
    //     Route::get('trabajo-dirijido', [ModuleController::class, 'trabajoDirijido'])->name('trabajo_dirijido.index');
    //     Route::get('graduacion-excelencia', [ModuleController::class, 'graduacionExcelencia'])->name('graduacion_excelencia.index');
    // });

    /**Settings System */
    Route::get('settings-system', [SettingController::class, 'index'])->name('settings');
});
