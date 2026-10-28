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
            --success: #34d399;
            --danger: #ef4444;
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
            max-width: 1100px;
            margin: 0 auto;
            padding: 40px 24px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 32px;
            gap: 20px;
            flex-wrap: wrap;
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
            display: flex;
            justify-content: space-between;
            align-items: center;
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
            word-break: break-word;
        }

        .empty {
            color: var(--muted);
            font-size: 0.9rem;
            padding: 12px 0;
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

        .btn-telegram {
            background: #0088cc;
            color: white;
        }

        .btn-danger {
            background: transparent;
            border: 1px solid var(--danger);
            color: var(--danger);
            padding: 6px 12px;
            font-size: 0.8rem;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .query-list, .evidence-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .query-item, .evidence-item {
            background: #111318;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 14px 16px;
        }

        .query-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
        }

        .query-string {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-size: 0.85rem;
            color: #a5f3fc;
            word-break: break-all;
            flex: 1;
        }

        .query-actions a {
            color: var(--accent);
            text-decoration: none;
            font-size: 0.85rem;
            white-space: nowrap;
        }

        .count {
            font-size: 0.85rem;
            color: var(--muted);
            font-weight: 400;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.12);
            border: 1px solid var(--accent);
            color: var(--success);
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 24px;
            font-size: 0.95rem;
        }

        .field {
            margin-bottom: 14px;
        }

        .field label {
            display: block;
            font-size: 0.82rem;
            color: var(--muted);
            margin-bottom: 5px;
        }

        .field input,
        .field select,
        .field textarea {
            width: 100%;
            padding: 10px 12px;
            background: #111318;
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--text);
            font-size: 0.9rem;
            outline: none;
        }

        .field input:focus,
        .field select:focus,
        .field textarea:focus {
            border-color: var(--accent);
        }

        .field textarea {
            min-height: 70px;
            resize: vertical;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .evidence-item h4 {
            font-size: 0.95rem;
            margin-bottom: 6px;
        }

        .evidence-item .url {
            font-size: 0.82rem;
            color: var(--accent);
            word-break: break-all;
            margin-bottom: 6px;
        }

        .evidence-item .snippet {
            font-size: 0.85rem;
            color: var(--muted);
            margin-bottom: 8px;
            line-height: 1.4;
        }

        .evidence-meta {
            display: flex;
            gap: 10px;
            align-items: center;
            font-size: 0.78rem;
            color: var(--muted);
        }

        .evidence-actions {
            margin-top: 10px;
        }

        @media (max-width: 600px) {
            .grid-2 {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <header class="topbar">
        <a href="/dashboard" class="logo">NEUROMAP</a>
        <a href="/dashboard">← Dashboard</a>
    </header>

    <div class="container">

        <?php if (isset($_GET['sent'])): ?>
            <div class="alert-success">✓ Report successfully generated and sent to Telegram.</div>
        <?php endif; ?>

        <?php if (isset($_GET['evidence'])): ?>
            <div class="alert-success">✓ Evidence added successfully.</div>
        <?php endif; ?>

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

        <!-- Subject Information -->
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

        <!-- Actions -->
        <div class="card">
            <h2>Investigation Actions</h2>
            <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                <a href="/investigation/<?= $investigation['id'] ?>/generate-dorks" class="btn btn-primary">Generate Dorks</a>
                <a href="/investigation/<?= $investigation['id'] ?>/send-report" class="btn btn-telegram">Send Report to Telegram</a>
                <a href="/dashboard" class="btn btn-secondary">Back to Dashboard</a>
            </div>
        </div>

        <!-- Generated Queries -->
        <div class="card">
            <h2>
                Generated Queries
                <span class="count"><?= count($queries) ?> total</span>
            </h2>

            <?php if (empty($queries)): ?>
                <div class="empty">No queries generated yet. Click "Generate Dorks" to begin.</div>
            <?php else: ?>
                <div class="query-list">
                    <?php foreach ($queries as $query): ?>
                        <div class="query-item">
                            <div class="query-string"><?= htmlspecialchars($query['query_string']) ?></div>
                            <div class="query-actions">
                                <a href="https://www.google.com/search?q=<?= urlencode($query['query_string']) ?>" target="_blank" rel="noopener">
                                    Open in Google ↗
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Add Evidence Form -->
        <div class="card">
            <h2>Add Evidence</h2>
            <form method="POST" action="/evidence/store">
                <input type="hidden" name="investigation_id" value="<?= $investigation['id'] ?>">

                <div class="field">
                    <label>Title</label>
                    <input type="text" name="title" placeholder="e.g. LinkedIn Profile, News Article, Leaked Document">
                </div>

                <div class="field">
                    <label>URL</label>
                    <input type="url" name="url" placeholder="https://...">
                </div>

                <div class="field">
                    <label>Snippet / Description</label>
                    <textarea name="snippet" placeholder="Short description or extracted text..."></textarea>
                </div>

                <div class="grid-2">
                    <div class="field">
                        <label>Source Platform</label>
                        <input type="text" name="source_platform" placeholder="Google, LinkedIn, Facebook, etc.">
                    </div>

                    <div class="field">
                        <label>Evidence Type</label>
                        <select name="evidence_type">
                            <option value="link">Link</option>
                            <option value="profile">Profile</option>
                            <option value="document">Document</option>
                            <option value="image">Image</option>
                            <option value="mention">Mention</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>

                <div class="grid-2">
                    <div class="field">
                        <label>Confidence</label>
                        <select name="confidence">
                            <option value="low">Low</option>
                            <option value="medium" selected>Medium</option>
                            <option value="high">High</option>
                        </select>
                    </div>

                    <div class="field">
                        <label>Notes</label>
                        <input type="text" name="notes" placeholder="Analyst notes...">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Add Evidence</button>
            </form>
        </div>

        <!-- Collected Evidence -->
        <div class="card">
            <h2>
                Collected Evidence
                <span class="count"><?= count($evidence) ?> items</span>
            </h2>

            <?php if (empty($evidence)): ?>
                <div class="empty">No evidence collected yet.</div>
            <?php else: ?>
                <div class="evidence-list">
                    <?php foreach ($evidence as $item): ?>
                        <div class="evidence-item">
                            <h4><?= htmlspecialchars($item['title'] ?: 'Untitled Evidence') ?></h4>
                            
                            <?php if (!empty($item['url'])): ?>
                                <div class="url">
                                    <a href="<?= htmlspecialchars($item['url']) ?>" target="_blank" rel="noopener" style="color: var(--accent);">
                                        <?= htmlspecialchars($item['url']) ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($item['snippet'])): ?>
                                <div class="snippet"><?= nl2br(htmlspecialchars($item['snippet'])) ?></div>
                            <?php endif; ?>

                            <div class="evidence-meta">
                                <span><?= htmlspecialchars($item['evidence_type']) ?></span>
                                <span>•</span>
                                <span><?= htmlspecialchars($item['confidence']) ?> confidence</span>
                                <?php if (!empty($item['source_platform'])): ?>
                                    <span>•</span>
                                    <span><?= htmlspecialchars($item['source_platform']) ?></span>
                                <?php endif; ?>
                            </div>

                            <?php if (!empty($item['notes'])): ?>
                                <div style="margin-top: 8px; font-size: 0.85rem; color: var(--muted);">
                                    Note: <?= htmlspecialchars($item['notes']) ?>
                                </div>
                            <?php endif; ?>

                            <div class="evidence-actions">
                                <a href="/evidence/<?= $item['id'] ?>/delete" class="btn btn-danger" 
                                   onclick="return confirm('Delete this evidence?')">Delete</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

    </div>

</body>
</html>
