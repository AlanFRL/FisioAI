<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataFeedController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiagnosticoController;
use App\Http\Controllers\EjerciciosController;
use App\Http\Controllers\SeguimientoController;

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

Route::redirect('/', 'login');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    // Route for the getting the data feed
    Route::get('/json-data-feed', [DataFeedController::class, 'getDataFeed'])->name('json_data_feed');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('diagnosticos', DiagnosticoController::class);

    // Rutas dinámicas para ejercicios
    Route::get('/ejercicios/{nombre}/{ejercicioId}/{tratamientoId}', [EjerciciosController::class, 'ejercicio'])->name('ejercicios.dinamico');
    Route::get('/guardar-resultado', [EjerciciosController::class, 'guardarResultado'])->name('guardar-resultado');

    Route::get('/ejercicios_muneca', [EjerciciosController::class, 'muneca'])->name('ejercicios_muneca');

    Route::resource('seguimiento', SeguimientoController::class);

    Route::fallback(function () {
        return view('pages/utility/404');
    });
});
