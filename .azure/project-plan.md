# Project Plan

**Status**: Awaiting Integration
**Created**: 2026-11-10
**Mode**: AUGMENT

---

## 1. Project Overview

**Goal**: Extend the established Amiru International School Laravel 12 application with a public admissions flow and authenticated staff/student portals for admissions review, timetable, attendance, and structured report cards while preserving the live configured database and academic-year/term model. The project is designed so that every module is independently testable.

**App Type**: Full-stack SSR

**API Login**: Yes

**Mode**: AUGMENT

**Deployment Plan**: No deployment plan found

---

## 2. Backend — Laravel 12

| Component | Technology |
|-----------|-----------|
| **Language** | PHP |
| **Runtime** | PHP |
| **Framework** | Laravel 12 |
| **Package Manager** | Composer |
| **Test Runner** | PHPUnit |
| **Mocking Library** | Mockery |
| **Test Command** | php artisan test |
| **Orchestration** | docker-compose |

> **Language vs Runtime**: `Language` is the source language the user picked in this service's `language` question. `Runtime` is the execution runtime — default `Node` for TypeScript/JavaScript, `CPython` for Python, `.NET` for C#. Only deviate from the default (e.g. `Bun`, `Deno`, `PyPy`) when the user explicitly asks. **Package Manager and Test Runner are language-dependent** — match them to this service's Language (e.g. C# → `dotnet (NuGet)` + `xUnit`/`NUnit`/`MSTest`). The `Orchestration` row is recorded for the scaffold step but hidden in the plan UI — always keep it set to `docker-compose`.

> Tooling alternatives in the template are examples, not an allowlist. Preserve the user's confirmed package manager and test runner, and derive a matching test command rather than replacing their selection with a default.

> **Runtime names only:** write just the runtime name in the Runtime row; keep host/programming-model details and explicit version constraints outside this row; detected tool versions belong in Prerequisites.

> **Framework selection:** Laravel 12 is the confirmed existing backend framework; preserve it rather than replacing the application with an unrelated API framework.

---

## 3. Frontend — Web App

| Component | Technology |
|-----------|-----------|
| **Language** | JavaScript |
| **Framework** | Laravel Blade + Vite |
| **Package Manager** | npm |
| **Test Runner** | Vitest |
| **Mocking Library** | vi.mock |
| **Test Command** | npx vitest |

---

## 4. Services Required

| Azure Service | Role in App | Environment Variable | Default Value (Local) | Classification |
|---------------|------------|---------------------|----------------------|----------------|
| SQLite | Primary relational school data store for admissions, student profiles, classes, attendance, timetables, exam results, and report cards | DB_CONNECTION / DB_DATABASE | `database/database.sqlite` from the Laravel app configuration | Essential |
| Azure Blob Storage | Store uploaded school files, such as report-card and timetable attachments when file workflows are enabled | STORAGE_CONNECTION_STRING | `UseDevelopmentStorage=true` | Essential |
| Azure App Service | Host the Laravel website and staff portal in an Azure deployment | APP_SERVICE_URL | `http://localhost:8000` | Essential |

---

## 5. Prerequisites

### Run

| Tool | Service(s) | Installed | Version |
|------|------------|-----------|---------|
| PHP | School Web | ✅ | 8.2.12 |
| Composer | School Web | ✅ | 2.10.3 |
| Node.js | School Web UI | ✅ | 24.20.0 |
| npm | School Web UI | ✅ | 11.19.0 |
| SQLite CLI (optional local inspection) | School Web | ❓ | Unknown |
| Vitest (planned frontend test runner) | School Web UI | ❓ | Unknown |

### Debug

| Tool | Service(s) | Installed | Version |
|------|------------|-----------|---------|
| Docker Desktop / Docker Engine | School Web | ❓ | Unknown |
| Docker Compose | School Web | ❓ | Unknown |
| VS Code PHP Debug extension | School Web | ❓ | Unknown |
| VS Code JavaScript/TypeScript debug support | School Web UI | ❓ | Unknown |

> Tool detection confirmed PHP 8.2.12, Composer 2.10.3, Node.js 24.20.0, and npm 11.19.0. SQLite CLI, Docker tooling, Vitest, and editor extensions could not be confirmed in the environment. Double-check that all ❓ tools needed for your chosen workflow are installed before proceeding.

---

## 6. Design System & UI

**Component Library**: Pico.css
**Style Direction**: A welcoming, trustworthy school experience with calm teal identity, warm gold highlights, spacious, readable records, and a clear public-to-portal journey for families, students, and staff.
**Typography**: Segoe UI Variable, system-ui

### Color Palette

| Token | Hex | Usage |
|-------|-----|-------|
| `primary` | `#0F766E` | School identity, admissions CTAs, and selected portal navigation |
| `accent` | `#F59E0B` | Review highlights, deadlines, and timetable/report-card emphasis |
| `surface` | `#F8FAFC` | Public pages and portal workspace backgrounds |
| `text` | `#0F172A` | Main body copy, student records, and application forms |
| `muted` | `#475569` | Secondary guidance, academic metadata, and status text |
| `border` | `#E2E8F0` | Form fields, data tables, and portal panel dividers |

### Pages

| Page | Route | Purpose | Layout |
|------|-------|---------|--------|
| Home | `/` | Showcase the school and current intake while guiding families to admissions. | `header + hero + card-list + footer` |
| Admissions Apply | `/admissions/apply` | Capture a student application and guardian details. | `header + split(form\|sidebar) + footer` |
| Portal Dashboard | `/portal` | Summarize the current academic period and recent school workflow actions. | `header + nav + grid + card-list` |
| Admissions Review | `/portal/admissions` | Let admissions staff review and decide on incoming applications. | `header + nav + action-bar + table` |
| Timetable | `/portal/timetable` | Show the schedule for the selected term and permitted class or student record. | `header + nav + action-bar + table` |
| Attendance | `/portal/attendance` | Record attendance and review permitted attendance history. | `header + nav + tabs + table` |
| Report Cards | `/portal/report-cards` | Publish or review structured exam results and report cards. | `header + nav + tabs + split(table\|form)` |

### Sample Content

> These representative values are for the planning preview only. They are not production fixtures or seed data. The scaffolded public website and portal must query and display the live records in the existing configured database.

Home — Admissions intake:
| Program | Intake | Deadline | Status |
| Foundation Year 2026 | September 2026 | 30 Apr 2026 | Open |
| Grade 7 | September 2026 | 15 May 2026 | Open |
| Grade 10 | September 2026 | 20 Jun 2026 | Open |
| Nursery | January 2027 | 31 Oct 2026 | Upcoming |

Admissions Apply — Applicant:
| Student | Guardian | Program | Status |
| Aisha Bello | Mrs. Titi Bello | Grade 7 | Draft |
| Daniel Okafor | Mr. Chima Okafor | Grade 10 | Submitted |
| Mariam Yusuf | Mrs. Halima Yusuf | Nursery | In review |
| Samuel Adeyemi | Mr. Bamidele Adeyemi | Foundation Year 2026 | Awaiting documents |

Portal Dashboard — Workflow summary:
| Area | Current | Next action |
| Admissions | 27 applications | Review 5 pending files |
| Attendance | 92% weekly compliance | Mark Monday attendance |
| Timetable | 18 classes active | Publish Grade 9 timetable |
| Report cards | 6 reports locked | Release Term 2 marks |

Admissions Review — Application queue:
| Applicant | Guardian | Intake | Decision |
| Imani Lawal | Mr. Segun Lawal | Grade 8 | Pending |
| Kelvin Adebayo | Mrs. Funke Adebayo | Grade 7 | Accepted |
| Zainab Ibrahim | Mr. Ibrahim Ibrahim | Foundation Year 2026 | Requires interview |
| Tobi Oladipo | Mrs. Grace Oladipo | Nursery | On hold |

Timetable — Weekly schedule:
| Class | Subject | Teacher | Period |
| Grade 7A | Mathematics | Mrs. Nneka Okafor | Monday 08:30 |
| Grade 8B | English | Mr. Emmanuel Idris | Tuesday 10:00 |
| Grade 10 Science | Biology | Mrs. Amina Yusuf | Wednesday 09:15 |
| Senior School | Physics | Mr. David Smith | Thursday 11:45 |

Attendance — Class register:
| Class | Date | Present | Absent | Status |
| Grade 7A | 10 Mar 2026 | 24 | 1 | Recorded |
| Grade 9B | 10 Mar 2026 | 22 | 3 | Requires follow-up |
| Grade 10 Science | 10 Mar 2026 | 18 | 2 | Recorded |
| Senior School | 10 Mar 2026 | 26 | 0 | Recorded |

Report Cards — Subject results:
| Student | Class | Subject | Score | Status |
| Aisha Bello | Grade 7A | Mathematics | 88% | Published |
| Daniel Okafor | Grade 10A | Biology | 76% | Draft |
| Mariam Yusuf | Nursery | Literacy | 91% | Published |
| Samuel Adeyemi | Foundation Year 2026 | Social Studies | 83% | Draft |

---

## 7. Project Structure

```
.
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Middleware/
│   │   └── Requests/
│   ├── Models/
│   ├── Policies/
│   └── Services/
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│       ├── admissions/
│       ├── auth/
│       ├── portal/
│       └── components/
├── routes/
│   └── web.php
├── storage/
├── tests/
├── .env.example
├── artisan
├── composer.json
├── package.json
├── phpunit.xml
├── vite.config.js
└── README.md
```

---

## 8. Route Definitions

| # | Method | Path | Description | Request Body | Response Body | Status Codes |
|---|--------|------|-------------|-------------|--------------|-------------|
| 1 | GET | `/api/health` | Health check for the web application stack | — | `{ status, services }` | 200, 503 |
| 2 | GET | `/` | Public school homepage and intake overview | — | `landing page + intake summary` | 200 |
| 3 | GET | `/admissions/apply` | Render the admissions application form | — | `application form metadata + required fields` | 200 |
| 4 | POST | `/admissions/apply` | Submit an admissions application | `{ student, guardian, program, documents }` | `{ application_id, status }` | 200, 201, 400 |
| 5 | GET | `/portal` | Staff/student portal dashboard | — | `dashboard summary for permitted role` | 200 |
| 6 | GET | `/portal/admissions` | Review admissions queue and decisions | — | `applications list plus filters` | 200 |
| 7 | GET | `/portal/timetable` | View timetable for the selected academic year and term | — | `schedule list for allowed classes/students` | 200 |
| 8 | POST | `/portal/attendance` | Record attendance for a class or student subset | `{ class_id, date, attendance }` | `{ saved_count, status }` | 200, 201, 403 |
| 9 | GET | `/portal/report-cards` | Fetch structured report-card results and assessment data | — | `assessment list and grade summary` | 200 |

---

## 9. Next Steps

1. Run **azure-project-scaffold** to execute this plan
2. Run **azure-project-integrate** to wire the frontend to live data, smoke-test the backend, and create the migrations
3. Run **azure-debug-plan** → **azure-debug-generate** for Docker emulators and VS Code debugging
4. Run the **azure-deploy** agent when ready; it uses **azure-app-onboard** for architecture, cost estimation, IaC generation, provisioning, and health verification
