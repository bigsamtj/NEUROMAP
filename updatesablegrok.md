**Understood.**

We will **redesign and rebuild NEUROMAP from the ground up** — more powerful, cleaner, and built for real deep OSINT work — while keeping the name **NEUROMAP** and some of the good structural ideas from the prototype.

---

### Proposed New Architecture (Powerful Version)

```
neuromap/
├── public/                     ← Web root
│   ├── index.php✔️✔️
│   ├── assets/
│   └── .htaccess
│
├── app/
│   ├── Core/                   ← Router✔️, Database✔️, Config, Helpers✔️
            App.php✔️
│   ├── Controllers/
│   │   ├── AuthController.php✔️
│   │   ├── DashboardController.php✔️
│   │   ├── InvestigationController.php✔️
│   │   └── ReportController.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Investigation.php
│   │   ├── Target.php
│   │   ├── Query.php
│   │   └── Evidence.php
│   ├── Services/
│   │   ├── DorkEngine.php          ← Advanced Google dork generator
│   │   ├── SearchOrchestrator.php  ← Runs multiple search types
│   │   ├── SocialScanner.php       ← Social media checks
│   │   ├── FileHunter.php          ← Document & file search
│   │   ├── ImageHunter.php         ← Reverse image / image search
│   │   ├── ReportBuilder.php       ← Builds final OSINT report
│   │   └── TelegramService.php     ← Sends full report
│   └── Middleware/
│
├── config/
│   ├── app.php   ✔️
│   ├── database.php
│   └── telegram.php
│
├── database/
│   └── schema.sql✔️
│
├── storage/
│   ├── logs/✔️
│   ├── reports/✔️
│   └── evidence/✔️
│
├── resources/views/
│   ├── layout.php
│   ├── login.php✔️
│   ├── dashboard.php✔️
│   ├── investigation/
│   │   ├── create.php✔️
│   │   ├── show.php✔️
│   │   └── report.php
│   └── components/
│✔️
├── .env✔️
├── composer.json
└── README.md
```

---

### Core Capabilities We Will Build

| Module                  | Functionality |
|-------------------------|-------------|
| **Target Ingestion**    | Name, aliases, phone, email, username, location, company, etc. |
| **Dork Engine**         | Extremely advanced Google dork generation based on any input combination |
| **Search Orchestrator** | Runs Google, social, files, images, mentions in organized batches |
| **Social Scanner**      | Platform-specific searches (Facebook, Instagram, Twitter/X, LinkedIn, TikTok, etc.) |
| **File & Document Hunter** | Looks for PDFs, docs, resumes, leaks related to the target |
| **Image Hunter**        | Searches for images and possible reverse image leads |
| **Report Builder**      | Creates structured, clean, professional OSINT reports |
| **Telegram Delivery**   | Sends full report (or summary + download link) to your bot |
| **Investigation Workspace** | Track status, notes, evidence, and findings per case |

---

### Recommended Development Order

1. **Project Foundation** (Core, Config, Database, Auth)
2. **Target & Investigation System**
3. **Advanced Dork Engine**
4. **Search Orchestrator**
5. **Report Builder + Telegram**
6. **UI (Dashboard + Investigation pages)**
7. **Extra modules** (Social, File, Image hunters)

---

**Question:**

Do you want me to start building from **Phase 1 (Project Foundation)** right now?

Or would you first like me to show you a more detailed technical blueprint / database schema before writing any code?




**NEUROMAP – Full Status Report + Updated README**

---

### 1. What We Have Built So Far

| Phase | Feature | Status |
|-------|---------|--------|
| **Phase 1** | Project Foundation | ✅ Completed |
| | Config system | ✅ |
| | Database layer (SQLite) | ✅ |
| | Router | ✅ |
| | Helper & App core | ✅ |
| | Authentication (Login/Logout) | ✅ |
| | Dashboard | ✅ |
| **Phase 2** | Target & Investigation System | ✅ Completed |
| | Create Investigation | ✅ |
| | Add Target details (name, phone, email, etc.) | ✅ |
| | View Investigation | ✅ |
| **Phase 3** | Advanced Dork Engine | ✅ Completed |
| | Powerful Google dork generation | ✅ |
| | Name, Email, Phone, Username, Social, File dorks | ✅ |
| | Generate & store queries | ✅ |
| | Open dorks directly in Google | ✅ |
| **Phase 4** | Report Builder + Telegram | ✅ Completed |
| | Professional report generation | ✅ |
| | Send report to Telegram | ✅ |
| | Save report as file | ✅ |

---

### 2. Current Working Flow

1. Login → Dashboard
2. Create New Investigation
3. Enter subject details (name, phone, email, usernames, etc.)
4. Click **Generate Dorks** → dozens of advanced search queries are created
5. Click **Open in Google** on any query
6. Click **Send Report to Telegram** → full report is delivered to your bot

---

### 3. What Is Still Pending (Next Phases)

| Phase | Feature | Priority |
|-------|---------|----------|
| Phase 5 | Evidence Collection System (manually add findings) | High |
| Phase 6 | Better UI / Layout consistency | Medium |
| Phase 7 | Social media specific scanners | Medium |
| Phase 8 | Export report as PDF | Low |
| Phase 9 | Multi-user support (optional) | Low |

---
