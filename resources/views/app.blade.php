<!DOCTYPE html>
@php
    $component = $page['component'] ?? '';
    $isPublicPage = str_starts_with($component, 'public/');
    $canonical = $page['props']['meta']['canonical'] ?? null;
    $robots = $page['props']['meta']['robots'] ?? null;
    $preloadImageUrl = $page['props']['meta']['preload_image_url'] ?? null;
    $alternates = $page['props']['meta']['alternates'] ?? [];
    $structuredData = $page['props']['meta']['structured_data'] ?? [];
    $pageLocale = $page['props']['locale']['current'] ?? app()->getLocale();
    $fontAliases = $isPublicPage
        ? ($pageLocale === 'ar' ? ['fraunces', 'manrope', 'noto-kufi-arabic'] : ['fraunces', 'manrope'])
        : ['instrument-sans', 'fraunces', 'manrope', 'noto-kufi-arabic'];
@endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @class(['dark' => ($appearance ?? 'system') == 'dark'])>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{-- Inline script to detect system dark mode preference and apply it immediately --}}
        <script>
            (function() {
                const appearance = '{{ $appearance ?? "system" }}';

                if (appearance === 'system') {
                    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

                    if (prefersDark) {
                        document.documentElement.classList.add('dark');
                    }
                }
            })();
        </script>

        {{-- Inline style to set the HTML background color based on our theme in app.css --}}
        <style>
            html {
                background-color: oklch(1 0 0);
            }

            html.dark {
                background-color: oklch(0.145 0 0);
            }
        </style>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        @fonts($fontAliases)

        @viteReactRefresh
        @vite(['resources/css/app.css', 'resources/js/app.tsx', "resources/js/pages/{$page['component']}.tsx"])
        <x-inertia::head>
            <title>{{ config('app.name', 'Goan Perfume') }}</title>
            @if ($isPublicPage && $canonical)
                <link data-inertia="canonical" rel="canonical" href="{{ $canonical }}">
            @endif
            @if ($isPublicPage && $preloadImageUrl)
                <link data-inertia="preload-image" rel="preload" as="image" href="{{ $preloadImageUrl }}" fetchpriority="high">
            @endif
            @if ($isPublicPage && $robots)
                <meta data-inertia="robots" name="robots" content="{{ $robots }}">
            @endif
            @if ($isPublicPage)
                @foreach ($alternates as $hrefLang => $href)
                    <link data-inertia="alternate-{{ $hrefLang }}" rel="alternate" hreflang="{{ $hrefLang }}" href="{{ $href }}">
                @endforeach
                @foreach ($structuredData as $index => $item)
                    <script data-inertia="structured-data-{{ $index }}" type="application/ld+json">{!! json_encode($item, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>
                @endforeach
            @endif
            @unless ($isPublicPage)
                <meta name="robots" content="noindex, nofollow">
            @endunless
        </x-inertia::head>
    </head>
    <body class="font-sans antialiased">
        <x-inertia::app />
    </body>
</html>
