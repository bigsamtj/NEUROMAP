<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Database;
use App\Services\QueryBuilder;
use App\Providers\GoogleLinkProvider;

session_start();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$db = Database::getConnection();

switch ($uri) {
    case '/':
    case '/dashboard':
        echo "<h1>NEUROMAP Recon Station</h1>";
        echo "<p><a href='/investigation/new'>+ Buat Investigasi Baru</a></p>";
        break;

    case '/investigation/new':
        echo '<h2>NEUROMAP - Input Parameter Target</h2>';
        echo '<form method="POST" action="/investigation/create">
                <p><label>Judul Kasus / Ref: <input type="text" name="title" required></label></p>
                <p><label>Nama Lengkap Target: <input type="text" name="full_name"></label></p>
                <p><label>Email: <input type="email" name="email"></label></p>
                <p><label>Pekerjaan / Spesialisasi: <input type="text" name="occupation"></label></p>
                <p><label>Username / Handle: <input type="text" name="username_handle"></label></p>
                <p><label>Known Domain: <input type="text" name="known_domains"></label></p>
                <button type="submit">Generasi Query OSINT</button>
              </form>';
        break;

    case '/investigation/create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $caseRef = 'NEURO-' . strtoupper(substr(md5(uniqid()), 0, 8));
            
            // 1. Simpan Data Kasus Ke DB
            $stmt = $db->prepare("INSERT INTO cases (case_ref, title, full_name, email, occupation, username_handle, known_domains) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $caseRef,
                $_POST['title'] ?? 'Kasus Tanpa Judul',
                $_POST['full_name'] ?? null,
                $_POST['email'] ?? null,
                $_POST['occupation'] ?? null,
                $_POST['username_handle'] ?? null,
                $_POST['known_domains'] ?? null
            ]);
            $caseId = $db->lastInsertId();

            // 2. Ambil Query Templates Aktif
            $templates = $db->query("SELECT * FROM query_templates WHERE is_active = 1")->fetchAll();

            // 3. Generasi Query
            $qb = new QueryBuilder();
            $provider = new GoogleLinkProvider();
            $queries = $qb->generateQueries($_POST, $templates);

            // 4. Tampilkan Hasil
            echo "<h2>Target Dorking: " . htmlspecialchars($_POST['title']) . " ({$caseRef})</h2>";
            echo '<ul>';
            foreach ($queries as $q) {
                $searchUrl = $provider->buildSearchUrl($q['query']);

                // Simpan Search Run ke DB
                $runStmt = $db->prepare("INSERT INTO search_runs (case_id, template_id, query_text, provider, search_url, status) VALUES (?, ?, ?, ?, ?, 'NOT_RUN')");
                $runStmt->execute([$caseId, $q['template_id'], $q['query'], $q['provider'], $searchUrl]);

                echo "<li>
                        <strong>[{$q['category']}] {$q['title']}</strong><br>
                        <code>" . htmlspecialchars($q['query']) . "</code><br>
                        <a href='{$searchUrl}' target='_blank' style='color: #00ff66; background: #111; padding: 2px 6px;'>[ Buka Query Google ]</a>
                      </li><br>";
            }
            echo '</ul>';
            echo "<p><a href='/dashboard'>Kembali ke Dashboard</a></p>";
        }
        break;

    default:
        http_response_code(404);
        echo "404 - NEUROMAP Page Not Found";
        break;
}
