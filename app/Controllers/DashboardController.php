<?php

namespace App\Controllers;

use App\Database;

class DashboardController
{
    public function index()
    {
        $db = Database::getConnection();
        
        // Ambil daftar investigasi/kasus
        $stmt = $db->query("SELECT * FROM cases ORDER BY created_at DESC");
        $cases = $stmt->fetchAll();

        // Load tampilan dashboard
        require_once __DIR__ . '/../../resources/views/dashboard.php';
    }
}
