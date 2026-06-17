# Google Analytics Integration Plan

This document describes how Google Analytics should be added to Goan Perfume and how analytics data can be shown inside the admin dashboard.

The site is for a Germany-based perfume shop, so analytics must be implemented with GDPR/cookie consent in mind.

## Goal

Add Google Analytics 4 tracking to the public website and show key analytics inside the Laravel dashboard so the admin does not need to open Google Analytics every time they want basic traffic statistics.

## Part 1: Public Website Tracking

Status: required before dashboard analytics can collect useful data.

Why: Google Analytics needs to receive events from the public website before the dashboard can report meaningful traffic data.

What it is: A consent-aware GA4 tracking setup on the public Inertia/React site.

Implement:

- Create a Google Analytics 4 property.
- Add the GA4 Measurement ID to environment config, for example:
  - `VITE_GOOGLE_ANALYTICS_MEASUREMENT_ID=G-XXXXXXXXXX`
- Use the `VITE_` prefix if React reads the value through `import.meta.env`, because Laravel Vite only exposes frontend environment variables with this prefix.
- If the measurement ID should not be baked into the compiled JavaScript bundle, share it from Laravel through Inertia props instead.
- Load Google Analytics only on the public website, not inside the admin dashboard unless admin usage should also be tracked.
- Track normal page views.
- Track Inertia client-side navigation as page views, because this is not a traditional full-page-load website.
- Track useful public events later if needed:
  - Product page viewed.
  - Category viewed.
  - WhatsApp contact clicked.
  - Phone contact clicked.
  - Email contact clicked.
  - Language changed.

## Consent And Privacy Requirements

Status: required for Germany/EU if Google Analytics is used.

Why: Google Analytics is non-essential tracking. It should not run before the visitor gives analytics consent.

What it is: A cookie/consent system that controls whether Google Analytics is allowed to load.

Implement:

- Add a cookie banner or consent manager.
- Provide at least:
  - Accept all.
  - Reject all.
  - Settings / granular consent.
- Do not preselect analytics consent.
- Do not load GA4 before analytics consent is granted.
- Store the visitor's consent choice.
- Provide a permanent `Cookie settings` link so consent can be changed later.
- Update the privacy policy to explain Google Analytics usage.
- Mention Google as a third-party provider.
- Explain what data is processed, the purpose, legal basis, retention, and withdrawal option.
- Consider Google Consent Mode so Google tags receive consent state correctly.

Sources:

- Google Consent Mode: https://developers.google.com/tag-platform/security/guides/consent
- GA4 web setup: https://developers.google.com/analytics/devguides/collection/ga4
- GDPR: https://eur-lex.europa.eu/legal-content/EN/TXT/?uri=CELEX:32016R0679

## Part 2: Analytics Data In The Dashboard

Status: implement after GA4 tracking and consent are in place.

Why: The dashboard should show the most important traffic data without forcing the admin to visit Google Analytics.

What it is: A dashboard page that reads GA4 data through the Google Analytics Data API.

Recommended route:

- `/dashboard/analytics`

Recommended dashboard metrics:

- Visitors / active users.
- Page views.
- Sessions.
- Engagement rate or average engagement time.
- Top pages.
- Top product pages.
- Top category pages.
- Traffic sources.
- Countries.
- Device categories.
- Realtime active users.
- Date range filters:
  - Last 7 days.
  - Last 30 days.
  - Last 90 days.

Source:

- Google Analytics Data API: https://developers.google.com/analytics/devguides/reporting/data/v1

## Required Google Setup

Status: required before backend API calls can work.

Why: The Laravel app needs authorized server-side access to read GA4 reports.

What it is: Google Cloud and GA4 credentials.

Implement:

