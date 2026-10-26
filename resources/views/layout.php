<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'NEUROMAP - OSINT Workbench' ?></title>
    <style>
        :root {
            --bg-deep: #0b0e14;
            --bg-card: #121820;
            --border-color: #212d3d;
            --accent-emerald: #00ff66;
            --accent-hover: #00cc52;
            --text-main: #e6edf3;
            --text-muted: #8b949e;
        }
        body {
            background-color: var(--bg-deep);
            color: var(--text-main);
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            margin: 0;
            padding: 20px;
        }
        .wrapper {
            max-width: 900px;
            margin: 40px auto;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.5);
        }
        h1, h2, h3 {
            color: #fff;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 10px;
            margin-top: 0;
        }
        a {
            color: var(--accent-emerald);
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .btn {
            background-color: var(--accent-emerald);
            color: #0b0e14;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
            display: inline-block;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .btn:hover {
            background-color: var(--accent-hover);
        }
        .btn-telegram {
            background-color: #0088cc;
            color: #fff;
            padding: 10px 20px;
            border-radius: 4px;
            font-weight: bold;
            display: inline-block;
            text-decoration: none;
            margin-bottom: 20px;
        }
        .btn-telegram:hover {
            opacity: 0.9;
        }
        label {
            display: block;
            margin-top: 15px;
            color: var(--text-muted);
            font-size: 14px;
        }
        input[type="text"], input[type="email"], textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            background-color: var(--bg-deep);
            border: 1px solid var(--border-color);
            color: var(--text-main);
            border-radius: 4px;
            box-sizing: border-box;
        }
        input:focus, textarea:focus {
            outline: none;
            border-color: var(--accent-emerald);
        }
        code {
            background-color: #000;
            color: var(--accent-emerald);
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 13px;
        }
        ul {
            padding-left: 20px;
        }
        li {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <?= $content ?? '' ?>
    </div>
</body>
</html>
