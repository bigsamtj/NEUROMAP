# NEUROMAP

<p align="center">
  <img src="public/assets/img/logo.png" alt="NEUROMAP Logo" width="160">
</p>

<p align="center">
  <strong>Personal OSINT Investigation & Intelligence Reconnaissance Station</strong><br>
  <strong>Creator:</strong> Samuel Adeyinka [BigSam]
</p>

NEUROMAP is a powerful, self-hosted PHP OSINT investigation platform.  
It allows you to create investigation cases, profile targets, automatically generate advanced Google dorks, collect findings, and receive full intelligence reports directly on Telegram.

---

## Current Features

- Secure Login / Authentication
- Investigation Case Management
- Target Profiling (Name, Aliases, Emails, Phones, Usernames, Locations, Organizations, Websites)
- Advanced Dork Engine (Name, Email, Phone, Username, Social, File, Combined queries)
- One-click “Open in Google” for every generated dork
- Professional Report Builder
- Instant Telegram Report Delivery
- Report saved as downloadable text file
- Clean dark interface

---

## Architecture & Directory Structure

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
│   │   └── InvestigationController.php
│   └── Services/
│       ├── DorkEngine.php
│       ├── ReportBuilder.php
│       └── TelegramService.php
├── config/
│   └── app.php
├── database/
│   └── schema.sql
├── public/
│   ├── assets/
│   │   └── img/
│   │       └── logo.png
│   └── index.php
├── resources/
│   └── views/
│       ├── login.php
│       ├── dashboard.php
│       └── investigation/
│           ├── create.php
│           └── show.php
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

- **Backend:** PHP 8.1+
- **Database:** SQLite 3 (via PDO)
- **Architecture:** Lightweight custom MVC
- **Frontend:** Modern dark UI (HTML + CSS)
- **Dependencies:** Composer (PSR-4 Autoloading)

---

## Installation & Setup

### 1. Requirements

- PHP 8.1 or higher (with `pdo_sqlite` and `curl` extensions)
- Composer

### 2. Quick Start

```bash
# Clone the repository
git clone https://github.com/bigsamtj/NEUROMAP.git
cd NEUROMAP

# Install dependencies
composer install

# Create environment file
cp .env.example .env

# Edit .env and add your Telegram Bot Token + Chat ID + Admin password

# Create storage folders and database
mkdir -p storage/logs storage/reports storage/evidence
sqlite3 storage/neuromap.db < database/schema.sql

# Start the development server
php -S 127.0.0.1:8000 -t public
```

Open your browser and visit:

```
http://127.0.0.1:8000
```

**Default Login:**
- Username: `admin`
- Password: (the one you set in `.env`)

---

## How to Use

1. Login to the dashboard
2. Click **+ New Investigation**
3. Enter the subject’s known details
4. Click **Generate Dorks**
5. Review the generated search queries and open them in Google
6. Click **Send Report to Telegram** to receive the full intelligence report

---

## Telegram Setup

1. Create a bot using [@BotFather](https://t.me/BotFather)
2. Get your Chat ID using [@userinfobot](https://t.me/userinfobot)
3. Add both values to your `.env` file:

```env
TELEGRAM_BOT_TOKEN=your_bot_token
TELEGRAM_CHAT_ID=your_chat_id
```

---

## Security Notice

- Always point your web server document root to the `public/` folder only
- Never commit your real `.env` file or the SQLite database
- Change the default admin password immediately

---

## Roadmap

- [x] Phase 1 – Foundation
- [x] Phase 2 – Investigation & Target System
- [x] Phase 3 – Advanced Dork Engine
- [x] Phase 4 – Report Builder + Telegram
- [ ] Phase 5 – Evidence Collection System
- [ ] Phase 6 – UI Polish
- [ ] Phase 7 – Social Media Scanners

---

## License

Distributed under the MIT License.

---

**NEUROMAP** — Built for precision. Designed for intelligence.  
**Creator:** Samuel Adeyinka (BigSam)
```
