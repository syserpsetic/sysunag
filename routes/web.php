<?php

use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DarkModeController;
use App\Http\Controllers\ColorSchemeController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\Solicitudes\SolicitudesController;
use App\Http\Controllers\Solicitudes\ControladorViatico;
use App\Http\Controllers\Configuracion\EstadosController;
use App\Http\Controllers\Configuracion\TiposSolicitudesController;
use App\Http\Controllers\Configuracion\ZonasController;
use App\Http\Controllers\Configuracion\CapitulosController;
use App\Http\Controllers\Configuracion\CategoriasController;
use App\Http\Controllers\Tienda\ControladorTiendaUNAG;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\googleController;
use App\Http\Controllers\MallaValidacion\MallaValidacionController;
use App\Http\Controllers\Egresados\EgresadosController;
use App\Http\Controllers\Egresados\ReportsEgresadosController;
use App\Http\Controllers\Setic\SeticController;
use App\Http\Controllers\Psicologia\PsicologiaController;
use App\Http\Controllers\GestionSolicitudes\GestionSolicitudesController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/auth/google', function () {
    return redirect(env('API_BASE_URL_ZETA').'/api/auth/google/redirect/'.env('APP_NAME'));
});

Route::post('/sesion', [googleController::class, 'handleGoogleCallback']);

