# NEUROMAP

<p align="center">
  <img src="public/assets/img/logo.png" alt="NEUROMAP Logo" width="160">
</p>

> **Personal OSINT Investigation & Intelligence Reconnaissance Station**  
> **Creator:** Samuel Adeyinka [BigSam]

NEUROMAP is a lightweight, PHP-native OSINT investigation platform designed to organize subject identities, map advanced search queries (dorks), test digital footprints, and structure investigation findings securely.

---

## Architecture & Directory Structure

```text
neuromap/
├── app/
│   ├── Auth/
│   │   ├── Session.php
│   │   └── Auth.php
│   ├── Controllers/
│   │   ├── DashboardController.php
│   │   ├── InvestigationController.php
│   │   └── SearchController.php
│   ├── Services/
│   │   ├── QueryBuilder.php
│   │   └── TelegramService.php
│   └── Providers/
│       ├── SearchProviderInterface.php
│       └── GoogleLinkProvider.php
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
│       ├── layout.php
│       ├── login.php
│       ├── dashboard.php
│       └── investigation_form.php
├── storage/
│   ├── logs/
│   ├── exports/
│   └── evidence/
├── .env.example
├── .gitignore
├── composer.json
└── README.md

```

---

## Tech Stack

* **Backend:** PHP 8.3+ (Modular, Lightweight Architecture)
* **Database:** SQLite 3 via PDO (Fast, Single-file, Zero-config)
* **Frontend:** HTML5, CSS3, Vanilla JavaScript (Graphite & Emerald Minimalist UI)
* **Dependencies:** Composer (Autoloading via PSR-4)

---

## Installation & Setup

### 1. Requirements

* PHP 8.3 or newer (with `pdo_sqlite` extension enabled).
* Composer installed globally.

### 2. Quickstart & Storage Initialization

```bash
# Clone the repository
git clone [https://github.com/bigsamtj/NEUROMAP.git](https://github.com/bigsamtj/NEUROMAP.git) neuromap
cd neuromap

# Install dependencies via Composer
composer install

# Set up local environment configuration
cp .env.example .env

# Create storage directories and initialize the SQLite database
mkdir -p storage/logs storage/exports storage/evidence
sqlite3 storage/neuromap.db < database/schema.sql

# Run the local development server (Point document root to public/)
php -S 127.0.0.1:8000 -t public

```

Access the NEUROMAP dashboard in your browser at `http://127.0.0.1:8000`.

---

## Core Features

1. **Target Profiling:** Flexible ingestion for full names, aliases, emails, phone numbers, usernames, domains, and organizations.
2. **Automated Dorking Engine:** Automatic generation of search queries based on customizable templates (`{{full_name}}`, `{{email}}`, `{{username}}`, etc.).
3. **Execution Tracking:** Track search execution statuses per query (`FOUND`, `NO_RESULTS`, `REQUIRES_REVIEW`, `PROVIDER_ERROR`).
4. **Evidence Workspace & Telegram Alerts:** Record source links, snippets, analyst notes, verification status, and instantly push reports to your Telegram bot.

---

## Security Notice

* Ensure your web server's document root points strictly to the `public/` folder.
* Never publish your `storage/neuromap.db` database file or sensitive environment configurations to public repositories.

---

## License

Distributed under the MIT License.

```

```
