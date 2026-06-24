<?php

namespace App\Http\Controllers\Public;

use Inertia\Inertia;
use Inertia\Response;

class TermsController extends PublicController
{
    public function __invoke(string $locale): Response
    {
        $meta = match ($this->locale()) {
            'en' => [
                'Terms and conditions',
                'General terms and conditions of Goan Perfume for in-store sales and WhatsApp orders.',
            ],
            'ar' => [
                'الشروط والأحكام',
                'الشروط والأحكام العامة لـ Goan Perfume للبيع في المتجر وطلبات واتساب.',
            ],
            default => [
                'Allgemeine Geschäftsbedingungen',
                'Allgemeine Geschäftsbedingungen (AGB) von Goan Perfume für Ladenverkauf und WhatsApp-Bestellungen.',
            ],
        };

        return Inertia::render('public/terms', [
            ...$this->layoutProps(),
            'meta' => $this->localizedMeta(...$meta, routeName: 'terms'),
        ]);
    }
}
