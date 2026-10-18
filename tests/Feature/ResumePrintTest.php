<?php

use App\Models\Experience;
use App\Models\Profile;

it('renders the printable resume without the contact form or site navigation', function () {
    Profile::factory()->create(['name' => 'Ada Lovelace']);
    Experience::factory()->create(['role' => 'Lead Programmer']);

    $response = $this->get(route('resume.print'));

    $response->assertOk()
        ->assertSee('Ada Lovelace')
        ->assertSee('Lead Programmer')
        ->assertSee('Save as PDF')
        ->assertDontSee('./contact.sh')
        ->assertDontSee('aria-label="Primary"', escape: false);
});

it('keeps a private phone number off the printable resume', function () {
    Profile::factory()->create(['phone' => '555-010-9999', 'show_phone' => false]);

    $response = $this->get(route('resume.print'));

    $response->assertDontSee('555-010-9999');
});
