#                                                 NEUROMAP

<p align="center">
  <img src="public/assets/img/logo.png" alt="NEUROMAP Logo" width="160">
</p>

<p align="center">
  <strong>Personal OSINT Investigation & Intelligence Reconnaissance Station</strong><br>
  <strong>Creator:</strong> Samuel Adeyinka [BigSam]
</p>

NEUROMAP is a self-hosted PHP OSINT platform for structured investigations.  
It helps you profile targets, generate advanced search dorks, collect evidence, build reports, and deliver intelligence summaries to Telegram.

---

## Current Version Status

**Version 1 (Stable)** — Phases 1 to 8 complete

### Completed Features
- Secure login (single-operator)
- Investigation case management
- Target profiling (name, aliases, emails, phones, usernames, locations, orgs, websites)
- Advanced Google dork generation
- Social media scan generation + profile URL guesses
- Manual evidence collection
- Report builder (Telegram + TXT)
- Printable report page (browser Print → Save as PDF)
- Dark mode default + Light mode toggle
- Branding overlay + logo support

### Planned Version 2
- Brave Search API live execution
- Screenshot capture pipeline
- Automated PDF compilation (Dompdf)
- One-click full investigation pipeline to Telegram

---

## Architecture

```text
neuromap/
├── app/
│   ├── Core/
│   │   ├── App.php
│   │   ├── Database.php
│   │   ├── Helper.php
│   │   └── Router.php
│   ├── Controllers/
│   │   ├── AuthController.php
│   │   ├── DashboardController.php
│   │   ├── InvestigationController.php
│   │   ├── EvidenceController.php
│   │   └── ReportController.php
│   └── Services/
│       ├── DorkEngine.php
│       ├── SocialScanner.php
│       ├── ReportBuilder.php
│       └── TelegramService.php
├── config/
│   └── app.php
├── database/
│   └── schema.sql
├── public/
│   ├── index.php
│   └── assets/img/
│       ├── logo.png
│       └── overlay.png
├── resources/views/
│   ├── layout.php
│   ├── login.php
│   ├── dashboard.php
│   └── investigation/
│       ├── create.php
│       ├── show.php
│       └── report.php
├── storage/
│   ├── logs/
│   ├── reports/
│   └── evidence/
├── .env.example
├── .gitignore
├── composer.json
└── README.md
```

---

## Tech Stack

- PHP 8.1+
- SQLite 3 (PDO)
- Custom lightweight MVC
- Server-rendered UI (HTML/CSS/JS)
- Telegram Bot API
- Composer PSR-4 autoloading

---

## Installation

### Requirements
- PHP 8.1+ with `pdo_sqlite` and `curl`
- Composer

### Setup

```bash
git clone https://github.com/bigsamtj/NEUROMAP.git
cd NEUROMAP

composer install
cp .env.example .env

# Edit .env with your values:
# TELEGRAM_BOT_TOKEN
# TELEGRAM_CHAT_ID
# ADMIN_USERNAME
# ADMIN_PASSWORD

mkdir -p storage/logs storage/reports storage/evidence
sqlite3 storage/neuromap.db < database/schema.sql

php -S 127.0.0.1:8000 -t public
```

Open: `http://127.0.0.1:8000`

---

## Usage Flow

1. Login
2. Create investigation + target details
3. Generate Dorks
4. Generate Social Scans
5. Open results / add evidence
6. View/Print Report or Send Report to Telegram

---

## Security Notes

- Point web root to `public/` only
- Never commit `.env` or `storage/neuromap.db`
- Change default admin password
- Use HTTPS in production

---

## License

MIT License

**Creator:** Samuel Adeyinka (BigSam)
