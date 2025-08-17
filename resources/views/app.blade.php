<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    @class(['dark' => ($appearance ?? 'system') === 'dark'])
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- WICHTIG: CSRF-Token für Ajax/SPA --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- System-Darkmode vor FOUC anwenden --}}
    <script>
        (function () {
            const appearance = @json($appearance ?? 'system');
            if (appearance === 'system') {
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                if (prefersDark) {
                    document.documentElement.classList.add('dark');
                }
            } else if (appearance === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

    {{-- Hintergrund passend zu den CSS-Tokens (FOUC vermeiden) --}}
    <style>
        html { background-color: oklch(1 0 0); }
        html.dark { background-color: oklch(0.145 0 0); }
    </style>

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    {{-- Ziggy Routen ins Frontend --}}
    @routes

    {{-- Inertia Head (SEO, title, meta aus Vue) --}}
    @inertiaHead

    {{-- Vite-Bundle (CSS wird in app.ts importiert) --}}
    @vite(['resources/js/app.ts'])
</head>
<body class="font-sans antialiased">
    @inertia
</body>
</html>
