<?php

use Illuminate\Support\Facades\Route;

test('registration routes are not registered', function () {
    expect(Route::has('register'))->toBeFalse()
        ->and(Route::has('register.store'))->toBeFalse();
});

test('registration screen is not available', function () {
    $this->get('/register')->assertRedirect('/de/register');
});

test('new users cannot self-register', function () {
    $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ])->assertMethodNotAllowed();

    $this->assertGuest();
});
