<?php
/**
 * NEUROMAP - Main Layout
 * Usage: 
 *   $title = 'Page Title';
 *   $content = '...html...';
 *   require layout.php;
 */
$title = $title ?? 'NEUROMAP';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?> — NEUROMAP</title>
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
            --telegram: #0088cc;
            --radius: 14px;
            --font: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font);
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            line-height: 1.5;
        }

        /* Topbar */
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 28px;
            border-bottom: 1px solid var(--border);
            background: #12151b;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--accent);
            text-decoration: none;
            letter-spacing: 0.3px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo img {
            height: 28px;
            width: auto;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .topbar-right span {
            color: var(--muted);
            font-size: 0.9rem;
        }

        .topbar-right a {
            color: var(--muted);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.2s;
        }

        .topbar-right a:hover {
            color: var(--text);
        }

        /* Container */
        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 36px 24px 60px;
        }

        /* Typography */
        h1 {
            font-size: 1.7rem;
            margin-bottom: 6px;
            letter-spacing: -0.02em;
        }

        .subtitle {
            color: var(--muted);
            margin-bottom: 32px;
            font-size: 0.95rem;
        }

        /* Cards */
        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 24px;
            margin-bottom: 22px;
        }

        .card h2 {
            font-size: 1.1rem;
            margin-bottom: 16px;
            color: var(--accent);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Buttons */
        .btn {
            display: inline-block;
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            border: none;
            cursor: pointer;
            transition: opacity 0.2s;
        }

        .btn:hover {
            opacity: 0.9;
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
            background: var(--telegram);
            color: white;
        }

        .btn-danger {
            background: transparent;
            border: 1px solid var(--danger);
            color: var(--danger);
            padding: 6px 12px;
            font-size: 0.8rem;
        }

        /* Forms */
        .field {
            margin-bottom: 16px;
        }

        .field label {
            display: block;
            font-size: 0.82rem;
            color: var(--muted);
            margin-bottom: 6px;
        }

        .field input,
        .field select,
        .field textarea {
            width: 100%;
            padding: 11px 13px;
            background: #111318;
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--text);
            font-size: 0.92rem;
            outline: none;
            transition: border-color 0.2s;
        }

        .field input:focus,
        .field select:focus,
        .field textarea:focus {
            border-color: var(--accent);
        }

        .field textarea {
            min-height: 80px;
            resize: vertical;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        /* Badge */
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 500;
            background: var(--accent-dim);
            color: var(--accent);
            text-transform: uppercase;
        }

        /* Alerts */
        .alert-success {
            background: rgba(16, 185, 129, 0.12);
            border: 1px solid var(--accent);
            color: var(--success);
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 24px;
            font-size: 0.95rem;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid var(--danger);
            color: #fca5a5;
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 24px;
            font-size: 0.95rem;
        }

        /* Empty state */
        .empty {
            color: var(--muted);
            font-size: 0.9rem;
            padding: 16px 0;
        }

        /* Stats */
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 16px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 20px;
        }

        .stat-card .number {
            font-size: 1.9rem;
            font-weight: 700;
            color: var(--accent);
            margin-bottom: 4px;
        }

        .stat-card .label {
            color: var(--muted);
            font-size: 0.88rem;
        }

        /* Tables */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 13px 16px;
            text-align: left;
            border-bottom: 1px solid var(--border);
            font-size: 0.9rem;
        }

        th {
            color: var(--muted);
            font-weight: 500;
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        tr:last-child td {
            border-bottom: none;
        }

        /* Responsive */
        @media (max-width: 640px) {
            .topbar {
                padding: 14px 18px;
            }
            .container {
                padding: 28px 16px 50px;
            }
            .grid-2 {
                grid-template-columns: 1fr;
            }
            h1 {
                font-size: 1.45rem;
            }
        }
    </style>
</head>
<body>

    <header class="topbar">
        <a href="/dashboard" class="logo">
            <?php if (file_exists(__DIR__ . '/../../public/assets/img/logo.png')): ?>
                <img src="/assets/img/logo.png" alt="NEUROMAP">
            <?php endif; ?>
            NEUROMAP
        </a>
        <div class="topbar-right">
            <?php if (!empty($_SESSION['neuromap_user'])): ?>
                <span><?= htmlspecialchars($_SESSION['neuromap_user']['username'] ?? 'Operator') ?></span>
                <a href="/logout">Logout</a>
            <?php endif; ?>
        </div>
    </header>

    <main class="container">
        <?= $content ?? '' ?>
    </main>

</body>
</html>
