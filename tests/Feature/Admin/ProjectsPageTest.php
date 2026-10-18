<?php

use App\Models\Project;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

it('creates a project with comma separated tech tags', function () {
    Livewire::test('pages::admin.projects')
        ->call('create')
        ->set('projectTitle', 'Resume Site')
        ->set('description', 'A database-driven resume.')
        ->set('tech', 'Laravel, Livewire , ,Pest')
        ->set('repoUrl', 'https://github.com/example/resume')
        ->call('save')
        ->assertHasNoErrors();

    $project = Project::query()->sole();
    expect($project->title)->toBe('Resume Site')
        ->and($project->tech)->toBe(['Laravel', 'Livewire', 'Pest'])
        ->and($project->is_featured)->toBeTrue();
});

it('rejects a repository link that is not https', function () {
    Livewire::test('pages::admin.projects')
        ->call('create')
        ->set('projectTitle', 'Resume Site')
        ->set('description', 'A database-driven resume.')
        ->set('tech', 'Laravel')
        ->set('repoUrl', 'javascript:alert(1)')
        ->call('save')
        ->assertHasErrors(['repoUrl']);

    expect(Project::query()->count())->toBe(0);
});

it('hides a project from the public site when it is unfeatured', function () {
    $project = Project::factory()->create(['title' => 'Old Prototype']);

    Livewire::test('pages::admin.projects')
        ->call('edit', $project->id)
        ->set('isFeatured', false)
        ->call('save')
        ->assertHasNoErrors();

    $this->get(route('home'))->assertDontSee('Old Prototype');
});
