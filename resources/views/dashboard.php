<?php
$pageTitle = "NEUROMAP - Dashboard";
ob_start();
?>
<h2>🌐 NEUROMAP Recon Station</h2>
<p style="color: var(--text-muted);">Personal OSINT Investigation Workbench</p>

<p><a href="/investigation/new" class="btn">+ Buat Investigasi Baru</a></p>

<h3>Daftar Kasus Aktif</h3>
<?php if (empty($cases)): ?>
    <p>Belum ada investigasi yang tercatat.</p>
<?php else: ?>
    <ul>
        <?php foreach ($cases as $c): ?>
            <li>
                <strong><?= htmlspecialchars($c['title']) ?></strong> (<code><?= htmlspecialchars($c['case_ref']) ?></code>)<br>
                Target: <?= htmlspecialchars($c['full_name'] ?? 'Tidak dispesifikasikan') ?> | Dibuat: <?= $c['created_at'] ?>
            </li>
            <br>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
<?php
$content = ob_get_clean();
require_once __DIR__ . '/layout.php';
