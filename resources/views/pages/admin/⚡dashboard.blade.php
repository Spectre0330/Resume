<?php

use App\Models\ContactMessage;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Project;
use App\Models\SkillGroup;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts::admin')] #[Title('Dashboard')] class extends Component
{
    /**
     * @return array<int, array{label: string, count: int, route: string}>
     */
    #[Computed]
    public function sections(): array
    {
        return [
            ['label' => 'experience', 'count' => Experience::query()->count(), 'route' => 'admin.experiences'],
            ['label' => 'projects', 'count' => Project::query()->count(), 'route' => 'admin.projects'],
            ['label' => 'skill groups', 'count' => SkillGroup::query()->count(), 'route' => 'admin.skill-groups'],
            ['label' => 'education', 'count' => Education::query()->count(), 'route' => 'admin.education'],
        ];
    }

    #[Computed]
    public function unreadMessageCount(): int
    {
        return ContactMessage::query()->unread()->count();
    }
};
?>

<div>
    <x-admin.page-header title="dashboard" />

    <a href="{{ route('admin.messages') }}" wire:navigate class="mb-6 flex items-center justify-between rounded-lg border border-line bg-surface p-5 hover:border-accent">
        <span class="font-mono text-sm">messages</span>
        <span @class(['font-mono text-sm', 'text-accent' => $this->unreadMessageCount > 0, 'text-muted' => $this->unreadMessageCount === 0])>
            {{ $this->unreadMessageCount }} unread
        </span>
    </a>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($this->sections as $section)
            <a href="{{ route($section['route']) }}" wire:navigate wire:key="{{ $section['route'] }}" class="rounded-lg border border-line bg-surface p-5 hover:border-accent">
                <p class="font-mono text-3xl font-bold text-accent">{{ $section['count'] }}</p>
                <p class="mt-1 font-mono text-xs text-muted">{{ $section['label'] }}</p>
            </a>
        @endforeach
    </div>

    <p class="mt-6 text-sm text-muted">
        Edit your <a href="{{ route('admin.profile') }}" wire:navigate class="text-accent underline underline-offset-4">profile</a> to change your name, headline, bio and links.
    </p>
</div>
