<?php
$title = 'Investigation #' . $investigation['id'];
?>

<?php if (isset($_GET['sent'])): ?>
    <div class="alert-success">✓ Report successfully generated and sent to Telegram.</div>
<?php endif; ?>

<?php if (isset($_GET['evidence'])): ?>
    <div class="alert-success">✓ Evidence added successfully.</div>
<?php endif; ?>

<div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 28px; gap: 16px; flex-wrap: wrap;">
    <div>
        <h1><?= htmlspecialchars($investigation['title']) ?></h1>
        <p class="subtitle" style="margin-bottom: 0;">
            Investigation #<?= $investigation['id'] ?> · 
            Created <?= htmlspecialchars($investigation['created_at']) ?>
        </p>
    </div>
    <span class="badge"><?= htmlspecialchars($investigation['status']) ?></span>
</div>

<!-- Subject Information -->
<div class="card">
    <h2>Subject Information</h2>
    <?php if ($target): ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px;">
            <div>
                <label style="display:block; font-size:0.78rem; color:var(--muted); margin-bottom:4px; text-transform:uppercase;">Full Name</label>
                <div><?= htmlspecialchars($target['full_name'] ?: '—') ?></div>
            </div>
            <div>
                <label style="display:block; font-size:0.78rem; color:var(--muted); margin-bottom:4px; text-transform:uppercase;">Aliases</label>
                <div><?= htmlspecialchars($target['aliases'] ?: '—') ?></div>
            </div>
            <div>
                <label style="display:block; font-size:0.78rem; color:var(--muted); margin-bottom:4px; text-transform:uppercase;">Emails</label>
                <div><?= htmlspecialchars($target['emails'] ?: '—') ?></div>
            </div>
            <div>
                <label style="display:block; font-size:0.78rem; color:var(--muted); margin-bottom:4px; text-transform:uppercase;">Phones</label>
                <div><?= htmlspecialchars($target['phones'] ?: '—') ?></div>
            </div>
            <div>
                <label style="display:block; font-size:0.78rem; color:var(--muted); margin-bottom:4px; text-transform:uppercase;">Usernames</label>
                <div><?= htmlspecialchars($target['usernames'] ?: '—') ?></div>
            </div>
            <div>
                <label style="display:block; font-size:0.78rem; color:var(--muted); margin-bottom:4px; text-transform:uppercase;">Locations</label>
                <div><?= htmlspecialchars($target['locations'] ?: '—') ?></div>
            </div>
            <div>
                <label style="display:block; font-size:0.78rem; color:var(--muted); margin-bottom:4px; text-transform:uppercase;">Organizations</label>
                <div><?= htmlspecialchars($target['organizations'] ?: '—') ?></div>
            </div>
            <div>
                <label style="display:block; font-size:0.78rem; color:var(--muted); margin-bottom:4px; text-transform:uppercase;">Websites</label>
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
        <span style="font-size: 0.85rem; color: var(--muted); font-weight: 400;"><?= count($queries) ?> total</span>
    </h2>

    <?php if (empty($queries)): ?>
        <div class="empty">No queries generated yet. Click "Generate Dorks" to begin.</div>
    <?php else: ?>
        <div style="display: flex; flex-direction: column; gap: 10px; max-height: 480px; overflow-y: auto;">
            <?php foreach ($queries as $query): ?>
                <div style="background: #111318; border: 1px solid var(--border); border-radius: 8px; padding: 12px 16px; display: flex; justify-content: space-between; align-items: center; gap: 16px;">
                    <div style="font-family: ui-monospace, monospace; font-size: 0.85rem; color: #a5f3fc; word-break: break-all; flex: 1;">
                        <?= htmlspecialchars($query['query_string']) ?>
                    </div>
                    <a href="https://www.google.com/search?q=<?= urlencode($query['query_string']) ?>" target="_blank" rel="noopener" style="color: var(--accent); text-decoration: none; font-size: 0.85rem; white-space: nowrap;">
                        Open in Google ↗
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Add Evidence -->
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
        <span style="font-size: 0.85rem; color: var(--muted); font-weight: 400;"><?= count($evidence) ?> items</span>
    </h2>

    <?php if (empty($evidence)): ?>
        <div class="empty">No evidence collected yet.</div>
    <?php else: ?>
        <div style="display: flex; flex-direction: column; gap: 12px;">
            <?php foreach ($evidence as $item): ?>
                <div style="background: #111318; border: 1px solid var(--border); border-radius: 8px; padding: 14px 16px;">
                    <div style="font-weight: 600; margin-bottom: 6px;">
                        <?= htmlspecialchars($item['title'] ?: 'Untitled Evidence') ?>
                    </div>

                    <?php if (!empty($item['url'])): ?>
                        <div style="font-size: 0.82rem; margin-bottom: 6px;">
                            <a href="<?= htmlspecialchars($item['url']) ?>" target="_blank" rel="noopener" style="color: var(--accent); word-break: break-all;">
                                <?= htmlspecialchars($item['url']) ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($item['snippet'])): ?>
                        <div style="font-size: 0.85rem; color: var(--muted); margin-bottom: 8px; line-height: 1.4;">
                            <?= nl2br(htmlspecialchars($item['snippet'])) ?>
                        </div>
                    <?php endif; ?>

                    <div style="font-size: 0.78rem; color: var(--muted); display: flex; gap: 10px; flex-wrap: wrap;">
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

                    <div style="margin-top: 10px;">
                        <a href="/evidence/<?= $item['id'] ?>/delete" class="btn btn-danger"
                           onclick="return confirm('Delete this evidence?')">Delete</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
