<?php

use App\Models\User;

test('guests cannot access the log viewer', function () {
    $this->get('/log-viewer')->assertForbidden();
});

test('authenticated non-admin users cannot access the log viewer', function () {
    $this->actingAs(User::factory()->create(['is_admin' => false]));

    $this->get('/log-viewer')->assertForbidden();
});

test('admin users can access the log viewer', function () {
    $this->actingAs(User::factory()->create(['is_admin' => true]));

    $this->get('/log-viewer')->assertOk();
});

test('guests cannot access the log viewer api', function () {
    $this->getJson('/log-viewer/api/folders')->assertForbidden();
});
