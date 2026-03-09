<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

it('allows a user to register', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertRedirect();
    $this->assertAuthenticated();
    $this->assertDatabaseHas('users', [
        'email' => 'test@example.com',
    ]);
});

it('allows a user to login', function () {
    $user = User::factory()->create([
        'password' => Hash::make('password123'),
    ]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password123',
    ]);

    $response->assertRedirect();
    $this->assertAuthenticatedAs($user);
});

it('allows a user to logout', function () {
    $user = User::factory()->create();

    $this->actingAs($user);
    $response = $this->post('/logout');

    $response->assertRedirect();
    $this->assertGuest();
});
