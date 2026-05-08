# Phase 0 — Project Bootstrap ✅

**Goal**: A running Laravel + React Starter Kit project with PostgreSQL connected, storage linked, and the dashboard accessible only to admin users.

## Current state (already done at start of phase)

- Laravel 13 + React Starter Kit installed (Inertia v3, React 19, Tailwind v4, Fortify v1, Wayfinder v0).
- `.env` had `DB_CONNECTION=pgsql`, `DB_DATABASE=goan_perfume`, `APP_URL=http://goan-perfumes.test` (Herd).
- `users` table migration existed; `User` model existed.
- Routes: `/` (welcome) and `/dashboard` (auth+verified) already defined.

## Completed

### 1. PostgreSQL database
- [x] User created the `goan_perfume` database manually.
- [x] `php artisan migrate` runs cleanly against it.

### 2. App identity
- [x] `APP_NAME="Goan Perfume"` in `.env`.
- [x] `APP_LOCALE=en` left as-is — public-site locale handling is Phase 5.

### 3. `is_admin` on users
- [x] Migration `2026_05_03_151732_add_is_admin_to_users_table.php` adds `boolean is_admin default false` after `email_verified_at`.
- [x] `User` model: `is_admin` added to `#[Fillable]` and cast to `'boolean'`.

### 4. Admin middleware on `/dashboard`
- [x] `App\Http\Middleware\EnsureUserIsAdmin` redirects non-admins to `home` with a German flash message.
- [x] Registered as alias `'admin'` in `bootstrap/app.php`.
- [x] Applied to the `/dashboard` route group in `routes/web.php` alongside `auth` + `verified`.

### 5. Seeded admin user
- [x] `AdminUserSeeder` uses `User::updateOrCreate` (idempotent): `admin@goanperfume.de` / `password`, `is_admin=true`, `email_verified_at=now()`.
- [x] Wired into `DatabaseSeeder::run()`. The starter-kit `Test User` line was removed.

### 6. Storage symlink
- [x] `php artisan storage:link` executed; `public/storage` resolves to `storage/app/public`.

### 7. README
- [x] `README.md` at project root with stack, setup steps, admin credentials, useful commands, and pointers to `docs/PROJECT.md` + `PROGRESS.md`.

### 8. Verification
- [x] `php artisan migrate:fresh --seed` completes cleanly.
- [x] `php artisan test --compact` — 41/41 pass, 138 assertions.
- [x] `vendor/bin/pint --dirty --format agent` clean.
- [x] `DashboardTest` updated: now covers guests-redirected, non-admin-redirected, and admin-allowed cases (so the new middleware is regression-tested).

### 9. Bookkeeping
- [x] All tasks marked complete here.
- [x] `PROGRESS.md` created with Phase 0 entry.

---

## Side adjustments worth noting

- **Pest `RefreshDatabase`**: the starter kit shipped with `->use(RefreshDatabase::class)` commented out in `tests/Pest.php`. With it commented, every Feature test errored on "no such table: users". Uncommenting was the standard fix and had nothing to do with my changes; flagging it here so it isn't a surprise later.

## Open questions resolved

1. **Postgres credentials** — kept `postgres` / `1234` for local dev.
2. **Admin seed credentials** — `admin@goanperfume.de` / `password`, README flags to change.
3. **Test User seed** — dropped; the new admin user replaces it.
4. **Non-admin behaviour on `/dashboard`** — redirect to `home` (`/`) with a flash error.
