# Production Notes

## Inertia SSR

This project should run Inertia SSR in production.

Inertia SSR has two moving parts:

- Laravel handles the request, builds the Inertia page props, and returns the response.
- A separate long-running Node SSR process renders the React page HTML for Laravel.

The SSR process is started with:

```bash
php artisan inertia:start-ssr
```

In production on Hetzner, run that command under a process supervisor such as Supervisor or systemd so it restarts after crashes and deploys. The web request process should not be responsible for starting it.

Recommended production environment values:

```env
INERTIA_SSR_ENABLED=true
INERTIA_SSR_URL=http://127.0.0.1:13714
INERTIA_SSR_RUNTIME=node
INERTIA_SSR_ENSURE_BUNDLE_EXISTS=true
INERTIA_SSR_ENSURE_RUNTIME_EXISTS=true
INERTIA_SSR_THROW_ON_ERROR=true
```

Build both the browser and SSR bundles during deployment:

```bash
npm ci
npm run build
composer install --no-dev --optimize-autoloader
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

After deploying a new build, restart the SSR process so it uses the new SSR bundle. Inertia provides:

```bash
php artisan inertia:stop-ssr
php artisan inertia:check-ssr
```

The process supervisor should start the SSR process again after `inertia:stop-ssr`.

## Local Development

Local development does not need SSR running all the time. If `INERTIA_SSR_ENABLED=true` but `php artisan inertia:start-ssr` is not running, Laravel will try SSR and then fall back to client rendering when `INERTIA_SSR_THROW_ON_ERROR=false`.

For normal UI work, either leave SSR disabled locally or ignore the fallback:

```env
INERTIA_SSR_ENABLED=false
INERTIA_SSR_THROW_ON_ERROR=false
```

For SEO or initial HTML testing, run the SSR process locally and inspect the HTML response:

```bash
php artisan inertia:start-ssr
php artisan inertia:check-ssr
```

The production target is SSR on. The Blade head tags inside `<x-inertia::head>` are fallback tags for non-SSR responses only; when SSR is active, Inertia renders the React `<Head>` output instead.
