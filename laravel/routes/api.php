<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\ReservationController; 
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| 
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Ruta per verificar si un usuari a fet login
    Route::middleware('auth:api')->get('/check-auth', [AuthController::class, 'checkAuth']);
    Route::get('get-id', [App\Http\Controllers\AuthController::class, 'getUserId']);

// Ruta para cerrar sesión
    Route::middleware('auth:api')->post('/logout', [AuthController::class, 'logout']);

//Rutas per els usuaris
    Route::post('register', [App\Http\Controllers\AuthController::class, 'register']);
    Route::post('login', [App\Http\Controllers\AuthController::class, 'login']);

// Rutas per las películas
    Route::post('movies', [App\Http\Controllers\MovieController::class, 'store']); //Insertar nueva peli
    Route::get('movies', [App\Http\Controllers\MovieController::class, 'index']); //Mostrar todas las pelis
    Route::get('movies/{id}', [App\Http\Controllers\MovieController::class, 'show']); //Mostrar una peli por id
    Route::put('movies/{id}', [App\Http\Controllers\MovieController::class, 'update']); //Actualizar peli
    Route::delete('movies/{id}', [App\Http\Controllers\MovieController::class, 'destroy']); //Eliminar peli


// Rutas per els seints d'una sessió específica
    Route::get('seient', [SeatController::class, 'index']); // Mostrar todos los asientos de una sesión
    Route::post('seient', [SeatController::class, 'store']); // Crear un nuevo asiento para una sesión
    Route::get('seient/{id}', [SeatController::class, 'show']); //Mostrar un asiento
    Route::post('/insert-seients',[SeatController::class, 'insert']); //Insertar nuevo asiento
    Route::patch('/seats/{id}/status', [SeatController::class, 'updateStatus']);
    Route::post('seats/generate', [SeatController::class, 'generateSeats']);



//Rutas per els tickets de compra
    Route::post('tickets', [TicketController::class, 'store']); // Crear un ticket
    Route::get('tickets', [TicketController::class, 'getTickets']); // Obtindre tickets d'un correu





?>