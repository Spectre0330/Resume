<?php

use App\Livewire\SortableRecordsPage;
use App\Models\SkillGroup;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

new #[Layout('layouts::admin')] #[Title('Skills')] class extends SortableRecordsPage
{
    public string $name = '';

    /**
     * Skills, one per line.
     */
    public string $skills = '';

    /**
     * @return Collection<int, SkillGroup>
     */
    #[Computed]
    public function skillGroups(): Collection
    {
        return SkillGroup::query()->ordered()->get();
    }

    protected function modelClass(): string
    {
        return SkillGroup::class;
    }

    protected function fillForm(Model $record): void
    {
        /** @var SkillGroup $record */
        $this->name = $record->name;
        $this->skills = implode("\n", $record->skills);
    }

    protected function validatedAttributes(): array
    {
        $validated = $this->validate([
            'name' => 'required|string|max:100',
            'skills' => 'required|string|max:2000',
        ]);

        return [
            'name' => $validated['name'],
            'skills' => $this->lines($validated['skills']),
        ];
    }
};
?>

<div>
    <x-admin.page-header title="skills">
        @unless ($showForm)
            <x-form.button wire:click="create">+ new group</x-form.button>
        @endunless
    </x-admin.page-header>

    @if ($showForm)
        <x-admin.record-form :editing="(bool) $editingId">
            <x-form.field label="group name" for="name" :error="$errors->first('name')">
                <x-form.input id="name" wire:model="name" required />
            </x-form.field>
            <x-form.field label="skills" for="skills" :error="$errors->first('skills')" hint="One per line">
                <x-form.textarea id="skills" wire:model="skills" rows="6" required />
            </x-form.field>
        </x-admin.record-form>
    @endif

    <x-admin.sortable-list empty="No skill groups yet.">
        @foreach ($this->skillGroups as $group)
            <x-admin.sortable-row :id="$group->id" :title="$group->name" :subtitle="implode(', ', $group->skills)" />
        @endforeach
    </x-admin.sortable-list>
</div>
