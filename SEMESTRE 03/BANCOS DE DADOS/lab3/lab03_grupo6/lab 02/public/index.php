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
    'usuarios' => [App\Controllers\UsuarioController::class, 'index'],
    'usuarios.create' => [App\Controllers\UsuarioController::class, 'create'],
    'usuarios.edit' => [App\Controllers\UsuarioController::class, 'edit'],
    'usuarios.delete' => [App\Controllers\UsuarioController::class, 'delete'],
];

if (!isset($routes[$route])) {
    http_response_code(404);
    echo 'Rota não encontrada.';
    exit;
}

[$controllerClass, $method] = $routes[$route];
(new $controllerClass())->$method();
