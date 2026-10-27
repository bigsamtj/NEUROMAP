-- NEUROMAP Database Schema
-- SQLite

PRAGMA foreign_keys = ON;

-- ======================
-- USERS (simple auth)
-- ======================
CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ======================
-- INVESTIGATIONS
-- ======================
CREATE TABLE IF NOT EXISTS investigations (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    status TEXT NOT NULL DEFAULT 'pending', -- pending, running, completed, archived
    notes TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ======================
-- TARGETS
-- ======================
CREATE TABLE IF NOT EXISTS targets (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    investigation_id INTEGER NOT NULL,
    full_name TEXT,
    aliases TEXT,               -- JSON array or comma separated
    emails TEXT,                -- JSON array or comma separated
    phones TEXT,                -- JSON array or comma separated
    usernames TEXT,             -- JSON array or comma separated
    locations TEXT,
    organizations TEXT,
    websites TEXT,
    extra_data TEXT,            -- JSON for any additional fields
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (investigation_id) REFERENCES investigations(id) ON DELETE CASCADE
);

-- ======================
-- QUERIES (Generated Dorks & Searches)
-- ======================
CREATE TABLE IF NOT EXISTS queries (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    investigation_id INTEGER NOT NULL,
    target_id INTEGER,
    query_type TEXT NOT NULL,   -- google_dork, social, file, image, mention, custom
    platform TEXT,              -- google, facebook, twitter, linkedin, etc.
    query_string TEXT NOT NULL,
    status TEXT DEFAULT 'pending', -- pending, running, completed, failed, no_results
    result_count INTEGER DEFAULT 0,
    executed_at DATETIME,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (investigation_id) REFERENCES investigations(id) ON DELETE CASCADE,
    FOREIGN KEY (target_id) REFERENCES targets(id) ON DELETE SET NULL
);

-- ======================
-- EVIDENCE / FINDINGS
-- ======================
CREATE TABLE IF NOT EXISTS evidence (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    investigation_id INTEGER NOT NULL,
    query_id INTEGER,
    title TEXT,
    url TEXT,
    snippet TEXT,
    source_platform TEXT,
    evidence_type TEXT,         -- link, profile, document, image, mention, other
    confidence TEXT DEFAULT 'medium', -- low, medium, high
    notes TEXT,
    is_verified INTEGER DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (investigation_id) REFERENCES investigations(id) ON DELETE CASCADE,
    FOREIGN KEY (query_id) REFERENCES queries(id) ON DELETE SET NULL
);

-- ======================
-- REPORTS
-- ======================
CREATE TABLE IF NOT EXISTS reports (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    investigation_id INTEGER NOT NULL,
    title TEXT NOT NULL,
    content TEXT,               -- Full report content (Markdown or HTML)
    file_path TEXT,             -- Path to exported file if any
    sent_to_telegram INTEGER DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (investigation_id) REFERENCES investigations(id) ON DELETE CASCADE
);

-- ======================
-- INDEXES for performance
-- ======================
CREATE INDEX IF NOT EXISTS idx_targets_investigation ON targets(investigation_id);
CREATE INDEX IF NOT EXISTS idx_queries_investigation ON queries(investigation_id);
CREATE INDEX IF NOT EXISTS idx_evidence_investigation ON evidence(investigation_id);
CREATE INDEX IF NOT EXISTS idx_reports_investigation ON reports(investigation_id);
