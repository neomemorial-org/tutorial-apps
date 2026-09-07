<?php
declare(strict_types=1);

// Unica puerta de entrada de la app (front controller).
require __DIR__ . '/../app/autoload.php';

use App\Core\Router;
use App\Controllers\HomeController;

$router = new Router();
$router->get('/', [HomeController::class, 'index']);
$router->dispatch($_SERVER['REQUEST_URI'] ?? '/', $_SERVER['REQUEST_METHOD'] ?? 'GET');
