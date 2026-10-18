<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $title ?? config('app.name') }}</title>
        <meta name="description" content="{{ $description ?? 'Resume and portfolio of '.config('app.name').'.' }}">

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        <x-theme-head />

        @fonts

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="min-h-screen bg-canvas font-sans text-ink antialiased selection:bg-accent selection:text-accent-ink">
        <a href="#main" class="sr-only focus:not-sr-only focus:fixed focus:top-2 focus:left-2 focus:z-50 focus:rounded focus:bg-accent focus:px-3 focus:py-2 focus:text-accent-ink">
            Skip to content
        </a>

        <header class="sticky top-0 z-40 border-b border-line bg-canvas/85 backdrop-blur">
            <nav aria-label="Primary" class="mx-auto flex max-w-3xl items-center gap-4 px-4 py-2.5 font-mono text-xs sm:px-6">
                <a href="{{ route('home') }}#top" class="shrink-0 font-bold text-accent">~/{{ str(config('app.name'))->lower()->replace(' ', '-') }}</a>

                <ul class="flex min-w-0 grow gap-4 overflow-x-auto text-muted [scrollbar-width:none]">
                    @foreach (['experience', 'projects', 'skills', 'education', 'contact'] as $section)
                        <li><a href="{{ route('home') }}#{{ $section }}" class="whitespace-nowrap transition hover:text-accent">{{ $section }}</a></li>
                    @endforeach
                </ul>

                <x-theme-toggle class="shrink-0" />
            </nav>
        </header>

        <main id="main" class="mx-auto max-w-3xl px-4 sm:px-6">
            {{ $slot }}
        </main>

        <footer class="mx-auto max-w-3xl px-4 py-10 font-mono text-xs text-muted sm:px-6">
            <p>
                <span class="text-accent">$</span> echo "© {{ now()->year }} {{ config('app.name') }} — built with Laravel, Livewire &amp; Tailwind"
            </p>
        </footer>

        @livewireScripts
    </body>
</html>
