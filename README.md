# School Attendance Management System

A Laravel application for managing students, classes, subjects, teachers, and daily attendance.

## Requirements

- PHP 8.2 or later
- Composer

## Run locally (Windows PowerShell)

```powershell
composer install
Copy-Item .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan serve --port=8001
```

Open <http://127.0.0.1:8001>. The app uses SQLite by default; Laravel creates `database/database.sqlite` when migrations run. The seeded data includes eight teacher records (using the requested names), six classes, four students (John Crismel Boligao, Axl Montuya, Klint Taylaran, and MAtt Omus), eight subjects, and attendance records for the recent weekdays.

> `migrate:fresh` drops all existing tables and data. Use it only when you intend to reset the local database.

## Features

- Dashboard with counts, recent records, and the latest attendance summary
- Create, view, edit, and delete students, classes, subjects, and teachers
- Create, edit, filter, and delete attendance records
- Server-side validation, including one record per student/subject/date
- Foreign-key relationships and delete safeguards

## Tests

```powershell
php artisan test
```
