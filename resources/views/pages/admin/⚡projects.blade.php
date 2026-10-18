<?php

use App\Livewire\SortableRecordsPage;
use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

new #[Layout('layouts::admin')] #[Title('Projects')] class extends SortableRecordsPage
{
    public string $projectTitle = '';

    public string $description = '';

    /**
     * Technologies, comma separated.
     */
    public string $tech = '';

    public string $repoUrl = '';

    public string $liveUrl = '';

    public bool $isFeatured = true;

    /**
     * @return Collection<int, Project>
     */
    #[Computed]
    public function projects(): Collection
    {
        return Project::query()->ordered()->get();
    }

    protected function modelClass(): string
    {
        return Project::class;
    }

    protected function fillForm(Model $record): void
    {
        /** @var Project $record */
        $this->projectTitle = $record->title;
        $this->description = $record->description;
        $this->tech = implode(', ', $record->tech);
        $this->repoUrl = $record->repo_url ?? '';
        $this->liveUrl = $record->live_url ?? '';
        $this->isFeatured = $record->is_featured;
    }

    protected function validatedAttributes(): array
    {
        $validated = $this->validate([
            'projectTitle' => 'required|string|max:150',
            'description' => 'required|string|max:1000',
            'tech' => 'required|string|max:500',
            'repoUrl' => 'nullable|url:https|max:255',
            'liveUrl' => 'nullable|url:https|max:255',
            'isFeatured' => 'boolean',
        ]);

        return [
            'title' => $validated['projectTitle'],
            'description' => $validated['description'],
            'tech' => str($validated['tech'])->explode(',')->map(fn (string $item): string => trim($item))->filter()->values()->all(),
            'repo_url' => $validated['repoUrl'] ?: null,
            'live_url' => $validated['liveUrl'] ?: null,
            'is_featured' => $validated['isFeatured'],
        ];
    }
};
?>

<div>
    <x-admin.page-header title="projects">
        @unless ($showForm)
            <x-form.button wire:click="create">+ new project</x-form.button>
        @endunless
    </x-admin.page-header>

    @if ($showForm)
        <x-admin.record-form :editing="(bool) $editingId">
            <x-form.field label="title" for="project-title" :error="$errors->first('projectTitle')">
                <x-form.input id="project-title" wire:model="projectTitle" required />
            </x-form.field>
            <x-form.field label="description" for="description" :error="$errors->first('description')">
                <x-form.textarea id="description" wire:model="description" rows="3" required />
            </x-form.field>
            <x-form.field label="tech" for="tech" :error="$errors->first('tech')" hint="Comma separated, e.g. Laravel, Livewire, Pest">
                <x-form.input id="tech" wire:model="tech" required />
            </x-form.field>
            <div class="grid gap-4 sm:grid-cols-2">
                <x-form.field label="repo url" for="repo-url" :error="$errors->first('repoUrl')">
                    <x-form.input id="repo-url" type="url" wire:model="repoUrl" />
                </x-form.field>
                <x-form.field label="live url" for="live-url" :error="$errors->first('liveUrl')">
                    <x-form.input id="live-url" type="url" wire:model="liveUrl" />
                </x-form.field>
            </div>
            <label class="flex items-center gap-2 font-mono text-xs text-muted">
                <input type="checkbox" wire:model="isFeatured" class="accent-accent"> show on public site
            </label>
        </x-admin.record-form>
    @endif

    <x-admin.sortable-list empty="No projects yet.">
        @foreach ($this->projects as $project)
            <x-admin.sortable-row :id="$project->id" :title="$project->title" :subtitle="implode(', ', $project->tech).($project->is_featured ? '' : ' · hidden')" />
        @endforeach
    </x-admin.sortable-list>
</div>
