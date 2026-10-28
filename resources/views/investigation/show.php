<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Investigation #<?= $investigation['id'] ?> — NEUROMAP</title>
    <style>
        :root {
            --bg: #0f1115;
            --card: #1a1d24;
            --border: #2a2e38;
            --text: #e5e7eb;
            --muted: #9ca3af;
            --accent: #10b981;
            --accent-dim: rgba(16, 185, 129, 0.12);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 32px;
            border-bottom: 1px solid var(--border);
            background: #12151b;
        }

        .logo {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--accent);
            text-decoration: none;
        }

        .topbar a {
            color: var(--muted);
            text-decoration: none;
            font-size: 0.9rem;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 40px 24px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 32px;
            gap: 20px;
        }

        h1 {
            font-size: 1.6rem;
            margin-bottom: 6px;
        }

        .meta {
            color: var(--muted);
            font-size: 0.9rem;
        }

        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: 500;
            background: var(--accent-dim);
            color: var(--accent);
            text-transform: uppercase;
        }

        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 24px;
            margin-bottom: 24px;
        }

        .card h2 {
            font-size: 1.1rem;
            margin-bottom: 18px;
            color: var(--accent);
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
        }

        .info-item label {
            display: block;
            font-size: 0.78rem;
            color: var(--muted);
            margin-bottom: 4px;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .info-item div {
            font-size: 0.95rem;
        }

        .empty {
            color: var(--muted);
            font-size: 0.9rem;
            padding: 12px 0;
        }

        .actions {
            display: flex;
            gap: 12px;
            margin-top: 10px;
        }

        .btn {
            display: inline-block;
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: var(--accent);
            color: #000;
        }

        .btn-secondary {
            background: transparent;
            border: 1px solid var(--border);
            color: var(--text);
        }
    </style>
</head>
<body>

    <header class="topbar">
        <a href="/dashboard" class="logo">NEUROMAP</a>
        <a href="/dashboard">← Dashboard</a>
    </header>

    <div class="container">

        <div class="header">
            <div>
                <h1><?= htmlspecialchars($investigation['title']) ?></h1>
                <div class="meta">
                    Investigation #<?= $investigation['id'] ?> · 
                    Created <?= htmlspecialchars($investigation['created_at']) ?>
                </div>
            </div>
            <span class="badge"><?= htmlspecialchars($investigation['status']) ?></span>
        </div>

        <!-- Target Information -->
        <div class="card">
            <h2>Subject Information</h2>

            <?php if ($target): ?>
                <div class="info-grid">
                    <div class="info-item">
                        <label>Full Name</label>
                        <div><?= htmlspecialchars($target['full_name'] ?: '—') ?></div>
                    </div>
                    <div class="info-item">
                        <label>Aliases</label>
                        <div><?= htmlspecialchars($target['aliases'] ?: '—') ?></div>
                    </div>
                    <div class="info-item">
                        <label>Emails</label>
                        <div><?= htmlspecialchars($target['emails'] ?: '—') ?></div>
                    </div>
                    <div class="info-item">
                        <label>Phones</label>
                        <div><?= htmlspecialchars($target['phones'] ?: '—') ?></div>
                    </div>
                    <div class="info-item">
                        <label>Usernames</label>
                        <div><?= htmlspecialchars($target['usernames'] ?: '—') ?></div>
                    </div>
                    <div class="info-item">
                        <label>Locations</label>
                        <div><?= htmlspecialchars($target['locations'] ?: '—') ?></div>
                    </div>
                    <div class="info-item">
                        <label>Organizations</label>
                        <div><?= htmlspecialchars($target['organizations'] ?: '—') ?></div>
                    </div>
                    <div class="info-item">
                        <label>Websites</label>
                        <div><?= htmlspecialchars($target['websites'] ?: '—') ?></div>
                    </div>
                </div>
            <?php else: ?>
                <div class="empty">No target details recorded.</div>
            <?php endif; ?>
        </div>

        <!-- Notes -->
        <?php if (!empty($investigation['notes'])): ?>
            <div class="card">
                <h2>Internal Notes</h2>
                <p style="line-height: 1.6; color: var(--muted);">
                    <?= nl2br(htmlspecialchars($investigation['notes'])) ?>
                </p>
            </div>
        <?php endif; ?>

        <!-- Future Actions -->
        <div class="card">
            <h2>Investigation Actions</h2>
            <p style="color: var(--muted); margin-bottom: 16px; font-size: 0.9rem;">
                Next phase will enable automated dork generation and deep search from here.
            </p>
            <div class="actions">
                <a href="#" class="btn btn-primary" style="opacity: 0.6; pointer-events: none;">
                    Generate Dorks (Coming in Phase 3)
                </a>
                <a href="/dashboard" class="btn btn-secondary">Back to Dashboard</a>
            </div>
        </div>

        <!-- Queries Placeholder -->
        <div class="card">
            <h2>Generated Queries</h2>
            <?php if (empty($queries)): ?>
                <div class="empty">No queries generated yet.</div>
            <?php else: ?>
                <!-- Will be filled in Phase 3 -->
            <?php endif; ?>
        </div>

        <!-- Evidence Placeholder -->
        <div class="card">
            <h2>Collected Evidence</h2>
            <?php if (empty($evidence)): ?>
                <div class="empty">No evidence collected yet.</div>
            <?php else: ?>
                <!-- Will be filled later -->
            <?php endif; ?>
        </div>

    </div>

</body>
</html>
