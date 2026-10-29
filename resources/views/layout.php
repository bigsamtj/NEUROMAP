<?php
/**
 * NEUROMAP - Main Layout
 * Dark (default) + Light mode, overlay, animations
 */
$title = $title ?? 'NEUROMAP';
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?> — NEUROMAP</title>
    <style>
        :root, [data-theme="dark"] {
            --bg: #0b0d12;
            --bg-elevated: #12151b;
            --card: #161a22;
            --border: #2a2f3a;
            --text: #e8eaed;
            --muted: #9aa3b2;
            --accent: #10b981;
            --accent-hover: #34d399;
            --accent-dim: rgba(16, 185, 129, 0.14);
            --success: #34d399;
            --danger: #ef4444;
            --telegram: #0088cc;
            --shadow: 0 10px 30px rgba(0,0,0,0.35);
            --radius: 14px;
            --font: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            --overlay-opacity: 0.08;
        }

        [data-theme="light"] {
            --bg: #f4f6f9;
            --bg-elevated: #ffffff;
            --card: #ffffff;
            --border: #e2e8f0;
            --text: #0f172a;
            --muted: #64748b;
            --accent: #059669;
            --accent-hover: #10b981;
            --accent-dim: rgba(5, 150, 105, 0.12);
            --success: #059669;
            --danger: #dc2626;
            --telegram: #0088cc;
            --shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
            --overlay-opacity: 0.05;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: var(--font);
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            line-height: 1.5;
            transition: background 0.25s ease, color 0.25s ease;
            position: relative;
        }

        /* Overlay background */
        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background: url('/assets/img/overlay.png') center center / cover no-repeat;
            opacity: var(--overlay-opacity);
            pointer-events: none;
            z-index: 0;
        }

        .topbar, .container {
            position: relative;
            z-index: 1;
        }

        /* Topbar */
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 28px;
            border-bottom: 1px solid var(--border);
            background: color-mix(in srgb, var(--bg-elevated) 92%, transparent);
            backdrop-filter: blur(10px);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--accent);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            letter-spacing: 0.3px;
        }

        .logo img {
            height: 28px;
            width: auto;
            display: block;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 14px;
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

        .theme-toggle {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: var(--card);
            color: var(--text);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            transition: border-color 0.2s, transform 0.15s;
        }

        .theme-toggle:hover {
            border-color: var(--accent);
            transform: translateY(-1px);
        }

        /* Container */
        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 36px 24px 60px;
            animation: fadeUp 0.35s ease;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

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
            box-shadow: var(--shadow);
            transition: transform 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
            animation: fadeUp 0.4s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            border-color: color-mix(in srgb, var(--accent) 35%, var(--border));
        }

        .card h2 {
            font-size: 1.1rem;
            margin-bottom: 16px;
            color: var(--accent);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
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
            transition: transform 0.15s ease, opacity 0.2s ease, box-shadow 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
            opacity: 0.95;
        }

        .btn-primary {
            background: var(--accent);
            color: #04140f;
            box-shadow: 0 6px 16px var(--accent-dim);
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
        .field { margin-bottom: 16px; }

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
            background: color-mix(in srgb, var(--bg) 80%, var(--card));
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--text);
            font-size: 0.92rem;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .field input:focus,
        .field select:focus,
        .field textarea:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-dim);
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
            background: var(--accent-dim);
            border: 1px solid var(--accent);
            color: var(--success);
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 24px;
            font-size: 0.95rem;
            animation: fadeUp 0.3s ease;
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
            box-shadow: var(--shadow);
            transition: transform 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
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

        tr:last-child td { border-bottom: none; }

        tr {
            transition: background 0.15s ease;
        }

        tr:hover td {
            background: color-mix(in srgb, var(--accent) 6%, transparent);
        }

        @media (max-width: 640px) {
            .topbar { padding: 12px 16px; }
            .container { padding: 28px 16px 50px; }
            .grid-2 { grid-template-columns: 1fr; }
            h1 { font-size: 1.45rem; }
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
            <button class="theme-toggle" id="themeToggle" title="Toggle theme" type="button">☀️</button>
            <?php if (!empty($_SESSION['neuromap_user'])): ?>
                <span><?= htmlspecialchars($_SESSION['neuromap_user']['username'] ?? 'Operator') ?></span>
                <a href="/logout">Logout</a>
            <?php endif; ?>
        </div>
    </header>

    <main class="container">
        <?= $content ?? '' ?>
    </main>

    <script>
        (function () {
            const root = document.documentElement;
            const toggle = document.getElementById('themeToggle');
            const saved = localStorage.getItem('neuromap-theme');

            // Default = dark
            const theme = saved || 'dark';
            root.setAttribute('data-theme', theme);
            toggle.textContent = theme === 'dark' ? '☀️' : '🌙';

            toggle.addEventListener('click', function () {
                const current = root.getAttribute('data-theme') === 'light' ? 'light' : 'dark';
                const next = current === 'dark' ? 'light' : 'dark';
                root.setAttribute('data-theme', next);
                localStorage.setItem('neuromap-theme', next);
                toggle.textContent = next === 'dark' ? '☀️' : '🌙';
            });
        })();
    </script>

</body>
</html>
