<?php

use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\AccesoController;
use App\Http\Controllers\UsuarioController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [UsuarioController::class, 'login'])->name('login');
Route::get('generate-password/{password}', [UsuarioController::class, 'generarPassword'])->name('generate-password');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource('funcionarios', FuncionarioController::class);
    Route::resource('vehiculos', VehiculoController::class);
    Route::resource('accesos', AccesoController::class);

    Route::get('generar-token-permanente/{userId}', [UsuarioController::class, 'generarTokenPermanente'])->name('generar-token-permanente');
});
