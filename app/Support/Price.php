<?php

namespace App\Support;

final class Price
{
    /**
     * Normalize a numeric price to a two-decimal string, or null when unset.
     */
    public static function decimal(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        return number_format((float) $value, 2, '.', '');
    }
}
