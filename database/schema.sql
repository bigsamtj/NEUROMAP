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
    surname VARCHAR(100),
    first_name VARCHAR(100),
    phone VARCHAR(50),
    nin VARCHAR(50),
    instagram VARCHAR(100),
    twitter VARCHAR(100),
    facebook VARCHAR(100),
    linkedin VARCHAR(100),
    email VARCHAR(255),
    organization VARCHAR(255),
    known_domains VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
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
    FOREIGN KEY(case_id) REFERENCES cases(id) ON DELETE CASCADE
);
