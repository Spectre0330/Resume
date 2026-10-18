<?php

use App\Models\ContactMessage;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

new #[Layout('layouts::admin')] #[Title('Messages')] class extends Component
{
    use WithPagination;

    /**
     * @return LengthAwarePaginator<int, ContactMessage>
     */
    #[Computed]
    public function messages(): LengthAwarePaginator
    {
        return ContactMessage::query()->latest()->paginate(15);
    }

    public function toggleRead(int $id): void
    {
        $message = ContactMessage::query()->findOrFail($id);

        $message->update(['read_at' => $message->read_at ? null : now()]);
    }

    public function delete(int $id): void
    {
        ContactMessage::query()->findOrFail($id)->delete();

        session()->flash('status', 'Message deleted.');
    }
};
?>

<div>
    <x-admin.page-header title="messages" />

    @if ($this->messages->isEmpty())
        <p class="rounded border border-dashed border-line p-6 text-center font-mono text-sm text-muted">Inbox zero. No messages yet.</p>
    @else
        <ul class="flex flex-col gap-3">
            @foreach ($this->messages as $message)
                <li wire:key="message-{{ $message->id }}" @class([
                    'rounded-lg border bg-surface p-4',
                    'border-accent/60' => ! $message->read_at,
                    'border-line opacity-80' => $message->read_at,
                ])>
                    <div class="flex flex-wrap items-baseline justify-between gap-2">
                        <p class="font-medium">
                            @unless ($message->read_at)
                                <span class="font-mono text-xs text-accent">● new</span>
                            @endunless
                            {{ $message->name }}
                            <a href="mailto:{{ $message->email }}" class="font-mono text-xs text-muted hover:text-accent">&lt;{{ $message->email }}&gt;</a>
                        </p>
                        <time datetime="{{ $message->created_at->toIso8601String() }}" class="font-mono text-xs text-date">{{ $message->created_at->diffForHumans() }}</time>
                    </div>
                    <p class="mt-2 text-sm leading-relaxed whitespace-pre-line">{{ $message->message }}</p>
                    <div class="mt-3 flex gap-2">
                        <x-form.button variant="secondary" wire:click="toggleRead({{ $message->id }})" class="px-2.5! py-1! text-xs!">
                            {{ $message->read_at ? 'mark unread' : 'mark read' }}
                        </x-form.button>
                        <x-form.button variant="danger" wire:click="delete({{ $message->id }})" wire:confirm="Delete this message?" class="px-2.5! py-1! text-xs!">delete</x-form.button>
                    </div>
                </li>
            @endforeach
        </ul>

        <div class="mt-6">
            {{ $this->messages->links() }}
        </div>
    @endif
</div>
