<?php

namespace App\Controllers;

use App\Core\Helper;
use App\Core\App;
use App\Core\Database;
use App\Services\ReportBuilder;

class ReportController
{
    /**
     * Show printable / PDF-ready report
     */
    public function show(string $id): void
    {
        Helper::requireAuth();

        $investigation = Database::fetch(
            "SELECT * FROM investigations WHERE id = ?",
            [$id]
        );

        if (!$investigation) {
            http_response_code(404);
            echo "Investigation not found.";
            return;
        }

        $target = Database::fetch(
            "SELECT * FROM targets WHERE investigation_id = ?",
            [$id]
        );

        $queries = Database::fetchAll(
            "SELECT * FROM queries WHERE investigation_id = ? ORDER BY query_type, created_at ASC",
            [$id]
        );

        $evidence = Database::fetchAll(
            "SELECT * FROM evidence WHERE investigation_id = ? ORDER BY created_at ASC",
            [$id]
        );

        // Build plain text version too (optional save)
        $builder = new ReportBuilder($investigation, $target, $queries, $evidence);
        $plainText = $builder->buildPlainReport();

        App::view('investigation/report', [
            'investigation' => $investigation,
            'target'        => $target,
            'queries'       => $queries,
            'evidence'      => $evidence,
            'plainText'     => $plainText
        ], false); // no main layout — clean print layout
    }

    /**
     * Download report as .txt file
     */
    public function download(string $id): void
    {
        Helper::requireAuth();

        $investigation = Database::fetch(
            "SELECT * FROM investigations WHERE id = ?",
            [$id]
        );

        if (!$investigation) {
            http_response_code(404);
            echo "Investigation not found.";
            return;
        }

        $target = Database::fetch(
            "SELECT * FROM targets WHERE investigation_id = ?",
            [$id]
        );

        $queries = Database::fetchAll(
            "SELECT * FROM queries WHERE investigation_id = ?",
            [$id]
        );

        $evidence = Database::fetchAll(
            "SELECT * FROM evidence WHERE investigation_id = ?",
            [$id]
        );

        $builder = new ReportBuilder($investigation, $target, $queries, $evidence);
        $content = $builder->buildPlainReport();

        $filename = 'NEUROMAP_Report_' . $id . '_' . date('Ymd_His') . '.txt';

        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Length: ' . strlen($content));
        echo $content;
        exit;
    }
}
