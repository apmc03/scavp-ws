<?php

use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\AccesoController;

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

Route::resource('funcionarios', FuncionarioController::class);
Route::resource('vehiculos', VehiculoController::class);
Route::resource('accesos', AccesoController::class);