<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\TagController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard'); // Asegúrate de que exista resources/views/dashboard.blade.php
})->name('dashboard'); // <-- Esto es lo que soluciona tu 

Route::resource('usuarios', UserController::class);
Route::resource('productos', ProductoController::class);
Route::resource('tags', TagController::class);