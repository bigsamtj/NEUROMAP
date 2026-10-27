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
        
        // Fetch case details by reference
        $stmt = $db->prepare("SELECT * FROM cases WHERE case_ref = ?");
        $stmt->execute([$ref]);
        $case = $stmt->fetch();

        if (!$case) {
            echo "Case not found in database.";
            exit;
        }

        // Fetch associated search runs
        $runStmt = $db->prepare("SELECT * FROM search_runs WHERE case_id = ?");
        $runStmt->execute([$case['id']]);
        $searchRuns = $runStmt->fetchAll();

        // Render the show view
        require_once __DIR__ . '/../../resources/views/investigations/show.php';
    }
}
