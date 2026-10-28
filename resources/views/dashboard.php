<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — NEUROMAP</title>
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
            letter-spacing: 0.5px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .topbar-right span {
            color: var(--muted);
            font-size: 0.9rem;
        }

        .topbar-right a {
            color: var(--muted);
            text-decoration: none;
            font-size: 0.9rem;
        }

        .topbar-right a:hover {
            color: var(--text);
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 40px 24px;
        }

        h1 {
            font-size: 1.8rem;
            margin-bottom: 8px;
        }

        .subtitle {
            color: var(--muted);
            margin-bottom: 36px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 18px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 22px;
        }

        .stat-card .number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--accent);
            margin-bottom: 4px;
        }

        .stat-card .label {
            color: var(--muted);
            font-size: 0.9rem;
        }

        .section-title {
            font-size: 1.15rem;
            margin-bottom: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn {
            display: inline-block;
            background: var(--accent);
            color: #000;
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 14px 18px;
            text-align: left;
            border-bottom: 1px solid var(--border);
            font-size: 0.92rem;
        }

        th {
            color: var(--muted);
            font-weight: 500;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 500;
            background: var(--accent-dim);
            color: var(--accent);
        }

        .empty {
            padding: 50px;
            text-align: center;
            color: var(--muted);
        }
    </style>
</head>
<body>

    <header class="topbar">
        <div class="logo">NEUROMAP</div>
        <div class="topbar-right">
            <span><?= htmlspecialchars($user) ?></span>
            <a href="/logout">Logout</a>
        </div>
    </header>

    <div class="container">
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
                <div class="label">Completed</d
