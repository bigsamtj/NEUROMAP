**NEUROMAP Version 2 – Architecture Overview**

Your idea is strong and fits cleanly on top of what we already built.

Below is a practical overview of how **Version 2** can work without redesigning the whole system.

---

### Current State (Version 1 – What We Have)

```
Target Input
    ↓
DorkEngine / SocialScanner  →  generates queries
    ↓
Operator manually opens Google links
    ↓
Operator manually adds evidence
    ↓
ReportBuilder + Telegram (text + txt file)
```

This is **operator-assisted OSINT**.

---

### Version 2 Vision (Automated Pipeline)

```
Target Input
    ↓
DorkEngine (already exists)
    ↓
SearchExecutor (Brave Search API)     ← NEW
    ↓
EvidenceHarvester (browse + screenshot)  ← NEW
    ↓
PdfReportBuilder (Dompdf / similar)   ← NEW
    ↓
TelegramService.sendDocument()        ← already exists
```

This becomes **semi-automated to fully automated OSINT**.

---

### Proposed V2 Modules

| Module | Role | Notes |
|--------|------|------|
| **SearchExecutor** | Runs dorks against Brave Search API | Returns top N URLs + titles + snippets |
| **EvidenceHarvester** | Visits URLs, captures screenshots + metadata | Saves into `storage/evidence/` |
| **PdfReportBuilder** | Builds real PDF with text + images | Uses Dompdf or similar |
| **PipelineOrchestrator** | Controls the full flow | One button: “Run Full Investigation” |
| **TelegramService** | Already ready | Just sends the PDF |

---

### Detailed Workflow

**1. Trigger**
- Operator opens an investigation
- Clicks **Run Full Scan** (new button)

**2. Query Generation**
- Existing `DorkEngine` + `SocialScanner` generate queries
- Stored in `queries` table (already working)

**3. Live Search Execution**
- New service: `BraveSearchService`
- For each selected dork:
  - Calls Brave Search API via cURL
  - Gets top results (title, URL, snippet)
  - Stores results as candidate evidence

**4. Page Capture**
- New service: `ScreenshotService`
- Options:
  - External API (e.g. screenshotone, urlbox, etc.)
  - Or local headless Chrome (Puppeteer/Playwright via CLI)
- Saves:
  - Screenshot image → `storage/evidence/`
  - Metadata (URL, title, timestamp)

**5. PDF Compilation**
- New service: `PdfReportBuilder`
- Uses Dompdf (PHP library)
- Includes:
  - Case info
  - Target profile
  - Queries used
  - Evidence list
  - Embedded screenshots
- Saves PDF → `storage/reports/`

**6. Telegram Delivery**
- Existing `TelegramService::sendDocument()`
- Sends the PDF to your chat/channel

---

### How It Fits Current Codebase

```
app/Services/
├── DorkEngine.php          ← keep
├── SocialScanner.php       ← keep
├── ReportBuilder.php       ← keep (text version)
├── TelegramService.php     ← keep
├── BraveSearchService.php  ← NEW (V2)
├── ScreenshotService.php   ← NEW (V2)
├── PdfReportBuilder.php    ← NEW (V2)
└── PipelineOrchestrator.php ← NEW (V2)
```

Database additions (small):

- `search_results` table (optional)
- Evidence table already supports images/links
- Reports table already supports file paths

---

### Recommended V2 Build Order

| Step | Module | Why |
|------|--------|-----|
| 1 | Brave Search API integration | Core live data source |
| 2 | Store search results as evidence candidates | Reuse existing evidence system |
| 3 | Screenshot capture | Visual proof |
| 4 | PDF generator (Dompdf) | Professional output |
| 5 | One-click pipeline button | Full automation |
| 6 | Telegram PDF delivery | Already mostly done |

---

### Important Considerations

**Brave Search API**
- Needs API key
- Rate limits apply
- Better privacy posture than Google scraping

**Screenshots**
- Lightweight path: use a screenshot API
- Heavy path: run headless Chrome on the server
- For shared hosting, API is safer

**PDF**
- Dompdf is pure PHP → fits your stack
- Can embed screenshots easily

**Performance**
- Full pipeline should run in background later (queue/job)
- For now, can run synchronously with a limit (e.g. top 10 results)

---

### Suggested Product Positioning

- **Version 1 (Current):** Assisted OSINT workstation  
- **Version 2:** Automated intelligence pipeline  
- **Version 3 (Future):** Multi-user + scheduling + continuous monitoring

---

### Bottom Line

Your proposed flow is correct and realistic:

> Dork generation → Brave Search execution → Screenshot capture → PDF compilation → Telegram delivery

It extends NEUROMAP naturally.  
No need to rewrite Phases 1–8. We only **add new services** and one orchestration layer.

---

When you are ready, we can start **NEUROMAP V2 – Step 1: Brave Search API Integration** and design the service + config structure first.
