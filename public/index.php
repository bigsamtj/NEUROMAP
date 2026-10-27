<?php

/**
 * NEUROMAP - Front Controller
 */

declare(strict_types=1);

// Start session
session_start();

// Load Composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Load environment variables (simple version)
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (str_starts_with(trim($line), '#')) continue;
        if (strpos($line, '=') !== false) {
            [$key, $value] = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
        }
    }
}

// Load config
$config = require __DIR__ . '/../config/app.php';

// Error reporting
if ($config['debug']) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(0);
    ini_set('display_errors', '0');
}

// Create router
use App\Core\Router;

$router = new Router();

// ======================
// ROUTES
// ======================

// Home / Dashboard
$router->get('/', function () {
    echo "NEUROMAP is running. Foundation ready.";
});

// Later we will add:
// $router->get('/login', [App\Controllers\AuthController::class, 'showLogin']);
// $router->post('/login', [App\Controllers\AuthController::class, 'login']);
// $router->get('/dashboard', [App\Controllers\DashboardController::class, 'index']);
// $router->get('/investigation/create', [App\Controllers\InvestigationController::class, 'create']);
// etc.

// Dispatch the request
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
