<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MovementController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Rutas de autenticación
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Rutas protegidas
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // CRUD Productos
    Route::apiResource('products', ProductController::class);

    // CRUD Categorías
    Route::apiResource('categories', CategoryController::class);

    // CRUD Ubicaciones
    Route::apiResource('locations', LocationController::class);

    // Movimientos
    Route::apiResource('movements', MovementController::class);

    // Usuarios
    Route::apiResource('users', UserController::class);
});
