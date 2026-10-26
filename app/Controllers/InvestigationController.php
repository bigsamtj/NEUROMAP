<?php

namespace App\Controllers;

use App\Database;
use App\Services\QueryBuilder;
use App\Providers\GoogleLinkProvider;
use App\Services\TelegramService;

class InvestigationController
{
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /investigation/new');
            exit;
        }

        $db = Database::getConnection();
        $caseRef = 'NEURO-' . strtoupper(substr(md5(uniqid()), 0, 8));
        
        $title = $_POST['title'] ?? 'Kasus Tanpa Judul';
        $surname = $_POST['surname'] ?? null;
        $firstName = $_POST['first_name'] ?? null;
        $phone = $_POST['phone'] ?? null;
        $nin = $_POST['nin'] ?? null;
        $instagram = $_POST['instagram'] ?? null;
        $twitter = $_POST['twitter'] ?? null;
        $facebook = $_POST['facebook'] ?? null;
        $linkedin = $_POST['linkedin'] ?? null;
        $email = $_POST['email'] ?? null;
        $organization = $_POST['organization'] ?? null;
        $knownDomains = $_POST['known_domains'] ?? null;

        // Simpan data kasus dengan parameter Nigeria ke database
        $stmt = $db->prepare("INSERT INTO cases (case_ref, title, surname, first_name, phone, nin, instagram, twitter, facebook, linkedin, email, organization, known_domains) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $caseRef, 
            $title, 
            $surname, 
            $firstName, 
            $phone, 
            $nin, 
            $instagram, 
            $twitter, 
            $facebook, 
            $linkedin, 
            $email, 
            $organization, 
            $knownDomains
        ]);
        $caseId = $db->lastInsertId();

        // Generasi query menggunakan QueryBuilder
        $qb = new QueryBuilder();
        $provider = new GoogleLinkProvider();
        $queries = $qb->generateQueries($_POST);

        // Simpan pencarian ke database search_runs
        foreach ($queries as $q) {
            $searchUrl = $provider->buildSearchUrl($q['query']);
            $runStmt = $db->prepare("INSERT INTO search_runs (case_id, template_id, query_text, provider, search_url, status) VALUES (?, ?, ?, ?, ?, 'NOT_RUN')");
            $runStmt->execute([$caseId, $q['template_id'], $q['query'], $q['provider'], $searchUrl]);
        }

        // Simpan laporan ringkas ke session untuk Telegram
        $_SESSION['last_report'] = [
            'case_ref' => $caseRef,
            'title' => $title,
            'queries' => $queries
        ];

        header('Location: /investigation/view?ref=' . $caseRef);
        exit;
    }

    public function sendTelegramReport()
    {
        if (isset($_SESSION['last_report'])) {
            $report = $_SESSION['last_report'];
            $msg = "*NEUROMAP OSINT REPORT*\n";
            $msg .= "Kasus: {$report['title']} (`{$report['case_ref']}`)\n\n";
            $msg .= "Daftar Query Dork:\n";
            foreach ($report['queries'] as $q) {
                $msg .= "- *{$q['title']}* (`{$q['category']}`)\n  `{$q['query']}`\n";
            }

            $telegram = new TelegramService();
            $sent = $telegram->sendReport($msg);

            if ($sent) {
                echo "<script>alert('Laporan berhasil dikirim ke Telegram!'); window.location.href='/dashboard';</script>";
            } else {
                echo "<script>alert('Gagal mengirim ke Telegram. Periksa Token & Chat ID.'); window.location.href='/dashboard';</script>";
            }
        } else {
            header('Location: /dashboard');
        }
    }
}
