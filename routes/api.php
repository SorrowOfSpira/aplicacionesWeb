<?php

use App\Http\Controllers\Api\ClienteAuthController;
use App\Http\Controllers\Api\ClienteController;
use App\Http\Controllers\Api\ProductoController;
use App\Http\Controllers\Api\TagController;
use Illuminate\Support\Facades\Route;

// ─── Públicos ────────────────────────────────────────────────────────────────
Route::get('/productos',        [ProductoController::class, 'index']);
Route::get('/productos/{id}',   [ProductoController::class, 'show']);
Route::get('/tags',             [TagController::class, 'index']);

// Registro de cliente (alta propia)
Route::post('/clientes/register', [ClienteController::class, 'store']);

// Login de cliente
Route::post('/clientes/login', [ClienteAuthController::class, 'login']);

// ─── Cliente autenticado ──────────────────────────────────────────────────────
Route::middleware('auth:clientes')->group(function () {
    Route::post('/clientes/logout',      [ClienteAuthController::class, 'logout']);
    Route::get('/clientes/me',           [ClienteAuthController::class, 'me']);
    Route::get('/clientes/me/ventas',    [ClienteAuthController::class, 'misVentas']);
});
