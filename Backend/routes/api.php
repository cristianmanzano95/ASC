<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FormularioController;
use App\Http\Controllers\AdminController;

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

Route::post('/create', [FormularioController::class, 'create'])->middleware('authentication');
Route::patch('/update', [FormularioController::class, 'update'])->middleware('authentication');
Route::get('/list', [FormularioController::class, 'select'])->middleware('authentication');
Route::get('/tipocubiculos', [FormularioController::class, 'lista_tipocubiculos'])->middleware('authentication');
Route::get('/listacubiculos', [FormularioController::class, 'lista_cubiculos'])->middleware('authentication');
Route::get('/listaprogramas', [FormularioController::class, 'lista_programas'])->middleware('authentication');
Route::get('/listaasignaturas', [FormularioController::class, 'lista_asignaturas'])->middleware('authentication');

Route::get('adm/rooms', [AdminController::class, 'rooms'])->middleware('adminauth');
Route::get('adm/pendientes', [AdminController::class, 'pendientes'])->middleware('adminauth');
Route::get('adm/confirmadas', [AdminController::class, 'confirmadas'])->middleware('adminauth');
Route::get('adm/rechazadas', [AdminController::class, 'rechazadas'])->middleware('adminauth');
Route::get('adm/asignadas', [AdminController::class, 'asignadas'])->middleware('adminauth');
Route::post('adm/confirmar', [AdminController::class, 'confirmar'])->middleware('adminauth');
Route::post('adm/asignar', [AdminController::class, 'asignar'])->middleware('adminauth');
Route::patch('adm/update', [AdminController::class, 'update'])->middleware('adminauth');
Route::post('adm/masivo_computo', [AdminController::class, 'masivo_computo'])->middleware('adminauth');
Route::post('adm/masivo_cubiculo', [AdminController::class, 'masivo_cubiculo'])->middleware('adminauth');
Route::get('adm/find', [AdminController::class, 'find'])->middleware('adminauth');

Route::post('/login', [AuthController::class, 'login']);
Route::post('adm/login', [AuthController::class, 'admin_login']);
Route::post('adm/loginback', [AuthController::class, 'admin_loginback']);
