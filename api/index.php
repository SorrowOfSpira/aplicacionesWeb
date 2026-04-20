<?php

require __DIR__ . '/../vendor/autoload.php';

// 1. Definir el storage temporal
$storagePath = '/tmp/storage';

// 2. Crear las carpetas necesarias
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

// 3. Arrancar la app
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 4. Configurar el storage path antes de resolver el Kernel
$app->useStoragePath($storagePath);

// 5. Correr el Kernel
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);