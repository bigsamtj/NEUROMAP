<?php

namespace App\Controllers;

use App\Database;

class SearchController
{
    public function viewResults()
    {
        $ref = $_GET['ref'] ?? null;
        if (!$ref) {
            header('Location: /dashboard');
            exit;
        }

        $db = Database::getConnection();
        
        // Ambil data kasus berdasarkan referensi
        $stmt = $db->prepare("SELECT * FROM cases WHERE case_ref = ?");
        $stmt->execute([$ref]);
        $case = $stmt->fetch();

        if (!$case) {
            echo "Kasus tidak ditemukan.";
            exit;
        }

        // Ambil daftar query search_runs yang terkait
        $runStmt = $db->prepare("SELECT * FROM search_runs WHERE case_id = ?");
        $runStmt->execute([$case['id']]);
        $searchRuns = $runStmt->fetchAll();

        require_once __DIR__ . '/../../resources/views/investigation_form.php'; // atau file view hasil
    }
}
