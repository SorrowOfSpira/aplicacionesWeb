<?php

// 1. Forzar visualización de errores antes de cargar nada
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    // 2. Verificar que el autoloader existe
    $autoload = __DIR__ . '/../vendor/autoload.php';
    if (!file_exists($autoload)) {
        throw new Exception("No se encontró el archivo vendor/autoload.php. ¿Se ejecutó composer install?");
    }
    require $autoload;

    // 3. Verificar que bootstrap existe
    $bootstrap = __DIR__ . '/../bootstrap/app.php';
    if (!file_exists($bootstrap)) {
        throw new Exception("No se encontró bootstrap/app.php");
    }
    $app = require_once $bootstrap;

    // 4. Ejecutar la aplicación
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

    $request = Illuminate\Http\Request::capture();
    $response = $kernel->handle($request);
    $response->send();
    $kernel->terminate($request, $response);

} catch (Exception $e) {
    echo "<h1>Error en el despliegue</h1>";
    echo "<p><strong>Mensaje:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>Archivo:</strong> " . $e->getFile() . " en línea " . $e->getLine() . "</p>";
    exit;
}