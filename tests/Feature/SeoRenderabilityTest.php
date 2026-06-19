<?php

use App\Models\User;
use Illuminate\Support\Facades\Http;

test('public pages can be server side rendered', function () {
    config([
        'inertia.ssr.enabled' => true,
        'inertia.ssr.ensure_bundle_exists' => false,
    ]);

    Http::fake([
        'http://127.0.0.1:13714/render' => Http::response([
            'head' => ['<title>SSR Public Page</title>'],
            'body' => '<main data-testid="ssr-public-page">SSR public catalogue content</main>',
        ]),
    ]);

    $this->get('/de')
        ->assertOk()
        ->assertSee('SSR public catalogue content', false);

    Http::assertSentCount(1);
});

test('private surfaces are excluded from server side rendering', function () {
    config([
        'inertia.ssr.enabled' => true,
        'inertia.ssr.ensure_bundle_exists' => false,
    ]);

    Http::fake([
        'http://127.0.0.1:13714/render' => Http::response([
            'head' => [],
            'body' => '<main>SSR private content</main>',
        ]),
    ]);

    $this->get('/login')
        ->assertOk()
        ->assertDontSee('SSR private content', false);

    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get('/dashboard')
        ->assertOk()
        ->assertDontSee('SSR private content', false);

    Http::assertNothingSent();
});

test('private and error pages emit noindex robots meta in the initial html', function () {
    $admin = User::factory()->admin()->create();

    $this->get('/login')
        ->assertOk()
        ->assertSee('name="robots"', false)
        ->assertSee('noindex, nofollow', false);

    $this->actingAs($admin)
        ->get('/dashboard')
        ->assertOk()
        ->assertSee('name="robots"', false)
        ->assertSee('noindex, nofollow', false);

    $this->get('/de/missing-fragrance-path')
        ->assertNotFound()
        ->assertSee('name="robots"', false)
        ->assertSee('noindex, nofollow', false);
});

test('public pages do not emit noindex robots meta in the initial html', function () {
    $this->get('/de')
        ->assertOk()
        ->assertDontSee('noindex, nofollow', false);
});
