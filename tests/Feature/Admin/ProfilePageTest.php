<?php

use App\Models\Profile;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

it('loads the current profile into the form', function () {
    Profile::factory()->create(['name' => 'Ada Lovelace']);

    Livewire::test('pages::admin.profile')
        ->assertSet('name', 'Ada Lovelace');
});

it('saves the profile', function () {
    $profile = Profile::factory()->create();

    Livewire::test('pages::admin.profile')
        ->set('name', 'Brandon Henry')
        ->set('headline', 'Software Developer')
        ->set('showPhone', true)
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route('admin.profile'));

    $profile->refresh();
    expect($profile->name)->toBe('Brandon Henry')
        ->and($profile->show_phone)->toBeTrue();
});

it('creates the profile when none exists', function () {
    Livewire::test('pages::admin.profile')
        ->set('name', 'Brandon Henry')
        ->set('headline', 'Software Developer')
        ->set('bio', 'I build things.')
        ->set('email', 'brandon@example.com')
        ->call('save')
        ->assertHasNoErrors();

    expect(Profile::current()?->name)->toBe('Brandon Henry');
});

it('requires the core profile fields', function () {
    Livewire::test('pages::admin.profile')
        ->call('save')
        ->assertHasErrors(['name' => 'required', 'headline' => 'required', 'bio' => 'required', 'email' => 'required']);

    expect(Profile::query()->count())->toBe(0);
});
