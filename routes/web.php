<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataFeedController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiagnosticoController;
use App\Http\Controllers\EjerciciosController;

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

    Route::get('/diagnostico', [DiagnosticoController::class, 'index'])->name('diagnostico');
    Route::post('/diagnostico', [DiagnosticoController::class, 'predict'])->name('diagnostico.predict');

    Route::resource('diagnosticos', DiagnosticoController::class);

    Route::get('/ejercicios_muneca', [EjerciciosController::class, 'muneca'])->name('ejercicios_muneca');

    Route::fallback(function() {
        return view('pages/utility/404');
    });    
});