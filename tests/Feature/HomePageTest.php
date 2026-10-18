<?php

use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\SkillGroup;

it('renders the profile and resume sections', function () {
    Profile::factory()->create(['name' => 'Ada Lovelace', 'headline' => 'Analytical Engineer']);
    Experience::factory()->create(['role' => 'Lead Programmer', 'company' => 'Babbage & Co']);
    Project::factory()->create(['title' => 'Difference Engine']);
    SkillGroup::factory()->create(['name' => 'Mathematics', 'skills' => ['Calculus', 'Algebra']]);

    $response = $this->get(route('home'));

    $response->assertOk()
        ->assertSee('Ada Lovelace')
        ->assertSee('Analytical Engineer')
        ->assertSee('Lead Programmer')
        ->assertSee('Babbage &amp; Co', escape: false)
        ->assertSee('Difference Engine')
        ->assertSee('Calculus');
});

it('lists experiences in their admin-defined order', function () {
    Experience::factory()->create(['role' => 'Second Role', 'sort_order' => 2]);
    Experience::factory()->create(['role' => 'First Role', 'sort_order' => 1]);

    $response = $this->get(route('home'));

    $response->assertSeeInOrder(['First Role', 'Second Role']);
});

it('labels a role without an end date as present', function () {
    Experience::factory()->current()->create(['started_on' => '2024-06-01']);

    $response = $this->get(route('home'));

    $response->assertSee('Jun 2024 — Present');
});

it('hides the phone number unless it is marked public', function () {
    Profile::factory()->create(['phone' => '555-010-9999', 'show_phone' => false]);

    $response = $this->get(route('home'));

    $response->assertOk()->assertDontSee('555-010-9999');
});

it('shows the phone number when it is marked public', function () {
    Profile::factory()->withVisiblePhone()->create(['phone' => '555-010-9999']);

    $response = $this->get(route('home'));

    $response->assertSee('555-010-9999');
});

it('does not list projects that are not featured', function () {
    Project::factory()->create(['title' => 'Hidden Experiment', 'is_featured' => false]);

    $response = $this->get(route('home'));

    $response->assertDontSee('Hidden Experiment');
});

it('escapes user-editable content', function () {
    Experience::factory()->create(['bullets' => ['<script>alert(1)</script>']]);

    $response = $this->get(route('home'));

    $response->assertDontSee('<script>alert(1)</script>', escape: false);
});
