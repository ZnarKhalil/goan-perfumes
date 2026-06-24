import { router } from '@inertiajs/react';

declare global {
    interface Window {
        dataLayer?: unknown[];
        gtag?: (...args: unknown[]) => void;
        [key: `ga-disable-${string}`]: boolean | undefined;
    }
}

const measurementId = import.meta.env.VITE_GOOGLE_ANALYTICS_MEASUREMENT_ID;
const scriptId = 'google-analytics-gtag';

let isInitialized = false;
let removeNavigateListener: (() => void) | null = null;

export function initializeGoogleAnalytics(): void {
    if (!measurementId || isInitialized || typeof window === 'undefined') {
        return;
    }

    window[`ga-disable-${measurementId}`] = false;
    window.dataLayer = window.dataLayer ?? [];
    // gtag.js only executes dataLayer entries that are `arguments` objects as
    // commands; a plain array is silently ignored, so the config/page_view hits
    // would never be sent. Push `arguments` itself, exactly like the official stub.
    window.gtag = function gtag() {
        // eslint-disable-next-line prefer-rest-params
        window.dataLayer?.push(arguments);
    };

    window.gtag('js', new Date());
    window.gtag('config', measurementId, {
        page_location: window.location.href,
        page_path: window.location.pathname + window.location.search,
        send_page_view: true,
    });

    if (!document.getElementById(scriptId)) {
        const script = document.createElement('script');
        script.id = scriptId;
        script.async = true;
        script.src = `https://www.googletagmanager.com/gtag/js?id=${measurementId}`;
        document.head.appendChild(script);
    }

    removeNavigateListener = router.on('navigate', (event) => {
        const url = new URL(event.detail.page.url, window.location.origin);

        trackPageView(url);
    });

    isInitialized = true;
}

export function disableGoogleAnalytics(): void {
    if (measurementId && typeof window !== 'undefined') {
        window[`ga-disable-${measurementId}`] = true;
    }

    removeNavigateListener?.();
    removeNavigateListener = null;
    isInitialized = false;

    if (typeof document !== 'undefined') {
        document.getElementById(scriptId)?.remove();
        deleteCookie('_ga');
        deleteCookie(`_ga_${measurementId.replace('G-', '')}`);
    }
}

function trackPageView(url: URL): void {
    if (!measurementId || !window.gtag) {
        return;
    }

    window.gtag('event', 'page_view', {
        page_location: url.href,
        page_path: url.pathname + url.search,
        page_title: document.title,
    });
}

function deleteCookie(name: string): void {
    const expires = 'Thu, 01 Jan 1970 00:00:00 GMT';
    const hostnameParts = window.location.hostname.split('.');
    const domains = [
        window.location.hostname,
        hostnameParts.length > 1 ? `.${hostnameParts.slice(-2).join('.')}` : '',
    ].filter(Boolean);

    document.cookie = `${name}=; expires=${expires}; path=/`;

    domains.forEach((domain) => {
        document.cookie = `${name}=; expires=${expires}; path=/; domain=${domain}`;
    });
}
