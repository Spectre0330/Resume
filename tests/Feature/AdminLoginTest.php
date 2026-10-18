<?php

use App\Models\User;
use Livewire\Livewire;

it('redirects guests from admin pages to the login page', function (string $routeName) {
    $response = $this->get(route($routeName));

    $response->assertRedirect(route('admin.login'));
})->with([
    'admin.dashboard',
    'admin.profile',
    'admin.experiences',
    'admin.projects',
    'admin.skill-groups',
    'admin.education',
    'admin.messages',
]);

it('logs the administrator in with valid credentials', function () {
    $user = User::factory()->create(['email' => 'owner@example.com', 'password' => 'correct-horse']);

    Livewire::test('pages::admin.login')
        ->set('email', 'owner@example.com')
        ->set('password', 'correct-horse')
        ->call('login')
        ->assertHasNoErrors()
        ->assertRedirect(route('admin.dashboard'));

    $this->assertAuthenticatedAs($user);
});

it('rejects invalid credentials', function () {
    User::factory()->create(['email' => 'owner@example.com', 'password' => 'correct-horse']);

    Livewire::test('pages::admin.login')
        ->set('email', 'owner@example.com')
        ->set('password', 'wrong-password')
        ->call('login')
        ->assertHasErrors(['email']);

    $this->assertGuest();
});

it('locks out the login after five failed attempts', function () {
    User::factory()->create(['email' => 'owner@example.com', 'password' => 'correct-horse']);
    $component = Livewire::test('pages::admin.login')->set('email', 'owner@example.com');

    foreach (range(1, 5) as $attempt) {
        $component->set('password', 'wrong-password')->call('login');
    }

    $component->set('password', 'correct-horse')->call('login')->assertHasErrors(['email']);

    $this->assertGuest();
});

it('logs the administrator out', function () {
    $this->actingAs(User::factory()->create());

    $response = $this->post(route('admin.logout'));

    $response->assertRedirect(route('home'));
    $this->assertGuest();
});

it('does not expose a registration page', function () {
    $response = $this->get('/register');

    $response->assertNotFound();
});
