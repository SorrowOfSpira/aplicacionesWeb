<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

    // Crear carpetas temporales para las vistas compiladas en Vercel
    if (env('APP_ENV') !== 'local') {
        $viewPath = '/tmp/storage/framework/views';
        if (!is_dir($viewPath)) {
            mkdir($viewPath, 0755, true);
        }
        config(['view.compiled' => $viewPath]);
}
