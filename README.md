# School Attendance Management System

A Laravel application for managing students, classes, subjects, teachers, and daily attendance.

## Requirements

- PHP 8.2 or later
- Composer
- MySQL 8.0 or later (or a compatible MariaDB server)

## Run locally (Windows PowerShell)

```powershell
composer install
Copy-Item .env.example .env
php artisan key:generate
mysql -u root -p -e "CREATE DATABASE school_attendance CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
php artisan migrate --seed
php artisan serve --port=8001
```

Before running migrations, make sure MySQL is running and update `DB_USERNAME` and `DB_PASSWORD` in `.env` to match your local MySQL account. The default database name is `school_attendance`; create it with the command above or change `DB_DATABASE` to an existing database. Open <http://127.0.0.1:8001> after the server starts. The seeded data includes eight teacher records (using the requested names), six classes, four students (John Crismel Boligao, Axl Montuya, Klint Taylaran, and MAtt Omus), eight subjects, and attendance records for the recent weekdays.

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