Route::get('/login', [ApiAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [ApiAuthController::class, 'login']);
Route::post('/change_password_view', [ApiAuthController::class, 'change_password_view']);
Route::post('/change_password', [ApiAuthController::class, 'change_password'])->name('change_password');
Route::get('/login_egresados', [ApiAuthController::class, 'showLoginFormEgresados'])->name('login_egresados');
Route::post('/login_egresados', [ApiAuthController::class, 'login']);

Route::middleware('auth')->group(function () {
    Route::get('/logout', [ApiAuthController::class, 'logout'])->name('logout');
    // Route::get('/', function () {
    //     return view('dashboard');
    // });

    Route::get('/', [PageController::class, 'dashboardOverview1']);
    Route::get('/estructura_menu', [PageController::class, 'menu']);
    Route::get('/reporte-prueba', [ReportsEgresadosController::class, 'prueba']);

    //Inincia SETIC
        Route::get('/setic/usuarios', [SeticController::class, 'usuarios'])->name('setic_usuarios');
        Route::get('/setic/usuarios/data', [SeticController::class, 'usuariosdata']);
        Route::get('/setic/usuarios/perfil/{username}', [SeticController::class, 'usuario_perfil']);
        Route::post('/setic/usuarios/perfil/roles/guardar', [SeticController::class, 'guardar_perfil_roles']);
        Route::get('/setic/roles', [SeticController::class, 'roles'])->name('setic_roles');
        Route::post('/setic/roles/guardar', [SeticController::class, 'guardar_roles']);
        Route::get('/setic/roles/{id_rol}/permisos', [SeticController::class, 'roles_permisos']);
        Route::post('/setic/roles/permisos/guardar', [SeticController::class, 'guardar_roles_permisos']);
        Route::get('/setic/permisos', [SeticController::class, 'permisos'])->name('setic_permisos');
        Route::post('/setic/permisos/guardar', [SeticController::class, 'guardar_permisos']);
        Route::get('/setic/paginas', [SeticController::class, 'paginas'])->name('setic_paginas');
        Route::post('/setic/paginas/guardar', [SeticController::class, 'guardar_paginas']);
    //Finaliza SETIC

    //Inincia Malla Validaciones
        Route::get('/setic/malla_validacion', [MallaValidacionController::class, 'malla_validaciones'])->name('malla_validacion');
        Route::post("setic/malla_validacion/tareas_pendientes_personas", [MallaValidacionController::class, 'malla_validaciones_tareas_pendientes_personas']); 
        Route::get("setic/malla_validacion/cobro_repetido_estudiantes", [MallaValidacionController::class, 'malla_cobro_repetido_estudiantes']); 
        Route::get("setic/malla_validacion/malla_secciones_sin_docente", [MallaValidacionController::class, 'malla_secciones_sin_docente']); 
        Route::get("setic/malla_validacion/malla_evidencias_pps", [MallaValidacionController::class, 'malla_evidencias_pps']); 
        Route::get("setic/malla_validacion/malla_migraciones_pps", [MallaValidacionController::class, 'malla_migraciones_pps']); 
        Route::get("setic/malla_validacion/pago_minimo_estudiantes", [MallaValidacionController::class, 'malla_pago_minimo_estudiantes']); 
        Route::get("setic/malla_validacion/pago_minimo_estudiantes/refrescar_vista_materializada_pago_minimo_alto_estudiantes", [MallaValidacionController::class, 'malla_refrescar_vista_materializada_pago_minimo_alto_estudiantes']); 
        Route::get("setic/malla_validacion/pago_minimo_estudiantes/refrescar_vista_materializada_clases_matriculadas", [MallaValidacionController::class, 'malla_refrescar_vista_materializada_clases_matriculadas']); 
        Route::get("setic/malla_validacion/malla_cobros_incorrectos", [MallaValidacionController::class, 'malla_cobros_incorrectos']); 
        //Route::get("setic/malla_validacion/malla_migraciones_pps", [MallaValidacionController::class, 'malla_migraciones_pps']); 
        Route::get("setic/malla_validacion/malla_parametrizacion_secciones_limite_estudiantes", [MallaValidacionController::class, 'malla_parametrizacion_secciones_limite_estudiantes']); 
        Route::get("setic/malla_validacion/malla_login_estudiantes", [MallaValidacionController::class, 'malla_login_estudiantes']); 
        Route::get("setic/malla_validacion/malla_estudiantes_permiso_matricula", [MallaValidacionController::class, 'malla_estudiantes_permiso_matricula']); 
        Route::get("setic/malla_validacion/malla_estudiantes_traslapes", [MallaValidacionController::class, 'malla_estudiantes_traslapes']); 
        Route::get("setic/malla_validacion/malla_secciones_sobrepobladas", [MallaValidacionController::class, 'malla_secciones_sobrepobladas']); 
        Route::get("setic/malla_validacion/malla_parametrizacion_estudiantes", [MallaValidacionController::class, 'malla_parametrizacion_estudiantes']); 
        Route::get("setic/malla_validacion/malla_estudiantes_sin_matricula", [MallaValidacionController::class, 'malla_estudiantes_sin_matricula']); 
    //Finaliza Malla Validaciones

    //Inicia Egresados
        Route::get('/egresados/datos_generales', [EgresadosController::class, 'ver_datos_generales'])->name('egresados');
        Route::post('/egresados/datos_generales/guardar', [EgresadosController::class, 'guardar_datos_generales']);
        Route::post('/egresados/datos_generales/municipios', [EgresadosController::class, 'ver_municipios']);
        Route::post('/egresados/datos_academicos/guardar', [EgresadosController::class, 'guardar_datos_academicos']);
        Route::post('/egresados/esperiencia_laboral/guardar', [EgresadosController::class, 'guardar_esperiencia_laboral']);
        Route::post('/egresados/habilidades_tecnicas/guardar', [EgresadosController::class, 'guardar_habilidades_tecnicas']);
    //Finaliza Egresados

    //Inicia Solicitudes
        Route::get('/solicitudes/recibidas', [GestionSolicitudesController::class, 'ver_solicitudes_recibidas']);
        Route::get('/solicitudes/leer', [GestionSolicitudesController::class, 'ver_solicitudes_leer']);
        Route::get('/solicitudes/nueva', [GestionSolicitudesController::class, 'ver_solicitudes_nueva']);
        Route::get('/solicitudes/enviadas', [GestionSolicitudesController::class, 'ver_solicitudes_enviadas']);
        Route::get('/solicitudes/proceso', [GestionSolicitudesController::class, 'ver_solicitudes_proceso']);
        Route::get('/solicitudes/terminadas', [GestionSolicitudesController::class, 'ver_solicitudes_terminadas']);
        Route::get('/solicitudes/trazabilidad', [GestionSolicitudesController::class, 'ver_solicitudes_trazabilidad']);
        Route::get('/solicitudes/vencidas', [GestionSolicitudesController::class, 'ver_solicitudes_vencidas']);
    //Finaliza Solicitudes

     //Inicia Psicologia
        //Rutas de calendario
            Route::get('/psicologia/calendario', [PsicologiaController::class, 'calendario_citas'])->name('calendario_citas');
            Route::post('/psicologia/citas', [PsicologiaController::class, 'guardar_cita'])->name('guardar_cita');
            Route::get('/psicologia/citas', [PsicologiaController::class, 'obtener_citas'])->name('obtener_citas');
            Route::get('/psicologia/estadisticas', [PsicologiaController::class, 'estadisticas_citas'])->name('estadisticas_citas');
            Route::post('/psicologia/citas/{id_cita}/estado', [PsicologiaController::class, 'actualizar_estado_cita'])->name('actualizar_estado_cita');
            Route::get('/psicologia/catalogos-intervencion', [PsicologiaController::class, 'obtener_catalogos_intervencion'])->name('obtener_catalogos_intervencion');
            Route::post('/psicologia/citas/{id_cita}/cancelar', [PsicologiaController::class, 'cancelar_cita'])->name('cancelar_cita');
		//Rutas de Evaluacion
            Route::get('/psicologia/intervencion/{id_cita}', [PageController::class, 'evaluacionPaciente'])->name('evaluacion_paciente');
            Route::get('/psicologia/cita/{id_cita}/datos', [PsicologiaController::class, 'obtener_datos_cita'])->name('obtener_datos_cita');
            Route::get('/psicologia/catalogos-motivo', [PsicologiaController::class, 'obtener_catalogos_motivo_consulta'])->name('obtener_catalogos_motivo_consulta');
            Route::get('/psicologia/catalogos-antecedentes', [PsicologiaController::class, 'obtener_catalogos_historial_clinico_antecedentes'])->name('obtener_catalogos_historial_clinico_antecedentes');
            Route::get('/psicologia/catalogos-evaluacion', [PsicologiaController::class, 'obtener_catalogos_evaluacion'])->name('obtener_catalogos_evaluacion');
            Route::get('/psicologia/catalogos-profesional', [PsicologiaController::class, 'obtener_catalogos_profesional'])->name('obtener_catalogos_profesional');
            Route::post('/psicologia/citas/{id_cita}/evaluacion', [PsicologiaController::class, 'guardar_evaluacion_psicologia'])->name('guardar_evaluacion_psicologia');
        //Rutas de Historial
            Route::get('/psicologia/historial/{numeroRegistro}', [PsicologiaController::class, 'obtener_historial'])->name('obtener_historial');
            Route::get('/psicologia/evaluacion/datos', [PsicologiaController::class, 'obtener_datos_evaluacion'])->name('obtener_datos_evaluacion');
            //abrir la vista historial
            Route::get('/psicologia/estudiante-historial/{id_cita}/{id_origen}', [PageController::class, 'verHistorial'])->name('ver_historial')->where('id_cita', '[0-9]+');
            //Vista Historial clinico
            Route::get('/psicologia/historialClinico', [PsicologiaController::class, 'historial_clinico'])->name('historial_clinico');
            Route::get('/psicologia/catalogos-clinica', [PsicologiaController::class, 'obtener_catalogos_clinica'])->name('obtener_catalogos_clinica');
    //Finaliza Psicologia
});

Route::group(['prefix' => 'email'], function(){
    Route::get('inbox', function () { return view('pages.email.inbox'); });
    Route::get('read', function () { return view('pages.email.read'); });
    Route::get('compose', function () { return view('pages.email.compose'); });
});

Route::group(['prefix' => 'apps'], function(){
    Route::get('chat', function () { return view('pages.apps.chat'); });
    Route::get('calendar', function () { return view('pages.apps.calendar'); });
});

Route::group(['prefix' => 'ui-components'], function(){
    Route::get('accordion', function () { return view('pages.ui-components.accordion'); });
    Route::get('alerts', function () { return view('pages.ui-components.alerts'); });
    Route::get('badges', function () { return view('pages.ui-components.badges'); });
    Route::get('breadcrumbs', function () { return view('pages.ui-components.breadcrumbs'); });
    Route::get('buttons', function () { return view('pages.ui-components.buttons'); });
    Route::get('button-group', function () { return view('pages.ui-components.button-group'); });
    Route::get('cards', function () { return view('pages.ui-components.cards'); });
    Route::get('carousel', function () { return view('pages.ui-components.carousel'); });
    Route::get('collapse', function () { return view('pages.ui-components.collapse'); });
    Route::get('dropdowns', function () { return view('pages.ui-components.dropdowns'); });
    Route::get('list-group', function () { return view('pages.ui-components.list-group'); });
    Route::get('media-object', function () { return view('pages.ui-components.media-object'); });
    Route::get('modal', function () { return view('pages.ui-components.modal'); });
    Route::get('navs', function () { return view('pages.ui-components.navs'); });
    Route::get('navbar', function () { return view('pages.ui-components.navbar'); });
    Route::get('pagination', function () { return view('pages.ui-components.pagination'); });
    Route::get('popovers', function () { return view('pages.ui-components.popovers'); });
    Route::get('progress', function () { return view('pages.ui-components.progress'); });
    Route::get('scrollbar', function () { return view('pages.ui-components.scrollbar'); });
    Route::get('scrollspy', function () { return view('pages.ui-components.scrollspy'); });
    Route::get('spinners', function () { return view('pages.ui-components.spinners'); });
    Route::get('tabs', function () { return view('pages.ui-components.tabs'); });
    Route::get('tooltips', function () { return view('pages.ui-components.tooltips'); });
});

Route::group(['prefix' => 'advanced-ui'], function(){
    Route::get('cropper', function () { return view('pages.advanced-ui.cropper'); });
    Route::get('owl-carousel', function () { return view('pages.advanced-ui.owl-carousel'); });
    Route::get('sortablejs', function () { return view('pages.advanced-ui.sortablejs'); });
    Route::get('sweet-alert', function () { return view('pages.advanced-ui.sweet-alert'); });
});

Route::group(['prefix' => 'forms'], function(){
    Route::get('basic-elements', function () { return view('pages.forms.basic-elements'); });
    Route::get('advanced-elements', function () { return view('pages.forms.advanced-elements'); });
    Route::get('editors', function () { return view('pages.forms.editors'); });
    Route::get('wizard', function () { return view('pages.forms.wizard'); });
});

Route::group(['prefix' => 'charts'], function(){
    Route::get('apex', function () { return view('pages.charts.apex'); });
    Route::get('chartjs', function () { return view('pages.charts.chartjs'); });
    Route::get('flot', function () { return view('pages.charts.flot'); });
    Route::get('peity', function () { return view('pages.charts.peity'); });
    Route::get('sparkline', function () { return view('pages.charts.sparkline'); });
});

Route::group(['prefix' => 'tables'], function(){
    Route::get('basic-tables', function () { return view('pages.tables.basic-tables'); });
    Route::get('data-table', function () { return view('pages.tables.data-table'); });
});

Route::group(['prefix' => 'icons'], function(){
    Route::get('feather-icons', function () { return view('pages.icons.feather-icons'); });
    Route::get('mdi-icons', function () { return view('pages.icons.mdi-icons'); });
});

Route::group(['prefix' => 'general'], function(){
    Route::get('blank-page', function () { return view('pages.general.blank-page'); });
    Route::get('faq', function () { return view('pages.general.faq'); });
    Route::get('invoice', function () { return view('pages.general.invoice'); });
    Route::get('profile', function () { return view('pages.general.profile'); });
    Route::get('pricing', function () { return view('pages.general.pricing'); });
    Route::get('timeline', function () { return view('pages.general.timeline'); });
});

Route::group(['prefix' => 'auth'], function(){
    Route::get('login', function () { return view('pages.auth.login'); });
    Route::get('register', function () { return view('pages.auth.register'); });
});

Route::group(['prefix' => 'error'], function(){
    Route::get('404', function () { return view('pages.error.404'); });
    Route::get('500', function () { return view('pages.error.500'); });
});

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});

// 404 for undefined routes
Route::any('/{page?}',function(){
    return View::make('pages.error.404');
})->where('page','.*');
