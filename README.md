# Resume

A Laravel + Livewire personal resume and portfolio site for managing professional experience, projects, education, skill groups, and contact messages from a private admin dashboard.

## Overview

This project is a content-driven resume website built around a database-backed admin workflow. The public-facing pages render profile and experience data from the database, while the admin area lets the owner update content without editing templates or code.

The app includes:

- A public resume landing page
- A print-friendly resume view
- A private admin panel for managing resume content
- Sortable sections for ordered content such as experience, projects, and education
- Contact form support with email handling and rate limiting
- Dark mode and responsive layout
- Content seeded for a personal portfolio/resume

## Tech Stack

- Laravel 13
- PHP 8.4
- Livewire 4
- SQLite by default for local development
- Vite for frontend asset building
- Pest for tests
- PHPStan for static analysis

## Project Structure

```text
app/
  Http/             HTTP-specific app code
  Livewire/         Reusable Livewire helpers and page components
  Models/           Resume data models
config/            Laravel configuration
database/
  migrations/       Schema definitions
  seeders/          Seed data for profile and content
public/            Public assets and entry point
resources/         Blade templates, CSS, JS, and Livewire views
routes/
  web.php           Application routes
storage/           Cached and generated files
tests/             Feature and integration tests
```

## Features

### Public site

- Home page for the resume and portfolio
- Print-ready resume view at `/resume`
- Contact form for visitors to send messages
- Responsive design with dark mode support

### Admin area

Protected routes are available under `/admin`:

- `/admin` dashboard
- `/admin/profile`
- `/admin/experiences`
- `/admin/projects`
- `/admin/skills`
- `/admin/education`
- `/admin/messages`

The admin interface supports:

- Creating and editing resume records
- Deleting records
- Reordering entries in sortable sections
- Managing contact submissions

## Local Setup

1. Clone the repository.
2. Install PHP dependencies:

```bash
composer install
```

3. Install frontend dependencies:

```bash
npm install
```

4. Copy the environment file:

```bash
cp .env.example .env
```

5. Generate the application key:

```bash
php artisan key:generate
```

6. Create and migrate the database:

```bash
php artisan migrate --seed
```

7. Build frontend assets:

```bash
npm run build
```

8. Start the app:

```bash
php artisan serve
```

Then open:

- http://localhost:8000
- http://localhost:8000/admin/login

## Admin Credentials

The seeded admin user is configured from environment variables in `.env`:

```env
ADMIN_NAME="First Last"
ADMIN_EMAIL=admin@example.com
ADMIN_PASSWORD=secret
```

If you create a fresh environment, make sure these values match the user you want to use for the admin login.

## Useful Commands

```bash
php artisan test
php artisan route:list
php artisan migrate
php artisan db:seed
npm run dev
```

## Notes

- The project is designed to use SQLite locally by default.
- The resume content is database-driven, so updates to the portfolio are usually made in the admin dashboard rather than in hardcoded templates.
- The codebase includes automated tests and static analysis checks for ongoing quality assurance.

## License

This project is licensed under the MIT License.
