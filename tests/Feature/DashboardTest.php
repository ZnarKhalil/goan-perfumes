<?php

use App\Models\User;

test('guests are redirected to the login page', function () {
    $response = $this->get(route('dashboard'));
    $response->assertRedirect(route('login'));
});

test('non-admin users are redirected away from the dashboard', function () {
    $user = User::factory()->create(['is_admin' => false]);
    $this->actingAs($user);

    $response = $this->get(route('dashboard'));
    $response->assertRedirect('/');
});

test('admin users can visit the dashboard', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    $response = $this->get(route('dashboard'));
    $response->assertOk();
});

test('shared auth user only exposes whitelisted fields', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    $this->get(route('dashboard'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->where('auth.user.id', $admin->id)
            ->where('auth.user.name', $admin->name)
            ->where('auth.user.email', $admin->email)
            ->has('auth.user.email_verified_at')
            ->missing('auth.user.password')
            ->missing('auth.user.is_admin')
            ->missing('auth.user.two_factor_secret')
            ->missing('auth.user.two_factor_recovery_codes')
            ->missing('auth.user.remember_token')
            ->missing('auth.user.created_at')
            ->missing('auth.user.updated_at'),
        );
});
