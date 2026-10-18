<?php

namespace App\Livewire;

use App\Models\Contracts\HasSortOrder;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

/**
 * Base for admin pages that edit an ordered resume section.
 */
abstract class SortableRecordsPage extends Component
{
    /**
     * The id of the record being edited, or null when creating a new one.
     */
    public ?int $editingId = null;

    /**
     * Whether the create/edit form is visible.
     */
    public bool $showForm = false;

    /**
     * The sortable Eloquent model this page manages.
     *
     * @return class-string<Model&HasSortOrder>
     */
    abstract protected function modelClass(): string;

    /**
     * Fill the form properties from an existing record.
     */
    abstract protected function fillForm(Model $record): void;

    /**
     * Validate the form and return attributes ready to persist.
     *
     * @return array<string, mixed>
     */
    abstract protected function validatedAttributes(): array;

    public function create(): void
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        $this->resetForm();
        $this->fillForm($this->modelClass()::query()->findOrFail($id));
        $this->editingId = $id;
        $this->showForm = true;
    }

    public function save(): void
    {
        $attributes = $this->validatedAttributes();

        if ($this->editingId) {
            $this->modelClass()::query()->findOrFail($this->editingId)->update($attributes);
        } else {
            $this->modelClass()::query()->create($attributes);
        }

        $this->resetForm();
        session()->flash('status', 'Saved.');
    }

    public function delete(int $id): void
    {
        $this->modelClass()::query()->findOrFail($id)->delete();

        if ($this->editingId === $id) {
            $this->resetForm();
        }

        session()->flash('status', 'Deleted.');
    }

    public function sort(int|string $id, int $position): void
    {
        $this->modelClass()::moveTo((int) $id, $position);
    }

    public function cancel(): void
    {
        $this->resetForm();
    }

    protected function resetForm(): void
    {
        $this->resetExcept([]);
        $this->resetValidation();
    }

    /**
     * Split a multi-line textarea value into a clean list of non-empty lines.
     *
     * @return array<int, string>
     */
    protected function lines(string $value): array
    {
        return str($value)->explode("\n")->map(fn (string $line): string => trim($line))->filter()->values()->all();
    }
}
