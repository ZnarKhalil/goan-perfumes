<?php

use Inertia\Testing\AssertableInertia;

test('not found pages render the branded inertia error page', function () {
    config(['app.debug' => false]);

    $response = $this->get('/de/missing-fragrance-path');

    $response
        ->assertNotFound()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('error')
            ->where('status', 404)
            ->has('name')
        );
});
