<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Database;
use App\Controllers\DashboardController;
use App\Controllers\InvestigationController;
use App\Controllers\SearchController;

session_start();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$db = Database::getConnection();

// Inisialisasi Controller
$dashboardCtrl = new DashboardController();
$investigationCtrl = new InvestigationController();
$searchCtrl = new SearchController();

switch ($uri) {
    case '/':
    case '/dashboard':
        $dashboardCtrl->index();
        break;

    case '/login':
        require_once __DIR__ . '/../resources/views/auth/login.php';
        break;

    case '/investigation/new':
        require_once __DIR__ . '/../resources/views/investigation_form.php';
        break;

    case '/investigation/store':
        $investigationCtrl->store();
        break;

    case '/investigation/view':
        $searchCtrl->viewResults();
        break;

    case '/investigation/send-telegram':
        $investigationCtrl->sendTelegramReport();
        break;

    default:
        http_response_code(404);
        echo "<div style='background:#0b0e14; color:#ff3333; padding:40px; font-family:monospace;'><h2>404 - NEUROMAP Route Not Found</h2><p>Target path does not exist in reconnaissance map.</p><a href='/dashboard' style='color:#00ff66;'>Return to Dashboard</a></div>";
        break;
}
