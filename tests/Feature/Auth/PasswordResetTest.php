<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

test('password reset routes are not registered', function () {
    expect(Route::has('password.request'))->toBeFalse()
        ->and(Route::has('password.email'))->toBeFalse()
        ->and(Route::has('password.reset'))->toBeFalse()
        ->and(Route::has('password.update'))->toBeFalse();
});

test('password reset screens are not available', function () {
    $this->get('/forgot-password')->assertRedirect('/de/forgot-password');
    $this->get('/reset-password/token')->assertNotFound();
});

test('password reset submissions are not accepted', function () {
    $user = User::factory()->create();
    $originalPassword = $user->password;

    $this->post('/forgot-password', ['email' => $user->email])
        ->assertMethodNotAllowed();

    $this->post('/reset-password', [
        'token' => 'invalid-token',
        'email' => $user->email,
        'password' => 'newpassword123',
        'password_confirmation' => 'newpassword123',
    ])->assertMethodNotAllowed();

    expect(Hash::check('newpassword123', $user->refresh()->password))->toBeFalse()
        ->and($user->password)->toBe($originalPassword);
});
