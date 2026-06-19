<?php

namespace App\Http\Controllers\Public;

use Inertia\Inertia;
use Inertia\Response;

class ContactController extends PublicController
{
    public function __invoke(string $locale): Response
    {
        $meta = match ($this->locale()) {
            'en' => [
                'Contact',
                'Contact Goan Perfume in Kelheim for personal fragrance advice, availability questions, and perfume recommendations by WhatsApp, phone, or email.',
            ],
            'ar' => [
                'تواصل معنا',
                'تواصل مع Goan Perfume في كيلهايم للحصول على استشارة عطرية شخصية وأسئلة التوفر والتوصيات عبر واتساب أو الهاتف أو البريد الإلكتروني.',
            ],
            default => [
                'Kontakt',
                'Kontakt zu Goan Perfume in Kelheim für persönliche Duftberatung, Fragen zu Verfügbarkeit und Empfehlungen per WhatsApp, Telefon oder E-Mail.',
            ],
        };

        return Inertia::render('public/contact', [
            ...$this->layoutProps(),
            'meta' => $this->localizedMeta(...$meta, routeName: 'contact'),
        ]);
    }
}
