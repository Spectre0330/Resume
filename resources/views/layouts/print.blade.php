<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex">

        <title>{{ $title ?? config('app.name').' — Resume' }}</title>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">

        @fonts

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles

        <style>
            @page {
                size: letter;
                margin: 0.5in 0.6in;
            }
        </style>
    </head>
    <body class="bg-neutral-200 font-sans text-neutral-900 antialiased print:bg-white">
        {{ $slot }}

        @livewireScripts
    </body>
</html>
