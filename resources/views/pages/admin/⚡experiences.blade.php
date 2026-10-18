<?php

use App\Livewire\SortableRecordsPage;
use App\Models\Experience;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

new #[Layout('layouts::admin')] #[Title('Experience')] class extends SortableRecordsPage
{
    public string $company = '';

    public string $role = '';

    public string $location = '';

    public string $startedOn = '';

    public string $endedOn = '';

    /**
     * Accomplishments, one per line.
     */
    public string $bullets = '';

    /**
     * @return Collection<int, Experience>
     */
    #[Computed]
    public function experiences(): Collection
    {
        return Experience::query()->ordered()->get();
    }

    protected function modelClass(): string
    {
        return Experience::class;
    }

    protected function fillForm(Model $record): void
    {
        /** @var Experience $record */
        $this->company = $record->company;
        $this->role = $record->role;
        $this->location = $record->location ?? '';
        $this->startedOn = $record->started_on->format('Y-m-d');
        $this->endedOn = $record->ended_on?->format('Y-m-d') ?? '';
        $this->bullets = implode("\n", $record->bullets);
    }

    protected function validatedAttributes(): array
    {
        $validated = $this->validate([
            'company' => 'required|string|max:150',
            'role' => 'required|string|max:150',
            'location' => 'nullable|string|max:100',
            'startedOn' => 'required|date',
            'endedOn' => 'nullable|date|after_or_equal:startedOn',
            'bullets' => 'required|string|max:5000',
        ]);

        return [
            'company' => $validated['company'],
            'role' => $validated['role'],
            'location' => $validated['location'] ?: null,
            'started_on' => $validated['startedOn'],
            'ended_on' => $validated['endedOn'] ?: null,
            'bullets' => $this->lines($validated['bullets']),
        ];
    }
};
?>

<div>
    <x-admin.page-header title="experience">
        @unless ($showForm)
            <x-form.button wire:click="create">+ new role</x-form.button>
        @endunless
    </x-admin.page-header>

    @if ($showForm)
        <x-admin.record-form :editing="(bool) $editingId">
            <div class="grid gap-4 sm:grid-cols-2">
                <x-form.field label="role" for="role" :error="$errors->first('role')">
                    <x-form.input id="role" wire:model="role" required />
                </x-form.field>
                <x-form.field label="company" for="company" :error="$errors->first('company')">
                    <x-form.input id="company" wire:model="company" required />
                </x-form.field>
                <x-form.field label="started on" for="started-on" :error="$errors->first('startedOn')">
                    <x-form.input id="started-on" type="date" wire:model="startedOn" required />
                </x-form.field>
                <x-form.field label="ended on" for="ended-on" :error="$errors->first('endedOn')" hint="Leave empty for a current role">
                    <x-form.input id="ended-on" type="date" wire:model="endedOn" />
                </x-form.field>
            </div>
            <x-form.field label="location" for="location" :error="$errors->first('location')">
                <x-form.input id="location" wire:model="location" />
            </x-form.field>
            <x-form.field label="accomplishments" for="bullets" :error="$errors->first('bullets')" hint="One bullet per line. Lead with the outcome.">
                <x-form.textarea id="bullets" wire:model="bullets" rows="5" required />
            </x-form.field>
        </x-admin.record-form>
    @endif

    <x-admin.sortable-list empty="No roles yet.">
        @foreach ($this->experiences as $experience)
            <x-admin.sortable-row :id="$experience->id" :title="$experience->role.' @ '.$experience->company" :subtitle="$experience->period()" />
        @endforeach
    </x-admin.sortable-list>
</div>
