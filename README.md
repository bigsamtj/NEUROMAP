# NEUROMAP

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
