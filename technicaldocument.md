# NEUROMAP Technical Document

**Project Name:** NEUROMAP  
**Title:** Personal OSINT Investigation & Intelligence Reconnaissance Station  
**Creator:** Samuel Adeyinka (BigSam)  
**Current Version:** 1.0 (Phases 1–8 Complete)  
**Document Type:** Technical Architecture & System Documentation  
**Status:** Stable (Version 1)

---

## 1. Purpose

NEUROMAP is a self-hosted OSINT investigation platform designed to support structured intelligence gathering against a subject (person, alias, organization, or digital identity).

It enables an operator to:

- Create investigation cases
- Profile targets using known identifiers
- Automatically generate advanced search queries (Google dorks and social scans)
- Collect and organize evidence
- Produce investigation reports
- Deliver reports to Telegram

Version 1 is an **operator-assisted** workstation.  
Version 2 is planned as an **automated pipeline** (live search → screenshots → PDF → Telegram).

---

## 2. System Objectives

1. Centralize OSINT case management
2. Standardize target profiling
3. Accelerate query generation using reusable logic
4. Maintain evidence in a structured, reviewable format
5. Produce consistent reports for operational use
6. Keep deployment lightweight (PHP + SQLite, no heavy framework)

---

## 3. Technology Stack

| Layer | Technology |
|------|------------|
| Language | PHP 8.1+ |
| Database | SQLite 3 via PDO |
| Architecture | Custom lightweight MVC |
| Frontend | Server-rendered HTML/CSS + minimal JS |
| Auth | Session-based single-operator auth |
| Integrations | Telegram Bot API |
| Dependency management | Composer (PSR-4 autoload) |
| Runtime | PHP built-in server or standard web host |

---

## 4. High-Level Architecture

```text
Client (Browser)
      │
      ▼
public/index.php  (Front Controller)
      │
      ├── Router
      │     ├── AuthController
      │     ├── DashboardController
      │     ├── InvestigationController
      │     ├── EvidenceController
      │     └── ReportController
      │
      ├── Services
      │     ├── DorkEngine
      │     ├── SocialScanner
      │     ├── ReportBuilder
      │     └── TelegramService
      │
      └── Core
            ├── App
            ├── Database
            ├── Helper
            └── Config
```

---

