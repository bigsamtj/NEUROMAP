<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Investigation — NEUROMAP</title>
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
            text-decoration: none;
        }

        .topbar a {
            color: var(--muted);
            text-decoration: none;
            font-size: 0.9rem;
        }

        .container {
            max-width: 780px;
            margin: 0 auto;
            padding: 40px 24px;
        }

        h1 {
            font-size: 1.7rem;
            margin-bottom: 8px;
        }

        .subtitle {
            color: var(--muted);
            margin-bottom: 32px;
        }

        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 28px;
        }

        .section-title {
            font-size: 1rem;
            font-weight: 600;
            margin: 28px 0 16px;
            color: var(--accent);
            padding-bottom: 8px;
            border-bottom: 1px solid var(--border);
        }

        .section-title:first-child {
            margin-top: 0;
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

        .field input,
        .field textarea {
            width: 100%;
            padding: 12px 14px;
            background: #111318;
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--text);
            font-size: 0.95rem;
            outline: none;
            transition: border-color 0.2s;
        }

        .field input:focus,
        .field textarea:focus {
            border-color: var(--accent);
        }

        .field textarea {
            min-height: 90px;
            resize: vertical;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .btn {
            display: inline-block;
            background: var(--accent);
            color: #000;
            padding: 12px 24px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            margin-top: 10px;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .error {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid var(--danger);
            color: #fca5a5;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        .hint {
            font-size: 0.8rem;
            color: var(--muted);
            margin-top: 4px;
        }

        @media (max-width: 600px) {
            .grid-2 {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <header class="topbar">
        <a href="/dashboard" class="logo">NEUROMAP</a>
        <a href="/dashboard">← Back to Dashboard</a>
    </header>

    <div class="container">
        <h1>New Investigation</h1>
        <p class="subtitle">Create a new case and add known subject details</p>

        <?php if (!empty($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="/investigation/store" class="card">

            <div class="section-title">Case Information</div>

            <div class="field">
                <label>Investigation Title *</label>
                <input type="text" name="title" required 
                       value="<?= htmlspecialchars($old['title'] ?? '') ?>"
                       placeholder="e.g. Subject Investigation - John Doe">
            </div>

            <div class="field">
                <label>Internal Notes</label>
                <textarea name="notes" placeholder="Any notes about this investigation..."><?= htmlspecialchars($old['notes'] ?? '') ?></textarea>
            </div>

            <div class="section-title">Subject / Target Details</div>

            <div class="field">
                <label>Full Name</label>
                <input type="text" name="full_name" 
                       value="<?= htmlspecialchars($old['full_name'] ?? '') ?>"
                       placeholder="e.g. John Michael Doe">
            </div>

            <div class="field">
                <label>Aliases / Nicknames</label>
                <input type="text" name="aliases" 
                       value="<?= htmlspecialchars($old['aliases'] ?? '') ?>"
                       placeholder="Comma separated (e.g. Johnny, J.Doe)">
                <div class="hint">Separate multiple values with commas</div>
            </div>

            <div class="grid-2">
                <div class="field">
                    <label>Email Addresses</label>
                    <input type="text" name="emails" 
                           value="<?= htmlspecialchars($old['emails'] ?? '') ?>"
                           placeholder="email1@example.com, email2@...">
                </div>

                <div class="field">
                    <label>Phone Numbers</label>
                    <input type="text" name="phones" 
                           value="<?= htmlspecialchars($old['phones'] ?? '') ?>"
                           placeholder="+234..., 080...">
                </div>
            </div>

            <div class="field">
                <label>Usernames / Handles</label>
                <input type="text" name="usernames" 
                       value="<?= htmlspecialchars($old['usernames'] ?? '') ?>"
                       placeholder="Comma separated usernames">
            </div>

            <div class="grid-2">
                <div class="field">
                    <label>Locations</label>
                    <input type="text" name="locations" 
                           value="<?= htmlspecialchars($old['locations'] ?? '') ?>"
                           placeholder="City, State, Country">
                </div>

                <div class="field">
                    <label>Organizations / Companies</label>
                    <input type="text" name="organizations" 
                           value="<?= htmlspecialchars($old['organizations'] ?? '') ?>"
                           placeholder="Company names">
                </div>
            </div>

            <div class="field">
                <label>Websites / Domains</label>
                <input type="text" name="websites" 
                       value="<?= htmlspecialchars($old['websites'] ?? '') ?>"
                       placeholder="example.com, linkedin.com/in/...">
            </div>

            <button type="submit" class="btn">Create Investigation</button>
        </form>
    </div>

</body>
</html>
