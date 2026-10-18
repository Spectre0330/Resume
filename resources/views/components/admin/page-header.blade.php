@props(['title'])

<div class="mb-6 flex flex-wrap items-center justify-between gap-4">
    <h1 class="font-mono text-xl font-bold"><span class="text-accent">#</span> {{ $title }}</h1>
    {{ $slot }}
</div>
