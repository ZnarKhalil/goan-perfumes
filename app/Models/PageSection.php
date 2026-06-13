<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['key', 'type', 'payload', 'sort_order', 'is_active'])]
class PageSection extends Model
{
    use HasTranslations;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'payload' => 'array',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Encode a list of bullet points into the JSON translation value, or null
     * when nothing remains after trimming.
     */
    public static function encodeBulletPoints(mixed $value): ?string
    {
        if (! is_array($value)) {
            return null;
        }

        $items = collect($value)
            ->filter(fn (mixed $item) => is_string($item) && trim($item) !== '')
            ->map(fn (string $item) => trim($item))
            ->values()
            ->all();

        if ($items === []) {
            return null;
        }

        return json_encode($items, JSON_UNESCAPED_UNICODE);
    }

    /**
     * @return array<int, string>
     */
    public static function decodeBulletPoints(?string $value): array
    {
        if ($value === null || $value === '') {
            return [];
        }

        $decoded = json_decode($value, true);

        return is_array($decoded)
            ? array_values(array_filter($decoded, is_string(...)))
            : [];
    }
}
