# Integration plan

## Backend
- App: `app/`
- Routes: `routes/web.php`
- DB migrations: `database/migrations/`
- Run: `php artisan serve` (or `php artisan migrate && php artisan serve`)
- Health: `/api/health`
- Ports: `http://localhost:8000`

## Frontend
- Views: `resources/views/`
- CSS/assets: `public/css/app.css`, `resources/js/`, `vite.config.js`
- Build: `npm run build`
- Dev: `npm run dev`
- Preview path: `/` and staff portal routes under `/portal*`

## Route inventory
- GET `/api/health`
- GET `/`
- GET `/admissions/apply`
- POST `/admissions/apply`
- GET `/login`
- POST `/login`
- POST `/logout`
- GET `/portal`
- GET `/portal/admissions`
- PATCH `/portal/admissions/{admission}`
- GET `/portal/timetable`
- GET `/portal/attendance`
- POST `/portal/attendance`
- GET `/portal/report-cards`

## Auth and identity
- Session-backed Laravel auth is in place.
- Roles: `administrator`, `admissions_officer`, `teacher`, `non_teaching_staff`, `student`.
- Protected routes are enforced with the `role` middleware.
- Sign-in flow: `app/Http/Controllers/AuthController.php`.

## Database and migrations
- Database tool: Laravel migrations + SQLite (`DB_CONNECTION` / `DB_DATABASE`)
- Migration directory: `database/migrations/`
- No seed data is to be created during integration; keep the configured live database intact.
- Important entities: `academic_years`, `academic_terms`, `school_classes`, `students`, `admissions`, `attendance_records`, `timetable_entries`, `report_cards`.

## Service list
- Essential: SQLite, Azure Blob Storage integration for future file workflows, App Service host.
- Enhancement: optional file-upload and attachment workflows.

## Shared types / service abstraction
- PHP/Laravel app uses Eloquent models and controller contracts rather than a separate TypeScript API seam.
- Keep business logic inside `app/Http/Controllers/` and `app/Models/`.

## Integration notes
- Use live records from Laravel database; do not replace them with static fixtures.
- Seeded examples may be used as fallback display data only when SQLite tables are empty.
- Preserve current academic-year and term model while enabling admissions, attendance, timetable, and report-card screens.
