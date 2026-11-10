# Amiru International School

Amiru's school website and Laravel 12 school-management system. It requires PHP 8.2 or newer and uses SQLite by default.

## Get started

From the project directory:

```powershell
composer install
php artisan migrate
php artisan serve
```

Open the local address printed by `php artisan serve`. The public website is at `/`, prospective families can submit an application at `/admissions/apply`, and school users can sign in at `/login`.

To create an account, run `php artisan school:user` and follow the prompts. The password is entered as a hidden prompt and must be at least 12 characters. Available roles are `administrator`, `admissions_officer`, `teacher`, `non_teaching_staff`, and `student`. Never commit real account credentials.

If you change database settings in `.env`, configure a supported database and run `php artisan migrate` before starting the application.

## Included foundation

- Responsive Amiru school homepage and online admissions application form.
- Authenticated portals with role-based access and an admissions review queue for administrators and admissions officers.
- Database schema for academic years and terms, classes, subjects, student profiles, attendance, timetables, examinations, exam results, report cards, and announcements.
- An interactive `school:user` command for creating the first administrator and subsequent school accounts.

Attendance, timetables, exam entry, report-card publishing, class/subject administration, staff profile management, guardian access, fees, and messaging are represented in the database foundation but still need their management screens and workflows. A submitted application also needs to be enrolled into the student register by a future admissions workflow; changing its review status does not enroll a learner automatically.

## Checks

Run the feature and unit test suite with:

```powershell
php artisan test
```
