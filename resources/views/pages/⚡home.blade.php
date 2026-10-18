<?php

use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\SkillGroup;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
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

<div id="top" class="flex flex-col gap-20 pt-14 pb-10 sm:pt-20">
    @if ($this->profile)
        <x-resume.hero :profile="$this->profile" />
    @endif

    @if ($this->experiences->isNotEmpty())
        <section id="experience" aria-labelledby="experience-heading">
            <x-resume.heading id="experience-heading" command="git log --experience">Experience</x-resume.heading>
            <x-resume.experience-log :experiences="$this->experiences" />
        </section>
    @endif

    @if ($this->projects->isNotEmpty())
        <section id="projects" aria-labelledby="projects-heading">
            <x-resume.heading id="projects-heading" command="ls ~/projects">Projects</x-resume.heading>
            <div class="grid gap-4 sm:grid-cols-2">
                @foreach ($this->projects as $project)
                    <x-resume.project-card :project="$project" wire:key="project-{{ $project->id }}" />
                @endforeach
            </div>
        </section>
    @endif

    @if ($this->skillGroups->isNotEmpty())
        <section id="skills" aria-labelledby="skills-heading">
            <x-resume.heading id="skills-heading" command="tree ~/skills">Skills</x-resume.heading>
            <x-resume.skill-tree :groups="$this->skillGroups" />
        </section>
    @endif

    @if ($this->educations->isNotEmpty())
        <section id="education" aria-labelledby="education-heading">
            <x-resume.heading id="education-heading" command="cat education.md">Education</x-resume.heading>
            <ul class="flex flex-col gap-6">
                @foreach ($this->educations as $education)
                    <li wire:key="education-{{ $education->id }}" class="rounded-lg border border-line bg-surface p-5">
                        <div class="flex flex-wrap items-baseline justify-between gap-x-4 gap-y-1">
                            <h3 class="font-semibold">{{ $education->institution }}</h3>
                            <p class="font-mono text-xs text-date">{{ $education->period() }}</p>
                        </div>
                        <p class="text-sm text-muted">{{ $education->credential }}</p>
                        @foreach ($education->details as $detail)
                            <p class="mt-3 text-sm leading-relaxed">{{ $detail }}</p>
                        @endforeach
                    </li>
                @endforeach
            </ul>
        </section>
    @endif

    <section id="contact" aria-labelledby="contact-heading">
        <x-resume.heading id="contact-heading" command="./contact.sh">Get in touch</x-resume.heading>
        <livewire:contact-form />
    </section>
</div>
