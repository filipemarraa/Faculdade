<?php

session_start();

spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    if (str_starts_with($class, $prefix)) {
        $path = __DIR__ . '/../app/' . str_replace('\\', '/', substr($class, strlen($prefix))) . '.php';
        if (file_exists($path)) {
            require $path;
        }
    }
});

$route = $_GET['route'] ?? 'home';

$routes = [
    'home' => [App\Controllers\HomeController::class, 'index'],
    'login' => [App\Controllers\AuthController::class, 'login'],
    'logout' => [App\Controllers\AuthController::class, 'logout'],
    'dashboard' => [App\Controllers\DashboardController::class, 'index'],
    'usuarios' => [App\Controllers\UsuarioController::class, 'index'],
    'usuarios.create' => [App\Controllers\UsuarioController::class, 'create'],
    'usuarios.edit' => [App\Controllers\UsuarioController::class, 'edit'],
    'usuarios.delete' => [App\Controllers\UsuarioController::class, 'delete'],
    'quartos' => [App\Controllers\QuartoController::class, 'index'],
    'quartos.create' => [App\Controllers\QuartoController::class, 'create'],
    'quartos.edit' => [App\Controllers\QuartoController::class, 'edit'],
    'quartos.delete' => [App\Controllers\QuartoController::class, 'delete'],
    'reservas' => [App\Controllers\ReservaController::class, 'index'],
    'reservas.create' => [App\Controllers\ReservaController::class, 'create'],
    'reservas.status' => [App\Controllers\ReservaController::class, 'status'],
    'reservas.delete' => [App\Controllers\ReservaController::class, 'delete'],
];

if (!isset($routes[$route])) {
    http_response_code(404);
    echo 'Rota não encontrada.';
    exit;
}

[$controllerClass, $method] = $routes[$route];
(new $controllerClass())->$method();
