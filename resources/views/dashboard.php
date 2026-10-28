<?php
$title = 'Dashboard';
?>

<h1>Dashboard</h1>
<p class="subtitle">Intelligence Investigation Station</p>

<div class="stats">
    <div class="stat-card">
        <div class="number"><?= $total ?></div>
        <div class="label">Total Investigations</div>
    </div>
    <div class="stat-card">
        <div class="number"><?= $pending ?></div>
        <div class="label">Pending</div>
    </div>
    <div class="stat-card">
        <div class="number"><?= $completed ?></div>
        <div class="label">Completed</div>
    </div>
</div>

<div class="card">
    <h2>
        Recent Investigations
        <a href="/investigation/create" class="btn btn-primary" style="font-size: 0.85rem; padding: 8px 14px;">+ New Investigation</a>
    </h2>

    <?php if (empty($recent)): ?>
        <div class="empty">
            No investigations yet.<br>
            Create your first case to begin.
        </div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recent as $item): ?>
                    <tr>
                        <td>#<?= $item['id'] ?></td>
                        <td><?= htmlspecialchars($item['title']) ?></td>
                        <td><span class="badge"><?= htmlspecialchars($item['status']) ?></span></td>
                        <td><?= htmlspecialchars($item['created_at']) ?></td>
                        <td>
                            <a href="/investigation/<?= $item['id'] ?>" style="color: var(--accent); text-decoration: none;">Open</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
