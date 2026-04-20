<?php

require __DIR__ . '/../vendor/autoload.php';

// 1. Configurar rutas temporales (RAM de Vercel)
$storagePath = '/tmp/storage';
$cachePath = '/tmp/bootstrap/cache';

// 2. Crear las carpetas si no existen
foreach ([$storagePath . '/framework/views', $storagePath . '/framework/cache', $storagePath . '/framework/sessions', $storagePath . '/logs', $cachePath] as $path) {
    if (!is_dir($path)) {
        mkdir($path, 0755, true);
    }
}

// 3. Cargar la aplicación
$app = require_once __DIR__ . '/../bootstrap/app.php';

/**
 * SOLUCIÓN AL ERROR: "bootstrap/cache directory must be present and writable"
 * Forzamos a Laravel a usar la carpeta /tmp para sus archivos de optimización
 */
$app->useStoragePath($storagePath);
$app->setBootstrapCachePath($cachePath); 

// 4. Ejecutar el Kernel
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);