- Create the GA4 property and web data stream first:
  - Go to https://analytics.google.com/.
  - Sign in with the Google account that should own the analytics property.
  - Go to `Admin`.
  - Click `Create` > `Property`.
  - Property name: `Goan Perfume Website`.
  - Reporting time zone: `Germany`.
  - Currency: `Euro (EUR)`.
  - Choose the business category, business size, and business objectives.
  - Click `Create` and accept the Analytics terms and data processing terms if prompted.
  - Create a `Web` data stream.
  - Website URL: use the production website URL.
  - Stream name: `Goan Perfume Web`.
  - Keep `Enhanced measurement` enabled for the first version.
  - Copy the `Measurement ID`, which looks like `G-XXXXXXXXXX`.
- Create or use a Google Cloud project.
- Enable the Google Analytics Data API.
- Create a service account.
- Download the service account JSON credentials.
- Store the credentials securely outside public web paths.
- Add the service account email as a user on the GA4 property with read/viewer access.
- Get the GA4 Property ID. This is the numeric property ID, not the `G-XXXXXXXXXX` Measurement ID.

Where to get each value:

- GA4 Measurement ID:
  - Go to https://analytics.google.com/
  - Open the correct account/property.
  - Go to `Admin`.
  - Go to `Data streams`.
  - Open the website's web stream.
  - Copy the `Measurement ID`, which looks like `G-XXXXXXXXXX`.
- GA4 Property ID:
  - Go to https://analytics.google.com/
  - Open the correct account/property.
  - Go to `Admin`.
  - Go to `Property settings` or `Property details`.
  - Copy the numeric `Property ID`, for example `123456789`.
- Service account JSON credentials:
  - Go to https://console.cloud.google.com/
  - Select or create the Google Cloud project used for analytics access.
  - Go to `APIs & Services` > `Library`.
  - Search for `Google Analytics Data API`.
  - Enable the API.
  - Go to `IAM & Admin` > `Service Accounts`.
  - Create a service account, for example `goan-perfume-analytics-reader`.
  - Open the service account.
  - Go to `Keys`.
  - Choose `Add key` > `Create new key`.
  - Select `JSON`.
  - Download the JSON file.
  - Store it somewhere private, for example `storage/app/analytics/service-account-credentials.json`.
  - Do not commit this file to Git.
- GA4 property access for the service account:
  - Open https://analytics.google.com/
  - Go to `Admin`.
  - Go to `Property access management`.
  - Add a user.
  - Use the `client_email` value from the downloaded service account JSON file.
  - Give it `Viewer` or `Analyst` access.

Environment variables:

```env
VITE_GOOGLE_ANALYTICS_MEASUREMENT_ID=G-XXXXXXXXXX
ANALYTICS_PROPERTY_ID=123456789
```

If the dashboard is implemented with `spatie/laravel-analytics`, use `ANALYTICS_PROPERTY_ID` for the numeric GA4 Property ID to match the package config. Do not duplicate the same value in `GOOGLE_ANALYTICS_PROPERTY_ID` unless custom code intentionally needs a separate config key.

Do not commit the credentials JSON file to Git.

Sources:

- Google Analytics: https://analytics.google.com/
- Google Cloud Console: https://console.cloud.google.com/
- Google Analytics Data API quickstart: https://developers.google.com/analytics/devguides/reporting/data/v1/quickstart
- Spatie package credential guide: https://github.com/spatie/laravel-analytics

## Laravel Package Recommendation

Status: recommended for dashboard reporting.

Why: The project needs to read Google Analytics reports in Laravel. Using a maintained package avoids writing all GA4 Data API request plumbing manually.

Recommended package:

- `spatie/laravel-analytics`

What it does:

- Reads Google Analytics 4 data from Laravel.
- Provides methods for common reports such as visitors/page views, most visited pages, referrers, browsers, countries, and operating systems.
- Returns Laravel collections that can be passed to Inertia dashboard pages.
- Supports custom GA4 Data API queries when the built-in helpers are not enough.
- Provides a fake facade for tests.

Compatibility:

- Current Packagist metadata for `spatie/laravel-analytics` shows support for PHP `^8.3` and Laravel `^12.40.1|^13.0`, so it fits this project stack.

