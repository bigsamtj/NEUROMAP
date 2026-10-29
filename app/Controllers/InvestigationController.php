<?php

namespace App\Controllers;

use App\Core\Helper;
use App\Core\App;
use App\Core\Database;
use App\Services\DorkEngine;
use App\Services\SocialScanner;
use App\Services\ReportBuilder;
use App\Services\TelegramService;

class InvestigationController
{
    public function create(): void
    {
        Helper::requireAuth();
        App::view('investigation/create');
    }

    public function store(): void
    {
        Helper::requireAuth();

        $title = trim($_POST['title'] ?? '');
        $notes = trim($_POST['notes'] ?? '');

        $full_name     = trim($_POST['full_name'] ?? '');
        $aliases       = trim($_POST['aliases'] ?? '');
        $emails        = trim($_POST['emails'] ?? '');
        $phones        = trim($_POST['phones'] ?? '');
        $usernames     = trim($_POST['usernames'] ?? '');
        $locations     = trim($_POST['locations'] ?? '');
        $organizations = trim($_POST['organizations'] ?? '');
        $websites      = trim($_POST['websites'] ?? '');

        if (empty($title)) {
            App::view('investigation/create', [
                'error' => 'Investigation title is required.',
                'old'   => $_POST
            ]);
            return;
        }

        $investigationId = Database::insert('investigations', [
            'title'  => $title,
            'status' => 'pending',
            'notes'  => $notes
        ]);

        Database::insert('targets', [
            'investigation_id' => $investigationId,
            'full_name'        => $full_name,
            'aliases'          => $aliases,
            'emails'           => $emails,
            'phones'           => $phones,
            'usernames'        => $usernames,
            'locations'        => $locations,
            'organizations'    => $organizations,
            'websites'         => $websites
        ]);

        Helper::redirect('/investigation/' . $investigationId);
    }

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
            "SELECT * FROM queries WHERE investigation_id = ? ORDER BY query_type, created_at DESC",
            [$id]
        );

        $evidence = Database::fetchAll(
            "SELECT * FROM evidence WHERE investigation_id = ? ORDER BY created_at DESC",
            [$id]
        );

        App::view('investigation/show', [
            'investigation' => $investigation,
            'target'        => $target,
            'queries'       => $queries,
            'evidence'      => $evidence
        ]);
    }

    public function generateDorks(string $id): void
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

        if (!$target) {
            Helper::redirect('/investigation/' . $id);
            return;
        }

        // Clear previous google dorks only
        Database::query(
            "DELETE FROM queries WHERE investigation_id = ? AND query_type = 'google_dork'",
            [$id]
        );

        $engine = new DorkEngine($target);
        $dorks  = $engine->generate();

        foreach ($dorks as $dork) {
            Database::insert('queries', [
                'investigation_id' => $id,
                'target_id'        => $target['id'],
                'query_type'       => $dork['type'],
                'platform'         => $dork['platform'],
                'query_string'     => $dork['query'],
                'status'           => 'pending'
            ]);
        }

        Database::update('investigations', [
            'status'     => 'running',
            'updated_at' => date('Y-m-d H:i:s')
        ], 'id = :id', ['id' => $id]);

        Helper::redirect('/investigation/' . $id);
    }

    /**
     * Generate social media scans
     */
    public function generateSocial(string $id): void
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

        if (!$target) {
            Helper::redirect('/investigation/' . $id);
            return;
        }

        // Clear previous social queries
        Database::query(
            "DELETE FROM queries WHERE investigation_id = ? AND query_type = 'social'",
            [$id]
        );

        $scanner = new SocialScanner($target);
        $results = $scanner->generate();

        foreach ($results as $item) {
            $queryString = $item['query'] ?? $item['url'] ?? '';

            if (empty($queryString)) continue;

            Database::insert('queries', [
                'investigation_id' => $id,
                'target_id'        => $target['id'],
                'query_type'       => 'social',
                'platform'         => $item['platform'] ?? 'unknown',
                'query_string'     => $queryString,
                'status'           => 'pending'
            ]);
        }

        Database::update('investigations', [
            'status'     => 'running',
            'updated_at' => date('Y-m-d H:i:s')
        ], 'id = :id', ['id' => $id]);

        Helper::redirect('/investigation/' . $id);
    }

    public function sendReport(string $id): void
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
        $telegramText = $builder->buildTelegramReport();
        $plainText    = $builder->buildPlainReport();

        $reportsDir = __DIR__ . '/../../storage/reports';
        if (!is_dir($reportsDir)) {
            mkdir($reportsDir, 0755, true);
        }

        $fileName = 'report_' . $id . '_' . date('Ymd_His') . '.txt';
        $filePath = $reportsDir . '/' . $fileName;
        file_put_contents($filePath, $plainText);

        Database::insert('reports', [
            'investigation_id' => $id,
            'title'            => 'Report for Investigation #' . $id,
            'content'          => $plainText,
            'file_path'        => $fileName,
            'sent_to_telegram' => 0
        ]);

        $telegram = new TelegramService();
        $sent = $telegram->sendMessage($telegramText);

        if ($sent) {
            $telegram->sendDocument($filePath, "Full report for Investigation #{$id}");

            Database::update('reports', [
                'sent_to_telegram' => 1
            ], 'investigation_id = :id', ['id' => $id]);
        }

        Database::update('investigations', [
            'status'     => 'completed',
            'updated_at' => date('Y-m-d H:i:s')
        ], 'id = :id', ['id' => $id]);

        Helper::redirect('/investigation/' . $id . '?sent=1');
    }
}
