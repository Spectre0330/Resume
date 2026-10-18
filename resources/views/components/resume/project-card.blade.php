@props(['project'])

<article {{ $attributes->class('flex flex-col overflow-hidden rounded-lg border border-line bg-surface transition hover:border-accent/60') }}>
    <div class="flex items-center gap-1.5 border-b border-line px-3 py-2" aria-hidden="true">
        <span class="size-2.5 rounded-full bg-[#ff5f57]/80"></span>
        <span class="size-2.5 rounded-full bg-[#febc2e]/80"></span>
        <span class="size-2.5 rounded-full bg-[#28c840]/80"></span>
        <span class="ml-2 truncate font-mono text-xs text-muted">~/projects/{{ str($project->title)->slug() }}</span>
    </div>

    <div class="flex grow flex-col gap-3 p-4">
        <h3 class="font-semibold">{{ $project->title }}</h3>
        <p class="text-sm leading-relaxed text-muted">{{ $project->description }}</p>

        <ul class="flex flex-wrap gap-x-2 gap-y-1 font-mono text-xs text-accent" aria-label="Technologies">
            @foreach ($project->tech as $tech)
                <li>[{{ $tech }}]</li>
            @endforeach
        </ul>

        @if ($project->repo_url || $project->live_url)
            <div class="mt-auto flex gap-4 pt-1 font-mono text-xs">
                @if ($project->repo_url)
                    <a href="{{ $project->repo_url }}" target="_blank" rel="noopener noreferrer" class="text-ink underline decoration-line underline-offset-4 hover:text-accent hover:decoration-accent">
                        source<span class="sr-only"> code for {{ $project->title }} (opens in a new tab)</span> ↗
                    </a>
                @endif
                @if ($project->live_url)
                    <a href="{{ $project->live_url }}" target="_blank" rel="noopener noreferrer" class="text-ink underline decoration-line underline-offset-4 hover:text-accent hover:decoration-accent">
                        live<span class="sr-only"> demo of {{ $project->title }} (opens in a new tab)</span> ↗
                    </a>
                @endif
            </div>
        @endif
    </div>
</article>
