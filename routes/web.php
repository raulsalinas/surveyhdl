<?php

use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\ConfiguracionEncuestaController;
use App\Http\Controllers\ConfiguracionPreguntaController;
use App\Http\Controllers\ConfiguracionRespuestaController;
use App\Http\Controllers\ConfiguracionUsuarioController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PrincipalController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

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
    });

    Route::name('dashboard.')->prefix('dashboard')->group(function () {
        Route::get('index', [DashboardController::class, 'index'])->name('index');
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
                Route::post('guardar', [ConfiguracionRespuestaController::class, 'guardar'])->name('guardar');

            });

        });
        Route::name('usuario.')->prefix('usuario')->group(function () {
            Route::get('index', [ConfiguracionUsuarioController::class, 'index'])->name('index');
            Route::post('listar', [ConfiguracionUsuarioController::class, 'listar'])->name('listar');

        });

    });
});