<?php

define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) { // ← ДОБАВИЛИ laravel_app/
    require $maintenance;
}

require __DIR__.'/../vendor/autoload.php';  // ← ДОБАВИЛИ laravel_app/

$app = require_once __DIR__.'/../bootstrap/app.php';  // ← ДОБАВИЛИ laravel_app/

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();
$kernel->terminate($request, $response);
