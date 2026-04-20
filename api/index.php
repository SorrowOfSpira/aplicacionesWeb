<?php

// 1. Cargamos el autoloader de Composer
require __DIR__ . '/../vendor/autoload.php';

// 2. Configuración para Vercel (Sistema de archivos de solo lectura)
// Definimos la ruta de almacenamiento en /tmp (RAM de Vercel)
$storagePath = '/tmp/storage';

// Creamos la estructura de carpetas necesaria si no existe
foreach ([
    "$storagePath/framework/cache",
    "$storagePath/framework/sessions",
    "$storagePath/framework/views",
    "$storagePath/logs"
] as $path) {
    if (!is_dir($path)) {
        mkdir($path, 0755, true);
    }
}

// 3. Arrancamos la aplicación Laravel
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 4. Forzamos a Laravel a usar el nuevo path de storage
$app->useStoragePath($storagePath);

// 5. Forzamos que los logs salgan por consola (stderr) y no a un archivo
config(['logging.default' => 'stderr']);

// 6. Manejamos la petición
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);