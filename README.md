# Goan Perfume

Product showcase website for **Goan Perfume**, a German-based perfume shop. The site is a public catalogue with rich filtering — there is no cart, checkout, or order processing. Customers browse and contact the shop directly via WhatsApp / phone / email.

## Stack

- **PHP** 8.4
- **Laravel** 13 with the **React Starter Kit** (Inertia v3 + React 19)
- **PostgreSQL**
- **Tailwind CSS** v4
- **Vite** + **Wayfinder** (typed route helpers)
- **Pest** v4 for testing
- Local development served by **Laravel Herd** at `http://goan-perfumes.test`

## Local setup

### Prerequisites

- PHP 8.4 (Herd ships a compatible version)
- Node.js 20+
- PostgreSQL 18+ running locally
- Composer 2.x
- Laravel Herd (recommended — registers the `.test` domain automatically)

### Steps

```bash
# 1. Clone, install backend deps
composer install

# 2. Copy env and generate key (skip if .env already exists)
cp .env.example .env
php artisan key:generate

# 3. Create the database
psql -U postgres -c "CREATE DATABASE goan_perfume;"

# 4. Run migrations and seed the admin user
php artisan migrate --seed

# 5. Link storage so uploaded media is publicly served
php artisan storage:link

# 6. Install JS deps
npm install

# 7. Run the dev stack (server + queue + logs + vite)
composer run dev
```

Visit `http://goan-perfumes.test/` — the site will be served by Herd. If you don't use Herd, run `php artisan serve` and visit `http://127.0.0.1:8000/`.

## Admin login

The seeder creates a single admin account:

| Field    | Value                       |
|----------|-----------------------------|
| Email    | `admin@goanperfume.de`      |
| Password | `password`                  |

> **Change this password on first login.** It's only intended for local development and initial production setup.

The dashboard is at `/dashboard` and is gated by the `admin` middleware — non-admin users are redirected back to `/`.

## Useful commands

```bash
php artisan test --compact      # run Pest test suite
php artisan migrate:fresh --seed  # drop and reseed everything
vendor/bin/pint --dirty         # auto-format only changed PHP files
npm run build                   # production asset build
npm run dev                     # vite dev server (or use `composer run dev`)
```
