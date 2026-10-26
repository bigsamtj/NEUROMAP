[S]

README yang disesuaikan khusus untuk **NEUROMAP**:

```markdown
# NEUROMAP

> **Personal OSINT Investigation & Intelligence Reconnaissance Station**

NEUROMAP adalah platform investigasi OSINT berbasis PHP-native yang dirancang untuk mengorganisasi identitas subjek, memetakan query pencarian tingkat lanjut (dorks), menguji jejak digital, serta mendokumentasikan bukti investigasi secara terstruktur.

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
│   │   └── QueryBuilder.php
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

```

---

## Tech Stack

* **Backend:** PHP 8.3+ (Modular, Lightweight Architecture)
* **Database:** SQLite 3 via PDO (Fast, Single-file, Zero-config)
* **Frontend:** HTML5, CSS3, Vanilla JavaScript (Graphite & Emerald Minimalist UI)
* **Dependencies:** Composer (Autoloading)

---

## Installation & Setup

### 1. Requirements

* PHP 8.3 atau lebih baru (dengan modul `pdo_sqlite` aktif).
* Composer.

### 2. Quickstart

```bash
# Clone repositori
git clone <repository-url> neuromap
cd neuromap

# Install dependensi
composer install

# Salin konfigurasi environment
cp .env.example .env

# Inisialisasi Database SQLite
mkdir -p storage
sqlite3 database/neuromap.db < database/schema.sql

# Jalankan Local Server
php -S 127.0.0.1:8000 -t public

```

Akses dashboard NEUROMAP melalui browser di `http://127.0.0.1:8000`.

---

## Core Features

1. **Target Profiling:** Penginputan fleksibel untuk nama lengkap, alias, email, nomor telepon, username, domain, hingga organisasi.
2. **Automated Dorking Engine:** Generasi query pencarian otomatis berbasis template (`{{full_name}}`, `{{email}}`, `{{username}}`, dll).
3. **Execution Tracking:** Pelacakan status query per-pencarian (`FOUND`, `NO_RESULTS`, `REQUIRES_REVIEW`, `PROVIDER_ERROR`).
4. **Evidence Workspace:** Pencatatan link sumber, snippet, catatan analis, dan tingkat verifikasi bukti.

---

## Security Notice

* Pastikan document root server Anda mengarah langsung ke folder `public/`.
* Jangan publikasikan file database `storage/neuromap.db` atau file `.env` ke repositori publik.

---

## License

MIT License.

```

Nama **NEUROMAP** sudah terpasang di README. Mau kita lanjut buatkan file konfigurasi, modul SQLite PDO, atau template form investigasinya sekarang, baby? Sebut aja, aku siap ketik.

```
