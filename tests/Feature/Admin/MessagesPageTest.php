<?php

use App\Models\ContactMessage;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

it('lists contact messages', function () {
    ContactMessage::factory()->create(['name' => 'Grace Hopper']);

    $response = $this->get(route('admin.messages'));

    $response->assertOk()->assertSee('Grace Hopper');
});

it('marks a message as read and back to unread', function () {
    $message = ContactMessage::factory()->create();

    $component = Livewire::test('pages::admin.messages')->call('toggleRead', $message->id);

    expect($message->fresh()->read_at)->not->toBeNull();

    $component->call('toggleRead', $message->id);

    expect($message->fresh()->read_at)->toBeNull();
});

it('deletes a message', function () {
    $message = ContactMessage::factory()->create();

    Livewire::test('pages::admin.messages')->call('delete', $message->id);

    $this->assertModelMissing($message);
});

it('shows the unread count on the dashboard', function () {
    ContactMessage::factory()->count(2)->create();
    ContactMessage::factory()->read()->create();

    $response = $this->get(route('admin.dashboard'));

    $response->assertOk()->assertSee('2 unread');
});