Install later, after approval to add a dependency:

```bash
composer require spatie/laravel-analytics
php artisan vendor:publish --tag="analytics-config"
```

Default package config expects:

```env
ANALYTICS_PROPERTY_ID=123456789
```

And a credentials file at:

```txt
storage/app/analytics/service-account-credentials.json
```

Important:

- This package is for reading analytics reports in the Laravel dashboard.
- It does not replace the public GA4 tracking script.
- It does not provide a cookie banner or consent manager.
- It does not automatically track Inertia SPA navigation.
- The public tracking and consent work still needs custom frontend implementation.

Alternative:

- Use Google's official PHP client package directly: `google/analytics-data`.
- Choose this only if the dashboard needs highly custom GA4 queries that are awkward through Spatie's helper methods.
- For this project, start with `spatie/laravel-analytics` and drop down to custom queries only where needed.

Sources:

- Spatie Laravel Analytics: https://github.com/spatie/laravel-analytics
- Packagist package metadata: https://packagist.org/packages/spatie/laravel-analytics
- Google Analytics Data API PHP quickstart: https://developers.google.com/analytics/devguides/reporting/data/v1/quickstart

## Laravel Implementation Shape

Status: recommended technical plan.

Why: Keeping analytics access behind a service class makes it easier to test, cache, and handle API failures.

Implement:

- Add `spatie/laravel-analytics` after dependency approval.
- Publish the package config.
- Store the service account credentials JSON in `storage/app/analytics/`.
- Add a backend service wrapper, for example:
  - `App\Services\GoogleAnalyticsService`
- The service should call the Spatie analytics facade, and use custom GA4 Data API calls only when the package helpers are not enough.
- Add a dashboard controller, for example:
  - `App\Http\Controllers\Dashboard\AnalyticsController`
- Add a protected dashboard route:
  - `GET /dashboard/analytics`
- Add an Inertia React dashboard page:
  - `resources/js/pages/dashboard/analytics.tsx`
- Add a dashboard navigation item.
- Cache API responses.
- Show a helpful empty/error state if credentials are missing or Google API is unavailable.

Recommended cache durations:

- Realtime users: 1-5 minutes.
- Main dashboard summary: 15-60 minutes.
- Top pages/source/country reports: 30-60 minutes.

Source:

- Google Analytics Data API quotas: https://developers.google.com/analytics/devguides/reporting/data/v1/quotas

## Suggested First Dashboard Version

Status: practical first milestone.

Why: Start with the data the shop owner will actually check often.

Implement first:

- Total users, sessions, and page views for the selected date range.
- Top 10 pages.
- Top 10 product pages.
- Top 5 traffic sources.
- Top 5 countries.
- Device split: desktop, mobile, tablet.
- Realtime active users.

Leave for later:

- Ecommerce revenue, because the current site does not have online checkout.
- Purchase events.
- Cart events.
- Checkout funnel.
- Customer lifetime value.

## Future Events If Online Selling Is Added

Status: only needed when the website includes cart/checkout/payment.

Why: Ecommerce tracking should match actual ecommerce behavior. The current project is a showcase/contact site, so ecommerce analytics would be misleading now.

Implement later:

- `view_item`
- `add_to_cart`
- `begin_checkout`
- `add_shipping_info`
- `add_payment_info`
- `purchase`
- `refund`

Only add these when the matching website features exist.

## Important Notes

- The GA4 Measurement ID is used on the frontend to collect analytics.
- The GA4 Property ID is used on the backend to read reports.
- The dashboard should not expose Google credentials to the browser.
- The dashboard should read reports through Laravel, not directly from React.
- API responses should be cached to avoid quota issues and slow dashboard loads.
- Analytics data can be delayed or sampled/modelled depending on GA4 settings, consent behavior, and report type.
- The numbers shown in the dashboard should be treated as traffic indicators, not accounting-grade records.
