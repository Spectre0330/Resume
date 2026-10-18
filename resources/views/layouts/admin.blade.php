<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex">

        <title>{{ $title ?? 'Admin' }} · {{ config('app.name') }}</title>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">

        <x-theme-head />

        @fonts

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="min-h-screen bg-canvas font-sans text-ink antialiased">
        <header class="border-b border-line">
            <div class="mx-auto flex max-w-5xl flex-wrap items-center gap-x-6 gap-y-2 px-4 py-3 font-mono text-xs sm:px-6">
                <a href="{{ auth()->check() ? route('admin.dashboard') : route('home') }}" class="font-bold text-accent">~/admin</a>

                @auth
                    <nav aria-label="Admin" class="flex grow flex-wrap gap-x-4 gap-y-1 text-muted">
                        @foreach ([
                            'admin.profile' => 'profile',
                            'admin.experiences' => 'experience',
                            'admin.projects' => 'projects',
                            'admin.skill-groups' => 'skills',
                            'admin.education' => 'education',
                            'admin.messages' => 'messages',
                        ] as $routeName => $label)
                            <a href="{{ route($routeName) }}" wire:navigate @class(['hover:text-accent', 'text-accent' => request()->routeIs($routeName)])>{{ $label }}</a>
                        @endforeach
                    </nav>
                @endauth

                <div class="ml-auto flex items-center gap-3">
                    <a href="{{ route('home') }}" class="text-muted hover:text-accent" target="_blank">view site ↗</a>
                    <x-theme-toggle />
                    @auth
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit" class="text-muted hover:text-danger">logout</button>
                        </form>
                    @endauth
                </div>
            </div>
        </header>

        <main class="mx-auto max-w-5xl px-4 py-8 sm:px-6">
            @if (session('status'))
                <p role="status" class="mb-6 rounded border border-accent/50 bg-surface px-4 py-2 font-mono text-sm text-accent">✓ {{ session('status') }}</p>
            @endif

            {{ $slot }}
        </main>

        @livewireScripts
    </body>
</html>
