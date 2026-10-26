CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS cases (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    case_ref VARCHAR(50) UNIQUE NOT NULL,
    title VARCHAR(255) NOT NULL,
    full_name VARCHAR(255),
    aliases TEXT,
    email VARCHAR(255),
    phone VARCHAR(50),
    username_handle VARCHAR(100),
    occupation VARCHAR(255),
    organization VARCHAR(255),
    country VARCHAR(100),
    city VARCHAR(100),
    known_domains TEXT,
    notes TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS query_templates (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title VARCHAR(100) NOT NULL,
    category VARCHAR(50) NOT NULL,
    pattern TEXT NOT NULL,
    provider VARCHAR(50) DEFAULT 'google',
    is_active INTEGER DEFAULT 1
);

CREATE TABLE IF NOT EXISTS search_runs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    case_id INTEGER NOT NULL,
    template_id INTEGER,
    query_text TEXT NOT NULL,
    provider VARCHAR(50) NOT NULL,
    search_url TEXT,
    status VARCHAR(30) DEFAULT 'NOT_RUN',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(case_id) REFERENCES cases(id) ON DELETE CASCADE,
    FOREIGN KEY(template_id) REFERENCES query_templates(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS findings (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    case_id INTEGER NOT NULL,
    search_run_id INTEGER,
    source_url TEXT NOT NULL,
    title VARCHAR(255),
    snippet TEXT,
    notes TEXT,
    verification_status VARCHAR(50) DEFAULT 'UNVERIFIED',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(case_id) REFERENCES cases(id) ON DELETE CASCADE,
    FOREIGN KEY(search_run_id) REFERENCES search_runs(id) ON DELETE SET NULL
);

-- Template Dork OSINT Bawaan NEUROMAP
INSERT INTO query_templates (title, category, pattern, provider) VALUES
('Exact Name Search', 'Identity', '"{{full_name}}"', 'google'),
('LinkedIn Profile', 'Professional', 'site:linkedin.com/in "{{full_name}}"', 'google'),
('Name + Occupation', 'Professional', '"{{full_name}}" "{{occupation}}"', 'google'),
('Public Email Mentions', 'Contact', '"{{email}}"', 'google'),
('Username Discovery', 'Social', '"{{username_handle}}"', 'google'),
('Domain Association', 'Domain', 'site:{{known_domains}} "{{full_name}}"', 'google'),
('File Documents (PDF/DOCX)', 'Documents', 'filetype:pdf OR filetype:docx "{{full_name}}"', 'google');
