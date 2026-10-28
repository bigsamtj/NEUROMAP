<?php

namespace App\Controllers;

use App\Core\Helper;
use App\Core\App;
use App\Core\Database;

class DashboardController
{
    public function index(): void
    {
        Helper::requireAuth();

        // Get basic stats
        $totalInvestigations = Database::fetch("SELECT COUNT(*) as total FROM investigations")['total'] ?? 0;
        $pending = Database::fetch("SELECT COUNT(*) as total FROM investigations WHERE status = 'pending'")['total'] ?? 0;
        $completed = Database::fetch("SELECT COUNT(*) as total FROM investigations WHERE status = 'completed'")['total'] ?? 0;

        $recent = Database::fetchAll(
            "SELECT * FROM investigations ORDER BY created_at DESC LIMIT 8"
        );

        App::view('dashboard', [
            'total'     => $totalInvestigations,
            'pending'   => $pending,
            'completed' => $completed,
            'recent'    => $recent,
            'user'      => $_SESSION['neuromap_user']['username'] ?? 'Operator'
        ]);
    }
}
