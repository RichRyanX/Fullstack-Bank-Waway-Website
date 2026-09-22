<p align="center">
  <img src="frontend-source/img/logo-bank-waway.png" alt="Bank Waway Lampung Logo" width="320">
</p>

<h1 align="center">Fullstack Website & Admin CMS Bank Waway Lampung </h1>

<p align="center">
  <strong>⚠️ Draft project made by a student intern at Bank Waway Lampung.<br>
  This is not an official or production release.</strong>
</p>

---

## About

This repository contains a fullstack rebuild of **PT BPR Bank Waway Lampung**'s public website and internal Admin CMS, built during a Cybersecurity/Software Engineering internship as part of an ITERA (Institut Teknologi Sumatera) Informatics Engineering practical work program (Praktek Kerja Lapangan / PKL).

The project consists of two main parts:

1. **Public Website** — an informational front-end covering company profile, products (savings, credit/loan products, employee products), reports, careers, and a whistleblowing system (WBS) page.
2. **Admin Panel / CMS** — an internal dashboard for managing website content, compliance reports, audit logs, and site settings.

## ⚠️ Disclaimer

- This is a **student intern draft project**, not an officially endorsed or deployed system by Bank Waway Lampung.
- It was built for learning and internship deliverable purposes.
- Do **not** treat any data, credentials, or content in this repo as production-accurate or authoritative.
- The `.env` file (real secrets/config) is intentionally excluded from this repository — see [Setup](#setup--installation) below.

## Tech Stack

| Layer | Technology |
|---|---|
| Backend framework | Laravel 13.x (PHP 8.4.24) |
| Package manager | Composer 2.10.2 |
| Database (dev) | SQLite |
| Auth | Laravel session-based auth with a custom `admin` guard, bcrypt password hashing |
| Frontend (public site) | Static HTML/CSS/JavaScript |
| Frontend (admin panel) | HTML/CSS/JavaScript served from `public/admin`, consuming Laravel API routes |
| Build tooling | Vite |
| Testing | PHPUnit (Feature & Unit tests) |

> **Migration note:** this project originally started as a Node.js + Express + SQLite backend, but was rebuilt in Laravel to match the production stack already used by Bank Waway's live site (PHP/Laravel).

## Features

### Public Website
- Company profile pages: visi-misi, susunan pengurus, tempat kedudukan, perijinan & legalitas, modal, prestasi & penghargaan
- Product pages: tabungan (tapis, cerdik, pegawai), kredit (UMKM, konsumer, komersil, B2B, PPPK, pensiun, pra-pensiun, tukin, subsidi, multiguna, PDRS)
- Laporan tahunan & laporan keberlanjutan (annual/sustainability reports)
- Karir (careers) page
- WBS (Whistleblowing System) page

### Admin Panel / CMS
- **Auth** — session-based admin login/logout
- **Konten Website** — CRUD for website content/news (berita), with automatic audit logging
- **Laporan & Kepatuhan** — compliance document repository with file upload and version history (root-based versioning)
- **Audit Log** — tracks all admin actions with the responsible admin auto-attached
- **Pengaturan** — site settings and badge/certification image management

## Project Structure

```text
├── admin/                 # Admin panel source
├── app/                    # Laravel application code (Models, Controllers, etc.)
├── bootstrap/               # Laravel bootstrap files
├── config/                    # Laravel configuration
├── database/                    # Migrations, seeders, factories
├── docs/                           # Supplementary docs (Google Apps Script integration notes, etc.)
├── frontend-source/                  # Static public website source (HTML/CSS/JS)
├── public/                              # Laravel public directory (served admin panel + entry point)
├── resources/                              # Blade views, assets
├── routes/                                    # API & web route definitions
├── storage/                                      # Laravel storage (logs, uploads — gitignored where appropriate)
├── tests/                                           # PHPUnit Feature & Unit tests
├── .env.example                                        # Template for required environment variables
├── composer.json                                          # PHP dependencies
├── package.json                                              # JS/build dependencies
└── artisan                                                     # Laravel CLI entry point
```

## Setup & Installation

> This project is intended to run **locally only** — hosting/deployment is out of scope and is the responsibility of the actual organization.

### Prerequisites
- PHP 8.4+
- Composer 2.x
- Node.js & npm (for frontend build tooling, if applicable)

### Steps

```bash
# 1. Clone the repository
git clone https://github.com/RichRyanX/Fullstack-Bank-Waway-Website.git
cd Fullstack-Bank-Waway-Website

# 2. Install PHP dependencies
composer install

# 3. Copy the environment template and fill in your own values
cp .env.example .env
php artisan key:generate

# 4. Run migrations
php artisan migrate

# 5. Seed an initial admin account
php artisan db:seed --class=AdminSeeder

# 6. Serve the application
php artisan serve
```

The app will be available at `http://127.0.0.1:8000`, with the Admin Panel at `http://127.0.0.1:8000/admin/HTML/index.html`.

> ⚠️ After seeding, log in and **change the default admin password immediately** — never leave seeded/default credentials active beyond local development.

## Environment Variables

See `.env.example` for the full list of required variables. Key groups:
- `APP_*` — application name, environment, debug mode, URL
- `DB_*` — database connection (SQLite by default for local dev)
- `SESSION_*` — session driver/lifetime config
- `MAIL_*` — mail driver config (used for OTP/notification features)
- `AWS_*` — optional, only needed if using S3-compatible storage instead of local disk

## Deliverables

This project's internship deliverables also include:
- UML Activity Diagram (verifikasi/pengajuan flow)
- UML Class Diagram
- UML Sequence Diagram (login with OTP verification)
- UML Use Case Diagrams (Admin CMS & Admin Hub)
- Figma UI/UX design reference

## Author

**Ryanda Aditya Irawan** — Informatics Engineering, Institut Teknologi Sumatera (ITERA)
Cybersecurity/SOC-focused student intern at Bank Waway Lampung

## License

This project is a personal/academic draft and is not licensed for production or commercial use without explicit authorization from PT BPR Bank Waway Lampung.
