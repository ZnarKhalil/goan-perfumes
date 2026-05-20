<?php

namespace App\Support;

final class PublicLocale
{
    public const CookieName = 'public_locale';

    public const Default = 'de';

    /**
     * @return array<string, array{code: string, label: string, native_label: string, flag: string, dir: 'ltr'|'rtl', formatter_locale: string}>
     */
    public static function supported(): array
    {
        return [
            'de' => [
                'code' => 'de',
                'label' => 'Deutsch',
                'native_label' => 'Deutsch',
                'flag' => 'DE',
                'dir' => 'ltr',
                'formatter_locale' => 'de-DE',
            ],
            'en' => [
                'code' => 'en',
                'label' => 'English',
                'native_label' => 'English',
                'flag' => 'GB',
                'dir' => 'ltr',
                'formatter_locale' => 'en-DE',
            ],
            'ar' => [
                'code' => 'ar',
                'label' => 'Arabic',
                'native_label' => 'العربية',
                'flag' => 'SA',
                'dir' => 'rtl',
                'formatter_locale' => 'ar',
            ],
        ];
    }

    /**
     * @return array<int, string>
     */
    public static function codes(): array
    {
        return array_keys(self::supported());
    }

    public static function isSupported(?string $locale): bool
    {
        return is_string($locale) && array_key_exists($locale, self::supported());
    }

    public static function normalize(?string $locale): string
    {
        return self::isSupported($locale) ? $locale : self::Default;
    }

    public static function direction(?string $locale): string
    {
        return self::definition($locale)['dir'];
    }

    public static function formatterLocale(?string $locale): string
    {
        return self::definition($locale)['formatter_locale'];
    }

    /**
     * @return array{code: string, label: string, native_label: string, flag: string, dir: 'ltr'|'rtl', formatter_locale: string}
     */
    public static function definition(?string $locale): array
    {
        $supported = self::supported();

        return $supported[self::normalize($locale)];
    }
}
