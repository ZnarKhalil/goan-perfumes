# Build Progress

One line per completed phase. See `PHASE_N_TASKS.md` files for per-phase task detail and `docs/PROJECT.md` for the spec.

## Phase 0 — Project bootstrap — 2026-05-03
Postgres `goan_perfume` connected; `is_admin` column + `EnsureUserIsAdmin` middleware (alias `admin`) protect `/dashboard`; admin seeded as `admin@goanperfume.de`/`password` (idempotent `AdminUserSeeder`); `storage:link` done; `APP_NAME="Goan Perfume"`; `README.md` written. **Side note**: enabled `RefreshDatabase` in `tests/Pest.php` (starter kit shipped with it commented, breaking all Feature tests). Final verification: `migrate:fresh --seed` clean, 41/41 Pest tests pass, Pint clean.