## 5. Directory Structure

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
├── .env
├── .env.example
├── .gitignore
├── composer.json
└── README.md
```

---

## 6. Request Lifecycle

1. HTTP request hits `public/index.php`
2. Session starts
3. Composer autoloader loads classes
4. `.env` values are loaded into `$_ENV`
5. `config/app.php` is loaded
6. `App::init()` ensures storage folders exist
7. Router matches method + URI
8. Target controller method executes
9. Controller may:
   - Validate input
   - Read/write SQLite data
   - Call one or more services
10. Response is returned as:
    - Rendered HTML view, or
    - Redirect, or
    - File download

---

## 7. Core Components

### 7.1 Front Controller (`public/index.php`)
- Application entry point
- Boots environment, config, router
- Defines all routes
- Dispatches request

### 7.2 Router (`app/Core/Router.php`)
- Registers GET/POST routes
- Supports path parameters (`{id}`)
- Resolves controller callables
- Returns 404 when unmatched

### 7.3 Database (`app/Core/Database.php`)
- Singleton PDO SQLite connection
- Helpers:
  - `query()`
  - `fetch()`
  - `fetchAll()`
  - `insert()`
  - `update()`
  - `delete()`

### 7.4 Helper (`app/Core/Helper.php`)
- Config access
- Auth checks (`requireAuth`, `isLoggedIn`)
- Redirect helper
- Sanitization helpers

### 7.5 App (`app/Core/App.php`)
- Storage initialization
- View rendering
- Optional layout wrapping

---

## 8. Controllers

| Controller | Responsibility |
|----------|----------------|
| `AuthController` | Login form, authentication, logout |
| `DashboardController` | Case statistics and recent investigations |
| `InvestigationController` | Create/view investigations, generate dorks/social scans, send Telegram report |
| `EvidenceController` | Add and delete evidence records |
| `ReportController` | Printable report page and TXT download |

---

## 9. Services

### 9.1 DorkEngine
**Input:** Target profile fields  
**Output:** Structured Google dork queries

Generates query categories including:
- Name
- Email
- Phone
- Username
- Organization
- Location
- Website
- Combined
- Filetype searches
- Social site-restricted searches

### 9.2 SocialScanner
**Input:** Target names/usernames/aliases  
**Output:**
- Platform-specific search queries
- Probable profile URL guesses

Platforms include Facebook, Instagram, X/Twitter, LinkedIn, TikTok, GitHub, YouTube, Reddit, Telegram, and others.

### 9.3 ReportBuilder
Builds two report formats:
1. Telegram HTML text summary
2. Plain-text full report for file storage/download

Includes:
- Case metadata
- Subject profile
- Query summary/samples
- Evidence summary

### 9.4 TelegramService
Uses Telegram Bot API:
- `sendMessage()` for text reports
- `sendDocument()` for file delivery

---

## 10. Database Design

### Tables

1. **investigations**
   - Case title, status, notes, timestamps

2. **targets**
   - Linked to investigation
   - Identity fields (name, aliases, emails, phones, usernames, locations, organizations, websites)

3. **queries**
   - Generated dorks/social queries
   - Type, platform, query string, status

4. **evidence**
   - Findings (title, URL, snippet, platform, type, confidence, notes)

5. **reports**
   - Generated report metadata and file path

6. **users**
   - Reserved/simple auth support (current auth primarily config-based)

Relationships are investigation-centric:
- One investigation → one primary target record
- One investigation → many queries
- One investigation → many evidence items
- One investigation → many reports

---

## 11. Major Operational Flows

### Flow A — Authentication
1. Operator opens `/login`
2. Credentials checked against config admin values
3. Session created on success
4. Protected routes enforce authentication

### Flow B — Create Investigation
1. Operator submits case + target details
2. Investigation row created
3. Target row linked to investigation
4. Redirect to investigation detail page

### Flow C — Generate Dorks
1. Operator clicks **Generate Dorks**
2. `DorkEngine` builds queries from target data
3. Queries stored in database
4. Investigation status set to running
5. Queries listed with “Open in Google”

### Flow D — Generate Social Scans
1. Operator clicks **Generate Social Scans**
2. `SocialScanner` produces platform queries and profile URL guesses
3. Results stored as `query_type = social`
4. Links open either Google search or direct profile URL

### Flow E — Evidence Collection
1. Operator adds evidence via form
2. Evidence stored against investigation
3. Evidence appears in case workspace
4. Evidence can be deleted

### Flow F — Report & Delivery
1. **View/Print Report:** printable HTML report page
2. **Download TXT:** plain-text file download
3. **Send to Telegram:**
   - Build report
   - Save TXT into `storage/reports`
   - Send message + document through Telegram
   - Mark investigation completed

---

## 12. UI System

### Layout
- Shared layout for authenticated pages
- Login and printable report pages are standalone

### Theme
- Dark mode default
- Light mode toggle
- Preference saved in `localStorage` (`neuromap-theme`)

### Branding
- Logo: `public/assets/img/logo.png`
- Overlay: `public/assets/img/overlay.png`
- Overlay applied across login and main application pages

### UX Behavior
- Card hover elevation
- Fade-in page/content animation
- Sticky topbar
- Responsive grid behavior

---

## 13. Configuration

Primary config file: `config/app.php`  
Secrets and environment values: `.env`

Key settings:
- App name/url/debug
- SQLite path
- Telegram bot token/chat ID
- Admin username/password
- Storage paths

---

## 14. Security Model

Current security controls:
- Session authentication for protected routes
- Output escaping in views
- Route-level auth checks
- `.env` excluded from version control
- Web root expected to be `public/`
- Storage artifacts kept outside public exposure where possible

Current limitations:
- Single-operator model
- Password stored as configured value (not multi-user hashed account system)
- No role hierarchy yet

---

## 15. Deployment Model

### Local / Kali
```bash
composer install
cp .env.example .env
sqlite3 storage/neuromap.db < database/schema.sql
php -S 127.0.0.1:8000 -t public
```

### Production
- Host with PHP 8.1+
- Document root → `public/`
- Writable `storage/` directories
- HTTPS recommended
- Valid Telegram credentials in `.env`

---

## 16. Completed Development Phases

| Phase | Scope | Status |
|------|------|--------|
| 1 | Foundation (core, router, DB, auth, dashboard) | Completed |
| 2 | Investigation + target system | Completed |
| 3 | Advanced dork engine | Completed |
| 4 | Report builder + Telegram delivery | Completed |
| 5 | Evidence collection | Completed |
| 6 | UI layout consistency | Completed |
| 7 | Social media scanners | Completed |
| 8 | Printable report + TXT download | Completed |
| UI Upgrade | Light/Dark mode + overlay + animations | Completed |

---

## 17. Planned Version 2 Scope

Version 2 intended pipeline:

1. Dork generation (existing)
2. Live search execution via Brave Search API
3. Target URL screenshot capture
4. PDF compilation with embedded evidence
5. Telegram PDF delivery

### Required for V2
- Brave Search API key
- Screenshot API key (recommended)
- Dompdf (or equivalent PDF library)
- New services:
  - `BraveSearchService`
  - `ScreenshotService`
  - `PdfReportBuilder`
  - `PipelineOrchestrator`

### Hosting note
- API-based V2 can run without VPS
- Local headless browser automation is better on VPS

---

## 18. Known Constraints (Version 1)

1. Search execution is manual (operator opens links)
2. No automatic page capture
3. PDF is browser-print based (not binary PDF library generation)
4. Single admin operator only
5. No background job queue

These constraints are intentional for Version 1 simplicity and stability.

---

## 19. Testing Checklist (Release Readiness)

- [ ] Login/logout works
- [ ] Create investigation with full target fields
- [ ] Generate dorks returns expected query volume
- [ ] Generate social scans returns platform queries/profile guesses
- [ ] Add and delete evidence
- [ ] View/print report page loads
- [ ] TXT download works
- [ ] Telegram message + document delivery works
- [ ] Dark/Light toggle persists
- [ ] Logo and overlay render on login and dashboard

---

## 20. Conclusion

NEUROMAP Version 1 is a complete, operational OSINT case workstation.  
It provides structured investigation management, automated query generation, evidence handling, reporting, and Telegram delivery in a lightweight PHP architecture.

The system is ready for practical use and is architected to support Version 2 automation without requiring a full rewrite.

---

**Document Owner:** Samuel Adeyinka (BigSam)  
**Project:** NEUROMAP  
**Version Covered:** 1.0 (Phases 1–8 + UI Upgrade)  
**Next Milestone:** Version 2 Automated Intelligence Pipeline
