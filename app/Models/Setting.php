<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

#[Fillable(['key', 'value'])]
class Setting extends Model
{
    public const CREATED_AT = null;

    private const CacheKey = 'settings:all';

    protected $primaryKey = 'key';

    public $incrementing = false;

    protected $keyType = 'string';

    public static function get(string $key, ?string $default = null): ?string
    {
        return self::allCached()[$key] ?? $default;
    }

    public static function put(string $key, string $value): self
    {
        return self::query()->updateOrCreate(['key' => $key], ['value' => $value]);
    }

    public static function flushCache(): void
    {
        Cache::forget(self::CacheKey);
    }

    protected static function booted(): void
    {
        static::saved(fn () => self::flushCache());
        static::deleted(fn () => self::flushCache());
    }

    /**
     * @return array<string, string>
     */
    private static function allCached(): array
    {
        return Cache::rememberForever(
            self::CacheKey,
            fn (): array => self::query()->pluck('value', 'key')->all(),
        );
    }
}
