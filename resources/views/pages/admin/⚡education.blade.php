<?php

use App\Livewire\SortableRecordsPage;
use App\Models\Education;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

new #[Layout('layouts::admin')] #[Title('Education')] class extends SortableRecordsPage
{
    public string $institution = '';

    public string $credential = '';

    public string $startedOn = '';

    public string $endedOn = '';

    /**
     * Detail lines (coursework, honors), one per line.
     */
    public string $details = '';

    /**
     * @return Collection<int, Education>
     */
    #[Computed]
    public function educations(): Collection
    {
        return Education::query()->ordered()->get();
    }

    protected function modelClass(): string
    {
        return Education::class;
    }

    protected function fillForm(Model $record): void
    {
        /** @var Education $record */
        $this->institution = $record->institution;
        $this->credential = $record->credential;
        $this->startedOn = $record->started_on->format('Y-m-d');
        $this->endedOn = $record->ended_on?->format('Y-m-d') ?? '';
        $this->details = implode("\n", $record->details);
    }

    protected function validatedAttributes(): array
    {
        $validated = $this->validate([
            'institution' => 'required|string|max:150',
            'credential' => 'required|string|max:150',
            'startedOn' => 'required|date',
            'endedOn' => 'nullable|date|after_or_equal:startedOn',
            'details' => 'nullable|string|max:3000',
        ]);

        return [
            'institution' => $validated['institution'],
            'credential' => $validated['credential'],
            'started_on' => $validated['startedOn'],
            'ended_on' => $validated['endedOn'] ?: null,
            'details' => $this->lines($validated['details'] ?? ''),
        ];
    }
};
?>

<div>
    <x-admin.page-header title="education">
        @unless ($showForm)
            <x-form.button wire:click="create">+ new entry</x-form.button>
        @endunless
    </x-admin.page-header>

    @if ($showForm)
        <x-admin.record-form :editing="(bool) $editingId">
            <div class="grid gap-4 sm:grid-cols-2">
                <x-form.field label="institution" for="institution" :error="$errors->first('institution')">
                    <x-form.input id="institution" wire:model="institution" required />
                </x-form.field>
                <x-form.field label="credential" for="credential" :error="$errors->first('credential')">
                    <x-form.input id="credential" wire:model="credential" required />
                </x-form.field>
                <x-form.field label="started on" for="started-on" :error="$errors->first('startedOn')">
                    <x-form.input id="started-on" type="date" wire:model="startedOn" required />
                </x-form.field>
                <x-form.field label="ended on" for="ended-on" :error="$errors->first('endedOn')" hint="Leave empty if in progress">
                    <x-form.input id="ended-on" type="date" wire:model="endedOn" />
                </x-form.field>
            </div>
            <x-form.field label="details" for="details" :error="$errors->first('details')" hint="One line each, e.g. coursework or honors">
                <x-form.textarea id="details" wire:model="details" rows="4" />
            </x-form.field>
        </x-admin.record-form>
    @endif

    <x-admin.sortable-list empty="No education entries yet.">
        @foreach ($this->educations as $education)
            <x-admin.sortable-row :id="$education->id" :title="$education->institution" :subtitle="$education->credential.' · '.$education->period()" />
        @endforeach
    </x-admin.sortable-list>
</div>
