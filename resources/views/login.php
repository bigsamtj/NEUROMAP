<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — NEUROMAP</title>
    <style>
        :root, [data-theme="dark"] {
            --bg: #0b0d12;
            --card: #161a22;
            --border: #2a2f3a;
            --text: #e8eaed;
            --muted: #9aa3b2;
            --accent: #10b981;
            --accent-dim: rgba(16, 185, 129, 0.14);
            --danger: #ef4444;
            --overlay-opacity: 0.08;
        }

        [data-theme="light"] {
            --bg: #f4f6f9;
            --card: #ffffff;
            --border: #e2e8f0;
            --text: #0f172a;
            --muted: #64748b;
            --accent: #059669;
            --accent-dim: rgba(5, 150, 105, 0.12);
            --danger: #dc2626;
            --overlay-opacity: 0.05;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            transition: background 0.25s ease, color 0.25s ease;
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background: url('/assets/img/overlay.png') center center / cover no-repeat;
            opacity: var(--overlay-opacity);
            pointer-events: none;
            z-index: 0;
        }

        .theme-toggle {
            position: fixed;
            top: 18px;
            right: 18px;
            z-index: 10;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: var(--card);
            color: var(--text);
            cursor: pointer;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: border-color 0.2s, transform 0.15s;
        }

        .theme-toggle:hover {
            border-color: var(--accent);
            transform: translateY(-1px);
        }

        .login-card {
            position: relative;
            z-index: 1;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 40px 36px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.25);
            animation: fadeUp 0.4s ease;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .logo {
            text-align: center;
            margin-bottom: 28px;
        }

        .logo img {
            height: 54px;
            width: auto;
            margin-bottom: 12px;
            display: inline-block;
        }

        .logo h1 {
            font-size: 1.6rem;
            letter-spacing: 0.5px;
            color: var(--accent);
        }

        .logo p {
            color: var(--muted);
            font-size: 0.9rem;
            margin-top: 6px;
        }

        .field {
            margin-bottom: 16px;
        }

        .field label {
            display: block;
            font-size: 0.85rem;
            color: var(--muted);
            margin-bottom: 6px;
        }

        .field input {
            width: 100%;
            padding: 12px 14px;
            background: color-mix(in srgb, var(--bg) 85%, var(--card));
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--text);
            font-size: 1rem;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .field input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-dim);
        }

        .btn {
            width: 100%;
            padding: 13px;
            background: var(--accent);
            color: #04140f;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.15s, opacity 0.2s;
            margin-top: 6px;
        }

        .btn:hover {
            transform: translateY(-1px);
            opacity: 0.95;
        }

        .error {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid var(--danger);
            color: #fca5a5;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 0.9rem;
            margin-bottom: 16px;
            text-align: center;
        }
    </style>
</head>
<body>
    <button class="theme-toggle" id="themeToggle" title="Toggle theme" type="button">☀️</button>

    <div class="login-card">
        <div class="logo">
            <img src="/assets/img/logo.png" alt="NEUROMAP Logo">
            <h1>NEUROMAP</h1>
            <p>OSINT Investigation Station</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="/login">
            <div class="field">
                <label>Username</label>
                <input type="text" name="username" required autofocus autocomplete="username">
            </div>

            <div class="field">
                <label>Password</label>
                <input type="password" name="password" required autocomplete="current-password">
            </div>

            <button type="submit" class="btn">Unlock Station</button>
        </form>
    </div>

    <script>
        (function () {
            const root = document.documentElement;
            const toggle = document.getElementById('themeToggle');
            const saved = localStorage.getItem('neuromap-theme');
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
