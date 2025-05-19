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


Route::get('/login', [ApiAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [ApiAuthController::class, 'login']);

Route::middleware('auth')->group(function () {
    Route::get('/logout', [ApiAuthController::class, 'logout'])->name('logout');
    Route::get('/', function () {
        return view('dashboard');
    });

    //Inincia Malla Validaciones
        Route::get('/setic/malla_validacion', [MallaValidacionController::class, 'malla_validaciones'])->name('malla_validacion');
        Route::post("setic/malla_validacion/tareas_pendientes_personas", [MallaValidacionController::class, 'malla_validaciones_tareas_pendientes_personas']); 
        Route::get("setic/malla_validacion/cobro_repetido_estudiantes", [MallaValidacionController::class, 'malla_cobro_repetido_estudiantes']); 
        Route::get("setic/malla_validacion/malla_secciones_sin_docente", [MallaValidacionController::class, 'malla_secciones_sin_docente']); 
        Route::get("setic/malla_validacion/malla_migraciones_pps", [MallaValidacionController::class, 'malla_migraciones_pps']); 
        Route::get("setic/malla_validacion/pago_minimo_estudiantes", [MallaValidacionController::class, 'malla_pago_minimo_estudiantes']); 
        Route::get("setic/malla_validacion/pago_minimo_estudiantes/refrescar_vista_materializada_pago_minimo_alto_estudiantes", [MallaValidacionController::class, 'malla_refrescar_vista_materializada_pago_minimo_alto_estudiantes']); 
        Route::get("setic/malla_validacion/pago_minimo_estudiantes/refrescar_vista_materializada_clases_matriculadas", [MallaValidacionController::class, 'malla_refrescar_vista_materializada_clases_matriculadas']); 
        Route::get("setic/malla_validacion/malla_cobros_incorrectos", [MallaValidacionController::class, 'malla_cobros_incorrectos']); 
        Route::get("setic/malla_validacion/malla_migraciones_pps", [MallaValidacionController::class, 'malla_migraciones_pps']); 
        Route::get("setic/malla_validacion/malla_parametrizacion_secciones_limite_estudiantes", [MallaValidacionController::class, 'malla_parametrizacion_secciones_limite_estudiantes']); 
        Route::get("setic/malla_validacion/malla_login_estudiantes", [MallaValidacionController::class, 'malla_login_estudiantes']); 
        Route::get("setic/malla_validacion/malla_estudiantes_permiso_matricula", [MallaValidacionController::class, 'malla_estudiantes_permiso_matricula']); 
        Route::get("setic/malla_validacion/malla_estudiantes_traslapes", [MallaValidacionController::class, 'malla_estudiantes_traslapes']); 
        Route::get("setic/malla_validacion/malla_secciones_sobrevaloradas", [MallaValidacionController::class, 'malla_secciones_sobrevaloradas']); 
        Route::get("setic/malla_validacion/malla_parametrizacion_estudiantes", [MallaValidacionController::class, 'malla_parametrizacion_estudiantes']); 
        Route::get("setic/malla_validacion/malla_estudiantes_sin_matricula", [MallaValidacionController::class, 'malla_estudiantes_sin_matricula']); 
    //Finaliza Malla Validaciones

    //Inicia Egresados
        Route::get('/egresados/datos_generales', [EgresadosController::class, 'ver_datos_generales'])->name('egresados');
        Route::post('/egresados/datos_generales/guardar', [EgresadosController::class, 'guardar_datos_generales']);
        Route::post('/egresados/datos_generales/municipios', [EgresadosController::class, 'ver_municipios']);
    //Finaliza Egresados
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
