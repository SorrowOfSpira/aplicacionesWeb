<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require __DIR__ . '/../vendor/autoload.php';

// 1. Configurar el entorno de almacenamiento en /tmp (RAM de Vercel)
$storagePath = '/tmp/storage';

foreach ([
    "$storagePath/framework/cache",
    "$storagePath/framework/sessions",
    "$storagePath/framework/views",
    "$storagePath/logs",
    "/tmp/bootstrap/cache"
] as $path) {
    if (!is_dir($path)) {
        mkdir($path, 0755, true);
    }
}

// 2. Definir la variable de entorno para el caché de bootstrap ANTES de cargar la app
putenv("APP_CONFIG_CACHE={$storagePath}/framework/config.php");
putenv("APP_ROUTES_CACHE={$storagePath}/framework/routes.php");
putenv("APP_SERVICES_CACHE={$storagePath}/framework/services.php");
putenv("APP_PACKAGES_CACHE={$storagePath}/framework/packages.php");

// 3. Cargar la aplicación
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 4. Forzar el storage path
$app->useStoragePath($storagePath);

// 5. Ejecutar el Kernel
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);