<?php

namespace Database\Seeders;

use RuntimeException;

final class DestructiveSeederGuard
{
    public static function ensureAllowed(): void
    {
        if (! app()->isProduction() || config('database.allow_destructive_seeding') === true) {
            return;
        }

        throw new RuntimeException(
            'Destructive database seeding is disabled in production. Set ALLOW_DESTRUCTIVE_SEEDING=true only for an intentional, supervised seed, then disable it immediately.',
        );
    }
}
