<?php

use App\Models\Experience;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

it('renders the experience list', function () {
    Experience::factory()->create(['role' => 'Lead Programmer']);

    $response = $this->get(route('admin.experiences'));

    $response->assertOk()->assertSee('Lead Programmer');
});

it('creates an experience with one bullet per non-empty line', function () {
    Livewire::test('pages::admin.experiences')
        ->call('create')
        ->set('role', 'Software Developer')
        ->set('company', 'Acme')
        ->set('startedOn', '2024-06-01')
        ->set('bullets', "Shipped the billing rewrite\n\n  Cut page load time in half  \n")
        ->call('save')
        ->assertHasNoErrors()
        ->assertSet('showForm', false);

    $experience = Experience::query()->sole();
    expect($experience->role)->toBe('Software Developer')
        ->and($experience->ended_on)->toBeNull()
        ->and($experience->bullets)->toBe(['Shipped the billing rewrite', 'Cut page load time in half']);
});

it('updates an existing experience', function () {
    $experience = Experience::factory()->create(['role' => 'Junior']);

    Livewire::test('pages::admin.experiences')
        ->call('edit', $experience->id)
        ->assertSet('role', 'Junior')
        ->set('role', 'Junior Associate')
        ->call('save')
        ->assertHasNoErrors();

    expect($experience->fresh()->role)->toBe('Junior Associate');
});

it('rejects an end date before the start date', function () {
    Livewire::test('pages::admin.experiences')
        ->call('create')
        ->set('role', 'Developer')
        ->set('company', 'Acme')
        ->set('startedOn', '2024-06-01')
        ->set('endedOn', '2023-01-01')
        ->set('bullets', 'Did things')
        ->call('save')
        ->assertHasErrors(['endedOn' => 'after_or_equal']);

    expect(Experience::query()->count())->toBe(0);
});

it('deletes an experience', function () {
    $experience = Experience::factory()->create();

    Livewire::test('pages::admin.experiences')->call('delete', $experience->id);

    $this->assertModelMissing($experience);
});

it('moves an experience to a new position', function () {
    $first = Experience::factory()->create(['sort_order' => 1]);
    $second = Experience::factory()->create(['sort_order' => 2]);
    $third = Experience::factory()->create(['sort_order' => 3]);

    Livewire::test('pages::admin.experiences')->call('sort', (string) $third->id, 0);

    expect(Experience::query()->ordered()->pluck('id')->all())->toBe([$third->id, $first->id, $second->id]);
});

it('appends new experiences to the end of the list', function () {
    $existing = Experience::factory()->create(['sort_order' => 5]);

    $created = Experience::factory()->create();

    expect($created->sort_order)->toBe(6)
        ->and(Experience::query()->ordered()->pluck('id')->last())->toBe($created->id);
});
