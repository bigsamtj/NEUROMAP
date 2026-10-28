<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — NEUROMAP</title>
    <style>
        :root {
            --bg: #0f1115;
            --card: #1a1d24;
            --border: #2a2e38;
            --text: #e5e7eb;
            --muted: #9ca3af;
            --accent: #10b981;
            --danger: #ef4444;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }

        .logo {
            text-align: center;
            margin-bottom: 28px;
        }

        .logo h1 {
            font-size: 1.8rem;
            letter-spacing: 1px;
            color: var(--accent);
        }

        .logo p {
            color: var(--muted);
            font-size: 0.9rem;
            margin-top: 6px;
        }

        .field {
            margin-bottom: 18px;
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
            background: #111318;
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--text);
            font-size: 1rem;
            outline: none;
            transition: border-color 0.2s;
        }

        .field input:focus {
            border-color: var(--accent);
        }

        .btn {
            width: 100%;
            padding: 13px;
            background: var(--accent);
            color: #000;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.2s;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .error {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid var(--danger);
            color: #fca5a5;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 0.9rem;
            margin-bottom: 18px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="logo">
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
</body>
</html>
