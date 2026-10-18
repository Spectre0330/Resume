@props(['groups'])

<div class="grid gap-6 font-mono text-sm sm:grid-cols-2">
    @foreach ($groups as $group)
        <div wire:key="skill-group-{{ $group->id }}">
            <h3 class="text-date">{{ $group->name }}/</h3>
            <ul class="mt-1 leading-7">
                @foreach ($group->skills as $skill)
                    <li class="flex">
                        <span class="whitespace-pre text-muted" aria-hidden="true">{{ $loop->last ? '└── ' : '├── ' }}</span>
                        <span>{{ $skill }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach
</div>
