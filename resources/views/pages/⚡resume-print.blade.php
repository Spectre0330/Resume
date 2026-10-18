<?php

use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\SkillGroup;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts::print')] class extends Component
{
    #[Computed]
    public function profile(): ?Profile
    {
        return Profile::current();
    }

    /**
     * @return Collection<int, Experience>
     */
    #[Computed]
    public function experiences(): Collection
    {
        return Experience::query()->ordered()->get();
    }

    /**
     * @return Collection<int, Project>
     */
    #[Computed]
    public function projects(): Collection
    {
        return Project::query()->where('is_featured', true)->ordered()->get();
    }

    /**
     * @return Collection<int, SkillGroup>
     */
    #[Computed]
    public function skillGroups(): Collection
    {
        return SkillGroup::query()->ordered()->get();
    }

    /**
     * @return Collection<int, Education>
     */
    #[Computed]
    public function educations(): Collection
    {
        return Education::query()->ordered()->get();
    }
};
?>

<div>
    <div class="sticky top-0 z-10 flex items-center justify-between gap-4 bg-neutral-900 px-4 py-3 font-mono text-sm text-white print:hidden">
        <a href="{{ route('home') }}" class="hover:underline">← back to site</a>
        <button type="button" onclick="window.print()" class="rounded bg-white px-3 py-1.5 text-neutral-900 hover:bg-neutral-200">
            Save as PDF / Print
        </button>
    </div>

    <article class="mx-auto my-8 max-w-[8.5in] bg-white px-[0.6in] py-[0.5in] text-[10.5pt] leading-snug shadow-lg print:my-0 print:max-w-none print:p-0 print:shadow-none">
        @if ($profile = $this->profile)
            <header class="border-b border-neutral-300 pb-3 text-center">
                <h1 class="text-[20pt] font-bold tracking-tight">{{ $profile->name }}</h1>
                <p class="mt-0.5 text-neutral-700">{{ $profile->headline }}</p>
                <p class="mt-1.5 flex flex-wrap justify-center gap-x-3 text-[9.5pt] text-neutral-700">
                    @if ($profile->location)
                        <span>{{ $profile->location }}</span>
                    @endif
                    <a href="mailto:{{ $profile->email }}">{{ $profile->email }}</a>
                    @if ($profile->show_phone && $profile->phone)
                        <span>{{ $profile->phone }}</span>
                    @endif
                    @if ($profile->linkedin_url)
                        <a href="{{ $profile->linkedin_url }}">{{ str($profile->linkedin_url)->after('://')->rtrim('/') }}</a>
                    @endif
                    @if ($profile->github_url)
                        <a href="{{ $profile->github_url }}">{{ str($profile->github_url)->after('://')->rtrim('/') }}</a>
                    @endif
                </p>
            </header>

            <p class="mt-3">{{ $profile->bio }}</p>
        @endif

        @if ($this->experiences->isNotEmpty())
            <x-print.section title="Experience">
                @foreach ($this->experiences as $experience)
                    <div wire:key="experience-{{ $experience->id }}" class="break-inside-avoid">
                        <div class="flex items-baseline justify-between gap-4">
                            <h3 class="font-semibold">{{ $experience->role }}, {{ $experience->company }}</h3>
                            <span class="shrink-0 text-[9.5pt] text-neutral-600">{{ $experience->period() }}</span>
                        </div>
                        <ul class="mt-0.5 list-disc pl-5">
                            @foreach ($experience->bullets as $bullet)
                                <li>{{ $bullet }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </x-print.section>
        @endif

        @if ($this->projects->isNotEmpty())
            <x-print.section title="Projects">
                @foreach ($this->projects as $project)
                    <div wire:key="project-{{ $project->id }}" class="break-inside-avoid">
                        <h3><span class="font-semibold">{{ $project->title }}</span> <span class="text-[9.5pt] text-neutral-600">— {{ implode(', ', $project->tech) }}</span></h3>
                        <p>{{ $project->description }}</p>
                    </div>
                @endforeach
            </x-print.section>
        @endif

        @if ($this->skillGroups->isNotEmpty())
            <x-print.section title="Skills">
                <dl class="grid grid-cols-[auto_1fr] gap-x-3 gap-y-0.5">
                    @foreach ($this->skillGroups as $group)
                        <dt wire:key="skill-group-{{ $group->id }}" class="font-semibold">{{ $group->name }}:</dt>
                        <dd>{{ implode(', ', $group->skills) }}</dd>
                    @endforeach
                </dl>
            </x-print.section>
        @endif

        @if ($this->educations->isNotEmpty())
            <x-print.section title="Education">
                @foreach ($this->educations as $education)
                    <div wire:key="education-{{ $education->id }}" class="break-inside-avoid">
                        <div class="flex items-baseline justify-between gap-4">
                            <h3><span class="font-semibold">{{ $education->institution }}</span> — {{ $education->credential }}</h3>
                            <span class="shrink-0 text-[9.5pt] text-neutral-600">{{ $education->period() }}</span>
                        </div>
                        @foreach ($education->details as $detail)
                            <p class="text-[9.5pt] text-neutral-700">{{ $detail }}</p>
                        @endforeach
                    </div>
                @endforeach
            </x-print.section>
        @endif
    </article>
</div>
