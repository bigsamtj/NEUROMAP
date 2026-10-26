<?php
$pageTitle = "NEUROMAP - Kasus: " . htmlspecialchars($case['title']);
ob_start();
?>
<div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color); padding-bottom: 15px; margin-bottom: 20px;">
    <div>
        <h2 style="margin: 0; border: none; padding: 0;"><?= htmlspecialchars($case['title']) ?></h2>
        <span style="color: var(--accent-emerald); font-size: 13px;"><?= htmlspecialchars($case['case_ref']) ?></span>
    </div>
    <div>
        <a href="/investigation/send-telegram?ref=<?= $case['case_ref'] ?>" class="btn-telegram" style="margin: 0; padding: 8px 16px;">🚀 Kirim ke Telegram</a>
        <a href="/dashboard" class="btn" style="background: transparent; border: 1px solid var(--border-color); color: var(--text-main); margin-left: 10px;">Kembali</a>
    </div>
</div>

<div style="background: var(--bg-deep); padding: 15px; border-radius: 6px; border: 1px solid var(--border-color); margin-bottom: 25px;">
    <h3 style="margin-top: 0; font-size: 16px; color: var(--text-muted);">Target Profiling Data</h3>
    <p style="margin: 5px 0;"><strong>Nama Lengkap:</strong> <?= htmlspecialchars($case['full_name'] ?? '-') ?></p>
    <p style="margin: 5px 0;"><strong>Email:</strong> <?= htmlspecialchars($case['email'] ?? '-') ?></p>
    <p style="margin: 5px 0;"><strong>Pekerjaan:</strong> <?= htmlspecialchars($case['occupation'] ?? '-') ?></p>
    <p style="margin: 5px 0;"><strong>Username / Handle:</strong> <?= htmlspecialchars($case['username_handle'] ?? '-') ?></p>
    <p style="margin: 5px 0;"><strong>Domain Terkait:</strong> <?= htmlspecialchars($case['known_domains'] ?? '-') ?></p>
</div>

<h3>Generated OSINT Dorks & Queries</h3>
<?php if (empty($searchRuns)): ?>
    <p style="color: var(--text-muted);">Tidak ada query dork yang ditemukan untuk kasus ini.</p>
<?php else: ?>
    <div style="display: flex; flex-direction: column; gap: 15px;">
        <?php foreach ($searchRuns as $run): ?>
            <div style="background: var(--bg-deep); border: 1px solid var(--border-color); padding: 15px; border-radius: 6px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span style="color: var(--accent-emerald); font-weight: bold; font-size: 13px;"><?= htmlspecialchars($run['provider']) ?> Engine</span>
                    <span style="background: #212d3d; padding: 2px 6px; border-radius: 4px; font-size: 11px;"><?= htmlspecialchars($run['status']) ?></span>
                </div>
                <code style="display: block; padding: 10px; margin-bottom: 10px; word-break: break-all;"><?= htmlspecialchars($run['query_text']) ?></code>
                <div>
                    <a href="<?= htmlspecialchars($run['search_url']) ?>" target="_blank" class="btn" style="font-size: 12px; padding: 6px 12px;">Buka Link Pencarian &rarr;</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layout.php';
