<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'NEUROMAP - OSINT Workbench' ?></title>
    <style>
        :root {
            --bg-color: #0f1115;
            --sidebar-color: #161b22;
            --card-bg: #1c2128;
            --accent: #00ff66;
            --text-main: #c9d1d9;
            --text-muted: #8b949e;
            --border: #30363d;
        }
        body {
            background-color: var(--bg-color);
            color: var(--text-main);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 6px;
        }
        h1, h2 { color: #fff; }
        a { color: var(--accent); text-decoration: none; }
        a:hover { text-decoration: underline; }
        .btn {
            background: var(--accent);
            color: #000;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
        }
        .btn:hover { opacity: 0.9; }
        input, textarea {
            width: 100%;
            padding: 8px;
            margin: 6px 0 16px 0;
            background: var(--bg-color);
            border: 1px solid var(--border);
            color: #fff;
            border-radius: 4px;
        }
        code { background: #000; padding: 2px 4px; color: var(--accent); }
    </style>
</head>
<body>
    <div class="container">
        <?= $content ?? '' ?>
    </div>
</body>
</html>
