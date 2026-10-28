**NEUROMAP – Full Technical Documentation**

**Version:** 1.0 (Phases 1–5 Complete)  
**Author:** Samuel Adeyinka (BigSam)  
**Type:** Self-hosted OSINT Investigation Platform

---

### 1. Application Overview

NEUROMAP is a lightweight, self-hosted PHP application designed for structured OSINT (Open Source Intelligence) investigations.  

It allows an operator to:

1. Create investigation cases
2. Profile a target with known identifiers
3. Automatically generate advanced Google dorks
4. Manually collect evidence
5. Generate professional reports
6. Send reports directly to Telegram

The system is built with a clean custom MVC-style architecture using pure PHP and SQLite (no heavy frameworks).

---

### 2. High-Level Architecture

```
Browser
   │
   ▼
public/index.php  (Front Controller)
   │
   ├── Router.php
   │       │
   │       ├── AuthController
   │       ├── DashboardController
   │       ├── InvestigationController
   │       └── EvidenceController
   │
   ├── Services
   │       ├── DorkEngine
   │       ├── ReportBuilder
   │       └── TelegramService
   │
   └── Core
           ├── Database (SQLite)
           ├── Helper
           └── App
```

---

### 3. Request Lifecycle (How a Request Works)

1. User visits a URL (example: `/investigation/5`)
2. `public/index.php` is executed
3. Environment variables are loaded from `.env`
4. Configuration is loaded from `config/app.php`
5. `App::init()` ensures storage folders exist
6. `Router` matches the URL to a controller method
7. Controller processes the request
8. Controller may call Services (DorkEngine, ReportBuilder, TelegramService)
9. Controller may read/write data using `Database`
10. Controller renders a view using `App::view()`
11. HTML is returned to the browser

---

### 4. Core Components Explained

#### 4.1 Front Controller (`public/index.php`)
- Entry point of the application
- Loads Composer autoloader
- Loads `.env` variables
- Loads configuration
- Initializes the application
- Defines all routes
- Dispatches the request to the correct controller

#### 4.2 Router (`app/Core/Router.php`)
- Registers GET and POST routes
- Supports route parameters (example: `{id}`)
- Matches incoming URI against registered routes
- Calls the appropriate controller method

#### 4.3 Database (`app/Core/Database.php`)
- Singleton PDO connection to SQLite
- Provides helper methods:
  - `query()`
  - `fetch()`
  - `fetchAll()`
  - `insert()`
  - `update()`
  - `delete()`

#### 4.4 Helper (`app/Core/Helper.php`)
- Configuration access
- Authentication checks
- Redirect helper
- Input sanitization
- JSON response helper

#### 4.5 App (`app/Core/App.php`)
- Initializes storage directories
- Renders views
- Provides base path helper

---

### 5. Controllers & Responsibilities

| Controller | Responsibility |
|----------|----------------|
| **AuthController** | Login, Logout, Session management |
| **DashboardController** | Shows statistics and recent investigations |
| **InvestigationController** | Create, view, generate dorks, send reports |
| **EvidenceController** | Add and delete evidence items |

---

### 6. Services (Business Logic)

#### 6.1 DorkEngine
**Location:** `app/Services/DorkEngine.php`

**Purpose:**  
Automatically generates advanced Google dorks based on target data.

**Input:** Target array (name, emails, phones, usernames, etc.)

**Output:** Array of structured dorks containing:
- type
- platform
- category
- query string

**Dork Categories Generated:**
- Name-based
- Email-based
- Phone-based
- Username-based
- Organization-based
- Location-based
- Website-based
- Combined
- File type searches
- Social media site searches

#### 6.2 ReportBuilder
**Location:** `app/Services/ReportBuilder.php`

**Purpose:**  
Builds investigation reports in two formats:

1. Telegram-friendly HTML report
2. Plain text report (saved as file)

**Includes:**
- Case information
- Subject details
- Generated queries summary
- Evidence summary

#### 6.3 TelegramService
**Location:** `app/Services/TelegramService.php`

**Purpose:**  
Sends messages and documents to a Telegram bot.

**Methods:**
- `sendMessage()` → Sends text report
- `sendDocument()` → Sends the full report file

---

### 7. Database Schema Overview

| Table | Purpose |
|------|---------|
| `users` | Simple authentication (currently config-based) |
| `investigations` | Investigation cases |
| `targets` | Subject/profile data linked to an investigation |
| `queries` | Generated dorks/search queries |
| `evidence` | Collected findings |
| `reports` | Generated reports metadata |

---

### 8. Main User Flows

#### Flow A: Create Investigation
1. User clicks “New Investigation”
2. Fills subject details
3. `InvestigationController@store` saves investigation + target
4. User is redirected to the investigation page

#### Flow B: Generate Dorks
1. User clicks “Generate Dorks”
2. `InvestigationController@generateDorks` is called
3. `DorkEngine` generates queries
4. Queries are stored in the `queries` table
5. Page reloads showing all generated dorks

#### Flow C: Add Evidence
1. User fills the “Add Evidence” form
2. `EvidenceController@store` saves the evidence
3. Evidence appears in the investigation page

#### Flow D: Send Report to Telegram
1. User clicks “Send Report to Telegram”
2. `ReportBuilder` creates the report
3. Report is saved as a `.txt` file
4. `TelegramService` sends the message + file
5. Investigation status is updated to `completed`

---

### 9. Completed Phases (1–5)

| Phase | Description | Status |
|------|-------------|--------|
| Phase 1 | Project Foundation (Core, Router, Database, Auth, Dashboard) | ✅ Completed |
| Phase 2 | Investigation & Target System | ✅ Completed |
| Phase 3 | Advanced Dork Engine | ✅ Completed |
| Phase 4 | Report Builder + Telegram Delivery | ✅ Completed |
| Phase 5 | Evidence Collection System | ✅ Completed |

---

### 10. Pending Phases (6–9)

| Phase | Description | Status |
|------|-------------|--------|
| Phase 6 | UI Polish & Layout Consistency | Pending |
| Phase 7 | Social Media Specific Scanners | Pending |
| Phase 8 | PDF Report Export | Pending |
| Phase 9 | Multi-user Support (Optional) | Pending |

---

### 11. Security Notes

- Document root must point only to `/public`
- Real `.env` file must never be committed
- SQLite database must remain private
- Authentication is currently single-user (config-based)
- All outputs are escaped to prevent XSS

---

### 12. Technology Summary

- **Language:** PHP 8.1+
- **Database:** SQLite 3
- **Architecture:** Custom lightweight MVC
- **Frontend:** Server-rendered HTML + CSS
- **External Integration:** Telegram Bot API
- **Dependency Management:** Composer (PSR-4)

---

### 13. Conclusion

NEUROMAP (Phases 1–5) is now a fully functional OSINT investigation platform capable of:

- Case management
- Target profiling
- Automated advanced dork generation
- Manual evidence collection
- Professional reporting
- Telegram delivery

The system is ready for operational use and can be extended with Phases 6–9 for improved UI, automation, and scalability.

---

**Document prepared for:** Samuel Adeyinka (BigSam)  
**Project:** NEUROMAP  
**Status:** Phases 1–5 Complete
