<?php

use App\Mail\NewContactMessage;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;

beforeEach(function () {
    Mail::fake();
    config(['app.admin.email' => 'owner@example.com']);
});

it('stores the message and emails the site owner', function () {
    Livewire::test('contact-form')
        ->set('name', 'Grace Hopper')
        ->set('email', 'grace@example.com')
        ->set('message', 'I would love to talk about a role on our team.')
        ->call('send')
        ->assertHasNoErrors()
        ->assertSet('sent', true)
        ->assertSee('message delivered');

    $this->assertDatabaseHas('contact_messages', [
        'name' => 'Grace Hopper',
        'email' => 'grace@example.com',
        'read_at' => null,
    ]);
    Mail::assertSent(NewContactMessage::class, fn (NewContactMessage $mail): bool => $mail->hasTo('owner@example.com')
        && $mail->hasReplyTo('grace@example.com'));
});

it('rejects an empty submission', function () {
    Livewire::test('contact-form')
        ->call('send')
        ->assertHasErrors(['name' => 'required', 'email' => 'required', 'message' => 'required']);

    expect(ContactMessage::query()->count())->toBe(0);
    Mail::assertNothingSent();
});

it('rejects an invalid email address', function () {
    Livewire::test('contact-form')
        ->set('name', 'Grace Hopper')
        ->set('email', 'not-an-email')
        ->set('message', 'I would love to talk about a role on our team.')
        ->call('send')
        ->assertHasErrors(['email' => 'email']);

    expect(ContactMessage::query()->count())->toBe(0);
});

it('rejects a message that is too short', function () {
    Livewire::test('contact-form')
        ->set('name', 'Grace Hopper')
        ->set('email', 'grace@example.com')
        ->set('message', 'hi')
        ->call('send')
        ->assertHasErrors(['message' => 'min']);
});

it('silently discards submissions that fill the honeypot', function () {
    Livewire::test('contact-form')
        ->set('name', 'Spam Bot')
        ->set('email', 'bot@example.com')
        ->set('message', 'Buy cheap followers today, limited offer!')
        ->set('website', 'https://spam.example.com')
        ->call('send')
        ->assertSet('sent', true);

    expect(ContactMessage::query()->count())->toBe(0);
    Mail::assertNothingSent();
});

it('limits each visitor to three messages per hour', function () {
    $component = Livewire::test('contact-form');

    foreach (range(1, 3) as $attempt) {
        $component->set('name', 'Grace Hopper')
            ->set('email', 'grace@example.com')
            ->set('message', "Follow-up message number {$attempt}.")
            ->call('send')
            ->assertHasNoErrors();
    }

    $component->set('name', 'Grace Hopper')
        ->set('email', 'grace@example.com')
        ->set('message', 'One message too many for this hour.')
        ->call('send')
        ->assertHasErrors('message');

    expect(ContactMessage::query()->count())->toBe(3);
    Mail::assertSentCount(3);
});
