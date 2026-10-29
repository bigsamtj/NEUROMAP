<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report — Investigation #<?= $investigation['id'] ?> — NEUROMAP</title>
    <style>
        :root {
            --text: #111;
            --muted: #555;
            --border: #ddd;
            --accent: #0f766e;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: Georgia, 'Times New Roman', serif;
            color: var(--text);
            background: #fff;
            line-height: 1.55;
            padding: 40px;
            max-width: 900px;
            margin: 0 auto;
        }

        .no-print {
            margin-bottom: 30px;
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-family: system-ui, sans-serif;
            font-size: 0.9rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
        }

        .btn-print {
            background: #0f766e;
            color: white;
        }

        .btn-download {
            background: #1e293b;
            color: white;
        }

        .btn-back {
            background: #e5e7eb;
            color: #111;
        }

        .header {
            border-bottom: 3px solid #111;
            padding-bottom: 16px;
            margin-bottom: 28px;
        }

        .header h1 {
            font-size: 1.8rem;
            margin-bottom: 6px;
        }

        .header .meta {
            color: var(--muted);
            font-size: 0.95rem;
            font-family: system-ui, sans-serif;
        }

        h2 {
            font-size: 1.15rem;
            margin: 28px 0 12px;
            padding-bottom: 6px;
            border-bottom: 1px solid var(--border);
            color: var(--accent);
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px 24px;
            margin-bottom: 8px;
        }

        .item label {
            display: block;
            font-size: 0.75rem;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.04em;
            font-family: system-ui, sans-serif;
            margin-bottom: 2px;
        }

        .item div {
            font-size: 0.95rem;
        }

        .notes {
            background: #f8fafc;
            border-left: 3px solid var(--accent);
            padding: 12px 16px;
            margin: 10px 0;
            font-size: 0.95rem;
        }

        .query, .evidence {
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
            font-size: 0.9rem;
        }

        .query code {
            font-family: ui-monospace, monospace;
            font-size: 0.84rem;
            background: #f1f5f9;
            padding: 2px 6px;
            border-radius: 4px;
        }

        .evidence strong {
            display: block;
            margin-bottom: 3px;
        }

        .evidence a {
            color: var(--accent);
            word-break: break-all;
            font-size: 0.85rem;
        }

        .footer {
            margin-top: 40px;
            padding-top: 16px;
            border-top: 2px solid #111;
            font-size: 0.85rem;
            color: var(--muted);
            font-family: system-ui, sans-serif;
        }

        @media print {
            .no-print { display: none !important; }
            body { padding: 0; }
            a { color: #000; text-decoration: none; }
        }

        @media (max-width: 600px) {
            .grid { grid-template-columns: 1fr; }
            body { padding: 20px; }
        }
    </style>
</head>
<body>

    <div class="no-print">
        <button onclick="window.print()" class="btn btn-print">Print / Save as PDF</button>
        <a href="/investigation/<?= $investigation['id'] ?>/report/download" class="btn btn-download">Download TXT</a>
        <a href="/investigation/<?= $investigation['id'] ?>" class="btn btn-back">← Back to Investigation</a>
    </div>

    <div class="header">
        <h1>NEUROMAP Investigation Report</h1>
        <div class="meta">
            Case: <?= htmlspecialchars($investigation['title']) ?><br>
            Investigation ID: #<?= $investigation['id'] ?> · 
            Status: <?= strtoupper($investigation['status']) ?><br>
            Created: <?= htmlspecialchars($investigation['created_at']) ?> · 
            Generated: <?= date('Y-m-d H:i:s') ?>
        </div>
    </div>

    <h2>Subject Information</h2>
    <?php if ($target): ?>
        <div class="grid">
            <div class="item">
                <label>Full Name</label>
                <div><?= htmlspecialchars($target['full_name'] ?: '—') ?></div>
            </div>
            <div class="item">
                <label>Aliases</label>
                <div><?= htmlspecialchars($target['aliases'] ?: '—') ?></div>
            </div>
            <div class="item">
                <label>Emails</label>
                <div><?= htmlspecialchars($target['emails'] ?: '—') ?></div>
            </div>
            <div class="item">
                <label>Phones</label>
                <div><?= htmlspecialchars($target['phones'] ?: '—') ?></div>
            </div>
            <div class="item">
                <label>Usernames</label>
                <div><?= htmlspecialchars($target['usernames'] ?: '—') ?></div>
            </div>
            <div class="item">
                <label>Locations</label>
                <div><?= htmlspecialchars($target['locations'] ?: '—') ?></div>
            </div>
            <div class="item">
                <label>Organizations</label>
                <div><?= htmlspecialchars($target['organizations'] ?: '—') ?></div>
            </div>
            <div class="item">
                <label>Websites</label>
                <div><?= htmlspecialchars($target['websites'] ?: '—') ?></div>
            </div>
        </div>
    <?php else: ?>
        <p>No subject details available.</p>
    <?php endif; ?>

    <?php if (!empty($investigation['notes'])): ?>
        <h2>Internal Notes</h2>
        <div class="notes">
            <?= nl2br(htmlspecialchars($investigation['notes'])) ?>
        </div>
    <?php endif; ?>

    <h2>Generated Queries (<?= count($queries) ?>)</h2>
    <?php if (empty($queries)): ?>
        <p>No queries generated.</p>
    <?php else: ?>
        <?php foreach ($queries as $i => $q): ?>
            <div class="query">
                <?= $i + 1 ?>. 
                <code><?= htmlspecialchars($q['query_string']) ?></code>
                <?php if (!empty($q['platform'])): ?>
                    <span style="color: var(--muted); font-size: 0.8rem;"> — <?= htmlspecialchars($q['platform']) ?></span>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <h2>Collected Evidence (<?= count($evidence) ?>)</h2>
    <?php if (empty($evidence)): ?>
        <p>No evidence collected.</p>
    <?php else: ?>
        <?php foreach ($evidence as $i => $ev): ?>
            <div class="evidence">
                <strong><?= $i + 1 ?>. <?= htmlspecialchars($ev['title'] ?: 'Untitled Evidence') ?></strong>
                <?php if (!empty($ev['url'])): ?>
                    <div><a href="<?= htmlspecialchars($ev['url']) ?>" target="_blank"><?= htmlspecialchars($ev['url']) ?></a></div>
                <?php endif; ?>
                <?php if (!empty($ev['snippet'])): ?>
                    <div style="color: var(--muted); margin-top: 4px;"><?= nl2br(htmlspecialchars($ev['snippet'])) ?></div>
                <?php endif; ?>
                <div style="font-size: 0.8rem; color: var(--muted); margin-top: 4px;">
                    Type: <?= htmlspecialchars($ev['evidence_type']) ?> · 
                    Confidence: <?= htmlspecialchars($ev['confidence']) ?>
                    <?php if (!empty($ev['source_platform'])): ?>
                        · Source: <?= htmlspecialchars($ev['source_platform']) ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <div class="footer">
        Generated by <strong>NEUROMAP</strong> — Personal OSINT Investigation Station<br>
        Creator: Samuel Adeyinka (BigSam) · <?= date('Y-m-d H:i:s') ?>
    </div>

</body>
</html>
