<?php
$pageTitle = "NEUROMAP - Workspace: " . htmlspecialchars($case['title']);
ob_start();
?>
<div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color); padding-bottom: 15px; margin-bottom: 20px;">
    <div>
        <h2 style="margin: 0; border: none; padding: 0;">🎯 Intelligence Workspace</h2>
        <span style="color: var(--accent-emerald); font-size: 13px;">Ref: <?= htmlspecialchars($case['case_ref']) ?> | Title: <?= htmlspecialchars($case['title']) ?></span>
    </div>
    <div>
        <a href="/investigation/send-telegram?ref=<?= $case['case_ref'] ?>" class="btn-telegram" style="padding: 8px 16px; margin-right: 10px;">🚀 Push to Telegram</a>
        <a href="/dashboard" class="btn" style="background: transparent; border: 1px solid var(--border-color); color: var(--text-main);">Dashboard</a>
    </div>
</div>

<!-- Target Overview -->
<div style="background: var(--bg-deep); padding: 15px; border-radius: 6px; border: 1px solid var(--border-color); margin-bottom: 25px; display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px;">
    <div>
        <p style="margin: 5px 0;"><strong>Subject:</strong> <?= htmlspecialchars(($case['first_name'] ?? '') . ' ' . ($case['surname'] ?? 'N/A')) ?></p>
        <p style="margin: 5px 0;"><strong>Phone (Nigeria):</strong> <?= htmlspecialchars($case['phone'] ?? 'N/A') ?></p>
        <p style="margin: 5px 0;"><strong>NIN / BVN:</strong> <?= htmlspecialchars($case['nin'] ?? 'N/A') ?></p>
        <p style="margin: 5px 0;"><strong>Email:</strong> <?= htmlspecialchars($case['email'] ?? 'N/A') ?></p>
    </div>
    <div>
        <p style="margin: 5px 0;"><strong>Instagram:</strong> <?= htmlspecialchars($case['instagram'] ?? 'N/A') ?></p>
        <p style="margin: 5px 0;"><strong>Twitter / X:</strong> <?= htmlspecialchars($case['twitter'] ?? 'N/A') ?></p>
        <p style="margin: 5px 0;"><strong>Organization:</strong> <?= htmlspecialchars($case['organization'] ?? 'N/A') ?></p>
        <p style="margin: 5px 0;"><strong>Domains:</strong> <?= htmlspecialchars($case['known_domains'] ?? 'N/A') ?></p>
    </div>
</div>

<h3>🔍 Automated OSINT Execution Matrix</h3>
<p style="color: var(--text-muted); font-size: 13px;">Launch queries directly to inspect digital footprints live.</p>

<?php if (empty($searchRuns)): ?>
    <p style="color: var(--text-muted);">No queries generated.</p>
<?php else: ?>
    <div style="display: flex; flex-direction: column; gap: 15px;">
        <?php foreach ($searchRuns as $run): ?>
            <div style="background: var(--bg-deep); border: 1px solid var(--border-color); padding: 15px; border-radius: 6px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                    <div>
                        <span style="color: var(--accent-emerald); font-weight: bold; font-size: 14px;"><?= htmlspecialchars($run['query_text']) ?></span>
                        <div style="font-size: 11px; color: var(--text-muted); margin-top: 2px;">Provider: <code><?= htmlspecialchars($run['provider']) ?></code></div>
                    </div>
                    <span style="background: #212d3d; color: var(--accent-emerald); padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: bold;"><?= htmlspecialchars($run['status']) ?></span>
                </div>
                
                <div style="margin-top: 12px;">
                    <a href="<?= htmlspecialchars($run['search_url']) ?>" target="_blank" class="btn" style="font-size: 12px; padding: 6px 14px; text-decoration: none;">
                        Launch Search Query &rarr;
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layout.php';
