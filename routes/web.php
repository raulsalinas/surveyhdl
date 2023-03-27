<?php

use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\ConfiguracionEncuestaController;
use App\Http\Controllers\ConfiguracionMuestraController;
use App\Http\Controllers\ConfiguracionMuestreoController;
use App\Http\Controllers\ConfiguracionPreguntaController;
use App\Http\Controllers\ConfiguracionRespuestaController;
use App\Http\Controllers\ConfiguracionUsuarioController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EncuestasController;
use App\Http\Controllers\PrincipalController;
use App\Http\Controllers\ReportesController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('artisan', function () {
    Artisan::call('clear-compiled');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('artisan', function () {
    Artisan::call('clear-compiled');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
});


Route::middleware(['auth'])->group(function () {
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');

    Route::name('principal.')->prefix('principal')->group(function () {
        Route::get('index', [PrincipalController::class, 'index'])->name('index');
        Route::post('obtener-informacion-de-resumen', [PrincipalController::class, 'obtenerInformacionDeResumen'])->name('obtener-informacion-de-resumen');

    });

    Route::name('dashboard.')->prefix('dashboard')->group(function () {
        Route::get('index', [DashboardController::class, 'index'])->name('index');
        Route::get('obtener-cifras-totales', [DashboardController::class, 'obtenerCifrasTotales'])->name('obtener-cifras-totales');
        Route::post('listar-informacion-usuarios', [DashboardController::class, 'listarInformacionUsuarios'])->name('listar-informacion-usuarios');
        Route::get('obtener-usuarios-activos-y-bajas', [DashboardController::class, 'obtenerUsuariosActivosYBajas'])->name('obtener-usuarios-activos-y-bajas');
        Route::post('obtener-avance-de-usuarios', [DashboardController::class, 'AvanceDeUsuariosView'])->name('obtener-avance-de-usuarios');
        Route::get('obtener-preguntas/{idEncuesta?}', [DashboardController::class, 'obtenerPreguntas'])->name('obtener-preguntas');
        Route::get('obtener-resultado-por-usuario/{idEncuesta?}/{idUsuario?}', [DashboardController::class, 'obtenerResultadoPorUsuario'])->name('obtener-resultado-por-usuario');
    });

    Route::name('encuestas.')->prefix('encuestas')->group(function () {
        Route::name('muestreo.')->prefix('muestreo')->group(function () {
            Route::get('index', [EncuestasController::class, 'muestreoIndex'])->name('index');
            Route::get('menu-muestreo', [EncuestasController::class, 'menuMuestreoList'])->name('menu-muestreo');
        });
        Route::name('encuesta.')->prefix('encuesta')->group(function () {
            Route::get('index', [EncuestasController::class, 'encuestaIndex'])->name('index');
            Route::get('menu-encuesta/{idMuestreo}/{idEncuesta}', [EncuestasController::class, 'menuEncuestaList'])->name('menu-encuesta');
            Route::get('llenar-encuesta', [EncuestasController::class, 'llenarEncuesta'])->name('llenar-encuesta');
            Route::get('obtener-preguntas-de-encuesta/{idEncuesta}', [EncuestasController::class, 'obtenerPreguntasDeEncuesta'])->name('obtener-preguntas-de-encuesta');
            Route::get('obtener-informacion-de-avance/{idEncuesta}', [EncuestasController::class, 'obtenerInformacionDeAvance'])->name('obtener-informacion-de-avance');
            Route::post('guardar-respuesta', [EncuestasController::class, 'guardarRespuesta'])->name('guardar-respuesta');
        });

    });
    Route::name('reportes.')->prefix('reportes')->group(function () {
        Route::get('index', [ReportesController::class, 'ReportesIndex'])->name('index');
        Route::post('listar-informacion-de-usuario', [ReportesController::class, 'listarInformacionDeUsuario'])->name('listar-informacion-de-usuario');
        Route::post('listar-avance-de-usuario', [ReportesController::class, 'listarAvanceDeUsuario'])->name('listar-avance-de-usuario');
        Route::post('listar-preguntas-por-encuesta', [ReportesController::class, 'listarPreguntasPorEncuesta'])->name('listar-preguntas-por-encuesta');
        Route::post('listar-resultados-por-encuesta', [ReportesController::class, 'listarResultadosPorEncuesta'])->name('listar-resultados-por-encuesta');
        Route::get('obtener-reporte-grafico/{idEncuesta}', [ReportesController::class, 'obtenerReporteGrafico'])->name('obtener-reporte-grafico');

    });


    Route::name('configuracion.')->prefix('configuracion')->group(function () {
        Route::get('index', [ConfiguracionController::class, 'configuracion_index'])->name('index');
        Route::name('encuesta.')->prefix('encuesta')->group(function () {
            Route::get('index', [ConfiguracionController::class, 'encuesta_index'])->name('index');
            Route::post('listar', [ConfiguracionEncuestaController::class, 'listar'])->name('listar');
            Route::get('obtener/{id}', [ConfiguracionEncuestaController::class, 'obtener'])->name('obtener');
            Route::post('guardar', [ConfiguracionEncuestaController::class, 'guardar'])->name('guardar');

        });
        Route::name('pregunta.')->prefix('pregunta')->group(function () {
            Route::get('index', [ConfiguracionPreguntaController::class, 'index'])->name('index');
            Route::post('listar', [ConfiguracionPreguntaController::class, 'listar'])->name('listar');
            Route::get('obtener/{id}', [ConfiguracionPreguntaController::class, 'obtener'])->name('obtener');
            Route::post('guardar', [ConfiguracionPreguntaController::class, 'guardar'])->name('guardar');
            Route::name('respuesta.')->prefix('respuesta')->group(function () {
                Route::post('listar', [ConfiguracionRespuestaController::class, 'listar'])->name('listar');
                Route::get('obtener/{id}', [ConfiguracionRespuestaController::class, 'obtener'])->name('obtener');
                Route::get('obtener-lista-respuestas/{id}', [ConfiguracionRespuestaController::class, 'obtenerListaRespuestas'])->name('obtener-lista-respuestas');
                Route::get('aplicar-respuestas-para-todas-las-preguntas/{id}', [ConfiguracionRespuestaController::class, 'aplicarRespuestasParaTodasLasPreguntas'])->name('aplicar-respuestas-para-todas-las-preguntas');
                Route::post('guardar', [ConfiguracionRespuestaController::class, 'guardar'])->name('guardar');
                
            });
            
        });
        
        Route::name('muestreo.')->prefix('muestreo')->group(function () {
            Route::post('listar', [ConfiguracionMuestreoController::class, 'listar'])->name('listar');
            Route::get('obtener_muestreo/{id}', [ConfiguracionMuestreoController::class, 'obtenerMuestreo'])->name('obtener_muestreo');
            Route::post('obtener_fechas', [ConfiguracionMuestreoController::class, 'obtenerFechas'])->name('obtener_fechas');
            Route::get('obtener_fecha/{id}', [ConfiguracionMuestreoController::class, 'obtenerFecha'])->name('obtener_fecha');
            Route::post('guardar_fecha', [ConfiguracionMuestreoController::class, 'guardarFecha'])->name('guardar_fecha');
            Route::post('guardar', [ConfiguracionMuestreoController::class, 'guardar'])->name('guardar');

        });
        Route::name('muestra.')->prefix('muestra')->group(function () {
            Route::post('listar', [ConfiguracionMuestraController::class, 'listar'])->name('listar');
            Route::get('obtener/{id}', [ConfiguracionMuestraController::class, 'obtener'])->name('obtener');
            Route::post('guardar', [ConfiguracionMuestraController::class, 'guardar'])->name('guardar');

        });

        Route::name('usuario.')->prefix('usuario')->group(function () {
            Route::post('listar', [ConfiguracionUsuarioController::class, 'listar'])->name('listar');
            Route::get('obtener/{id}', [ConfiguracionUsuarioController::class, 'obtener'])->name('obtener');
            Route::post('guardar', [ConfiguracionUsuarioController::class, 'guardar'])->name('guardar');
            Route::get('obtener_acceso/{id}', [ConfiguracionUsuarioController::class, 'obtenerAcceso'])->name('obtener_acceso');
            Route::get('obtener_acceso_prueba', [ConfiguracionUsuarioController::class, 'actualizarAccesoPrueba'])->name('obtener_acceso_prueba');
            Route::post('actualizar_acceso', [ConfiguracionUsuarioController::class, 'actualizarAcceso'])->name('actualizar_acceso');

        });



        Route::name('usuario.')->prefix('usuario')->group(function () {
            Route::get('index', [ConfiguracionUsuarioController::class, 'index'])->name('index');
            Route::post('listar', [ConfiguracionUsuarioController::class, 'listar'])->name('listar');

        });

    });
});