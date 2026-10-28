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


